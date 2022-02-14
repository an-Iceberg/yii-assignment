<?php

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
      'role' => $model['role']
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
              return Html::a
              (
                '<i class="nf nf-fa-pencil action-icon"></i>',
                createUrl('edit-role', $model)
              );
            },
            'delete' => function ($url, $model, $key)
            {
              return Html::a
              (
                '<i class="nf nf-fa-trash action-icon"></i>',
                createUrl('delete-role', $model)
              );
            }
          ]
        ]
      ]
    ]
  )
?>
