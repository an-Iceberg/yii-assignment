<?php

use app\assets\EditRoleAsset;
use yii\helpers\Html;
use yii\helpers\VarDumper;
use yii\widgets\ActiveForm;

// echo VarDumper::dump($role, 10, true);
// exit;

// if (isset($role) && isset($workTimes) && isset($postParams))
// {
//   // echo VarDumper::dump($postParams, 10, true);
//   echo '<hr>';
//   echo VarDumper::dump($role, 10, true);
//   echo '<hr>';
//   echo VarDumper::dump($workTimes, 10, true);
//   exit;
// }
EditRoleAsset::register($this);

$this->title = $role->role_name;
$this->params['currentPage'] = 'roles';
?>

<div class="top-row">
  <a href="/backend/roles">
    <i class="nf nf-fa-chevron_left"></i>
  </a>

  <h1 class="h3">&nbsp;/ <?= $role->role_name ?></h1>
</div>

<?php
  $form = ActiveForm::begin([
    'action' => '/backend/edit-role',
    'method' => 'post'
  ])
?>

<?php // Language switcher ?>
<div class="language-switcher">
  <a href="#" class="language active-language">Deutsch</a>
  <a href="#" class="language">English</a>
  <a href="#" class="language">Français</a>
</div>

<div class="grid-container">
  <label class="input-label"><span>Designation</span>
    <input type="text" value="<?= $role->role_name ?>" name="role_name">
  </label>
  <label class="input-label"><span>E-Mail</span>
    <input type="email" value="<?= $role->email ?>" name="email">
  </label>
  <label class="input-label description"><span>Description</span>
    <textarea rows="4" name="description"><?= $role->description ?></textarea>
  </label>
  <label class="input-label"><span>Sort Order</span>
    <input type="number" value="<?= $role->sort_order ?>" name="sort_order">
  </label>

  <div class="break"></div>

  <label class="input-label"><span>Duration (min)</span>
    <?= $this->render('partials/duration-select', [
      'model' => $role
    ]) ?>
  </label>

  <div class="input-label"><span>Treatments</span>
    <div class="role-treatments">

      <?php // TODO: rework this using HTML data attributes ?>
      <div id="treatments">
        <?php foreach ($role->treatments as $key => $treatment) { ?>
          <div id="treatment-<?= $key ?>">
            <input type="hidden" name="treatments[<?= $key ?>][treatment_id]" value="<?= $treatment->id ?>">
            <label class="sub-input"><span>Treatment</span>
              <input type="text" name="treatments[<?= $key ?>][treatment_name]" value="<?= $treatment->treatment_name ?>">
            </label>
            <label class="sub-input"><span>Sort Order</span>
              <input type="number" name="treatments[<?= $key ?>][sort_order]" value="<?= $treatment->sort_order ?>">
            </label>
            <button type="button" class="sub-input treatment-delete-button" id="delete-button-<?= $key ?>">
              <i class="nf nf-fa-times"></i>
            </button>
          </div>
        <?php } ?>
      </div>

      <button type="button" class="create-treatment" id="create-button">
        Create New Treatment
      </button>

    </div>
  </div>

  <?php // 0-based index for weekends (coincides with array indices) ?>
  <div class="input-label"><span>Working Hours</span>
    <div class="working-hours">
      <?php // Renders 3 input fields for each day of the week
        foreach ($role->workTimes as $index => $day)
        {
          $name;
          // Assigning a name based on the number stored in the DB
          switch ($day->weekday) {
            case 0: $name = 'monday'; break;
            case 1: $name = 'tuesday'; break;
            case 2: $name = 'wednesday'; break;
            case 3: $name = 'thursday'; break;
            case 4: $name = 'friday'; break;
            case 5: $name = 'saturday'; break;
            case 6: $name = 'sunday'; break;
            default: $name = 'weekday name'; break;
          }

          echo $this->render('partials/weekday-times', [
            'workTimes' => $role->workTimes,
            'name' => $name,
            'weekday' => $index
          ]);
        }
      ?>
    </div>
  </div>

  <div class="break"></div>

  <?php // Status ?>
  <label class="input-label last-input-element"><span>Status</span>
    <select name="status">
      <option <?= ($role->status == 1) ? 'selected' : '' ?> value="1">Active</option>
      <option <?= ($role->status == 0) ? 'selected' : '' ?> value="0">Inactive</option>
    </select>
  </label>

  <input type="hidden" name="role_id" value="<?= $role->id ?>">

  <?= Html::hiddenInput('newEntry', $newEntry, [
    'readonly' => true
  ]) ?>

</div>

<div class="save">
  <?= Html::submitButton('Save Changes', ['class' => 'btn btn-warning']) ?>
</div>

<?php ActiveForm::end() ?>
