<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "drivers".
 *
 * @property string $driver_id
 * @property integer $company_id
 * @property string $driver_name
 * @property string $driver_address
 * @property string $driver_image
 * @property string $driver_phone
 * @property integer $record_status
 *
 * @property Companies $company
 * @property Vehicles[] $vehicles
 */
class Driver extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'drivers';
    }

    public function rules()
    {
        return [
            [['company_id', 'driver_name', 'driver_address', 'driver_phone'], 'required'],
            [['company_id', 'record_status'], 'integer'],
            [['driver_name', 'driver_address', 'driver_image', 'driver_phone'], 'string', 'max' => 255],
            [['driver_phone', 'driver_name'], 'unique'],
            ['driver_image', 'file'],
            ['company_id', 'exist', 'targetClass' => '\app\models\Company', 'targetAttribute' => 'company_id']
        ];
    }

    public function attributeLabels()
    {
        return [
            'driver_id' => 'Driver ID',
            'company_id' => 'Company ID',
            'driver_name' => 'Driver Name',
            'driver_address' => 'Driver Address',
            'driver_image' => 'Driver Image',
            'driver_phone' => 'Driver Phone',
            'record_status' => 'Record Status',
        ];
    }

    public function getCompany()
    {
        return Company::find()
            ->where(['company_id' => $this->company_id])
                ->one();
    }

    public function getVehicle()
    {
        return Vehicle::find()
            ->where(['driver_id' => $this->driver_id])
                ->one();
    }
}
