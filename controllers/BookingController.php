<?php

namespace app\controllers;

use app\models\Bookings;
use app\models\Roles;
use app\models\Treatments;
use app\models\Holidays;
use app\models\WhoHasHolidays;
use app\models\WorkTimes;
use DateInterval;
use DateTime;
use Yii;
use yii\helpers\VarDumper;
use yii\web\Controller;

class BookingController extends Controller
{
  /**
   * All booking views go through this action
   * The information between them is shared via hidden inputs
   *
   * @return string
   */
  public function actionIndex()
  {
    if (Yii::$app->request->getMethod() == 'POST')
    {
      $postParams = Yii::$app->request->post();

      // TODO: handle empty/no input with appropriate error messages
      // Rendering the next view depending on which view the user has been on previously
      switch ($postParams['view'])
      {
        // User has selected a role
        case 'role':
          // User moves on to select treatment
          if ($postParams['button'] == 'next')
          {
            $role = $postParams['role'];
            $treatments = Treatments::getTreatments($role);

            return $this->render('treatment', [
              'treatments' => $treatments,
              'role' => $role,
            ]);
          }
        break;

        // User has selected a treatment
        case 'treatment':
          // User moves on to select date and time
          if ($postParams['button'] == 'next')
          {
            // TODO: days, that are completetly booked and/or completely 'consumed' by a holiday should be disabled in the date picker
            // * Alternative approach: send all present bookings of the selected role as a hidden input
            // * That would avoid the constant Ajax calls upon selecting a date
            // * But it would only work for a relatively small amount of clients

            $role = $postParams['role'];
            $treatments = $postParams['treatments'];

            $duration = Roles::getDuration($role);
            $totalDuration = $duration * count($treatments);

            return $this->render('time-and-date', [
              'role' => $role,
              'treatments' => $treatments,
              'totalDuration' => $totalDuration
            ]);
          }
          // User goes back to change the role
          elseif ($postParams['button'] == 'back')
          {
            $roles = Roles::getAllActiveRoles();

            $selectedRole = $postParams['role'];

            return $this->render('role', [
              'roles' => $roles,
              'selectedRole' => $selectedRole
            ]);
          }
        break;

        case 'time-and-date':
          if ($postParams['button'] == 'next')
          {
            return $this->render('personal-info', [
              'role' => $postParams['role'],
              'treatments' => $postParams['treatments'],
              'totalDuration' => $postParams['totalDuration'],
              'date' => $postParams['date'],
              'time' => $postParams['time']
            ]);
          }
          elseif ($postParams['button'] == 'back')
          {
            $role = $postParams['role'];
            $treatments = Treatments::getTreatments($role);
            $selectedTreatments = $postParams['treatments'];

            return $this->render('treatment', [
              'role' => $role,
              'treatments' => $treatments,
              'selectedTreatments' => $selectedTreatments,
              'date' => $postParams['date'],
              'time' => $postParams['time']
            ]);
          }
        break;

        case 'personal-info':
          if ($postParams['button'] == 'next')
          {
          }
          elseif ($postParams['button'] == 'back')
          {
          }
        break;

        default:
          // Retrieving all available roles from the database
          $role = Roles::getAllActiveRoles();

          return $this->render('role', [
            'roles' => $role
          ]);
        break;
      }
    }
    else
    {
      // Retrieving all available roles from the database
      $role = Roles::getAllActiveRoles();

      return $this->render('role', [
        'roles' => $role
      ]);
    }
  }

