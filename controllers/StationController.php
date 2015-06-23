<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\Station;
use app\models\Line;
use app\models\CreateUser;
use yii\web\UploadedFile;
use callmehuyv\helpers\Input;
use yii\helpers\ArrayHelper;
use yii\data\Pagination;

class StationController extends Controller
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
                    ]
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
        $selected_line = (int)Input::get('line');
        $params['record_status'] = 4;
        if($selected_line != null){
            $params['line_id'] = $selected_line;
        }

        $query = Station::find()->where($params);
        $count = $query->count();     
        $pagination = new Pagination(['totalCount' => $count]);
        $pagination->defaultPageSize = 5;
        $stations = $query->offset($pagination->offset)->limit($pagination->limit)->all();
        $list_lines = Line::find()->all();

        $data['pagination'] = $pagination;
        $data['stations'] = $stations;
        $data['list_lines'] = $list_lines;
        $data['selected_line'] = $selected_line;

        return $this->render('index', $data);
    }

    public function actionDelete()
    {
        $selected_station = (int)Input::get('station');
        $model = Station::findOne($selected_station);
        $model->record_status = 3;
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        return [
            'status' => $model->save(),
            'element' => '#station_'.$selected_station
        ];
    }

    public function actionEdit() {
        $selected_station = (int)Input::get('station');
        $model = Station::findOne($selected_station);
        $oldImage = $model->station_image;

        if ( $model->load(Yii::$app->request->post()) ) {
            if ($model->validate()) {
                $count = Station::find()->where(['line_id' => $model->line_id, 'record_status' => 4])->where(['not', ['station_id' => $model->station_id]])->count();
                if ($count >= 7) {
                    $model->addError('line_id', 'This Line has max 7 station. Please choose other line');
                } else {
                    $file = UploadedFile::getInstance($model, 'station_image');
                    if ($file) {
                        $file->saveAs('uploads/station_' . $model->station_id . '.' . $file->extension);
                        $model->station_image = 'uploads/station_' . $model->station_id . '.' . $file->extension;
                    } else {
                        $model->station_image = $oldImage;
                    }

                    $model->save();
                    Yii::$app->getSession()->setFlash('message', 'Update Station success!');
                    return $this->redirect(['station/edit', 'station' => $model->station_id]);
                }
            }
        }

        $prepare_list_lines = Line::find()->where(['record_status' => 4])->all();

        $data['list_lines'] = ArrayHelper::map($prepare_list_lines, 'line_id', 'line_name');
        // Foreach list line and check, if it has max 7 station, unset it
        foreach ($data['list_lines'] as $line_id => $line_name ) {
            $count = Station::find()->where(['line_id' => $line_id, 'record_status' => 4])->count();
            if ($count >= 7 && $line_id != $model->line_id) {
                unset($data['list_lines'][$line_id]);
            }
        }
        $data['model'] = $model;

        return $this->render('edit', $data);
    }


    public function actionCreate()
    {
        $selected_line = (int)Input::get('line');
        $model = new Station();
        $model->line_id = $selected_line;
        if ($model->load(Yii::$app->request->post())) {
            if ($model->validate()) {
                $count = Station::find()->where(['line_id' => $model->line_id, 'record_status' => 4])->count();
                if ($count >= 7) {
                    $model->addError('line_id', 'This Line has max 7 station. Please choose other line');
                } else {
                    $file = UploadedFile::getInstance($model, 'station_image');
                    if ($file) {
                        $model->station_image = '';
                        $model->save();
                        $file->saveAs('uploads/station_' . $model->station_id . '.' . $file->extension);
                        $model->station_image = 'uploads/station_' . $model->station_id . '.' . $file->extension;
                    } else {
                        $model->station_image = 'uploads/no-thumbnail.png';
                    }

                    $model->save();
                    Yii::$app->getSession()->setFlash('message', 'Created new Station success!');
                    return $this->redirect(['/station/index']);
                }
            }
        }

        $prepare_list_lines = Line::find()->where(['record_status' => 4])->all();

        $data['list_lines'] = ArrayHelper::map($prepare_list_lines, 'line_id', 'line_name');
        // Foreach list line and check, if it has max 7 station, we will unset it
        foreach ($data['list_lines'] as $line_id => $line_name ) {
            $count = Station::find()->where(['line_id' => $line_id, 'record_status' => 4])->count();
            if ($count >= 7) {
                unset($data['list_lines'][$line_id]);
            }
        }
        $data['model'] = $model;
        $data['selected_line'] = $selected_line;

        return $this->render('create', $data);
    }

}
