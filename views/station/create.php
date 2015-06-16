<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\time\TimePicker;

/* @var $this yii\web\View */
/* @var $model app\models\Users */
/* @var $form ActiveForm */
?>
<div class="site-create">
    <?php echo $selected_line; ?>
    <h1>CREATE NEW STATION</h1>
    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]) ?>

        <?= $form->field($model, 'station_name') ?>
        <?= $form->field($model, 'station_description') ?>
        <?= $form->field($model, 'line_id')->dropDownList($array_list_lines, ['option' => [$selected_line => ['selected' => true]]]); ?>
        <?= $form->field($model, 'station_image')->fileInput(); ?>

        <div class="form-group">
            <?= Html::submitButton('Create', ['class' => 'btn btn-primary']) ?>
        </div>
    <?php ActiveForm::end(); ?>

</div><!-- site-create -->
