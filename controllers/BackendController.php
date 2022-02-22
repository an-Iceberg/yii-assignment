<?php

namespace app\controllers;

use app\models\Bookings;
use app\models\Holidays;
use app\models\Roles;
use app\models\Treatments;
use app\models\WorkTimes;
use Yii;
use yii\base\Controller;
use yii\data\ActiveDataProvider;
use yii\db\Query;
use yii\helpers\VarDumper;

class BackendController extends Controller
{
  public $layout = 'backend_layout';

  // This is the login page for the backend
  public function actionIndex()
  {
    $this->layout = '@app/views/layouts/main.php';

    // User is trying to log in
    if (Yii::$app->request->method == 'POST')
    {
      return $this->render('index', [
        'data' => Yii::$app->request->bodyParams
      ]);
    }

    return $this->render('index');
  }

  // Displays all bookings present in the DB
  public function actionBookings()
  {
    $getParams = Yii::$app->request->get();

    // Decrementing page by one since the dataprovider has 0-based index
    (isset($getParams['page'])) ? $getParams['page'] -= 1 : '';

    $query = Bookings::find()
    ->select(['role_name', 'role_id', 'bookings.id', 'patient_salutation', 'patient_lastName', 'date', 'time', 'bookings.status'])
    ->innerJoinWith('role');

    $dataProvider = new ActiveDataProvider([
      'query' => $query,
      'pagination' =>
      [
        'totalCount' => Bookings::find()->count(),
        'pageSize' => 10,
        'page' => $getParams['page'] ?? 0
      ]
    ]);

    return $this->render('bookings', [
      'dataProvider' => $dataProvider
    ]);
  }

  // Displays the data of the selected booking
  public function actionEditBooking()
  {
    if (Yii::$app->request->method == 'GET')
    {
      $getParams = Yii::$app->request->get();

      $booking = null;
      $treatments = null;
      $newEntry = null;

      // Retrieving all roles
      $roles = Roles::find()
      ->select('id, role_name')
      ->all();

      // Creating a new booking
      if (isset($getParams['createNew']) && $getParams['createNew'] == 1)
      {
        $booking = new Bookings();

        $booking->status = 1;

        // For a new booking the first role will be displayed, thus we're getting the first roles treatments
        $treatments = Treatments::find()
        ->select('id, treatment_name')
        ->where('role_id = :role_id', ['role_id' => $roles[0]->id])
        ->all();

        $newEntry = true;
      }
      // Reading an existing booking
      else
      {
        // Retrieving the one selected booking entry
        $booking = Bookings::find()
        ->where('id=:id', [':id' => $getParams['id']])
        ->one();

        // Retrieving all treatments
        $treatments = Treatments::find()
        ->select('id, treatment_name')
        ->where('role_id=:role_id', [':role_id' => $booking->role_id])
        ->all();

        $newEntry = false;
      }

      return $this->render('editBooking', [
          'booking' => $booking,
          'roles' => $roles,
          'treatments' => $treatments,
          'newEntry' => $newEntry,
          'id' => $getParams['id'] ?? null
        ]
      );
    }
    // Updating an existing booking/Saving a new booking
    elseif (Yii::$app->request->method == 'POST')
    {
      $postParams = Yii::$app->request->post();

      // Creating new booking if the flag is set
      $booking = null;
      if (isset($postParams['createNew']) && $postParams['createNew'] == 1)
      {
        $booking = new Bookings();
      }
      else
      {
        // Retrieving the selected booking from the DB
        $booking = Bookings::find()
        ->where('id=:id', [':id' => $postParams['id']])
        ->one();
      }

      // This is a workaround, but writing the values directly into $bookings throws an error
      // Building the treatments array
      $treatments[] = [];
      foreach ($postParams['treatment'] as $key => $value)
      {
        $treatments[] = $key;
      }
      unset($treatments[0]);

      $booking->duration = $postParams['duration'] ?? null;
      $booking->role_id = $postParams['role'];
      $booking->treatment_id = $treatments;
      $booking->date = $postParams['date'];
      $booking->time = $postParams['bookingTime'].':00';
      $booking->patient_salutation = $postParams['salutation'];
      $booking->patient_firstName = $postParams['firstName'];
      $booking->patient_lastName = $postParams['lastName'];
      $booking->patient_birthdate = $postParams['birthdate'];
      $booking->patient_street = $postParams['street'];
      $booking->patient_city = $postParams['city'];
      $booking->patient_zipCode = $postParams['zipCode'];
      $booking->patient_email = $postParams['email'];
      $booking->patient_phoneNumber = $postParams['telephone'];
      $booking->patient_comment = $postParams['comment'];
      $booking->callback = isset($postParams['reminder']) ? 1 : 0;
      $booking->newPatient = isset($postParams['newPatient']) ? 1 : 0;
      $booking->send_confirmation = isset($postParams['sendConfirmation']) ? 1 : 0;
      $booking->status = $postParams['status'];

      if ($booking->validate())
      {
        $booking->save();

        return Yii::$app->getResponse()->redirect('/backend/bookings');
      }
      // TODO: what to do on invalid input
      else
      {
        echo VarDumper::dump($booking->errors, 10, true);
      }
    }
  }