  /**
   * Target for Ajax call; getting all the times for a specified date from the DB
   * Returns a HTML snippet to be inserted into #times so that the client machine can run as efficiently as possible
   *
   * @return string
   */
  public function actionGetTimes()
  {

    // Only processing the request if the method is POST
    if (Yii::$app->request->method == 'POST')
    {
      /**
       * Returns the time in hh:mm:ss calculated from the beginning time plus the duraion in minutes.
       * Wether or not this function is truly more efficient than a DateTime object remains to be seen.
       *
       * @param string $beginnigTime A time in hh:mm:ss
       * @param integer $duration A duration in minutes
       * @return string A time in hh:mm:ss that is the beginning time + duration
       */
      // ! TODO: this needs debugging: '08:00:00', 45 => '09:0-15:00'
      function getEndTime($starTime, $duration)
      {
        // Extracting the hours and minutes from the start time
        $startHours = intval(substr($starTime, 0, 2));
        $startMinutes = intval(substr($starTime, 2, 2));

        // Getting the duration in hours
        $duration /= 60;

        // Extracting the number of hours from the durations
        $durationHours = round($duration, 0);

        // Extracting the nuber of remaining minutes
        $durationMinutes = ($duration - $durationHours) * 60; // ! TODO: account for negative minute numbers

        // Adding the amount of time
        $endHours = $startHours + $durationHours;
        $endMinutes = $startMinutes + $durationMinutes;

        // Account for overflow in minutes
        if ($endMinutes > 60)
        {
          // Calculating the amount of hours too much in $endMinutes
          $hoursOverflow = round($endMinutes / 60, 0);

          // Adding the calculated number of hours to $endHours
          $endHours += $hoursOverflow;

          // Calculating the remaining minutes
          $endMinutes -= $hoursOverflow * 60;
        }

        // Account for overflow in hours (even though in this use-case that should never happen)
        if ($endHours > 24)
        {
          $endHours -= 24;
        }

        // Returning the calculated time string
        return (($endHours < 10) ? '0'.$endHours : $endHours).':'.(($endMinutes < 10) ? '0'.$endMinutes : $endMinutes).':00';
      }

      /**
       * The following values will come through the Ajax call:
       * @var string ['date']
       * @var string ['role']
       * @var string ['totalDuration']
       */
      $postParams = Yii::$app->request->post();

      // TODO: put this query in the Roles model
      // Retrieving the times if there's a holiday present for the current role
      $query = Yii::$app->db->createCommand(
        'SELECT holidays.beginning_time, holidays.end_time
        FROM roles
        JOIN who_has_holidays ON roles.id = who_has_holidays.role_id
        JOIN holidays ON who_has_holidays.holiday_id = holidays.id
        WHERE roles.id = :role_id AND holidays.date = :holiday_date;',
        [
          ':role_id' => intval($postParams['role']),
          ':holiday_date' => $postParams['date']
        ]
      );

      $holiday = $query->queryAll();
      $bookedTimes = Bookings::getTimes($postParams['role'], $postParams['date']);

      // Retrieving the work times of the current role for the selected weekday
      $weekday = new DateTime($postParams['date']);
      $workTimes = WorkTimes::getWorkTime(intval($postParams['role']), (intval($weekday->format('N')) - 1));
      $workTimeFrom = new DateTime($workTimes['from']);
      $workTimeUntil = new DateTime($workTimes['until']);

      $times = [];

      array_push($times, $workTimeFrom->format('H:i:00'));

      // TODO: generate dates without using DateTime objects
      // There are 96 15-minute intervals in a 24 hour day ((24 * 60) / 15), that's the saveguard here
      // Generating the times from the given work time interval ends
      for ($loopSaveguard = 0; $loopSaveguard < 97 && $workTimeFrom < $workTimeUntil; $loopSaveguard++)
      {
        // Adding 15 minutes to the date and appending it to the times array
        $workTimeFrom->add(new DateInterval('PT15M'));
        array_push($times, $workTimeFrom->format('H:i:00'));
      }

      // Correcting an off-by-one error: the last time is when the shift ends and shouldn't be included in $times
      unset($times[count($times) - 1]);

      $HTMLsnippet = '';

      // TODO: create an array with the booking times so that in the for loop removing reserved times is a simple comparison

      // Since we are removing elements from the array, we need a number representing the initial size of the array
      $sizeOfTimes = count($times);

      // Removing all holiday and booked times
      for ($key = 0; $key < $sizeOfTimes; $key++)
      {
        // If the time falls withing the range of a holiday, it gets removed from the array
        if (
          isset($holiday[0]['beginning_time']) &&
          isset($holiday[0]['end_time']) &&
          $times[$key] >= $holiday[0]['beginning_time'] &&
          $times[$key] <= $holiday[0]['end_time']
        )
        {
          unset($times[$key]);
        }

        // If the time falls within the range of a booking, it gets removed
        foreach ($bookedTimes as $booking)
        {
          $beginning = $booking['time'];
          $end = getEndTime($booking['time'], $booking['duration']);

          if ($times[$key] >= $beginning && $times[$key] <= $end)
          {
            unset($times[$key]);
          }
        }
      }

      // TODO: Go through each time again and remove any times where the $totalDuration doesn't fit
      // Removing any time slots that would not fit the $totalDuration
      $sizeOfTimes = count($times);
      for ($key = 0; $key < $sizeOfTimes; $key++) {
        // Calculate the destination time using our own getEndTime function
        $destinationTime = getEndTime($times[$key], intval($postParams['totalDuration']));
return json_encode([$times[$key], $postParams['totalDuration'], $destinationTime]);

        // Calculate the number of 15 minute segments needed to reserve for said duration

        // Retrieve the time at said offset

        // If the time at the offset is smaller than the DateTime object, remove the time from the array
      }

      // Creating the HTML snippet from the array of remaining open times
      foreach ($times as $time)
      {
        $HTMLsnippet .= '<label class="input-label times">'.substr($time, 0, 5).'<input type="radio" name="time" value"'.$time.'"></label>';
      }

      // return json_encode($times);
      return $HTMLsnippet;
    }

    return;
  }

