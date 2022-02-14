<?php

use app\modules\backend\models\Booking;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\VarDumper;

$this->title = 'Bookings';
$this->params['currentPage'] = 'bookings';

function createUrl($viewName, $model)
{
  return Url::to
  (
    [
      $viewName,
      'role' => $model['role'],
      'patient_lastName' => $model['patient_lastName'],
      'date' => $model['date'],
      'time' => $model['time']
    ]
  );
}
?>

<?=
  GridView::widget
  (
    [
      'dataProvider' => $dataProvider,
      'columns' =>
      [
        'role',
        'patient_salutation',
        'patient_lastName',
        'date',
        'time',
        'status',
        [
          'class' => 'yii\grid\ActionColumn',
          'header' => 'Actions',
          'template' => '{edit} {delete}',
          'buttons' =>
          [
            'edit' => function ($url, $model, $key)
            {
              return Html::a
              (
                '<i class="nf nf-fa-pencil action-icon"></i>',
                createUrl('edit-booking', $model)
              );
            },
            'delete' => function ($url, $model, $key)
            {
              return Html::a
              (
                '<i class="nf nf-fa-trash action-icon"></i>',
                createUrl('delete-booking', $model)
              );
            }
          ]
        ]
      ]
    ]
  )
?>
