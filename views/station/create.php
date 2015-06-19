<?php
    use yii\helpers\Html;
    use yii\widgets\ActiveForm;
     use yii\helpers\Url;
    use kartik\time\TimePicker;

    $this->title = 'Create Station';
    $this->params['breadcrumbs'][] = ['label' => 'Station', 'url' => ['station/index']];
    $this->params['breadcrumbs'][] = $this->title;

?>
<div class="site-create">
    <h1>CREATE NEW STATION</h1>
    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]) ?>

        <?= $form->field($model, 'station_name') ?>
        <?= $form->field($model, 'station_description')->textArea() ?>
        <?= $form->field($model, 'line_id')->dropDownList($list_lines); ?>
        <?= $form->field($model, 'station_image')->fileInput(); ?>

        <div class="form-group">
            <?= Html::submitButton('Create', ['class' => 'btn btn-primary']) ?>
        </div>
    <?php ActiveForm::end(); ?>

</div><!-- site-create -->
