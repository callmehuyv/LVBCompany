<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\User;

class AdminController extends Controller
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

    public function actionUser()
    {
        $users = User::find()
            ->where(['record_status' => 4])
                ->all();
        return $this->render('user', ['users' => $users]);
    }

    public function actionDelete_user()
    {
        return $_GET['id'];
    }

    public function actionEdit_user() {
        $id = (int)$_GET['id'];
        $user = User::findOne($id);
        return $this->render('edit_user', ['user' => $user]);
    }

}
