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
                'only' => ['delete', 'edit', 'create', 'index'],
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
        return $this->render('index', ['drivers' => $drivers, 'list_companies' => $list_companies, 'selected_company' => $selected_company]);
    }

    public function actionDelete()
    {
        $selected_driver = (int)Input::get('driver');
        $model = Driver::findOne($selected_driver);
        $model->record_status = 3;
        $model->save();
        Yii::$app->getSession()->setFlash('message', 'Delete Driver success!');
        return $this->redirect(['driver/index']);
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
        } else {
            return $this->render('edit', [
                'model' => $model,
            ]);
        }

        return $this->render('edit', ['model' => $model]);
    }


    public function actionCreate()
    {
        $model = new Driver();
        if ($model->load(Yii::$app->request->post())) {
            $file = UploadedFile::getInstance($model, 'driver_image');
            if ($file) {
                $model->driver_image = '';
                $model->save();
                $file->saveAs('uploads/driver_' . $model->driver_id . '.' . $file->extension);
                $model->driver_image = 'uploads/driver_' . $model->driver_id . '.' . $file->extension;
                $model->save();
            } else {
                $model->driver_image = 'uploads/no-thumbnail.png';
                $model->save();
            }

            Yii::$app->getSession()->setFlash('message', 'Created new Driver success!');
            return $this->redirect(['/driver/index']);
        }
        $prepare_list_companies = Company::find()
            ->where(['record_status' => 4])
                ->asArray()
                    ->all();

        if (Input::has('company')) {
            $model->company_id = (int)Input::get('company');
        }
        $list_companies = ArrayHelper::map($prepare_list_companies, 'company_id', 'company_name');
        return $this->render('create', ['model' => $model, 'list_companies' => $list_companies]);
    }

}
