<?php
use app\assets\BookingAsset;
use app\models\Booking;
use yii\helpers\Html;
use yii\helpers\VarDumper;
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

    <h2>Choose a treatment type</h2>

    <?php // Type of treatment // Prints all treatment types in $data
    foreach ($data as $entry) { ?>

      <label>
        <input type="radio" name="Booking[doctor]" value="<?= $entry['profession']?>">
        <?= $entry['profession'] ?>
      </label>
      <br>

    <?php } ?>

  </div>

  <div id="treatment">

    <?= // Treatment
    'treatment input goes here' ?>

    <div class="form-group">
      <div class="col-lg-offset-1 col-lg-11">
        <span class="btn btn-primary">Next</span>
      </div>
    </div>

  </div>

  <div id="date">

    <?= // Date
    'date input goes here' ?>

    <div class="form-group">
      <div class="col-lg-offset-1 col-lg-11">
        <span class="btn btn-primary">Next</span>
      </div>
    </div>

  </div>

  <div id="personal-data">

    <?= // Personal data
    'personal data input goes here' ?>

    <div class="form-group">
      <div class="col-lg-offset-1 col-lg-11">
        <span class="btn btn-primary">Next</span>
      </div>
    </div>

  </div>

  <div id="overview">

    <?= // Overview
    'overview goes here' ?>

    <div class="form-group">
      <div class="col-lg-offset-1 col-lg-11">
        <span class="btn btn-primary">Next</span>
      </div>
    </div>

  </div>

  <!-- <div class="form-group">
    <div class="col-lg-offset-1 col-lg-11">
      <?= Html::submitButton('Submit', ['class' => 'btn btn-primary']) ?>
    </div>
  </div> -->

<?php ActiveForm::end(); ?>
