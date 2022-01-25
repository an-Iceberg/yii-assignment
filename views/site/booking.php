<?php
use app\assets\BookingAsset;
use app\models\Booking;
use yii\helpers\Html;
// use yii\helpers\VarDumper;
use yii\widgets\ActiveForm;

BookingAsset::register($this);

$booking = new Booking();
?>

<h1>Booking Form</h1>
<hr>

<?php // Booking form
$bookingForm = ActiveForm::begin([
  'id' => 'booking-form',
  'action' => '/site/input-validation',
  'method' => 'post'
]); ?>

  <div id="treatment-type">

    <h2 class="h3">Choose a treatment type</h2>

    <?php // Type of treatment
    // Prints all treatment types in $data
    foreach ($data as $entry) { ?>

      <label class="capitalize">
        <input type="radio" name="Booking[doctor]" value="<?= $entry['profession']?>">
        <?= $entry['profession'] ?>
      </label>
      <br>

    <?php } ?>

      <div class="form-group col-lg-offset-1 col-lg-11">
        <span class="btn btn-secondary not-visible">Back</span>
        <span id="type-next-btn" class="btn btn-primary">Next</span>
      </div>

  </div>


  <div id="treatment" class="capitalize">

    <h2 class="h3">Choose a treatment</h2>

    <?= // Treatment
    'treatment input goes here' ?>

      <div class="form-group col-lg-offset-1 col-lg-11">
        <span id="treatment-back-btn" class="btn btn-outline-secondary">Back</span>
        <span id="treatment-next-btn" class="btn btn-primary">Next</span>
      </div>

  </div>


  <div id="date" class="capitalize">

    <h2 class="h3">Pick a date that's suitable for you</h2>

    <?= // Date
    'date input goes here' ?>

      <div class="form-group col-lg-offset-1 col-lg-11">
        <span id="date-back-btn" class="btn btn-outline-secondary">Back</span>
        <span id="date-next-btn" class="btn btn-primary">Next</span>
      </div>

  </div>


  <div id="personal-data" class="capitalize">

    <h2 class="h3">Please enter your personal data</h2>

    <?= // Personal data
    'personal data input goes here' ?>

      <div class="form-group col-lg-offset-1 col-lg-11">
        <span id="data-back-btn" class="btn btn-outline-secondary">Back</span>
        <span id="data-next-btn" class="btn btn-primary">Next</span>
      </div>

  </div>


  <div id="overview" class="capitalize">

    <h2 class="h3">Overview</h2>

    <?= // Overview
    'overview goes here' ?>

      <div class="form-group col-lg-offset-1 col-lg-11">
        <span id="overview-back-btn" class="btn btn-outline-secondary">Back</span>
        <?= Html::submitButton('Submit', [
          'class' => 'btn btn-primary submit-button',
          'id' => 'overview-submit-btn'
        ]) ?>
      </div>

  </div>

<?php ActiveForm::end(); ?>
