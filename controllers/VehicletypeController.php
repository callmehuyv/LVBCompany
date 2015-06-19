<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\Vehicletype;
use yii\web\UploadedFile;
use callmehuyv\helpers\Input;

class VehicletypeController extends Controller
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
        $vehicletypes = Vehicletype::find()
            ->where(['record_status' => 4])
                ->all();
        return $this->render('index', ['vehicletypes' => $vehicletypes]);
    }

    public function actionDelete()
    {
        $selected_vehicletype = Input::get('vehicletype');
        $model = Vehicletype::findOne($selected_vehicletype);
        $model->record_status = 3;
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        return [
            'status' => $model->save(),
            'element' => '#vehicletype_'.$selected_vehicletype
        ];
    }

    public function actionEdit() {
        $selected_vehicletype = Input::get('vehicletype');
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
        $model = new Vehicletype();
        if ($model->load(Yii::$app->request->post())) {
            if ($model->validate()) {
                $file = UploadedFile::getInstance($model, 'vehicletype_image');
                if ($file) {
                    $model->vehicletype_image = '';
                    $model->save();
                    $file->saveAs('uploads/vehicletype_' . $model->vehicletype_id . '.' . $file->extension);
                    $model->vehicletype_image = 'uploads/vehicletype_' . $model->vehicletype_id . '.' . $file->extension;
                    $model->save();
                } else {
                    $model->vehicletype_image = 'uploads/no-thumbnail.png';
                    $model->save();
                }

                Yii::$app->getSession()->setFlash('message', 'Created new Vehicle Type success!');
                return $this->redirect(['/vehicletype/index']);
            }
        }
        return $this->render('create', ['model' => $model]);
    }

}
