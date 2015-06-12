<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Users */
/* @var $form ActiveForm */
?>
<div class="site-create">

    <h1>TẠO TÀI KHOẢN ADMIN MỚI</h1>
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