  // Deleting an existing booking
  public function actionDeleteBooking()
  {
    $getParams = Yii::$app->request->post();

    $booking = Bookings::find()
    ->where('id=:id', [':id' => $getParams['id']])
    ->one();

    $booking->delete();

    return Yii::$app->getResponse()->redirect('/backend/bookings');
  }

  // Target for Ajax call for the selection of treatments
  public function actionGetTreatments()
  {
    // Data being sent in format ['role' => '<role_id>']
    $data = Yii::$app->request->get();

    $treatments = Treatments::find()
    ->where('role_id = :role_id', [':role_id' => $data['role']])
    ->all();

    // Creating all the HTML here so that the Ajax function can just inject it into the right place
    $HTMLsnippet = '';
    foreach ($treatments as $treatment) {
      $HTMLsnippet .= "
      <label class=\"sub-input time-checkbox\">&nbsp;$treatment->treatment_name
        <input type=\"checkbox\" name=\"treatment[$treatment->id]\">
      </label>
      ";
    }

    return $HTMLsnippet;
  }

  // The Calendar to be displayed
  public function actionCalendar()
  {
    return $this->render('calendar');
  }

  // Displays all created roles
  public function actionRoles()
  {
    $getParams = Yii::$app->request->get();

    // Decrementing page by one since the dataprovider has 0-based index
    if (isset($getParams['page']))
    {
      $getParams['page'] -= 1;
    }

    $dataProvider = new ActiveDataProvider([
      'query' => Roles::find()->select(['id', 'role_name', 'email', 'status', 'sort_order']),
      'pagination' => [
        'totalCount' => Roles::find()->count(),
        'pageSize' => 10,
        'page' => $getParams['page'] ?? 0
      ]
    ]);

    return $this->render('roles', [
      'dataProvider' => $dataProvider
    ]);
  }

