<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\Line;
use app\models\Station;
use yii\web\UploadedFile;

use callmehuyv\helpers\Input;

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
        $lines = Line::find()
            ->where(['record_status' => 4])
                ->all();
        return $this->render('index', ['lines' => $lines]);
    }

    public function actionDelete()
    {
        $selected_line = (int)Input::get('line');
        $model = Line::findOne($selected_line);
        $model->record_status = 3;
        $model->save();
        Yii::$app->getSession()->setFlash('message', 'Delete Line success!');
        return $this->redirect(['line/index']);
    }

    public function actionEdit() {
        $selected_line = (int)Input::get('line');
        $model = Line::findOne($selected_line);
        $oldImage = $model->line_image;

        if ( $model->load(Yii::$app->request->post()) ) {
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
        } else {
            return $this->render('edit', [
                'model' => $model,
            ]);
        }

        return $this->render('edit', ['model' => $model]);
    }


    public function actionCreate()
    {
        $model = new Line();
        if ($model->load(Yii::$app->request->post())) {
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
        return $this->render('create', ['model' => $model]);
    }

}
