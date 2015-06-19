<?php
    use yii\helpers\Html;
    use yii\widgets\ActiveForm;
    use yii\helpers\Url;
    use kartik\time\TimePicker;

    $this->title = 'Edit Line';
    $this->params['breadcrumbs'][] = ['label' => 'Line', 'url' => ['line/index']];
    $this->params['breadcrumbs'][] = $this->title;
    
?>
<div class="site-create">
    
    <a class="btn btn-success" href="<?php echo Url::toRoute('line/index') ?>">View all Lines</a>

    <?php messageSystems(); ?>

    <br><br>

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]) ?>

    <?= $form->field($model, 'line_name') ?>
    <?= $form->field($model, 'line_description')->textArea() ?>
    <?= $form->field($model, 'line_start_time')->widget(TimePicker::classname(), ['pluginOptions' => ['showMeridian' => false]]) ?>
    <?= $form->field($model, 'line_end_time')->widget(TimePicker::classname(), ['pluginOptions' => ['showMeridian' => false]]) ?>
    <?= $form->field($model, 'line_image')->fileInput() ?>
    
    <?= Html::img('@web/'.$model->line_image, ['alt' => 'Line Image', 'width' => '200px']) ?>
    <br><br>

    <div class="form-group">
        <?= Html::submitButton('Update', ['class' => 'btn btn-warning']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
