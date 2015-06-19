<?php
    use yii\helpers\Html;
    use yii\widgets\ActiveForm;
    use yii\helpers\Url;
    use kartik\time\TimePicker;

    $this->title = 'Edit Station';
    $this->params['breadcrumbs'][] = ['label' => 'Station', 'url' => ['station/index']];
    $this->params['breadcrumbs'][] = $this->title;
    
?>
<div class="site-create">
    
        <a class="btn btn-success" href="<?php echo Url::toRoute('station/index') ?>">View all Station</a>

        <?php messageSystems() ?>

        <br><br>
    
        <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]) ?>

        <?= $form->field($model, 'station_name') ?>
        <?= $form->field($model, 'station_description')->textArea() ?>
        <?= $form->field($model, 'line_id')->dropDownList($list_lines); ?>
        <?= $form->field($model, 'station_image')->fileInput() ?>
        
        <?= Html::img('@web/'.$model->station_image, ['alt' => 'Station Image', 'width' => '200px']) ?>
        <br><br>

        <div class="form-group">
            <?= Html::submitButton('Update', ['class' => 'btn btn-warning']) ?>
        </div>

        <?php ActiveForm::end(); ?>

</div>
