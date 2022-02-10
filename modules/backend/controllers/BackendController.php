<?php

namespace app\modules\backend\controllers;

use app\models\Bookings;
use app\models\Holidays;
use app\models\Roles;
use Yii;
use yii\base\Controller;
use yii\data\ActiveDataProvider;
use yii\data\Pagination;
use yii\data\Sort;

class BackendController extends Controller
{
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
    $pagination = new Pagination([
      'totalCount' => Bookings::find()->count(),
      'pageSize' => 4,
      'page' => 0
    ]);

    $bookings = Bookings::find()
    ->select(['role', 'patient_salutation', 'patient_lastName', 'date'])
    ->offset($pagination->offset)
    ->limit($pagination->limit)
    ->orderBy('date ASC')
    ->all();

    return $this->render('bookings', [
      'bookings' => $bookings
    ]);
  }

  // Displays the data of the selected booking
  public function actionEditBooking()
  {
    return $this->render('editBooking');
  }

  public function actionCalendar()
  {
    return $this->render('calendar');
  }

  // Displays all created roles
  public function actionRoles()
  {
    $pagination = new Pagination([
      'totalCount' => Roles::find()->count(),
      'pageSize' => 10,
      'page' => 0
    ]);

    $roles = Roles::find()
    ->select(['role', 'email', 'status', 'sort_order'])
    ->offset($pagination->offset)
    ->limit($pagination->limit)
    ->orderBy('sort_order ASC')
    ->all();

    return $this->render('roles', [
      'roles' => $roles
    ]);
  }

  // Displays the data of the selected role
  public function actionEditRole()
  {
    return $this->render('editRole');
  }

  public function actionHolidays()
  {
    $pagination = new Pagination([
      'totalCount' => Holidays::find()->count(),
      'pageSize' => 10,
      'page' => 0
    ]);

    $holidays = Holidays::find()
    ->select(['name', 'date'])
    ->offset($pagination->offset)
    ->limit($pagination->limit)
    ->orderBy('date ASC')
    ->all();

    return $this->render('holidays', [
      'holidays' => $holidays
    ]);
  }

  // Displays the data of the selected holiday
  public function actionEditHoliday()
  {
    return $this->render('editHoliday');
  }
}
