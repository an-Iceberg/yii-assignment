<div class="capitalize"><?= $name ?></div>

<?php // Renders the starting time ?>
<label class="time-input">&nbsp;From
  <?= $this->render('time-select', [
    'workTimes' => $workTimes,
    'name' => 'from',
    'weekday' => $weekday,
    'method' => 'from'
  ]) ?>
</label>

<?php // Renders the ending time ?>
<label class="time-input">&nbsp;Until
  <?= $this->render('time-select', [
    'workTimes' => $workTimes,
    'name' => 'until',
    'weekday' => $weekday,
    'method' => 'until'
  ]) ?>
</label>

<?php // Renders the checkbox telling the user if this day is free (this overrides time selections) ?>
<label class="time-input time-checkbox">&nbsp;Has Free
  <input type="checkbox" name="week[<?= $weekday ?>][has_free]" <?= ($workTimes[$weekday]['has_free']) ? 'checked' : '' ?>>
</label>
