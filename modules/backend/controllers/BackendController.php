<?php

namespace app\modules\backend\controllers;

use app\modules\backend\models\Booking;
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

  public function actionBookings()
  {
    // $getParams = Yii::$app->request->get();
    // if (isset($getParams['page']))
    // {
    //   $getParams['page']--;
    // }

    $pagination = new Pagination([
      'totalCount' => Booking::find()->count(),
      'pageSize' => 4,
      'page' => 0
    ]);

    // $sort = new Sort([ // Doesn't work
    //   'attributes' => [
    //     'date'
    //   ]
    // ]);

    $bookings = Booking::find()
    ->select(['role', 'patient_salutation', 'patient_lastName', 'date'])
    ->offset($pagination->offset)
    ->limit($pagination->limit)
    ->orderBy('date ASC') // <== this is uninitialized, 'date ASC' would work
    ->all();

    // ? Maybe a self-made grid would prove easier in the long run?
    // $provider = new ActiveDataProvider([
    //   'query' => Booking::find()
    //   ->select(['role', 'patient_salutation', 'patient_lastName', 'date'])
    //   ->orderBy('date ASC'),
    //   'pagination' => [
    //     'totalCount' => Booking::find()->count(),
    //     'pageSize' => 4,
    //     'page' => $getParams['page'] ?? 0
    //   ],
    // ]);

    return $this->render('bookings', [
      'bookings' => $bookings
    ]);
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