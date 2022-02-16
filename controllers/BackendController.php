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
    // TODO: only query DB if method is GET
    $getParams = Yii::$app->request->get();

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
  // Displays the data of the selected role
  public function actionEditRole()
  {
    // Viewing the role
    if (Yii::$app->request->method == 'GET')
    {
      $getParams = Yii::$app->request->get();

      // Retrieving the data for the selected role
      $role = Roles::find()
      ->where('roles.id=:id', [':id' => $getParams['id']])
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

      // Retrieving the role and the weekdays to be changed
      $role = Roles::find()
      ->where('id=:id', [':id' => $postParams['role_id']])
      ->one();

      $workTimes = WorkTimes::find()
      ->where('role_id=:id', [':id' => $postParams['role_id']])
      ->all();

      // Assigning new values
      $role->role_name = $postParams['role_name'];
      $role->email = $postParams['email'];
      $role->description = $postParams['description'];
      $role->sort_order = $postParams['sort_order'];
      $role->duration = $postParams['duration'] ?? null;
      $role->status = $postParams['status'];

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

      // Input is valid
      if ($role->validate() && $allWorkTimesAreValid)
      {
        // Update query for the role
        $updateRole = Yii::$app->db->createCommand(
          'UPDATE roles
          SET role_name = :role_name, email = :email, description = :description, sort_order = :sort_order, duration = :duration, status = :status
          WHERE id = :id;'
        );

        // Binding role parameters
        $updateRole->bindValues([
          ':role_name' => $role->role_name,
          ':email' => $role->email,
          ':description' => $role->description,
          ':sort_order' => $role->sort_order,
          ':duration' => $role->duration,
          ':status' => ($role->status) ? true : false,
          ':id' => $postParams['role_id']
        ]);

        $updateRole->execute();

        // Updating all working hours
        for ($i = 0; $i < 7; $i++)
        {
          // Update query for a workday
          $updateWorkTime = Yii::$app->db->createCommand(
            "UPDATE work_times
            SET work_times.from = :from, until = :until, has_free = :has_free
            WHERE role_id = :role_id AND weekday = $i;"
          );

          // Binding workTime parameters
          // Only setting time values, if the day is not set to 'free'
          $updateWorkTime->bindValues([
            ':from' => ($workTimes[$i]->has_free) ? '00:00:00': $workTimes[$i]->from.':00',
            ':until' => ($workTimes[$i]->has_free) ? '00:00:00' : $workTimes[$i]->until.':00',
            ':has_free' => $workTimes[$i]->has_free,
            ':role_id' => $postParams['role_id']
          ]);

          $updateWorkTime->execute();
        }

        return Yii::$app->getResponse()->redirect('/backend/roles');
      }
      // TODO: input is invalid
      else
      {
      }

      return $this->render('editRole', [
        'role' => $role,
        // 'workTimes' => $workTimes,
        // 'postParams' => $postParams
      ]);
    }
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

      // Querying the DB for the specified name
      $holiday = Holidays::find()
      ->where('id=:id', [':id' => $getParams['id']])
      ->one();

      return $this->render('editHoliday', [
        'holiday' => $holiday
      ]);
    }
    // Saving changes made to the holiday
    elseif (Yii::$app->request->method == 'POST')
    {
      $getInput = Yii::$app->request->post();

      // Retrieving the entry to be changed
      $holiday = Holidays::find()
      ->where('id=:id', [':id' => $getInput['id']])
      ->limit(1)
      ->one();

      // Assigning new values
      $holiday->holiday_name = $getInput['holiday_name'];
      $holiday->date = $getInput['date'];
      $holiday->beginning_time = $getInput['beginning_time'];
      $holiday->end_time = $getInput['end_time'];

      // Input is valid
      if ($holiday->validate())
      {
        // Creating the UPDATE query
        $updateQuery = Yii::$app->db->createCommand(
          'UPDATE holidays
          SET holiday_name = :holiday_name, date = :date, beginning_time = :beginning_time, end_time = :end_time
          WHERE id = :id;'
        );

        // Binding parameters (to prevent SQL-Injection)
        $updateQuery->bindValues([
          ':holiday_name' => $holiday->holiday_name,
          ':date' => $holiday->date,
          ':beginning_time' => $holiday->beginning_time,
          ':end_time' => $holiday->end_time,
          ':id' => $getInput['id']
        ]);

        $updateQuery->execute();

        return Yii::$app->getResponse()->redirect('/backend/holidays');
      }
      // TODO: what to do on invalid input
      else
      {
      }

      $holiday->name = 'something went wrong';

      return $this->render('editHoliday', [
        'holiday' => $holiday,
        'getInput' => $getInput
      ]);
    }
  }
}