  // TODO: roles with no treatments and no working hours should still be able to show
  // TODO: prevent treatments with empty names from entering the DB
  // Displays the data of the selected role
  public function actionEditRole()
  {
    // Viewing the role
    if (Yii::$app->request->method == 'GET')
    {
      $getParams = Yii::$app->request->get();

      if (isset($getParams['createNew']))
      {
        echo 'Creating new role';
        return;
      }

      // Retrieving the data for the selected role
      $role = Roles::find()
      ->where('roles.id=:id', [':id' => intval($getParams['id'])])
      ->innerJoinWith('treatments')
      ->innerJoinWith('workTimes')
      ->one();

      return $this->render('editRole', [
        'role' => $role,
        'newEntry' => false
      ]);
    }
    // Saving changes made to the viewed role
    elseif (Yii::$app->request->method == 'POST')
    {
      $postParams = Yii::$app->request->post();

      // Retrieving the the data to be changed from the DB
      $role = Roles::find()
      ->where('id=:id', [':id' => $postParams['role_id']])
      ->one();

      $workTimes = WorkTimes::find()
      ->where('role_id=:id', [':id' => $postParams['role_id']])
      ->all();

      $treatments = Treatments::find()
      ->where('role_id=:id', [':id' => $postParams['role_id']])
      ->all();

      // Assigning new role values
      $role->role_name = $postParams['role_name'];
      $role->email = $postParams['email'];
      $role->description = $postParams['description'];
      $role->sort_order = $postParams['sort_order'];
      $role->duration = $postParams['duration'] ?? null;
      $role->status = $postParams['status'];

      // Assigning new work time values and performing input validation on them
      $allWorkTimesAreValid = true;
      for ($i = 0; $i < 7; $i++)
      {
        $workTimes[$i]->from = $postParams['week'][$i]['from'] ?? null;
        $workTimes[$i]->until = $postParams['week'][$i]['until'] ?? null;
        $workTimes[$i]->has_free = (isset($postParams['week'][$i]['has_free'])) ? true : false;

        if (!$workTimes[$i]->validate())
        {
          $allWorkTimesAreValid = false;
        }
      }

      $deleteThese = [];
      $allTreatmentsAreValid = true;

      // Modifying all existing treatment entries
      // Looping over all old entries present in the DB
      foreach ($treatments as $oldTreatment)
      {
        $oldEntryHasBeenModified = false;

        // Finding the respective new entires with matching IDs
        foreach ($postParams['treatments'] as $newTreatment)
        {
          // Only modify an existing old entry, if the new entry has an ID
          if (isset($newTreatment['treatment_id']) && $newTreatment['treatment_id'] == $oldTreatment->id)
          {
            $oldTreatment->treatment_name = $newTreatment['treatment_name'];
            $oldTreatment->sort_order = intval($newTreatment['sort_order']);

            $oldEntryHasBeenModified = true;

            // Validating input
            if (!$oldTreatment->validate())
            {
              $allTreatmentsAreValid = false;
            }

            break;
          }
        }
        unset($newTreatment);

        // Delete the old entry from the DB and mark it for deletion
        if (!$oldEntryHasBeenModified)
        {
          array_push($deleteThese, $oldTreatment->id);
          $oldTreatment->delete();
        }
      }
      unset($oldTreatment);

      // Adding all the entries that are new to the $treatments
      foreach ($postParams['treatments'] as $newTreatment)
      {
        // A newly created entry doesn't have an ID but it does have a name
        // If the name is the empty string, it doesn't get created
        // If only the sort order is set, it doesn't get created
        if (!isset($newTreatment['treatment_id']) && isset($newTreatment['treatment_name']) && $newTreatment['treatment_name'] != '')
        {
          // Creating the new entry
          $newTreatmentElement = new Treatments([
            'role_id' => intval($postParams['role_id']),
            'treatment_name' => $newTreatment['treatment_name'],
            'sort_order' => intval($newTreatment['sort_order'])
          ]);

          array_push($treatments, $newTreatmentElement);

          // Since the newly added array element is the last one we can validate it by simply validating the last array element
          if (!end($treatments)->validate())
          {
            $allTreatmentsAreValid = false;
          }

          // Since end() sets the internal pointer to the end of the array, we set it back to the beginning of the array here
          reset($treatments);
        }
      }
      unset($newTreatment);

      // Input is valid
      if ($role->validate() && $allWorkTimesAreValid && $allTreatmentsAreValid)
      {
        $role->save();

        // TODO: make this work without createCommand()
        // Updating all working hours
        foreach ($workTimes as $key => $workTime)
        {

          $hasFree = $workTime->has_free;

          // Update query for a workday
          $query = Yii::$app->db->createCommand(
            "UPDATE work_times
            SET work_times.from = :from, until = :until, has_free = :has_free
            WHERE role_id = :role_id AND weekday = $key;",
            [
              ':from' => ($hasFree) ? '00:00:00': $workTime->from.':00',
              ':until' => ($hasFree) ? '00:00:00' : $workTime->until.':00',
              ':has_free' => $hasFree,
              ':role_id' => $postParams['role_id']
            ]
          );

          $query->execute();
        }
        unset($workTime);

        // Updating all treatments
        foreach ($treatments as $treatment)
        {
          // Checks, if the current element is marked for deletion
          $deleted = false;
          foreach ($deleteThese as $deleteThis)
          {
            // Element has been found, deleting
            if ($treatment->id == $deleteThis)
            {
              $deleted = true;
              break;
            }
          }

          // Element is not marked for deletion, saving to DB
          if (!$deleted)
          {
            $treatment->save();
          }
        }
        unset($treatment);

        return Yii::$app->getResponse()->redirect('/backend/roles');
      }
      // TODO: input is invalid
      else
      {
      }
    }

    return Yii::$app->getResponse()->redirect('/backend/roles');
  }

