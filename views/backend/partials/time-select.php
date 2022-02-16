<select name="week[<?= $weekday ?>][<?= $name ?>]">
  <?php if ($workTimes[$weekday]['has_free'] || $workTimes[$weekday][$method] == '') { ?>
    <option selected disabled value=""></option>
  <?php } ?>
  <option value="08:00" <?= ($workTimes[$weekday][$method] == '08:00:00') ? 'selected' : '' ?>>8:00</option>
  <option value="08:30" <?= ($workTimes[$weekday][$method] == '08:30:00') ? 'selected' : '' ?>>8:30</option>
  <option value="09:00" <?= ($workTimes[$weekday][$method] == '09:00:00') ? 'selected' : '' ?>>9:00</option>
  <option value="09:30" <?= ($workTimes[$weekday][$method] == '09:30:00') ? 'selected' : '' ?>>9:30</option>
  <option value="10:00" <?= ($workTimes[$weekday][$method] == '10:00:00') ? 'selected' : '' ?>>10:00</option>
  <option value="10:30" <?= ($workTimes[$weekday][$method] == '10:30:00') ? 'selected' : '' ?>>10:30</option>
  <option value="11:00" <?= ($workTimes[$weekday][$method] == '11:00:00') ? 'selected' : '' ?>>11:00</option>
  <option value="11:30" <?= ($workTimes[$weekday][$method] == '11:30:00') ? 'selected' : '' ?>>11:30</option>
  <option value="12:00" <?= ($workTimes[$weekday][$method] == '12:00:00') ? 'selected' : '' ?>>12:00</option>
  <option value="12:30" <?= ($workTimes[$weekday][$method] == '12:30:00') ? 'selected' : '' ?>>12:30</option>
  <option value="13:00" <?= ($workTimes[$weekday][$method] == '13:00:00') ? 'selected' : '' ?>>13:00</option>
  <option value="13:30" <?= ($workTimes[$weekday][$method] == '13:30:00') ? 'selected' : '' ?>>13:30</option>
  <option value="14:00" <?= ($workTimes[$weekday][$method] == '14:00:00') ? 'selected' : '' ?>>14:00</option>
  <option value="14:30" <?= ($workTimes[$weekday][$method] == '14:30:00') ? 'selected' : '' ?>>14:30</option>
  <option value="15:00" <?= ($workTimes[$weekday][$method] == '15:00:00') ? 'selected' : '' ?>>15:00</option>
  <option value="15:30" <?= ($workTimes[$weekday][$method] == '15:30:00') ? 'selected' : '' ?>>15:30</option>
  <option value="16:00" <?= ($workTimes[$weekday][$method] == '16:00:00') ? 'selected' : '' ?>>16:00</option>
  <option value="16:30" <?= ($workTimes[$weekday][$method] == '16:30:00') ? 'selected' : '' ?>>16:30</option>
  <option value="17:00" <?= ($workTimes[$weekday][$method] == '17:00:00') ? 'selected' : '' ?>>17:00</option>
  <option value="17:30" <?= ($workTimes[$weekday][$method] == '17:30:00') ? 'selected' : '' ?>>17:30</option>
  <option value="18:00" <?= ($workTimes[$weekday][$method] == '18:00:00') ? 'selected' : '' ?>>18:00</option>
  <option value="18:30" <?= ($workTimes[$weekday][$method] == '18:30:00') ? 'selected' : '' ?>>18:30</option>
  <option value="19:00" <?= ($workTimes[$weekday][$method] == '19:00:00') ? 'selected' : '' ?>>19:00</option>
  <option value="19:30" <?= ($workTimes[$weekday][$method] == '19:30:00') ? 'selected' : '' ?>>19:30</option>
  <option value="20:00" <?= ($workTimes[$weekday][$method] == '20:00:00') ? 'selected' : '' ?>>20:00</option>
</select>