<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Users */
/* @var $form ActiveForm */

    $this->title = 'Create User';
    $this->params['breadcrumbs'][] = ['label' => 'User', 'url' => ['user/index']];
    $this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-create">

    <h1>CREATE NEW ACCOUNT</h1>
    <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($model, 'user_email') ?>
        <?= $form->field($model, 'user_first_name') ?>
        <?= $form->field($model, 'user_last_name') ?>
        <?= $form->field($model, 'user_phone') ?>
        <?= $form->field($model, 'user_password')->passwordInput() ?>
        <?= $form->field($model, 'confirmPassword')->passwordInput() ?>

        <div class="form-group">
            <?= Html::submitButton('Submit', ['class' => 'btn btn-primary']) ?>
        </div>
    <?php ActiveForm::end(); ?>

</div><!-- site-create -->
