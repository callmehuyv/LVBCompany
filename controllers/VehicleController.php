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

    public function actionDelete($selected_vehicletype = null)
    {
        $model = Vehicletype::findOne($selected_vehicletype);
        $model->record_status = 3;
        $model->save();
        Yii::$app->getSession()->setFlash('message', 'Delete Vehicle Type success!');
        return $this->redirect(['vehicletype/index']);
    }

    public function actionEdit($selected_vehicletype = null) {
        $model = Vehicletype::findOne($selected_vehicletype);
        $oldImage = $model->vehicletype_image;

        if ( $model->load(Yii::$app->request->post()) ) {
            $file = UploadedFile::getInstance($model, 'vehicletype_image');

            if ($file) {
                $file->saveAs('uploads/vehicletype_' . $model->vehicletype_id . '.' . $file->extension);
                $model->vehicletype_image = 'uploads/vehicletype_' . $model->vehicletype_id . '.' . $file->extension;
            } else {
                $model->vehicletype_image = $oldImage;
            }

            $model->save();
            Yii::$app->getSession()->setFlash('message', 'Update Vehicle Type success!');
            return $this->redirect(['vehicletype/edit/'.$model->vehicletype_id]);
        } else {
            return $this->render('edit', [
                'model' => $model,
            ]);
        }

        return $this->render('edit', ['model' => $model]);
    }


    public function actionCreate()
    {
        $model = new Vehicle();
        if ($model->load(Yii::$app->request->post())) {
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
        return $this->render('create', $data);
    }

}
