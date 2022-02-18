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

      if (isset($getParams['createNew']))
      {
        echo 'Creating new booking';
        return;
      }

      // Retrieving the one selected booking entry
      $booking = Bookings::find()
      ->where('id=:id', [':id' => $getParams['id']])
      ->one();

      // Retrieving all roles
      $roles = Roles::find()
      ->select('id, role_name')
      ->all();

      // Retrieving all treatments
      $treatments = Treatments::find()
      ->select('id, treatment_name')
      ->where('role_id=:role_id', [':role_id' => $booking->role_id])
      ->all();

      return $this->render('editBooking', [
          'booking' => $booking,
          'roles' => $roles,
          'treatments' => $treatments
        ]
      );
    }
    elseif (Yii::$app->request->method == 'POST')
    {
      $postParams = Yii::$app->request->post();

      if (isset($postParams['createNew']))
      {
        // TODO: creating a new booking
        return;
      }

      $booking = Bookings::find()
      ->where('id=:id', [':id' => $postParams['']])
      ->one();

      // TODO: modify existing booking and write it back into the DB
    }
  }

  // Deletes the specified booking from the DB
  public function actionDeleteBooking()
  {
    $getParams = Yii::$app->request->post();
    echo 'Booking #'.$getParams['id'].' needs to be deleted.';
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

  // TODO: fix 'cat' not loading
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
        'role' => $role
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

      // * Alternative method: delete all entries with the current role_id from the DB and insert all new values into it
      // * That has to be done using a transaction though
      // Modifying all existing treatment entries
      // Looping over all old entries present in the DB
      foreach ($treatments as $key => $oldTreatment)
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

        // Delete the old entry from the DB
        if (!$oldEntryHasBeenModified)
        {
          array_push($deleteThese, $treatments[$key]->id);
          // Apparently, calling unset() on the array element has no effect on it, this however works
          // Try $oldTreatment->delete()
          unset($treatments[$key]);
          unset($oldTreatment);
        }
      }

      // Adding all the entries that are new to the $treatments
      foreach ($postParams['treatments'] as $newTreatment)
      {
        // A newly created entry doesn't have an ID but it does have a name (in case the new entry only has sort order set it gets ignored)
        if (!isset($newTreatment['treatment_id']) && isset($newTreatment['treatment_name']))
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

      // Input is valid
      if ($role->validate() && $allWorkTimesAreValid && $allTreatmentsAreValid)
      {
        $role->save();

        // * createCommand calls bindValues internally
        // Update query for the role
        // $updateRole = Yii::$app->db->createCommand(
        //   'UPDATE roles
        //   SET role_name = :role_name, email = :email, description = :description, sort_order = :sort_order, duration = :duration, status = :status
        //   WHERE id = :id;', [
        //     ':role_name' => $role->role_name,
        //     ':email' => $role->email,
        //     ':description' => $role->description,
        //     ':sort_order' => $role->sort_order,
        //     ':duration' => $role->duration,
        //     ':status' => ($role->status) ? true : false,
        //     ':id' => $postParams['role_id']
        //   ]
        // );

        // $updateRole->execute();

        // Updating all working hours
        foreach ($workTimes as $key => $workTime)
        {
          // TODO: make this work with $workTime->save();

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

        // Updating all treatments
        foreach ($treatments as $treatment)
        {
          $treatment->save();
          // $query = null;

          // // If the ID is not set, create a new entry
          // if (!isset($treatment->id))
          // {
          //   $query = Yii::$app->db->createCommand(
          //     'INSERT INTO treatments (role_id, treatment_name, sort_order)
          //     VALUES(:role_id, :treatment_name, :sort_order);',
          //     [
          //       ':role_id' => intval($postParams['role_id']),
          //       ':treatment_name' => $treatment->treatment_name,
          //       ':sort_order' => intval($treatment->sort_order)
          //     ]
          //   );

          //   $query->execute();
          // }
          // // Update an existing entry
          // else
          // {
          //   $query = Yii::$app->db->createCommand(
          //     'UPDATE treatments
          //     SET treatment_name = :treatment_name, sort_order = :sort_order
          //     WHERE id = :id AND role_id = :role_id;',
          //     [
          //       ':treatment_name' => $treatment->treatment_name,
          //       ':sort_order' => $treatment->sort_order,
          //       ':id' => $treatment->id,
          //       ':role_id' => $postParams['role_id']
          //     ]
          //   );

          //   $query->execute();
          // }
        }

        // Deleting all old entries that are marked for deletion
        // TODO: make deletions work with only ->save()
        foreach ($deleteThese as $oldEntry)
        {
          $query = Yii::$app->db->createCommand(
            'DELETE FROM treatments
            WHERE role_id = :role_id AND id = :id;',
            [
              ':role_id' => $postParams['role_id'],
              ':id' => $oldEntry
            ]
          );

          $query->execute();
        }

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
