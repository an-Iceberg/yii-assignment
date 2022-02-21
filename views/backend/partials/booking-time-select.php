<select name="bookingTime">
  <?php if ($model->time == '') { ?>
    <option selected disabled>Please select</option>
  <?php } ?>
  <option <?= ($model->time == '08:00:00') ? 'selected' : '' ?> value="08:00">8:00</option>
  <option <?= ($model->time == '08:15:00') ? 'selected' : '' ?> value="08:15">8:15</option>
  <option <?= ($model->time == '08:30:00') ? 'selected' : '' ?> value="08:30">8:30</option>
  <option <?= ($model->time == '08:45:00') ? 'selected' : '' ?> value="08:45">8:45</option>
  <option <?= ($model->time == '09:00:00') ? 'selected' : '' ?> value="09:00">9:00</option>
  <option <?= ($model->time == '09:15:00') ? 'selected' : '' ?> value="09:15">9:15</option>
  <option <?= ($model->time == '09:30:00') ? 'selected' : '' ?> value="09:30">9:30</option>
  <option <?= ($model->time == '09:45:00') ? 'selected' : '' ?> value="09:45">9:45</option>
  <option <?= ($model->time == '10:00:00') ? 'selected' : '' ?> nalue="10:00">10:00</option>
  <option <?= ($model->time == '10:15:00') ? 'selected' : '' ?> value="10:15">10:15</option>
  <option <?= ($model->time == '10:30:00') ? 'selected' : '' ?> value="10:30">10:30</option>
  <option <?= ($model->time == '10:45:00') ? 'selected' : '' ?> value="10:45">10:45</option>
  <option <?= ($model->time == '11:00:00') ? 'selected' : '' ?> value="11:00">11:00</option>
  <option <?= ($model->time == '11:15:00') ? 'selected' : '' ?> value="11:15">11:15</option>
  <option <?= ($model->time == '11:30:00') ? 'selected' : '' ?> value="11:30">11:30</option>
  <option <?= ($model->time == '11:45:00') ? 'selected' : '' ?> value="11:45">11:45</option>
  <option <?= ($model->time == '12:00:00') ? 'selected' : '' ?> value="12:00">12:00</option>
  <option <?= ($model->time == '12:15:00') ? 'selected' : '' ?> value="12:15">12:15</option>
  <option <?= ($model->time == '12:30:00') ? 'selected' : '' ?> value="12:30">12:30</option>
  <option <?= ($model->time == '12:45:00') ? 'selected' : '' ?> value="12:45">12:45</option>
  <option <?= ($model->time == '13:00:00') ? 'selected' : '' ?> value="13:00">13:00</option>
  <option <?= ($model->time == '13:15:00') ? 'selected' : '' ?> value="13:15">13:15</option>
  <option <?= ($model->time == '13:30:00') ? 'selected' : '' ?> value="13:30">13:30</option>
  <option <?= ($model->time == '13:45:00') ? 'selected' : '' ?> value="13:45">13:45</option>
  <option <?= ($model->time == '14:00:00') ? 'selected' : '' ?> value="14:00">14:00</option>
  <option <?= ($model->time == '14:15:00') ? 'selected' : '' ?> value="14:15">14:15</option>
  <option <?= ($model->time == '14:30:00') ? 'selected' : '' ?> value="14:30">14:30</option>
  <option <?= ($model->time == '14:45:00') ? 'selected' : '' ?> value="14:45">14:45</option>
  <option <?= ($model->time == '15:00:00') ? 'selected' : '' ?> value="15:00">15:00</option>
  <option <?= ($model->time == '15:15:00') ? 'selected' : '' ?> value="15:15">15:15</option>
  <option <?= ($model->time == '15:30:00') ? 'selected' : '' ?> value="15:30">15:30</option>
  <option <?= ($model->time == '15:45:00') ? 'selected' : '' ?> value="15:45">15:45</option>
  <option <?= ($model->time == '16:00:00') ? 'selected' : '' ?> value="16:00">16:00</option>
  <option <?= ($model->time == '16:15:00') ? 'selected' : '' ?> value="16:15">16:15</option>
  <option <?= ($model->time == '16:30:00') ? 'selected' : '' ?> value="16:30">16:30</option>
  <option <?= ($model->time == '16:45:00') ? 'selected' : '' ?> value="16:45">16:45</option>
  <option <?= ($model->time == '17:00:00') ? 'selected' : '' ?> value="17:00">17:00</option>
  <option <?= ($model->time == '17:15:00') ? 'selected' : '' ?> value="17:15">17:15</option>
  <option <?= ($model->time == '17:30:00') ? 'selected' : '' ?> value="17:30">17:30</option>
  <option <?= ($model->time == '17:45:00') ? 'selected' : '' ?> value="17:45">17:45</option>
  <option <?= ($model->time == '18:00:00') ? 'selected' : '' ?> value="18:00">18:00</option>
  <option <?= ($model->time == '18:15:00') ? 'selected' : '' ?> value="18:15">18:15</option>
  <option <?= ($model->time == '18:30:00') ? 'selected' : '' ?> value="18:30">18:30</option>
  <option <?= ($model->time == '18:45:00') ? 'selected' : '' ?> value="18:45">18:45</option>
  <option <?= ($model->time == '19:00:00') ? 'selected' : '' ?> value="19:00">19:00</option>
  <option <?= ($model->time == '19:15:00') ? 'selected' : '' ?> value="19:15">19:15</option>
  <option <?= ($model->time == '19:30:00') ? 'selected' : '' ?> value="19:30">19:30</option>
  <option <?= ($model->time == '19:45:00') ? 'selected' : '' ?> value="19:45">19:45</option>
</select>