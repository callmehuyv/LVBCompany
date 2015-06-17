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
            [['line_description'], 'string'],
            [['line_start_time', 'line_end_time'], 'safe'],
            [['record_status'], 'integer'],
            [['line_name', 'line_image'], 'string', 'max' => 255],
            [['line_image'], 'file']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'line_id' => 'ID',
            'line_name' => 'Name',
            'line_description' => 'Description',
            'line_start_time' => 'Start Time',
            'line_end_time' => 'End Time',
            'line_image' => 'Upload New Line Image',
            'record_status' => 'Record Status',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStations()
    {
        return $this->hasMany(Station::className(), ['line_id' => 'line_id', 'record_status' => 4]);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getVehicles()
    {
        return $this->hasMany(Vehicle::className(), ['line_id' => 'line_id', 'record_status' => 4]);
    }
}
