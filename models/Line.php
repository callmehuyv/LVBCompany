<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "lines".
 *
 * @property integer $id
 * @property string $name
 * @property string $description
 * @property string $start_time
 * @property string $end_time
 * @property string $image
 * @property integer $record_status
 *
 * @property Stations[] $stations
 * @property Vehicles[] $vehicles
 */
class Line extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'lines';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['description'], 'string'],
            [['start_time', 'end_time'], 'safe'],
            [['record_status'], 'integer'],
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
            'name' => 'Name',
            'description' => 'Description',
            'start_time' => 'Start Time',
            'end_time' => 'End Time',
            'image' => 'Image',
            'record_status' => 'Record Status',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStations()
    {
        return $this->hasMany(Stations::className(), ['line_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getVehicles()
    {
        return $this->hasMany(Vehicles::className(), ['line_id' => 'id']);
    }
}
