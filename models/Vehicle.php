<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "vehicles".
 *
 * @property integer $id
 * @property integer $company_id
 * @property integer $line_id
 * @property integer $user_id
 * @property integer $vehicle_type_id
 * @property string $license_plate
 * @property string $image
 * @property integer $record_status
 *
 * @property Companies $company
 * @property Lines $line
 * @property Users $user
 * @property VehicleType $vehicleType
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
            [['company_id', 'line_id', 'user_id', 'vehicle_type_id', 'record_status'], 'integer'],
            [['license_plate', 'image'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'company_id' => 'Company ID',
            'line_id' => 'Line ID',
            'user_id' => 'User ID',
            'vehicle_type_id' => 'Vehicle Type ID',
            'license_plate' => 'License Plate',
            'image' => 'Image',
            'record_status' => 'Record Status',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCompany()
    {
        return $this->hasOne(Companies::className(), ['id' => 'company_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLine()
    {
        return $this->hasOne(Lines::className(), ['id' => 'line_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(Users::className(), ['id' => 'user_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getVehicleType()
    {
        return $this->hasOne(VehicleType::className(), ['id' => 'vehicle_type_id']);
    }
}
