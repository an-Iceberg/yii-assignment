<?php

namespace app\modules\booking\models;

use Yii;

/**
 * This is the model class for table "holidays".
 *
 * @property string|null $date
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
            [['date'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'date' => 'Date',
        ];
    }

    // Returns all holidays
    public static function getHolidays()
    {
        return Holidays::find()
        ->all();
    }
}
