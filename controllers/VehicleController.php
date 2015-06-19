<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\Vehicle;
use app\models\Vehicletype;
use app\models\Company;
use app\models\Driver;
use app\models\Line;
use yii\web\UploadedFile;
use yii\helpers\ArrayHelper;
use callmehuyv\helpers\Input;
use yii\db\Query;

class VehicleController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['delete', 'edit', 'create'],
                'rules' => [
                    [
                        'actions' => ['delete', 'edit', 'create'],
                        'allow' => false,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['delete', 'edit', 'create', 'index'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    public function actionIndex()
    {
        $params['record_status'] = 4;
        if (Input::has('company')) {
            $params['company_id'] = Input::get('company');
        }
        if (Input::has('line')) {
            $params['line_id'] = Input::get('line');
        }
        if (Input::has('vehicletype')) {
            $params['vehicletype_id'] = Input::get('vehicletype');
        }

        $vehicles = Vehicle::find()
            ->where($params)
                ->all();

        $data['vehicles'] = $vehicles;
        $data['selected_company'] = (int)Input::get('company');
        $data['list_companies'] = Company::find()->where(['record_status' => 4])->all();

        $data['selected_line'] = (int)Input::get('line');
        $data['list_lines'] = Line::find()->where(['record_status' => 4])->all();

        $data['selected_vehicletype'] = (int)Input::get('vehicletype');
        $data['list_vehicletypes'] = Vehicletype::find()->where(['record_status' => 4])->all();
        return $this->render('index', $data);
    }

    public function actionDelete()
    {
        $selected_vehicle = (int)Input::get('vehicle');
        $model = Vehicle::findOne($selected_vehicle);
        $model->record_status = 3;
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        return [
            'status' => $model->save(),
            'element' => '#vehicle_'.$selected_vehicle
        ];
    }

    public function actionEdit() {
        $selected_vehicle = (int)Input::get('vehicle');
        $model = Vehicle::findOne($selected_vehicle);
        $oldImage = $model->vehicle_image;

        if ( $model->load(Yii::$app->request->post()) ) {
            $file = UploadedFile::getInstance($model, 'vehicle_image');

            if ($file) {
                $file->saveAs('uploads/vehicle_' . $model->vehicle_id . '.' . $file->extension);
                $model->vehicle_image = 'uploads/vehicle_' . $model->vehicle_id . '.' . $file->extension;
            } else {
                $model->vehicle_image = $oldImage;
            }

            $model->save();
            Yii::$app->getSession()->setFlash('message', 'Update Vehicle success!');
            return $this->redirect(['vehicle/edit', 'vehicle' => $model->vehicle_id]);
        }

        $prepare_list_companies = Company::find()
            ->where(['record_status' => 4])
                ->all();
        $prepare_list_vehicletypes = Vehicletype::find()
            ->where(['record_status' => 4])
                ->all();
        $prepare_list_drivers = Driver::find()
            ->where(['record_status' => 4])
                ->all();
        $prepare_list_lines = Line::find()
            ->where(['record_status' => 4])
                ->all();

        $data['list_companies'] = ArrayHelper::map($prepare_list_companies, 'company_id', 'company_name');
        $data['list_vehicletypes'] = ArrayHelper::map($prepare_list_vehicletypes, 'vehicletype_id', 'vehicletype_name');
        $data['list_drivers'] = ArrayHelper::map($prepare_list_drivers, 'driver_id', 'driver_name');
        $data['list_lines'] = ArrayHelper::map($prepare_list_lines, 'line_id', 'line_name');

        $data['model'] = $model;
        return $this->render('edit', $data);
    }


    public function actionCreate()
    {
        $model = new Vehicle();
        if ($model->load(Yii::$app->request->post())) {
            if ($model->validate()) {
            $file = UploadedFile::getInstance($model, 'vehicle_image');
                if ($file) {
                    $model->vehicle_image = '';
                    $model->save();
                    $file->saveAs('uploads/vehicle_' . $model->vehicle_id . '.' . $file->extension);
                    $model->vehicle_image = 'uploads/vehicle_' . $model->vehicle_id . '.' . $file->extension;
                    $model->save();
                } else {
                    $model->vehicle_image = 'uploads/no-thumbnail.png';
                    $model->save();
                }
                Yii::$app->getSession()->setFlash('message', 'Created new Vehicle success!');
                return $this->redirect(['/vehicle/index']);
            }
        }

        if (Input::has('company')) {
            $model->company_id = (int)Input::get('company');
        }
        if (Input::has('vehicletype')) {
            $model->vehicletype_id = (int)Input::get('vehicletype');
        }
        if (Input::has('driver')) {
            $model->driver_id = (int)Input::get('driver');
        }
        if (Input::has('line')) {
            $model->line_id = (int)Input::get('line');
        }

        $prepare_list_companies = Company::find()
            ->where(['record_status' => 4])
                ->all();
        $prepare_list_vehicletypes = Vehicletype::find()
            ->where(['record_status' => 4])
                ->all();

        // Get list validate drivers

        $prepare_list_drivers = Driver::find()
                ->where(['drivers.record_status' => 4])
                    ->where(['not in', 'driver_id', (new Query())->select('driver_id')->from('vehicles')->where(['record_status' => 4])])
                            ->all();
        print_r($prepare_list_drivers);die;
        $prepare_list_lines = Line::find()
            ->where(['record_status' => 4])
                ->all();

        $data['list_companies'] = ArrayHelper::map($prepare_list_companies, 'company_id', 'company_name');
        $data['list_vehicletypes'] = ArrayHelper::map($prepare_list_vehicletypes, 'vehicletype_id', 'vehicletype_name');
        $data['list_drivers'] = ArrayHelper::map($prepare_list_drivers, 'driver_id', 'driver_name');
        $data['list_lines'] = ArrayHelper::map($prepare_list_lines, 'line_id', 'line_name');
        $data['model'] = $model;
        return $this->render('create', $data);
    }

}
