<?php

namespace app\models;

use yii\data\ActiveDataProvider;

class RolesSearch extends Roles
{
  public function rules()
  {
    return [
      [['role_name', 'email'], 'safe'],
      [['status'], 'boolean']
    ];
  }

  public function search($params)
  {
    $query = Roles::find()->select(['id', 'role_name', 'email', 'status', 'sort_order']);

    $dataProvider = new ActiveDataProvider([
      'query' => $query,
      'pagination' => [
        'totalCount' => Roles::find()->count(),
        'pageSize' => 10,
        'page' => $params['page'] ?? 0
      ]
    ]);

    // Load the search form data and validate
    if (!($this->load($params)) && $this->validate())
    {
      return $dataProvider;
    }

    // Adjust the query by adding the filters
    $query->andFilterWhere(['like', 'role_name', $this->role_name])
    ->andFilterWhere(['like', 'email', $this->email])
    ->andFilterWhere(['status' => $this->status]);

    return $dataProvider;
  }
}
