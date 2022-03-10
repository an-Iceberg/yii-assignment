<?php

/**
 * This view expects:
 * @var int $role
 * @var array $treatments
 * @var int $totalDuration
 * @var string $time
 * @var string $date
 * @var array $client
 * @var array $errors
 */

use app\assets\NextAndBackButtonsAsset;
use app\assets\PersonalInfoCSSAsset;
use yii\helpers\Html;
use yii\helpers\VarDumper;
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
      <label class="input-label <?= (isset($errors['salutation']) && !$errors['salutation']) ? 'invalid-input' : '' ?>"><span>Salutation*</span>
        <select name="client[salutation]">
          <option <?= (!isset($client['salutation'])) ? 'selected' : '' ?> disabled>Please select your salutation.</option>
          <option <?= (isset($client['salutation']) && $client['salutation'] == 'mr') ? 'selected' : '' ?> value="mr">Mr.</option>
          <option <?= (isset($client['salutation']) && $client['salutation'] == 'mrs') ? 'selected' : '' ?> value="mrs">Mrs.</option>
          <option <?= (isset($client['salutation']) && $client['salutation'] == 'other') ? 'selected' : '' ?> value="other">Other</option>
          <option <?= (isset($client['salutation']) && $client['salutation'] == 'mystery') ? 'selected' : '' ?> value="mystery">Mystery</option>
        </select>
      </label>

      <label class="input-label <?= (isset($errors['lastName']) && !$errors['lastName']) ? 'invalid-input' : '' ?>"><span>Last Name*</span>
        <input type="text" name="client[lastName]" value="<?= isset($client['lastName']) ? $client['lastName'] : '' ?>">
      </label>

      <label class="input-label <?= (isset($errors['firstName']) && !$errors['firstName']) ? 'invalid-input' : '' ?>"><span>First Name*</span>
       <input type="text" name="client[firstName]" value="<?= isset($client['firstName']) ? $client['firstName'] : '' ?>">
      </label>

      <label class="input-label <?= (isset($errors['birthdate']) && !$errors['birthdate']) ? 'invalid-input' : '' ?>"><span>Birthdate*</span>
        <input type="date" name="client[birthdate]" max="<?=date('Y-m-d')?>" value="<?= isset($client['birthdate']) ? $client['birthdate'] : '' ?>">
      </label>

      <label class="input-label <?= (isset($errors['street']) && !$errors['street']) ? 'invalid-input' : '' ?>"><span>Street*</span>
        <input type="text" name="client[street]" value="<?= isset($client['street']) ? $client['street'] : '' ?>">
      </label>

      <label class="input-label <?= (isset($errors['zipCode']) && !$errors['zipCode']) ? 'invalid-input' : '' ?>"><span>ZIP Code*</span>
        <input type="number" name="client[zipCode]" value="<?= isset($client['zipCode']) ? $client['zipCode'] : '' ?>">
      </label>

      <label class="input-label <?= (isset($errors['city']) && !$errors['city']) ? 'invalid-input' : '' ?>"><span>City*</span>
        <input type="text" name="client[city]" value="<?= isset($client['city']) ? $client['city'] : '' ?>">
      </label>

      <label class="input-label <?= (isset($errors['telephone']) && !$errors['telephone']) ? 'invalid-input' : '' ?>"><span>Telephone*</span>
        <input type="tel" name="client[telephone]" value="<?= isset($client['telephone']) ? $client['telephone'] : '' ?>">
      </label>

      <label class="input-label <?= (isset($errors['email']) && !$errors['email']) ? 'invalid-input' : '' ?>"><span>E-Mail*</span>
        <input type="email" name="client[email]" value="<?= isset($client['email']) ? $client['email'] : '' ?>">
      </label>
    </div>

    <div class="right-half">
      <label class="input-label"><span>Comment</span>
        <textarea name="client[comment]" rows="7"><?= isset($client['comment']) ? $client['comment'] : '' ?></textarea>
      </label>

      <div class="checkboxes">
        <label class="input-label input-checkbox"><span>New Patient?</span>
          <input type="checkbox" name="client[newPatient]" <?= isset($client['newPatient']) ? 'checked' : '' ?>>
        </label>

        <label class="input-label input-checkbox"><span>Reminder?</span>
          <input type="checkbox" name="client[callback]" <?= isset($client['callback']) ? 'checked' : '' ?>>
        </label>

        <label class="input-label input-checkbox"><span>Send confirmation E-Mail?</span>
          <input type="checkbox" name="client[send_confirmation]" <?= (isset($client['send_confirmation']) || isset($send_confirmation)) ? 'checked' : '' ?>>
        </label>

        <label class="input-label input-checkbox <?= (isset($errors['terms-and-conditions']) && !$errors['terms-and-conditions']) ? 'invalid-input' : '' ?>">
          <span>I have read the <a href="http://example.net" target="_blank">Terms and Conditions</a>.*</span>
          <input type="checkbox" name="client[terms-and-conditions]">
        </label>
      </div>

    </div>

  </div>

  <div class="alert alert-primary" role="alert">*These fields are required</div>

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
