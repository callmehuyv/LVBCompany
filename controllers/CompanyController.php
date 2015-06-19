<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\Company;
use yii\web\UploadedFile;
use callmehuyv\helpers\Input;
use yii\data\Pagination;

class CompanyController extends Controller
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
        $query = Company::find()->where(['record_status' => 4]);
        $count = $query->count();
        $pagination = new Pagination(['totalCount' => $count]);
        $pagination->defaultPageSize = 5;
        $companies = $query->offset($pagination->offset)->limit($pagination->limit)->all();
        $data['pagination'] = $pagination;
        $data['companies'] = $companies;
        return $this->render('index', $data);
    }

    public function actionDelete()
    {
        $selected_company = (int)Input::get('company');
        $model = Company::findOne($selected_company);
        $model->record_status = 3;
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        return [
            'status' => $model->save(),
            'element' => '#company_'.$selected_company
        ];
    }

    public function actionEdit() {
        $selected_company = (int)Input::get('company');
        $model = Company::findOne($selected_company);
        $oldImage = $model->company_image;

        if ( $model->load(Yii::$app->request->post()) && $model->validate()) {
            $file = UploadedFile::getInstance($model, 'company_image');
            if ($file) {
                $file->saveAs('uploads/company_' . $model->company_id . '.' . $file->extension);
                $model->company_image = 'uploads/company_' . $model->company_id . '.' . $file->extension;
            } else {
                $model->company_image = $oldImage;
            }
            $model->save();
            Yii::$app->getSession()->setFlash('message', 'Update Company success!');
            return $this->redirect(['company/edit', 'company' => $model->company_id]);
        }

        return $this->render('edit', ['model' => $model]);
    }


    public function actionCreate()
    {
        $model = new Company();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $file = UploadedFile::getInstance($model, 'company_image');
            if ($file) {
                $model->company_image = '';
                $model->save();
                $file->saveAs('uploads/company_' . $model->company_id . '.' . $file->extension);
                $model->company_image = 'uploads/company_' . $model->company_id . '.' . $file->extension;
                $model->save();
            } else {
                $model->company_image = 'uploads/no-thumbnail.png';
                $model->save();
            }
            Yii::$app->getSession()->setFlash('message', 'Created new Company success!');
            return $this->redirect(['/company/index']);
        }
        
        return $this->render('create', ['model' => $model]);
    }

}
