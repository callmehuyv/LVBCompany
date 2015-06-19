<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\User;
use app\models\CreateUser;
use callmehuyv\helpers\Input;
use yii\data\Pagination;

class UserController extends Controller
{

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['delete', 'edit', 'create', 'index'],
                'rules' => [
                    [
                        'actions' => ['create', 'delete', 'edit', 'index'],
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
        $query = User::find()->where(['record_status' => 4]);
        $count = $query->count();
                
        $pagination = new Pagination(['totalCount' => $count]);
        $pagination->defaultPageSize = 5;
        $users = $query->offset($pagination->offset)->limit($pagination->limit)->all();
        $data['users'] = $users;
        $data['pagination'] = $pagination;
        return $this->render('index', $data);
    }

    public function actionDelete()
    {
        $selected_user = (int)Input::get('user');
        $model = User::findOne($selected_user);
        $model->record_status = 3;
        $model->save();
        Yii::$app->getSession()->setFlash('message', 'Delete User success!');
        return $this->redirect(['user/index']);
    }

    public function actionEdit() {
        $selected_user = (int)Input::get('user');
        $model = User::findOne($selected_user);
        $oldPassword = $model->user_password;

        if ( $model->load(Yii::$app->request->post())  && $model->validate()) {
            if ($model->user_password !== $oldPassword) {
                $model->user_password = Yii::$app->security->generatePasswordHash($model->user_password);
            }
            if ($model->user_password != '') {
                $model->generateAuthKey();
            }
            $model->save();
            Yii::$app->getSession()->setFlash('message', 'Update User success!');
            return $this->redirect(['user/edit', 'user' => $model->user_id]);
        }

        return $this->render('edit', ['model' => $model]);
    }


    public function actionCreate()
    {
        $model = new CreateUser();
        if ($model->load(Yii::$app->request->post()) && $model->register() ) {
            Yii::$app->getSession()->setFlash('message', 'Create new account success!');
            return $this->redirect(['/user/index']);
        }
        return $this->render('create', ['model' => $model]);
    }

}
