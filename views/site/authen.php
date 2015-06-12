<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Users */
/* @var $form ActiveForm */
?>
<div class="site-authen">

    <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($model, 'account') ?>
        <?= $form->field($model, 'password') ?>
        <?= $form->field($model, 'record_status') ?>
        <?= $form->field($model, 'token_expire') ?>
    
        <div class="form-group">
            <?= Html::submitButton('Submit', ['class' => 'btn btn-primary']) ?>
        </div>
    <?php ActiveForm::end(); ?>

</div><!-- site-authen -->
