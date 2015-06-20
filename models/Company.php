<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "companies".
 *
 * @property integer $company_id
 * @property string $company_name
 * @property string $company_description
 * @property string $company_image
 * @property integer $record_status
 *
 * @property Vehicles[] $vehicles
 */
class Company extends \yii\db\ActiveRecord
{

    public static function tableName()
    {
        return 'companies';
    }

    public function rules()
    {
        return [
            [['company_description'], 'string'],
            [['record_status'], 'integer'],
            [['company_name', 'company_image'], 'string', 'max' => 255],
            ['company_name', 'unique'],
            [['company_image'], 'file', 'extensions' => 'jpg, gif, png']
        ];
    }

    public function attributeLabels()
    {
        return [
            'company_id' => 'Company ID',
            'company_name' => 'Company Name',
            'company_description' => 'Company Description',
            'company_image' => 'Company Image',
            'record_status' => 'Record Status',
        ];
    }

    public function getVehicles()
    {
        return Vehicle::find()
            ->where(['record_status' => 4, 'company_id' => $this->company_id])
                ->all();
    }

    public function getDrivers()
    {
        return Driver::find()
            ->where(['record_status' => 4, 'company_id' => $this->company_id])
                ->all();
    }
}
