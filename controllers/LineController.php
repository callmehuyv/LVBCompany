<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\Line;
use app\models\Station;
use app\models\CreateUser;
use yii\web\UploadedFile;

class LineController extends Controller
{

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
        $id = (int)$_GET['id'];
        $model = User::findOne($id);
        $model->record_status = 3;
        $model->save();
        Yii::$app->getSession()->setFlash('message', 'Delete User success!');
        return $this->redirect(['user/index']);
    }

    public function actionEdit() {
        $id = (int)$_GET['id'];
        $model = Line::findOne($id);
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
            return $this->redirect(['edit', 'id' => $model->line_id]);
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
