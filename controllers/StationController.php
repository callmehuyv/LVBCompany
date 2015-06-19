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
        if($selected_line != null){
            $stations = Station::find()
                ->where(['record_status' => 4, 'line_id'=>$selected_line])
                    ->all();
        } else {
            $stations = Station::find()
                ->where(['record_status' => 4])
                    ->all();
        }
        $list_lines = Line::find()
            ->all();
        return $this->render('index', ['stations' => $stations, 'list_lines' => $list_lines, 'selected_line' => $selected_line]);
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

        $object_list_lines = Line::find()
            ->where(['record_status' => 4])
                ->all();
        $array_list_lines= [];
        foreach ($object_list_lines as $line) {
            $array_list_lines[$line->line_id] = $line->line_name;
        }
        return $this->render('edit', ['model' => $model, 'array_list_lines' => $array_list_lines]);
    }


    public function actionCreate()
    {
        $selected_line = (int)Input::get('line');
        $model = new Station();
        $model->line_id = $selected_line;
        if ($model->load(Yii::$app->request->post())) {
            $file = UploadedFile::getInstance($model, 'station_image');
            if ($file) {
                $model->station_image = '';
                $model->save();
                $file->saveAs('uploads/station_' . $model->station_id . '.' . $file->extension);
                $model->station_image = 'uploads/station_' . $model->station_id . '.' . $file->extension;
            } else {
                $model->station_image = 'uploads/no-thumbnail.png';
            }
            if ($model->save()) {
                Yii::$app->getSession()->setFlash('message', 'Created new Station success!');
            } else {
                Yii::$app->getSession()->setFlash('message', 'Created new Station fail!');
            }

            Yii::$app->getSession()->setFlash('message', 'Created new Station success!');
            return $this->redirect(['/station/index']);
        }
        $object_list_lines = Line::find()
            ->where(['record_status' => 4])
                ->all();
        $array_list_lines= [];
        foreach ($object_list_lines as $line) {
            $array_list_lines[$line->line_id] = $line->line_name;
        }
        return $this->render('create', ['model' => $model, 'array_list_lines' => $array_list_lines, 'selected_line' => $selected_line]);
    }

}