  // User chooses the role
  public function actionRole()
  {
    $roles = Roles::find()
    ->select('id, role_name')
    ->where('status = true')
    ->all();

    return $this->render('role', [
      'roles' => $roles
    ]);
  }

  // User chooses the treatment available for the chosen role
  public function actionTreatment()
  {
    // TODO: redirect on GET
    if (Yii::$app->request->getMethod() == 'POST')
    {
      $postParams = Yii::$app->request->post();

      $role = $postParams['role'];

      // If the back button was clicked, redirect there
      // if ()
      // {}

      $treatments = Treatments::find()
      ->select('id, treatment_name')
      ->where('role_id = :role_id', [':role_id' => $postParams['role']])
      ->all();

      return $this->render('treatment', [
        'treatments' => $treatments,
        'role' => $role
      ]);
    }
    // Redirect on GET
    else
    {
      return $this->redirect('/booking');
    }
  }

  // User chooses appropriate time and date
  public function actionTimeAndDate()
  {
    // TODO: redirect on GET
    $postParams = Yii::$app->request->post();

    $role = $postParams['role'];
    $treatments = [];
    foreach ($postParams['treatment'] as $key => $value) {
      $treatments[] = $key;
    }

    // TODO: retrieve date and time

    return $this->render('time-and-date', [
      'treatments' => $treatments,
      'role' => $role
    ]);
  }

  public function actionPersonalInfo()
  {
    // TODO: redirect on get
    return $this->render('personal-info');
  }

  /**
   * Target for Ajax call
   * Returns all holidays
   *
   * @return void|string
   */
  public function actionGetHolidays()
  {
    // If this site is not accessed via POST method, redirect to the index site
    if (Yii::$app->request->method != 'POST')
    {
      return $this->redirect('/booking/booking');
    }

    // Retrieving holidays and bookings from the database
    $holidays = Holidays::getHolidays();

    $responseData = [];

    // Populating the response data array with the dates
    foreach ($holidays as $date)
    {
      $responseData[] = $date->date;
    }

    return json_encode($responseData);
  }

