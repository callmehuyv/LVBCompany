<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "stations".
 *
 * @property integer $id
 * @property integer $line_id
 * @property string $name
 * @property string $description
 * @property string $image
 * @property integer $record_status
 *
 * @property Lines $line
 */
class Station extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'stations';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id'], 'required'],
            [['id', 'line_id', 'record_status'], 'integer'],
            [['description'], 'string'],
            [['name', 'image'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'line_id' => 'Line ID',
            'name' => 'Name',
            'description' => 'Description',
            'image' => 'Image',
            'record_status' => 'Record Status',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLine()
    {
        return $this->hasOne(Lines::className(), ['id' => 'line_id']);
    }
}
