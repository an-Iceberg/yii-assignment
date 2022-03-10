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
   * All booking views go through this action.
   * The information between them is shared via hidden inputs.
   *
   * @return string
   */
  public function actionIndex()
  {
    if (Yii::$app->request->getMethod() == 'POST')
    {
      $postParams = Yii::$app->request->post();

      // TODO: Database migrations
      // TODO: handle empty/no input with appropriate error messages
      // TODO: just pass in the $postParams everywhere, it's gonna be much easier to deal with
      // Rendering the next view depending on which view the user has been on previously
      // TODO OPTIONAL: account for unset $postParams['view']
      switch ($postParams['view'])
      {
        case 'role':
          if ($postParams['button'] == 'next')
          {
            // User has not selected a role
            if (!isset($postParams['role']))
            {
              return $this->render('role', [
                'roles' => Roles::getAllActiveRoles(),
                'error' => true
              ]);
            }

            $role = $postParams['role'];
            $treatments = Treatments::getTreatments($role);

            // User moves on to select a treatment
            return $this->render('treatment', [
              'treatments' => $treatments,
              'role' => $role,
            ]);
          }
        break;

        case 'treatment':
          if ($postParams['button'] == 'next')
          {
            // User has not selected a treatment
            if (!isset($postParams['treatments']))
            {
              return $this->render('treatment', [
                'role' => $postParams['role'],
                'treatments' => Treatments::getTreatments($postParams['role']),
                'error' => true
              ]);
            }

            $role = $postParams['role'];
            $treatments = $postParams['treatments'];

            // Retrieving the duration of a single treatment
            $duration = Roles::getDuration($role);

            // Calculating the total duration of all selected treatments
            $totalDuration = $duration * count($treatments);

            // User moves on to select date and time
            return $this->render('time-and-date', [
              'role' => $role,
              'treatments' => $treatments,
              'totalDuration' => $totalDuration,
              'holidays' => $this->getHolidays($role)
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
            // User has not selected neither date nor time
            if (!isset($postParams['date']) && !isset($postParams['time']))
            {
              $error = 2;
            }
            // User has not selected a date
            elseif (!isset($postParams['date']))
            {
              $error = 1;
            }
            // User has not selected a time
            elseif (!isset($postParams['time']))
            {
              $error = 0;
            }

            // Re-render view on invalid input
            if (isset($error))
            {
              return $this->render('time-and-date', [
                'role' => $postParams['role'],
                'treatments' => $postParams['treatments'],
                'totalDuration' => $postParams['totalDuration'],
                'holidays' => $this->getHolidays($postParams['role']),
                'error' => $error
              ]);
            }

            return $this->render('personal-info', [
              'role' => $postParams['role'],
              'treatments' => $postParams['treatments'],
              'totalDuration' => $postParams['totalDuration'],
              'date' => $postParams['date'],
              'time' => $postParams['time'],
              'send_confirmation' => true
            ]);
          }
          // User goes back to change the treatment(s)
          elseif ($postParams['button'] == 'back')
          {
            $role = $postParams['role'];
            $treatments = Treatments::getTreatments($role);
            $selectedTreatments = $postParams['treatments'];

            return $this->render('treatment', [
              'role' => $role,
              'treatments' => $treatments,
              'selectedTreatments' => $selectedTreatments,
            ]);
          }
        break;

        case 'personal-info':
          if ($postParams['button'] == 'next')
          {
            $errors = [
              'salutation' => true,
              'lastName' => true,
              'firstName' => true,
              'birthdate' => true,
              'street' => true,
              'zipCode' => true,
              'city' => true,
              'telephone' => true,
              'email' => true,
              'terms-and-conditions' => true
            ];

            $someInputIsInvalid = false;

            // Input validation
            foreach ($errors as $key => &$field)
            {
              // If the input is empty
              if (!isset($postParams['client'][$key]) || $postParams['client'][$key] == '')
              {
                $field = false;
                $someInputIsInvalid = true;
              }
              // TODO: valide input using model as well
            }
            unset($field);

            // On invalid input, re-render the form again
            if ($someInputIsInvalid)
            {
              return $this->render('personal-info', [
                'role' => $postParams['role'],
                'treatments' => $postParams['treatments'],
                'totalDuration' => $postParams['totalDuration'],
                'date' => $postParams['date'],
                'time' => $postParams['time'],
                'client' => $postParams['client'],
                'errors' => $errors
              ]);
            }
            // Move on to the overview
            else
            {
              $role = Roles::getRoleName($postParams['role']);
              $treatmentNames = Treatments::getTreatmentNames($postParams['treatments']);

              return $this->render('overview', [
                'postParams' => $postParams,
                'role' => $role,
                'treatments' => $treatmentNames
              ]);
            }
          }
          elseif ($postParams['button'] == 'back')
          {
            return $this->render('time-and-date', [
              'role' => $postParams['role'],
              'treatments' => $postParams['treatments'],
              'totalDuration' => $postParams['totalDuration'],
              'holidays' => $this->getHolidays($postParams['role'])
            ]);
          }
        break;

        case 'overview':
          if ($postParams['button'] == 'submit')
          {
            $booking = new Bookings();

            foreach ($postParams['treatments'] as $item)
            {
              $item;
            }

            $booking->duration = $postParams['totalDuration'];
            $booking->role_id = $postParams['role'];
            $booking->treatment_id = $postParams['treatments'];
            $booking->date = $postParams['date'];
            $booking->time = $postParams['time'];
            $booking->patient_salutation = $postParams['client']['salutation'];
            $booking->patient_firstName = $postParams['client']['firstName'];
            $booking->patient_lastName = $postParams['client']['lastName'];
            $booking->patient_birthdate = $postParams['client']['birthdate'];
            $booking->patient_street = $postParams['client']['street'];
            $booking->patient_zipCode = $postParams['client']['zipCode'];
            $booking->patient_city = $postParams['client']['city'];
            $booking->patient_phoneNumber = $postParams['client']['telephone'];
            $booking->patient_email = $postParams['client']['email'];
            $booking->patient_comment = $postParams['client']['comment'] ?? '';
            $booking->newPatient = isset($postParams['client']['newPatient']) ? 1 : 0;
            $booking->callback = isset($postParams['client']['callback']) ? 1 :  0;
            $booking->send_confirmation = isset($postParams['client']['send_confirmation']) ? 1 : 0;
            $booking->status = 1;

            if ($booking->validate())
            {
              $booking->save();

              return $this->redirect('/');
            }
            else
            {
              return ':(<br>Something went wrong'.'<hr>'.VarDumper::dump($booking->errors, 10, true);
            }
          }
          // User goes back to change personal information
          elseif ($postParams['button'] == 'back')
          {
            return $this->render('personal-info', [
              'role' => $postParams['role'],
              'treatments' => $postParams['treatments'],
              'totalDuration' => $postParams['totalDuration'],
              'date' => $postParams['date'],
              'time' => $postParams['time'],
              'client' => $postParams['client'],
            ]);
          }
        break;

        default:
          $roles = Roles::getAllActiveRoles();

          return $this->render('role', [
            'roles' => $roles
          ]);
        break;
      }
    }
    else
    {
      $roles = Roles::getAllActiveRoles();

      return $this->render('role', [
        'roles' => $roles
      ]);
    }
  }

  /**
   * Takes a role and returns all the holidays that fully cover the worktimes for said role
   *
   * @param int $role The id of the role
   * @return array The holidays that fully take up the worktimes
   */
  public function getHolidays($role)
  {
    // Retrieving all holidays for the selected role
    $holidays = Holidays::getHolidaysForRole($role);

    $excludeTheseDates = [];

    // Removing holidays from the array that are not required to be there
    $today = date('Y-m-d');
    $arraySize = count($holidays);
    for ($key = 0; $key < $arraySize; $key++)
    {
      // If the holiday is in the past its no longer relevant thus can be removed
      if ($holidays[$key]['date'] < $today)
      {
        unset($holidays[$key]);
      }
      // If the holiday doesn't cover 100% of the worktime it gets removed
      else
      {
        // Find out, what day of the week the date is
        $weekday = $this->getDayOfWeek(
          intval(substr($holidays[$key]['date'], 0, 4)),
          intval(substr($holidays[$key]['date'], 5, 2)),
          intval(substr($holidays[$key]['date'], 8, 2))
        );

        // Retrieve said day of the work times for the role for said weekday
        $workTimes = WorkTimes::find()
        ->select('from, until')
        ->where('role_id = :role_id', [':role_id' => $role])
        ->andWhere('weekday = :weekday', [':weekday' => $weekday])
        ->one();

        // If the holiday covers the work times completely, format it and push it onto the exclusion list
        if ($holidays[$key]['beginning_time'] <= $workTimes['from'] && $workTimes['until'] <= $holidays[$key]['end_time'])
        {
          $holiday = [
            'year' => intval(substr($holidays[$key]['date'], 0, 4)),
            'month' => intval(substr($holidays[$key]['date'], 5, 2)) - 1,
            'day' => intval(substr($holidays[$key]['date'], 8, 2))
          ];

          array_push($excludeTheseDates, $holiday);
        }
      }
    }

    return $excludeTheseDates;
  }

  /**
   * Returns a number representing the day of the week given a date
   *
   * @param int $year Four digit positive integer representing the year
   * @param int $month Two digit positive integer no larger than 12 representing the month
   * @param int $day Two digit positive integer no larger than 31/30/29/28 (depending on the month) positive integer representing the day of the month
   * @return int The day of the week with 0 = Monday and 6 = Sunday
   */
  public function getDayOfWeek($year, $month, $day)
  {
    // Adjusting the input values for the formula
    if ($month < 3)
    {
      $month += 12;
      $year--;
    }

    // The formula is an alternative to Zeller's rule; it can be found here => https://www.themathdoctors.org/zellers-rule-what-day-of-the-week-is-it/
    $weekday = ($day + (2*$month) + floor(3*($month+1)/5) + $year + floor($year/4) - floor($year/100) + floor($year/400) + 2) % 7;

    // Adjusting output value to correspond to 0 = Monday and 6 = Sunday
    $weekday -= 2;
    if ($weekday < 0)
    {
      $weekday += 7;
    }

    return $weekday;
  }

  /**
   * Target for Ajax call; getting all the times for a specified date from the DB.
   * Returns an HTML snippet to be inserted into #times so that the client machine can run as efficiently as possible
   *
   * @return string HTML formatted input fields
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
       * @param string $beginnigTime A time in hh:mm:ss that is larger than 00:00:00 and not negative
       * @param integer $duration A duration in minutes that is a positive integer
       * @return string A time in hh:mm:ss that is the beginning time + duration
       */
      function getEndTime($starTime, $duration)
      {
        // Extracting the hours and minutes from the start time
        $startHours = intval(substr($starTime, 0, 2));
        $startMinutes = intval(substr($starTime, 3, 2));

        $endHours = $startHours;
        $endMinutes = $startMinutes;

        // Getting the duration in hours
        $duration /= 60;

        // Extracting the number of hours from the durations
        $durationHours = floor($duration);

        // Extracting the nuber of remaining minutes
        $durationMinutes = ($duration - $durationHours) * 60;

        // Adding the amount of time
        $endHours = $startHours + $durationHours;
        $endMinutes = $startMinutes + $durationMinutes;

        // Account for overflow in minutes
        if ($endMinutes > 59)
        {
          // Calculating the amount of hours too much in $endMinutes
          $hoursOverflow = floor($endMinutes / 60);

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
      $workTimeFrom = $workTimes['from'];
      $workTimeUntil = $workTimes['until'];

      $times = [];

      // Extracting the hours and minutes from $workTimes
      $fromHours = intval(substr($workTimeFrom, 0, 2));
      $fromMinutes = intval(substr($workTimeFrom, 3, 2));
      $untilHours = intval(substr($workTimeUntil, 0, 2));
      $untilMinutes = intval(substr($workTimeUntil, 3, 2));

      // There are 96 15-minute intervals in a 24 hour day ((24 * 60) / 15), that's the saveguard here
      // Generating the times from the given work time interval ends
      for ($loopSaveguard = 0; $loopSaveguard < 97 && $workTimeFrom < $workTimeUntil; $loopSaveguard++)
      {
        // Pushing the time onto the array
        array_push($times, strval(($fromHours < 10) ? '0'.$fromHours : $fromHours).':'.(($fromMinutes < 10) ? '0'.$fromMinutes : $fromMinutes).':00');

        // Incrementing the time by 15 minutes
        $fromMinutes += 15;

        // Accounting for overflow
        if ($fromMinutes > 45)
        {
          $fromHours++;
          $fromMinutes = 0;
        }

        // Checking if the end time has been reached
        if ($fromHours == $untilHours && $fromMinutes == $untilMinutes)
        {
          break;
        }
      }

      // Correcting an off-by-one error: the last time is when the shift ends and shouldn't be included in $times
      unset($times[count($times) - 1]);

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
          if (isset($times[$key]))
          {
            $beginning = $booking['time'];
            $end = getEndTime($booking['time'], $booking['duration']);

            if ($times[$key] >= $beginning && $times[$key] <= $end)
            {
              unset($times[$key]);
            }
          }
        }
      }

      // Only removing times, if there are any present in the array
      if (count($times) > 0)
      {
        // Restoring the indices of the array elements because deleting an array element does not change its index
        $times = array_values($times);

        // The max iteration count for the for loop
        $sizeOfTimes = count($times);

        // The offset to be used to calculate the array index where the time will be searched
        $offset = intval($postParams['totalDuration']);
        $offset /= 15;

        // Removing all times that would not fit the duration of the selected treatment(s)
        for ($key = 0; $key < $sizeOfTimes; $key++)
        {
          // Calculate the destination time using the getEndTime function
          $destinationTime = getEndTime($times[$key], intval($postParams['totalDuration']));

          // Calculating the key of the array element which shall be verified
          $searchKey = $key + $offset;

          // If the search key reaches beyond the end of the array, remove the current element
          if ($searchKey > $sizeOfTimes - 1)
          {
            unset($times[$key]);
            continue;
          }

          // If the destination time isn't the one calculted before, remove the current element
          if ($times[$searchKey] != $destinationTime)
          {
            unset($times[$key]);
          }
        }
      }

      $HTMLsnippet = '';

      // There are times available -> construct the HTML snippet
      if (count($times) > 0)
      {
        // Creating the HTML snippet from the array of remaining open times
        foreach ($times as $time)
        {
          $HTMLsnippet .= '<label class="input-label times">'.substr($time, 0, 5).'<input type="radio" name="time" value="'.$time.'"></label>';
        }
      }
      // Notify the user that there are no free time-slots available
      else
      {
        $HTMLsnippet = 'Sorry, but there are no available times for this day.';
      }

      return $HTMLsnippet;
    }

    return 'You\'re not supposed to be here.<br>;)';
  }
}
