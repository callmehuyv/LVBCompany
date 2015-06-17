<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "vehicles".
 *
 * @property integer $vehicle_id
 * @property integer $company_id
 * @property integer $line_id
 * @property integer $vehicletype_id
 * @property string $driver_id
 * @property string $vehicle_image
 * @property integer $record_status
 *
 * @property Companies $company
 * @property Lines $line
 * @property Drivers $driver
 * @property Vehicletypes $vehicletype
 */
class Vehicle extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'vehicles';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['company_id', 'line_id', 'vehicletype_id', 'driver_id', 'record_status'], 'integer'],
            [['driver_id', 'vehicle_number'], 'required'],
            [['vehicle_image'], 'string', 'max' => 255],
            [['vehicle_number'], 'string', 'max' => 64],
            ['vehicle_image', 'image'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'vehicle_id' => 'Vehicle ID',
            'company_id' => 'Company ID',
            'line_id' => 'Line ID',
            'vehicletype_id' => 'Vehicletype ID',
            'driver_id' => 'Driver ID',
            'vehicle_image' => 'Vehicle Image',
            'record_status' => 'Record Status',
        ];
    }

    public function getCompany()
    {
        return Company::find()
            ->where(['record_status' => 4, 'company_id' => $this->company_id])
                ->one();
    }

    public function getLine()
    {
        return Line::find()
            ->where(['record_status' => 4, 'line_id' => $this->line_id])
                ->one();
    }

    public function getDriver()
    {
        return Driver::find()
                    ->where(['record_status' => 4, 'driver_id' => $this->driver_id])
                        ->one();
    }

    public function getVehicletype()
    {
        return Vehicletype::find()
                    ->where(['record_status' => 4, 'vehicletype_id' => $this->vehicletype_id])
                        ->one();
    }
}
