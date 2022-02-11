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

use function Symfony\Component\String\b;

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
    $getParams = Yii::$app->request->get();

    // Default sort criterium
    $sortCriterium = 'date ASC';

    // Applies sorting criterium only if said sorting criterium is set
    if (isset($getParams['dateSort']))
    {
      BackendController::setSorting($sortCriterium, $getParams['dateSort'], 'date');
    }
    elseif (isset($getParams['nameSort']))
    {
      BackendController::setSorting($sortCriterium, $getParams['nameSort'], 'patient_lastName');
    }

    // Creates pagination numbers
    $pagination = new Pagination([
      'totalCount' => Bookings::find()->count(),
      'pageSize' => 5,
      'page' => 0
    ]);

    // Queryies DB with said pagination numbers
    $bookings = Bookings::find()
    ->select(['role', 'patient_salutation', 'patient_lastName', 'date'])
    ->offset($pagination->offset)
    ->limit($pagination->limit)
    ->orderBy($sortCriterium)
    ->all();

    return $this->render('bookings', [
      'bookings' => $bookings,
      'getParams' => $getParams
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
    $getParams = Yii::$app->request->get();

    // Default sort criterium
    $sortCriterium = 'sort_order ASC';

    // Applies sorting criterium only if said sorting cirterium is set
    if (isset($getParams['roleSort']))
    {
      BackendController::setSorting($sortCriterium, $getParams['roleSort'], 'role');
    }
    elseif (isset($getParams['emailSort']))
    {
      BackendController::setSorting($sortCriterium, $getParams['emailSort'], 'email');
    }
    elseif (isset($getParams['statusSort']))
    {
      BackendController::setSorting($sortCriterium, $getParams['statusSort'], 'status');
    }
    elseif (isset($getParams['sortOrder']))
    {
      BackendController::setSorting($sortCriterium, $getParams['sortOrder'], 'sort_order');
    }

    // Creates pagination numbers
    $pagination = new Pagination([
      'totalCount' => Roles::find()->count(),
      'pageSize' => 10,
      'page' => 0
    ]);

    // Queryies DB with said pagination numbers
    $roles = Roles::find()
    ->select(['role', 'email', 'status', 'sort_order'])
    ->offset($pagination->offset)
    ->limit($pagination->limit)
    ->orderBy($sortCriterium)
    ->all();

    return $this->render('roles', [
      'roles' => $roles,
      'getParams' => $getParams
    ]);
  }

  // Displays the data of the selected role
  public function actionEditRole()
  {
    return $this->render('editRole');
  }

  public function actionHolidays()
  {
    $getParams = Yii::$app->request->get();

    // Default sort criterium
    $sortCriterium = 'name ASC';

    // Applies sorting criterium only if said sorting criterium is set
    if (isset($getParams['nameSort']))
    {
      BackendController::setSorting($sortCriterium, $getParams['nameSort'], 'name');
    }
    elseif (isset($getParams['dateSort']))
    {
      BackendController::setSorting($sortCriterium, $getParams['dateSort'], 'date');
    }

    // Creates pagination numbers
    $pagination = new Pagination([
      'totalCount' => Holidays::find()->count(),
      'pageSize' => 10,
      'page' => 0
    ]);

    // Queryies DB with said pagination numbers
    $holidays = Holidays::find()
    ->select(['name', 'date'])
    ->offset($pagination->offset)
    ->limit($pagination->limit)
    ->orderBy($sortCriterium)
    ->all();

    return $this->render('holidays', [
      'holidays' => $holidays,
      'getParams' => $getParams
    ]);
  }

  // Displays the data of the selected holiday
  public function actionEditHoliday()
  {
    return $this->render('editHoliday');
  }

  // Helper function to avoid code repetition
  // Sets the sorting criterium according to the URL parameter
  public static function setSorting(&$criterium, &$URLparameter, $columnName)
  {
    switch ($URLparameter)
    {
      case 1: $criterium = "$columnName ASC"; break;
      case 2: $criterium = "$columnName DESC"; break;
      default: break;
    }
  }
}
