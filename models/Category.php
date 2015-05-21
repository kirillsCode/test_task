<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%cat}}".
 *
 * @property integer $id
 * @property string $title
 * @property string $date
 * @property integer $is_active
 * @property string $description
 */
class Category extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%cat}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['date'], 'safe'],
            [['is_active'], 'integer'],
            [['description'], 'string'],
            [['title'], 'string', 'max' => 256]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
            'date' => 'Date',
            'is_active' => 'Is Active',
            'description' => 'Description',
        ];
    }
}
