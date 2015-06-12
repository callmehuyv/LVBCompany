<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Users */
/* @var $form ActiveForm */
?>
<div class="site-create">

    <h1>Đăng ký tài khoản</h1>
    <p>Bản thử nghiệm này cho phép bạn đăng ký tài khoản với quyền admin</p>
    <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($model, 'user_email') ?>
        <?= $form->field($model, 'user_first_name')->passwordInput() ?>
        <?= $form->field($model, 'user_last_name')->passwordInput() ?>
        <?= $form->field($model, 'user_phone')->passwordInput() ?>
        <?= $form->field($model, 'user_password')->passwordInput() ?>
        <?= $form->field($model, 'confirmPassword')->passwordInput() ?>

        <div class="form-group">
            <?= Html::submitButton('Submit', ['class' => 'btn btn-primary']) ?>
        </div>
    <?php ActiveForm::end(); ?>

</div><!-- site-create -->