  /**
   * Target for Ajax call
   * Returns all bookings for a specific date
   *
   * @return void|string
   */
  public function actionGetBookings()
  {
    // If this site is not accessed via POST method, redirect to the index site
    if (Yii::$app->request->method != 'POST')
    {
      return $this->redirect('/booking/booking');
    }

    $booking = Yii::$app->request->bodyParams['booking'];

    // Retrieving all existing bookings in the relevant categories
    $queryResults = Bookings::getBookings($booking['role'], $booking['treatment'], $booking['date'], $booking['time']);

    $responseData = [];

    // Extracting the date and appending it to the array
    foreach ($queryResults as $value)
    {
      $responseData[] = substr($value->date, 11, 5);
    }

    return json_encode($responseData);
  }

  /**
   * Displays booked appointment on successful booking
   *
   * @return void|string
   */
  public function actionInputValidation()
  {
    // Todo: User can create multiple DB entries by refreshing the page/going back to said page; fix that!
    // If this site is not accessed via POST method, redirect to the index site
    if (Yii::$app->request->method != 'POST')
    {
      return $this->redirect('/booking/booking');
    }

    $booking = new Bookings();

    $requestData = Yii::$app->request->bodyParams['booking'];

    // Assigning the request data to the Booking object
    $booking->role = $requestData['role'];
    $booking->treatment = $requestData['treatment'];
    $booking->date = $requestData['date'];
    $booking->time = $requestData['time'].':00';
    $booking->patient_salutation = $requestData['patient_salutation'];
    $booking->patient_firstName = $requestData['patient_firstName'];
    $booking->patient_lastName = $requestData['patient_lastName'];
    $booking->patient_birthdate = $requestData['patient_birthdate'];
    $booking->patient_street = $requestData['patient_street'];
    $booking->patient_zipCode = $requestData['patient_zipCode'];
    $booking->patient_city = $requestData['patient_city'];
    $booking->patient_phoneNumber = $requestData['patient_phoneNumber'];
    $booking->patient_email = $requestData['patient_email'];
    $booking->patient_comment = $requestData['patient_comment'];
    $booking->newPatient = $requestData['newPatient'] == '1' ? 1 : 0;
    $booking->recall = $requestData['recall'] == '1' ? 1 : 0;

    // If the validation is successful, insert values into database
    if ($booking->validate()) {

      // Creating insert query
      $insertQuery = Yii::$app->db->createCommand('INSERT INTO bookings VALUES (
        :role,
        :treatment,
        :date,
        :time,
        :patient_salutation,
        :patient_firstName,
        :patient_lastName,
        :patient_birthdate,
        :patient_street,
        :patient_zipCode,
        :patient_city,
        :patient_phoneNumber,
        :patient_email,
        :patient_comment,
        :newPatient,
        :recall
      );');

      // Binding values
      $insertQuery->bindValue(':role', $booking->role)
      ->bindValue(':treatment', $booking->treatment)
      ->bindValue(':date', $booking->date)
      ->bindValue(':patient_salutation', $booking->patient_salutation)
      ->bindValue(':patient_firstName', $booking->patient_firstName)
      ->bindValue(':patient_lastName', $booking->patient_lastName)
      ->bindValue(':patient_birthdate', $booking->patient_birthdate)
      ->bindValue(':patient_street', $booking->patient_street)
      ->bindValue(':patient_zipCode', $booking->patient_zipCode)
      ->bindValue(':patient_city', $booking->patient_city)
      ->bindValue(':patient_phoneNumber', $booking->patient_phoneNumber)
      ->bindValue(':patient_email', $booking->patient_email)
      ->bindValue(':patient_comment', $booking->patient_comment)
      ->bindValue(':newPatient', $booking->newPatient)
      ->bindValue(':recall', $booking->recall);

      // Executing query
      $insertQuery->execute();

      return $this->render('bookingSuccess', [
        'message' => 'Your booking has been saved.'
      ]);
    }

    $inputErrors = $booking->errors;
    $displayErrors = [];

    // Extracts all the errors from the object into a separate array
    foreach ($inputErrors as $errors) {
      foreach ($errors as $error) {
        $displayErrors[] = $error;
      }
    }

    return $this->render('bookingFailiure', [
      'message' => implode('<br>', $displayErrors)
    ]);
  }
}
