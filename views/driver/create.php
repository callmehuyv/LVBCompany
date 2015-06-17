<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\time\TimePicker;

/* @var $this yii\web\View */
/* @var $model app\models\Users */
/* @var $form ActiveForm */

    $this->title = 'Create Driver';
    $this->params['breadcrumbs'][] = ['label' => 'Driver', 'url' => ['driver/index']];
    $this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-create">

    <h1>CREATE NEW DRIVER</h1>
    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]) ?>
        <?= $form->errorSummary($model); ?>
        <?= $form->field($model, 'driver_name') ?>
        <?= $form->field($model, 'driver_address') ?>
        <?= $form->field($model, 'driver_phone') ?>
        <?= $form->field($model, 'company_id')->dropDownList($list_companies); ?>
        <?= $form->field($model, 'driver_image')->fileInput(); ?>

        <div class="form-group">
            <?= Html::submitButton('Create', ['class' => 'btn btn-primary']) ?>
        </div>
    <?php ActiveForm::end(); ?>

</div><!-- site-create -->
