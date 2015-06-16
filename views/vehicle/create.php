<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\time\TimePicker;

/* @var $this yii\web\View */
/* @var $model app\models\Users */
/* @var $form ActiveForm */

    $this->title = 'Create Vehicle';
    $this->params['breadcrumbs'][] = ['label' => 'Vehicle', 'url' => ['vehicle/index']];
    $this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-create">

    <h1>CREATE NEW VEHICLE</h1>
    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]) ?>

        <?= $form->field($model, 'vehicle_number') ?>
        <?= $form->field($model, 'driver_id')->dropDownList($list_drivers); ?>
        <?= $form->field($model, 'company_id')->dropDownList($list_companies); ?>
        <?= $form->field($model, 'line_id')->dropDownList($list_lines); ?>
        <?= $form->field($model, 'vehicletype_id')->dropDownList($list_vehicletypes); ?>
        <?= $form->field($model, 'vehicle_image')->fileInput(); ?>

        <div class="form-group">
            <?= Html::submitButton('Create', ['class' => 'btn btn-primary']) ?>
        </div>
    <?php ActiveForm::end(); ?>

</div><!-- site-create -->
