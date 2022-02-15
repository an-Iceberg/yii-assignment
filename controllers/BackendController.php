<?php

namespace app\controllers;

use app\models\Bookings;
use app\models\Holidays;
use app\models\Roles;
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

    $booking = Bookings::find()
    ->where('bookings.id=:id', [':id' => $getParams['id']])
    ->innerJoinWith('role')
    ->innerJoinWith('treatment')
    ->one();

    return $this->render(
      'editBooking',
      [
        'booking' => $booking
      ]
    );
  }

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

  // Displays the data of the selected role
  public function actionEditRole()
  {
    // TODO: only query DB if method is GET
    $getParams = Yii::$app->request->get();

    // TODO: join to treatments and work_times
    $role = Roles::find()
    ->where('id=:id', [':id' => $getParams['id']])
    ->one();

    return $this->render('editRole', [
      'role' => $role
    ]);
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
    // Action for GET
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
    // Action for POST
    elseif (Yii::$app->request->method == 'POST')
    {
      $getInput = Yii::$app->request->post();

      // Retrieving the entry to be changed
      $holiday = Holidays::find()
      ->where('id=:id', [':id' => $getInput['id']])
      ->limit(1)
      ->one();

      // Binding values
      $holiday->holiday_name = $getInput['holiday_name'];
      $holiday->date = $getInput['date'];
      $holiday->beginning_time = $getInput['beginning_time'];
      $holiday->end_time = $getInput['end_time'];

      // Input is valid
      if ($holiday->validate())
      {
        // Creating the UPDATE query
        $updateQuery = Yii::$app->db->createCommand
        (
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

        // Executing query
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
