<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "roles".
 *
 * @property string|null $role
 * @property string|null $email
 * @property string|null $description
 * @property int|null $sort_order
 * @property int|null $work_duration
 */
class Roles extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'roles';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['description'], 'string'],
            [['sort_order', 'work_duration'], 'integer'],
            [['role'], 'string', 'max' => 50],
            [['email'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'role' => 'Role',
            'email' => 'Email',
            'description' => 'Description',
            'sort_order' => 'Sort Order',
            'work_duration' => 'Work Duration',
        ];
    }
}
