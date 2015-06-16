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

    public function actionIndex($selected_line = null)
    {
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
        $id = (int)$_GET['id'];
        $model = User::findOne($id);
        $model->record_status = 3;
        $model->save();
        Yii::$app->getSession()->setFlash('message', 'Delete User success!');
        return $this->redirect(['user/index']);
    }

    public function actionEdit() {
        $id = (int)$_GET['id'];
        $model = Station::findOne($id);
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
            return $this->redirect(['edit', 'id' => $model->station_id]);
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
        $model = new Station();
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
        return $this->render('create', ['model' => $model, 'array_list_lines' => $array_list_lines]);
    }

}
