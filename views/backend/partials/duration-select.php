<select name="duration">
  <?php if ($model->duration == '') { ?>
    <option value="" selected disabled>Please select</option>
  <?php } ?>
  <option <?= ($model->duration == 15) ? 'selected' : '' ?> value="15">15</option>
  <option <?= ($model->duration == 30) ? 'selected' : '' ?> value="30">30</option>
  <option <?= ($model->duration == 45) ? 'selected' : '' ?> value="45">45</option>
  <option <?= ($model->duration == 60) ? 'selected' : '' ?> value="60">60</option>
  <option <?= ($model->duration == 90) ? 'selected' : '' ?> value="90">90</option>
  <option <?= ($model->duration == 120) ? 'selected' : '' ?> value="120">120</option>
  <option <?= ($model->duration == 150) ? 'selected' : '' ?> value="150">150</option>
  <option <?= ($model->duration == 180) ? 'selected' : '' ?> value="180">180</option>
  <option <?= ($model->duration == 210) ? 'selected' : '' ?> value="210">210</option>
  <option <?= ($model->duration == 240) ? 'selected' : '' ?> value="240">240</option>
  <option <?= ($model->duration == 270) ? 'selected' : '' ?> value="270">270</option>
  <option <?= ($model->duration == 300) ? 'selected' : '' ?> value="300">300</option>
  <option <?= ($model->duration == 330) ? 'selected' : '' ?> value="330">330</option>
  <option <?= ($model->duration == 360) ? 'selected' : '' ?> value="360">360</option>
  <option <?= ($model->duration == 390) ? 'selected' : '' ?> value="390">390</option>
  <option <?= ($model->duration == 420) ? 'selected' : '' ?> value="420">420</option>
  <option <?= ($model->duration == 450) ? 'selected' : '' ?> value="450">450</option>
  <option <?= ($model->duration == 480) ? 'selected' : '' ?> value="480">480</option>
  <option <?= ($model->duration == 510) ? 'selected' : '' ?> value="510">510</option>
</select>