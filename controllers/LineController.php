<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\Line;
use app\models\Station;
use app\models\Vehicletype;
use yii\web\UploadedFile;
use yii\helpers\ArrayHelper;
use callmehuyv\helpers\Input;
use yii\data\Pagination;

class LineController extends Controller
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
        $data['selected_vehicletype'] = Input::get('vehicletype');
        if (Input::has('vehicletype')) {
            $params['vehicletype_id'] = $data['selected_vehicletype'];
        }

        $query = Line::find()->where($params);
        $count = $query->count();
        $pagination = new Pagination(['totalCount' => $count]);
        $pagination->defaultPageSize = 5;
        $data['list_lines'] = $query->offset($pagination->offset)->limit($pagination->limit)->all();
        $data['pagination'] = $pagination;
        $data['list_vehicletypes'] = Vehicletype::find()->where(['record_status' => 4])->all();
        $data['selected_vehicletype']= (int)Input::get('vehicletype');
        return $this->render('index', $data);
    }

    public function actionDelete()
    {
        $selected_line = (int)Input::get('line');
        $model = Line::findOne($selected_line);
        $model->record_status = 3;
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        return [
            'status' => $model->save(),
            'element' => '#line_'.$selected_line
        ];
    }

    public function actionEdit() {
        $selected_line = (int)Input::get('line');
        $model = Line::findOne($selected_line);
        $oldImage = $model->line_image;

        if ( $model->load(Yii::$app->request->post()) && $model->validate() ) {
            $file = UploadedFile::getInstance($model, 'line_image');

            if ($file) {
                $file->saveAs('uploads/line_' . $model->line_id . '.' . $file->extension);
                $model->line_image = 'uploads/line_' . $model->line_id . '.' . $file->extension;
            } else {
                $model->line_image = $oldImage;
            }

            $model->save();
            Yii::$app->getSession()->setFlash('message', 'Update Line success!');
            return $this->redirect(['line/edit', 'line' => $model->line_id]);
        }

        return $this->render('edit', ['model' => $model]);
    }


    public function actionCreate()
    {
        $model = new Line();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $file = UploadedFile::getInstance($model, 'line_image');
            if ($file) {
                $model->line_image = '';
                $model->save();
                $file->saveAs('uploads/line_' . $model->line_id . '.' . $file->extension);
                $model->line_image = 'uploads/line_' . $model->line_id . '.' . $file->extension;
                $model->save();
            } else {
                $model->line_image = 'uploads/no-thumbnail.png';
                $model->save();
            }
            Yii::$app->getSession()->setFlash('message', 'Created new Line success!');
            return $this->redirect(['/line/index']);
        }

        if (Input::has('vehicletype')) {
            $model->vehicletype_id = Input::get('vehicletype');
        }
        $prepare_vehicletypes = Vehicletype::find()
            ->where(['record_status' => 4])
                ->all();
        $data['list_vehicletypes'] = ArrayHelper::map($prepare_vehicletypes, 'vehicletype_id', 'vehicletype_name');
        $data['model'] = $model;

        return $this->render('create', $data);
    }

}
