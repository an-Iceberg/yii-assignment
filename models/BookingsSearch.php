<?php

namespace app\models;

use yii\data\ActiveDataProvider;

class BookingsSearch extends Bookings
{
  public function rules()
  {
    return [
      [['patient_lastName', 'date', 'time'], 'safe'],
      [['status'], 'integer']
    ];
  }

  public function search($params)
  {
    $query = Bookings::find()
    ->select(['role_name', 'role_id', 'bookings.id', 'patient_salutation', 'patient_lastName', 'date', 'time', 'bookings.status'])
    ->innerJoinWith('role');

    $dataProvider = new ActiveDataProvider([
      'query' => $query,
      'pagination' =>
      [
        'totalCount' => Bookings::find()->count(),
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
    $query->andFilterWhere(['like', 'patient_lastName', $this->patient_lastName])
    ->andFilterWhere(['like', 'date', $this->date])
    ->andFilterWhere(['like', 'time', $this->time])
    ->andFilterWhere(['status' => $this->status]);

    return $dataProvider;
  }
}
