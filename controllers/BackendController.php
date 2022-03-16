<?php

namespace app\controllers;

use app\models\Bookings;
use app\models\BookingsSearch;
use app\models\Holidays;
use app\models\HolidaysSearch;
use app\models\Roles;
use app\models\RolesSearch;
use app\models\Treatments;
use app\models\WhoHasHolidays;
use app\models\WorkTimes;
use Yii;
use yii\base\Controller;
use yii\data\ActiveDataProvider;
use yii\db\Query;
use yii\filters\AccessControl;
use yii\helpers\VarDumper;

class BackendController extends Controller
{
  public $layout = 'backend_layout';

  /** {@inheritDoc} */
  public function behaviors()
  {
    return [
      'access' => [
        'class' => AccessControl::class,
        'only' => [
          'index',
          'bookings',
          'edit-bookings',
          'delete-booking',
          'calendar',
          'roles',
          'edit-role',
          'delete-role',
          'holidays',
          'edit-holiday',
          'delete-holiday'
        ],
        'rules' => [
          [
            // Unauthorized users are redirected to the login page
            'allow' => true,
            'actions' => ['index'],
            'roles' => ['?']
          ],
          [
            'allow' => true,
            'actions' => [
              'bookings',
              'edit-bookings',
              'delete-booking',
              'calendar',
              'roles',
              'edit-role',
              'delete-role',
              'holidays',
              'edit-holiday',
              'delete-holiday'
            ],
            'roles' => ['@']
          ]
        ]
      ]
    ];
  }

  /** This is the login page for the backend */
  public function actionIndex()
  {
    if (Yii::$app->request->method == 'POST')
    {
      VarDumper::dump(Yii::$app->request->post(), 10, true);

      $postParams = Yii::$app->request->post();
    }

    $this->layout = '@app/views/layouts/main.php';

    // If a user is already logged in, redirect to the bookings page
    if (!Yii::$app->user->isGuest)
    {
      return Yii::$app->getResponse()->redirect('/backend/bookings');
    }

    return $this->render('index');
  }

  /** Displays all bookings present in the DB */
  public function actionBookings()
  {
    $getParams = Yii::$app->request->get();

    // Decrementing page by one since the dataprovider has 0-based index
    (isset($getParams['page'])) ? $getParams['page'] -= 1 : '';

    $searchModel = new BookingsSearch();
    $dataProvider = $searchModel->search($getParams);

    return $this->render('bookings', [
      'dataProvider' => $dataProvider,
      'searchModel' => $searchModel
    ]);
  }

  /** Displays the data of the selected booking */
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
      ->select('id, role_name, status')
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

  /** Deleting an existing booking */
  public function actionDeleteBooking()
  {
    $getParams = Yii::$app->request->post();

    $booking = Bookings::find()
    ->where('id=:id', [':id' => $getParams['id']])
    ->one();

    $booking->delete();

    return Yii::$app->getResponse()->redirect('/backend/bookings');
  }

  /** Target for Ajax call for the selection of treatments */
  public function actionGetTreatments()
  {
    // Data being sent in format ['role' => '<role_id>']
    $data = Yii::$app->request->get();

    $treatments = Treatments::find()
    ->where('role_id = :role_id', [':role_id' => $data['role']])
    ->all();

    // Creating all the HTML here so that the Ajax function can just inject it into the right place
    $HTMLsnippet = '';
    foreach ($treatments as $treatment)
    {
      $HTMLsnippet .= "
      <label class=\"sub-input time-checkbox\">&nbsp;$treatment->treatment_name
        <input type=\"checkbox\" name=\"treatment[$treatment->id]\">
      </label>
      ";
    }

    return $HTMLsnippet;
  }

  /** The Calendar to be displayed */
  public function actionCalendar()
  {
    return $this->render('calendar');
  }

  /** Displays all created roles */
  public function actionRoles()
  {
    $getParams = Yii::$app->request->get();

    // Decrementing page by one since the dataprovider has 0-based index
    if (isset($getParams['page']))
    {
      $getParams['page'] -= 1;
    }

    $searchModel = new RolesSearch();
    $dataProvider = $searchModel->search($getParams);

    return $this->render('roles', [
      'dataProvider' => $dataProvider,
      'searchModel' => $searchModel
    ]);
  }

