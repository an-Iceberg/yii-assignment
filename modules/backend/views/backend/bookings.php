<?php

use app\modules\backend\models\Booking;
use yii\grid\GridView;
use yii\helpers\VarDumper;

$this->title = 'Bookings';
$this->params['currentPage'] = 'bookings';
?>
<h1>bookings</h1>
<?= ''
// GridView::widget([
//   'dataProvider' => $bookings,
//   'columns' => [
//     'role',
//     'patient_salutation',
//     'patient_lastName',
//     'date',
//     [
//       'class' => 'yii\grid\ActionColumn',
//       'template' => '{update} {delete}'
//     ]
//   ],
// ])
?>

<div class="grid">

  <input type="text">
  <input type="text">
  <input type="text">
  <input type="text">

  <?php foreach ($bookings as $bookingKey => $booking) { ?>

    <div><?= $booking['role'] ?></div>
    <div><?= $booking['patient_salutation'] ?></div>
    <div><?= $booking['patient_lastName'] ?></div>
    <div><?= $booking['date'] ?></div>

    <div class="actions">
      <a href="#">Edit</a>
      <a href="#">Delete</a>
    </div>

  <?php } ?>

</div>
