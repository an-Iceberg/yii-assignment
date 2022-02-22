<?php

use app\assets\RolesAsset;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\VarDumper;

$this->title = 'Roles';
$this->params['currentPage'] = 'roles';

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
  <?= Html::a('+ Create new Role', Url::to([
    'edit-role',
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
        'role_name',
        'email',
        'status',
        'sort_order',
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
                createUrl('edit-role', $model)
              );
            },
            'delete' => function ($url, $model, $key)
            {
              $form = Html::beginForm('delete-role', 'post', [
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