  // TODO: refactor and clean this mess up
  /** Displays the data of the selected role */
  public function actionEditRole()
  {
    // Viewing the role
    if (Yii::$app->request->method == 'GET')
    {
      $getParams = Yii::$app->request->get();

      $newEntry = null;
      $role = null;
      $treatments = null;
      $workTimes = null;
      $holidays = Holidays::find()->select(['id', 'holiday_name'])->all();
      $selectedHolidays = null;

      if (isset($getParams['createNew']) && $getParams['createNew'] == 1)
      {
        $newEntry = true;

        $role = new Roles();
        $treatments = [
          new Treatments(),
          new Treatments(),
          new Treatments()
        ];

        // Generating an array of empty work times
        $workTimes = [];
        for ($i = 0; $i < 7; $i++)
        {
          $workTimes[$i] = new WorkTimes();
          $workTimes[$i]->weekday = $i;
          $workTimes[$i]->from = '08:00:00';
          $workTimes[$i]->until = '17:00:00';
          $workTimes[$i]->has_free = false;
        }

        $role->status = 1;
      }
      else
      {
        $newEntry = false;

        // Useing separate queries to retrieve additional info for roles
        // Because joins return null if they don't find any data
        $role = Roles::find()
        ->where('roles.id=:id', [':id' => intval($getParams['id'])])
        ->one();

        $treatments = Treatments::find()
        ->where('role_id = :role_id', [':role_id' => intval($getParams['id'])])
        ->all();

        $workTimes = WorkTimes::find()
        ->where('role_id = :role_id', [':role_id' => intval($getParams['id'])])
        ->all();

        $selectedHolidays = WhoHasHolidays::find()
        ->where('role_id = :role_id', [':role_id' => intval($getParams['id'])])
        ->all();
      }

      return $this->render('editRole', [
        'role' => $role,
        'treatments' => $treatments,
        'workTimes' => $workTimes,
        'newEntry' => $newEntry,
        'holidayData' => $holidays,
        'selectedHolidays' => $selectedHolidays
      ]);
    }
    // Saving changes made to the viewed role
    elseif (Yii::$app->request->method == 'POST')
    {
      $postParams = Yii::$app->request->post();

      $role = null;
      $treatments = null;
      $workTimes = null;
      $holidays = null;

      // Saving a new entry
      if (isset($postParams['createNew']) && $postParams['createNew'] == 1)
      {
        // Creating new Active Record objects
        $role = new Roles();
        $treatments = [];
        $workTimes = null;
        for ($i = 0; $i < 7; $i++)
        {
          $workTimes[$i] = new WorkTimes();
        }

        // Assigning new role values
        $role->role_name = $postParams['role_name'];
        $role->email = $postParams['email'];
        $role->description = $postParams['description'];
        $role->sort_order = $postParams['sort_order'];
        $role->duration = $postParams['duration'] ?? null;
        $role->status = $postParams['status'];

        // Now the new role has an ID with which we can save all the other data as well
        if ($role->validate())
        {
          $role->save();
        }
        else
        {
          echo 'input invalid';
          return;
        }

        // Creating new treatments for the new role and saving them
        foreach ($postParams['treatments'] as $treatment)
        {
          $newTreatment = new Treatments();
          $newTreatment->role_id = $role->id;
          $newTreatment->treatment_name = $treatment['treatment_name'];
          $newTreatment->sort_order = $treatment['sort_order'];

          // Only save if the input is valid and not the empty string
          if ($newTreatment->validate() && $newTreatment->treatment_name != '')
          {
            $newTreatment->save();
          }
        }
        unset($treatment);

        // Creating new work time values and saving them if valid
        foreach ($postParams['week'] as $key => $weekday)
        {
          $hasFree = isset($weekday['has_free']) ? true : false;

          $newWorkTime = new WorkTimes();
          $newWorkTime->role_id = $role->id;
          $newWorkTime->weekday = $key;
          $newWorkTime->from = (!$hasFree) ? $weekday['from'].':00' : null;
          $newWorkTime->until = (!$hasFree) ? $weekday['until'].':00' : null;
          $newWorkTime->has_free = $hasFree;

          if ($newWorkTime->validate())
          {
            $newWorkTime->save();
          }
        }
        unset($weekday);

        // Creating new holiday relations and saving them
        foreach ($postParams['holiday'] as $key => $holiday)
        {
          $newHoliday = new WhoHasHolidays();
          $newHoliday->role_id = intval($role->id);
          $newHoliday->holiday_id = $key;

          if ($newHoliday->validate())
          {
            $newHoliday->save();
          }
        }
        unset($holiday);

        return Yii::$app->getResponse()->redirect('/backend/roles');
      }

      // Retrieving the data to be changed from the DB
      $role = Roles::find()
      ->where('id=:id', [':id' => $postParams['role_id']])
      ->one();

      $workTimes = WorkTimes::find()
      ->where('role_id=:id', [':id' => $postParams['role_id']])
      ->all();

      $treatments = Treatments::find()
      ->where('role_id=:id', [':id' => $postParams['role_id']])
      ->all();

      $holidays = WhoHasHolidays::find()
      ->where('role_id = :role_id', [':role_id' => $postParams['role_id']])
      ->all();

      // Assigning new role values
      $role->role_name = $postParams['role_name'];
      $role->email = $postParams['email'];
      $role->description = $postParams['description'];
      $role->sort_order = $postParams['sort_order'];
      $role->duration = $postParams['duration'] ?? null;
      $role->status = $postParams['status'];

      if ($role->validate())
      {
        $role->save();
      }

      // Assigning new work time values and performing input validation on them
      foreach ($workTimes as $key => $workTime)
      {
        $hasFree = (isset($postParams['week'][$key]['has_free'])) ? true : false;

        $workTime->from = ($hasFree) ? '00:00:00' : $postParams['week'][$key]['from'];
        $workTime->until = ($hasFree) ? '00:00:00' : $postParams['week'][$key]['until'];
        $workTime->has_free = $hasFree;

        if ($workTime->validate())
        {
          $workTime->save();
        }
      }

      // Modifying all existing treatment entries
      // Looping over all old entries present in the DB
      foreach ($treatments as $oldTreatment)
      {
        $oldEntryHasBeenModified = false;

        // Finding the respective new entry with matching ID
        foreach ($postParams['treatments'] as $newTreatment)
        {
          // Only modifying an existing old entry, if the new entry has an ID
          if (isset($newTreatment['treatment_id']) && $newTreatment['treatment_id'] == $oldTreatment->id)
          {
            $oldTreatment->treatment_name = $newTreatment['treatment_name'];
            $oldTreatment->sort_order = intval($newTreatment['sort_order']);

            $oldEntryHasBeenModified = true;

            // Validating input
            if ($oldTreatment->validate())
            {
              // Save modified treatment to DB
              $oldTreatment->save();
            }

            break;
          }
        }
        unset($newTreatment);

        // Delete the old entry from the DB
        if (!$oldEntryHasBeenModified)
        {
          $oldTreatment->delete();
        }
      }
      unset($oldTreatment);

      // Adding newly created treatments
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
          if (end($treatments)->validate())
          {
            $newTreatmentElement->save();
          }

          // Since end() sets the internal pointer to the end of the array, we set it back to the beginning of the array here
          reset($treatments);
        }
      }
      unset($newTreatment);

