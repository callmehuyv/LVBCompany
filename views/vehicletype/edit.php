<?php
    use yii\helpers\Html;
    use yii\widgets\ActiveForm;
    use yii\helpers\Url;
    use kartik\time\TimePicker;

    $this->title = 'Edit Vehicle Type';
    $this->params['breadcrumbs'][] = ['label' => 'Vehicle Type', 'url' => ['vehicletype/index']];
    $this->params['breadcrumbs'][] = $this->title;
    
?>
<div class="site-create">
    
        <a class="btn btn-success" href="<?php echo Url::toRoute('vehicletype/index') ?>">View all Vehicle Types</a>

        <?php messageSystems() ?>
        <br><br>
    
        <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]) ?>

        <?= $form->field($model, 'vehicletype_name') ?>
        <?= $form->field($model, 'vehicletype_description') ?>
        <?= $form->field($model, 'vehicletype_image')->fileInput() ?>
        
        <?= Html::img('@web/'.$model->vehicletype_image, ['alt' => 'Vehicle Type Image', 'width' => '200px']) ?>
        <br><br>

        <div class="form-group">
            <?= Html::submitButton('Update', ['class' => 'btn btn-warning']) ?>
        </div>

        <?php ActiveForm::end(); ?>

</div>