  // Deletes the specified role from the DB
  public function actionDeleteRole()
  {
    $getParams = Yii::$app->request->post();
    echo 'Role #'.$getParams['id'].' needs to be deleted.';
  }

  // Displays all created holidays
  public function actionHolidays()
  {
    $getParams = Yii::$app->request->get();

    // Decrementing page by one since the dataprovider has 0-based index
    if (isset($getParams['page']))
    {
      $getParams['page'] -= 1;
    }

    $dataProvider = new ActiveDataProvider([
      'query' => Holidays::find()->select(['id', 'holiday_name', 'date']),
      'pagination' => [
        'totalCount' => Holidays::find()->count(),
        'pageSize' => 10,
        'page' => $getParams['page'] ?? 0
      ]
    ]);

    return $this->render('holidays', [
      'dataProvider' => $dataProvider
    ]);
  }

  // Displays the data of the selected holiday
  public function actionEditHoliday()
  {
    // Viewing the holiday
    if (Yii::$app->request->method == 'GET')
    {
      $getParams = Yii::$app->request->get();

      if (isset($getParams['createNew']))
      {
        $holiday = new Holidays();

        return $this->render('editHoliday', [
          'holiday' => $holiday,
          'newEntry' => true
        ]);
      }

      // Querying the DB for the specified name
      $holiday = Holidays::find()
      ->where('id=:id', [':id' => $getParams['id']])
      ->one();

      return $this->render('editHoliday', [
        'holiday' => $holiday,
        'newEntry' => false
      ]);
    }
    // Saving changes made to the holiday
    elseif (Yii::$app->request->method == 'POST')
    {
      $getInput = Yii::$app->request->post();

      // Adding the new entry to the DB
      if ($getInput['newEntry'])
      {
        $newHoliday = new Holidays();

        $newHoliday->attributes = $getInput;

        // Input is valid
        if ($newHoliday->validate())
        {
          $newHoliday->save();
        }
        // TODO: what to do on invalid input
        else
        {
        }

        return Yii::$app->getResponse()->redirect('/backend/holidays');
      }

      // Retrieving the entry to be changed
      $holiday = Holidays::find()
      ->where('id=:id', [':id' => $getInput['id']])
      ->limit(1)
      ->one();

      // Modifying the selected entry
      $holiday->attributes = $getInput;

      // Input is valid
      if ($holiday->validate())
      {
        $holiday->save();

        return Yii::$app->getResponse()->redirect('/backend/holidays');
      }
      // TODO: what to do on invalid input
      else
      {
      }
    }

    return Yii::$app->getResponse()->redirect('/backend/holidays');
  }

  // Deletes the specified holiday from the DB
  public function actionDeleteHoliday()
  {
    $getParams = Yii::$app->request->post();

    $holiday = Holidays::find()
    ->where('id=:id', [':id' => $getParams['id']])
    ->limit(1)
    ->one();

    $holiday->delete();

    return Yii::$app->getResponse()->redirect('/backend/holidays');
  }
}
