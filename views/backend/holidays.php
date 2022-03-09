<?php

/**
 * @var dataProvider
 */

use app\assets\BackendGridviewCSSAsset;
use app\assets\HolidaysAsset;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\VarDumper;

BackendGridviewCSSAsset::register($this);

$this->title = 'Holidays';
$this->params['currentPage'] = 'holidays';

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
  <?= Html::a('+ Create new Holiday', Url::to([
    'edit-holiday',
    'createNew' => true
  ]), [
    'class' => 'btn create-new-button'
  ]) ?>
</div>

<?= // TODO: filtering
  GridView::widget
  (
    [
      'dataProvider' => $dataProvider,
      'layout' => '{items}{pager}{summary}',
      'columns' =>
      [
        'holiday_name',
        'date',
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
                createUrl('edit-holiday', $model), [
                  'class' => 'edit-button'
                ]
              );
            },
            'delete' => function ($url, $model, $key)
            {
              $form = Html::beginForm('delete-holiday', 'post', [
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
