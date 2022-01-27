<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use app\models\Profession;
use app\models\Treatment;

class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    /**
     * Login action.
     *
     * @return Response|string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }

        $model->password = '';
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return Response|string
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        }
        return $this->render('contact', [
            'model' => $model,
        ]);
    }

    /**
     * Displays about page.
     *
     * @return string
     */
    public function actionAbout()
    {
        return $this->render('about');
    }

  /**
   * Displays the page to book an appointment
   *
   * @return string
   */
  public function actionBooking()
  {
    $profession = Profession::getAllProfessions();

    return $this->render('booking', [
      'data' => $profession
    ]);
  }

  /**
   * Target for Ajax call
   *
   * @return void|string
   */
  public function actionTreatment()
  {
    // If this site is not accessed via POST method, redirect to /site/booking
    if (Yii::$app->request->method != 'POST')
    {
      $this->redirect('/site/booking');
    }

    // Extracting the relevant input data from the request
    $booking = Yii::$app->request->bodyParams['booking'];

    // Retrieving data from database
    $queryResults = Treatment::getTreatments($booking['doctor']);

    // Extracting the treatments from $queryResults and applying HTML formatting to it so it can just be inserted into the correct place without any additional editing
    $treatments = '';
    for ($i = 0; $i < sizeof($queryResults); $i++)
    {
      $treatments .=
      '<label>'.
      '<input type="radio" name="booking[treatment]" value="'.
      $queryResults[$i]->treatment.
      '"> '.
      $queryResults[$i]->treatment.
      '</label>';

      if ($i < sizeof($queryResults) - 1)
      {
        $treatments .= '<br>';
      }
    }

    return $treatments;
  }

  /**
   * Target for Ajax call
   *
   * @return void
   */
  public function actionDate()
  {
    // If this site is not accessed via POST method, redirect to /site/booking
    if (Yii::$app->request->method != 'POST')
    {
      $this->redirect('/site/booking');
    }
  }


  /**
   * Displays booked appointment on successful booking
   *
   * @return void|string
   */
  public function actionInputValidation()
  {
    // If this site is not accessed via POST method, redirect to /site/booking
    if (Yii::$app->request->method != 'POST')
    {
      $this->redirect('/site/booking');
    }

    $parameters = Yii::$app->request->bodyParams;

    return $this->render('bookingSuccess', [
      'request' => $parameters
    ]);
  }
}
