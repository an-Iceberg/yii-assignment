<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "holidays".
 *
 * @property string|null $name
 * @property string|null $date
 * @property string|null $beginning time
 * @property string|null $end time
 */
class Holidays extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'holidays';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['date', 'beginning time', 'end time'], 'safe'],
            [['name'], 'string', 'max' => 50],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'name' => 'Name',
            'date' => 'Date',
            'beginning time' => 'Beginning Time',
            'end time' => 'End Time',
        ];
    }
}
