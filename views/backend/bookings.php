<?php

use app\assets\BookingsAsset;
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
      'id' => $model['id']
    ]
  );
}
?>

<div class="create-button">
  <?= Html::a('+ Create new Booking', Url::to([
    'edit-booking',
    'createNew' => true
  ]), [
    'class' => 'btn btn-primary'
  ]) ?>
</div>

<?=
  GridView::widget
  (
    [
      'dataProvider' => $dataProvider,
      'columns' =>
      [
        'role.role_name',
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
              return Html::a(
                '<i class="nf nf-fa-pencil action-icon"></i>',
                createUrl('edit-booking', $model)
              );
            },
            'delete' => function ($url, $model, $key)
            {
              $form = Html::beginForm('delete-booking', 'post', [
                'class' => 'delete-form'
              ]);
              $form .= Html::hiddenInput('id', $key);
              $form .= Html::submitButton('<i class="nf nf-fa-trash action-icon"></i>', [
                'class' => 'delete-form-icon',
                'data-confirm' => 'Are you certain you want to delete this?'
              ]);
              $form .= Html::endForm();
              return $form;
            }
          ]
        ]
      ]
    ]
  )
?>
