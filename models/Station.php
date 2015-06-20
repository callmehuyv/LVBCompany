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

    public function rules()
    {
        return [
            [['line_id', 'station_description', 'station_name'], 'required'],
            [['line_id', 'record_status'], 'integer'],
            [['station_description'], 'string'],
            [['station_name', 'station_image'], 'string', 'max' => 255],
            [['station_image'], 'file', 'extensions' => 'jpg, gif, png'],
            ['station_name', 'unique'],
            ['line_id', 'exist', 'targetClass' => '\app\models\Line', 'targetAttribute' => 'line_id']
        ];
    }

    public function attributeLabels()
    {
        return [
            'station_id' => 'ID',
            'line_id' => 'Line',
            'station_name' => 'Name',
            'station_description' => 'Description',
            'station_image' => 'Upload New Image',
            'record_status' => 'Record Status',
        ];
    }

    public function getLine()
    {
        return Line::find()
            ->where(['line_id' => $this->line_id])
                ->one();
    }
}
