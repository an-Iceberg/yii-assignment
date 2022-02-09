<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "who_has_holidays".
 *
 * @property string|null $role
 * @property string|null $holiday_name
 * @property string|null $holiday_date
 */
class WhoHasHolidays extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'who_has_holidays';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['holiday_date'], 'safe'],
            [['role', 'holiday_name'], 'string', 'max' => 50],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'role' => 'Role',
            'holiday_name' => 'Holiday Name',
            'holiday_date' => 'Holiday Date',
        ];
    }
}
