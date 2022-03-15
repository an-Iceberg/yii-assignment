<?php

namespace app\models;

use yii\data\ActiveDataProvider;

class HolidaysSearch extends Holidays
{
  public function rules()
  {
    return [
      [['holiday_name', 'date'], 'safe'],
    ];
  }

  public function search($params)
  {
    $query = Holidays::find()->select(['id', 'holiday_name', 'date']);

    $dataProvider = new ActiveDataProvider([
      'query' => $query,
      'pagination' => [
        'totalCount' => Holidays::find()->count(),
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
    $query->andFilterWhere(['like', 'holiday_name', $this->holiday_name])
    ->andFilterWhere(['like', 'date', $this->date]);

    return $dataProvider;
  }
}
