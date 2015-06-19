<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\Driver;
use app\models\Company;
use yii\web\UploadedFile;
use yii\helpers\ArrayHelper;

use callmehuyv\helpers\Input;

class DriverController extends Controller
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
        $selected_company = (int)Input::get('company');
        $params['record_status'] = 4;
        if ($selected_company != null) {
           $params['company_id'] = $selected_company;
        }
        $drivers = Driver::find()
            ->where($params)
                ->all();
        $list_companies = Company::find()
            ->where(['record_status' => 4])
                ->all();
        $data['drivers'] = $drivers;
        $data['list_companies'] = $list_companies;
        $data['selected_company'] = $selected_company;
        return $this->render('index', $data);
    }

    public function actionDelete()
    {
        $selected_driver = (int)Input::get('driver');
        $model = Driver::findOne($selected_driver);
        $model->record_status = 3;
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        return [
            'status' => $model->save(),
            'element' => '#driver_'.$selected_driver
        ];
    }

    public function actionEdit() {
        $selected_driver = (int)Input::get('driver');
        $model = Driver::findOne($selected_driver);
        $oldImage = $model->driver_image;

        if ( $model->load(Yii::$app->request->post()) ) {
            $file = UploadedFile::getInstance($model, 'driver_image');

            if ($file) {
                $file->saveAs('uploads/driver_' . $model->driver_id . '.' . $file->extension);
                $model->driver_image = 'uploads/driver_' . $model->driver_id . '.' . $file->extension;
            } else {
                $model->driver_image = $oldImage;
            }
            $model->save();
            Yii::$app->getSession()->setFlash('message', 'Update Driver success!');
            return $this->redirect(['driver/edit', 'driver' => $model->driver_id]);
        }

        $prepare_list_companies = Company::find()
            ->where(['record_status' => 4])
                ->asArray()
                    ->all();
        $list_companies = ArrayHelper::map($prepare_list_companies, 'company_id', 'company_name');

        $data['model'] = $model;
        $data['list_companies'] = $list_companies;

        return $this->render('edit', $data);
    }


    public function actionCreate()
    {
        $model = new Driver();
        if ($model->load(Yii::$app->request->post())) {
            // If request is post and validate
            if ($model->validate()) {
                $file = UploadedFile::getInstance($model, 'driver_image');
                if ($file) {
                    $model->driver_image = '';
                    $model->save();
                    $file->saveAs('uploads/driver_' . $model->driver_id . '.' . $file->extension);
                    $model->driver_image = 'uploads/driver_' . $model->driver_id . '.' . $file->extension;
                } else {
                    $model->driver_image = 'uploads/no-thumbnail.png';
                }
                Yii::$app->getSession()->setFlash('message', 'Created new Driver success!');
                return $this->redirect(['/driver/index']);
            } else {
                // If False Validate : Goback with Error (Dont forget pass listcompany to model)
                $prepare_list_companies = Company::find()->where(['record_status' => 4])->asArray()->all();
                $list_companies = ArrayHelper::map($prepare_list_companies, 'company_id', 'company_name');
                return $this->render('create', ['model' => $model, 'list_companies' => $list_companies]);
            }
        }

        if (Input::has('company')) {
            $model->company_id = (int)Input::get('company');
        }

        $prepare_list_companies = Company::find()->where(['record_status' => 4])->asArray()->all();
        $data['list_companies'] = ArrayHelper::map($prepare_list_companies, 'company_id', 'company_name');
        $data['model'] = $model;
        return $this->render('create', $data);
    }

}
