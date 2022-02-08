<?php

namespace app\modules\backend\controllers;

use yii\base\Controller;

class BackendController extends Controller
{
  // This is the login page for the backend
  public function actionIndex()
  {
    $this->layout = '@app/views/layouts/main.php';
    return $this->render('index');
  }

  public function actionBookings()
  {
    return $this->render('bookings');
  }

  public function actionCalendar()
  {
    return $this->render('calendar');
  }

  public function actionRoles()
  {
    return $this->render('roles');
  }

  public function actionHolidays()
  {
    return $this->render('holidays');
  }
}