      WhoHasHolidays::getDb()->transaction(function($db) use ($holidays, $postParams)
      {
        // A very rudimentary solution ngl, but it works
        // All we do here is deleting all existing holiday relations and saving all the ones in the payload
        // This is a lot easier than detecting if an entry was changed, deleted or is new

        // Deleting all DB entries
        foreach ($holidays as $holiday) {
          $holiday->delete();
        }

        // If any holiday relations are present, write them all into the DB
        if (isset($postParams['holiday']))
        {
          // Saving all entries supplied in the POST payload
          foreach ($postParams['holiday'] as $key => $holiday)
          {
            $newHoliday = new WhoHasHolidays();

            $newHoliday->role_id = $postParams['role_id'];
            $newHoliday->holiday_id = $key;

            if ($newHoliday->validate())
            {
              $newHoliday->save();
            }
          }
        }
      });
    }

    return Yii::$app->getResponse()->redirect('/backend/roles');
  }

  /** Deletes the specified role from the DB */
  public function actionDeleteRole()
  {
    // Extracting the id of the role
    $getParams = Yii::$app->request->post();
    $roleId = $getParams['id'];

    // Deleting the role
    $role = Roles::find()
    ->where('id = :id', [':id' => $roleId])
    ->one();
    $role->delete();

    // Deleting all treatments of said role
    $treatments = Treatments::find()
    ->where('role_id = :role_id', [':role_id' => $roleId])
    ->all();
    foreach ($treatments as $treatment)
    {
      $treatment->delete();
    }

    // Deleting all work times of said role
    $workTimes = WorkTimes::find()
    ->where('role_id = :role_id', [':role_id' => $roleId])
    ->all();
    foreach ($workTimes as $workTime)
    {
      $workTime->delete();
    }

    // Deleting all holiday relations of said role
    $holidays = WhoHasHolidays::find()
    ->where('role_id = :role_id', [':role_id' => $roleId])
    ->all();
    foreach ($holidays as $holiday)
    {
      $holiday->delete();
    }

    return Yii::$app->getResponse()->redirect('/backend/roles');
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

    $searchModel = new HolidaysSearch();
    $dataProvider = $searchModel->search($getParams);

    return $this->render('holidays', [
      'dataProvider' => $dataProvider,
      'searchModel' => $searchModel
    ]);
  }

  /** Displays the data of the selected holiday */
  public function actionEditHoliday()
  {
    // Viewing the holiday
    if (Yii::$app->request->method == 'GET')
    {
      $getParams = Yii::$app->request->get();

      if (isset($getParams['createNew']) && $getParams['createNew'] == 1)
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

      // Creating a new holiday
      if (isset($getInput['createNew']) && $getInput['createNew'] == 1)
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
          // Use $model->getErrors()
        }

        return Yii::$app->getResponse()->redirect('/backend/holidays');
      }

      // Reading the holiday
      $holiday = Holidays::find()
      ->where('id=:id', [':id' => $getInput['id']])
      ->limit(1)
      ->one();

      // Modifying the selected entry
      $holiday->attributes = $getInput;

      // Input is valid
      if ($holiday->validate())
      {
        // Updating the holiday
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

  /** Deletes the specified holiday from the DB */
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
