<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\time\TimePicker;

/* @var $this yii\web\View */
/* @var $model app\models\Users */
/* @var $form ActiveForm */

    $this->title = 'Create Line';
    $this->params['breadcrumbs'][] = ['label' => 'Line', 'url' => ['line/index']];
    $this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-create">

    <h1>CREATE NEW LINE</h1>
    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]) ?>

        <?= $form->field($model, 'line_name') ?>
        <?= $form->field($model, 'line_description') ?>
        <?= $form->field($model, 'vehicletype_id')->dropDownList($list_vehicletypes); ?>
        <?= $form->field($model, 'line_start_time')->widget(TimePicker::classname(), ['pluginOptions' => ['showMeridian' => false]]) ?>
        <?= $form->field($model, 'line_end_time')->widget(TimePicker::classname(), ['pluginOptions' => ['showMeridian' => false]]) ?>
        <?= $form->field($model, 'line_image')->fileInput(); ?>

        <div class="form-group">
            <?= Html::submitButton('Create', ['class' => 'btn btn-primary']) ?>
        </div>
    <?php ActiveForm::end(); ?>

</div><!-- site-create -->
