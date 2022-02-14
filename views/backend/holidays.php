<?php

use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\VarDumper;

$this->title = 'Holidays';
$this->params['currentPage'] = 'holidays';

function createUrl($viewName, $model)
{
  return Url::to
  (
    [
      $viewName,
      'name' => $model['name']
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
        'name',
        'date',
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
                createUrl('edit-holiday', $model)
              );
            },
            'delete' => function ($url, $model, $key)
            {
              return Html::a
              (
                '<i class="nf nf-fa-trash action-icon"></i>',
                createUrl('delete-holiday', $model)
              );
            }
          ]
        ]
      ]
    ]
  )
?>
