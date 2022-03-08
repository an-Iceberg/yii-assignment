<?php

/**
 * This view expects:
 * @var int $role
 * @var array $treatments
 * @var int $totalDuration
 * @var string $time
 * @var string $date
 */

use app\assets\NextAndBackButtonsAsset;
use app\assets\PersonalInfoCSSAsset;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

NextAndBackButtonsAsset::register($this);
PersonalInfoCSSAsset::register($this);
?>

<?php ActiveForm::begin([
  'method' => 'post',
  'action' => '/booking'
]) ?>

  <h1>Please enter your personal Information</h1>

  <hr>

  <div class="personal-info-container">

    <div class="left-half">
      <label class="input-label"><span>Salutation</span>
        <select name="salutation" required>
          <option selected disabled>Please select your salutation.</option>
          <option value="mr">Mr.</option>
          <option value="mrs">Mrs.</option>
          <option value="other">Other</option>
          <option value="mystery">Mystery</option>
        </select>
      </label>

      <label class="input-label"><span>Last Name</span>
        <input type="text" name="lastName" required>
      </label>

      <label class="input-label"><span>First Name</span>
       <input type="text" name="firstName" required>
      </label>

      <label class="input-label"><span>Birthdate</span>
        <input type="date" name="birthdate" max="<?=date('Y-m-d')?>" required>
      </label>

      <label class="input-label"><span>Street</span>
        <input type="text" name="street" required>
      </label>

      <label class="input-label"><span>ZIP Code</span>
        <input type="number" name="zipCode" required>
      </label>

      <label class="input-label"><span>City</span>
        <input type="text" name="city" required>
      </label>

      <label class="input-label"><span>Telephone</span>
        <input type="tel" name="telephone" required>
      </label>

      <label class="input-label"><span>E-Mail</span>
        <input type="email" name="email" required>
      </label>
    </div>

    <div class="right-half">
      <label class="input-label"><span>Comment</span>
        <textarea name="comment" rows="7"></textarea>
      </label>

      <div class="checkboxes">
        <label class="input-label input-checkbox"><span>New Patient?</span>
          <input type="checkbox" name="newPatient">
        </label>

        <label class="input-label input-checkbox"><span>Reminder?</span>
          <input type="checkbox" name="callback">
        </label>

        <label class="input-label input-checkbox"><span>Send confirmation E-Mail?</span>
          <input type="checkbox" name="send_confirmation" checked>
        </label>

        <label class="input-label input-checkbox">
          <span>I have read the <a href="http://example.org">Terms and Conditions</a>.</span>
          <input type="checkbox" required>
        </label>
      </div>

    </div>

  </div>

  <hr>

  <?= Html::hiddenInput('view', 'personal-info') ?>
  <?= Html::hiddenInput('role', $role, [
    'id' => 'role'
  ]) ?>
  <?php foreach ($treatments as $treatment) { ?>
    <?= Html::hiddenInput('treatments[]', $treatment) ?>
  <?php } ?>
  <?= Html::hiddenInput('totalDuration', $totalDuration) ?>
  <?= Html::hiddenInput('date', $date) ?>
  <?= Html::hiddenInput('time', $time) ?>

  <div class="buttons">
    <?= Html::submitButton('Back', [
      'class' => 'btn btn-outline-secondary form-back-btn',
      'name' => 'button',
      'value' => 'back'
    ]) ?>
    <?= Html::submitButton('Next', [
      'class' => 'btn btn-outline-primary form-next-btn',
      'name' => 'button',
      'value' => 'next'
    ]) ?>
  </div>

<?php ActiveForm::end() ?>
