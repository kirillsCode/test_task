<?php

namespace app\models;

use Yii;
use yii\behaviors\SluggableBehavior;

/**
 * This is the model class for table "{{%news}}".
 *
 * @property integer $id
 * @property string $header
 * @property string $date
 * @property string $content
 * @property integer $is_active
 * @property integer $c_id
 * @property string $filename
 */
class News extends \yii\db\ActiveRecord
{
    public $file;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%news}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['date'], 'safe'],
            [['content'], 'string'],
            [['is_active', 'c_id'], 'integer'],
            [['header', 'filename'], 'string', 'max' => 256]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'header' => 'Header',
            'date' => 'Date',
            'content' => 'Content',
            'is_active' => 'Is Active',
            'c_id' => 'C ID',
            'filename' => 'Filename',
        ];
    }

}
