<?php

/**
 * @var dataProvider
 */

use app\assets\BackendGridviewCSSAsset;
use app\assets\RolesAsset;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\VarDumper;

BackendGridviewCSSAsset::register($this);

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
        'role_name',
        'email',
        [
          'label' => 'Status',
          'attribute' => 'status',
          'enableSorting' => true,
          'format' => 'html',
          'value' => function ($data) {
            $label = null;
            switch ($data->status) {
              case 0:
                $label = '<span class="badge badge-pill badge-secondary">Inactive</span>';
                break;

              case 1:
                $label = '<span class="badge badge-pill badge-success">Active</span>';

              default:
                break;
            }
            return $label;
          }
        ],
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
                createUrl('edit-role', $model), [
                  'class' => 'edit-button'
                ]
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
