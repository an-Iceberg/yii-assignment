<?php

/**
 * This view expects:
 * @var array $dataProvider
 * @var array $searchModel
 */

use app\assets\BackendGridviewCSSAsset;
use app\assets\BookingsAsset;
use app\modules\backend\models\Booking;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\VarDumper;

BackendGridviewCSSAsset::register($this);

$this->title = 'Bookings';
$this->params['currentPage'] = 'bookings';

function createUrl($viewName, $model)
{
  return Url::to([
    $viewName,
    'id' => $model['id']
  ]);
}
?>

<div class="create-button">
  <?= Html::a('+ Create new Booking', Url::to([
    'edit-booking',
    'createNew' => true
  ]), [
    'class' => 'btn create-new-button'
  ]) ?>
</div>

<?= // TODO: proper filtering input of 'Status' using dropdown menu (and maybe date as well)
  GridView::widget
  (
    [
      'dataProvider' => $dataProvider,
      'filterModel' => $searchModel,
      'layout' => '{items}{pager}{summary}',
      'columns' =>
      [
        [
          // TODO OPTIONAL: make this column sortable (is explained in the Yii documentation)
          'label' => 'Role',
          'attribute' => 'roles.role_name',
          'enableSorting' => true,
          'content' => function ($data){
            return $data->role->role_name;
          }
        ],
        'patient_salutation',
        'patient_lastName',
        'date',
        'time',
        [
          'label' => 'Status',
          'attribute' => 'status',
          'enableSorting' => true,
          'format' => 'text',
          'value' => function ($data)
          {
            $message = null;
            switch ($data->status) {
              case 0:
                $message = 'Booking has been processed';
                break;

              case 1:
                $message = 'Open';
                break;

              case 2:
                $message = 'Cancelled';
                break;

              case 3:
                $message = 'Booking is being processed';
                break;

              default:
                break;
            }
            return $message;
          }
        ],
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
                createUrl('edit-booking', $model), [
                  'class' => 'edit-button'
                ]
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
