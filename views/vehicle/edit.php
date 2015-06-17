<?php
    use yii\helpers\Html;
    use yii\widgets\ActiveForm;
    use yii\helpers\Url;
    use kartik\time\TimePicker;

    $this->title = 'Edit Vehicle';
    $this->params['breadcrumbs'][] = ['label' => 'Vehicle', 'url' => ['vehicle/index']];
    $this->params['breadcrumbs'][] = $this->title;
    
?>
<div class="site-create">
    
        <a class="btn btn-success" href="<?php echo Url::toRoute('vehicle/index') ?>">View all Vehicle</a>

        <?php if(Yii::$app->session->get('message') != null) : ?>
            <p class="bg-success"> <?php echo htmlentities(Yii::$app->session->getFlash('message')); ?></p>
        <?php endif; ?>

        <br><br>
    
        <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]) ?>

        <?= $form->field($model, 'vehicle_number') ?>
        <?= $form->field($model, 'driver_id')->dropDownList($list_drivers); ?>
        <?= $form->field($model, 'company_id')->dropDownList($list_companies); ?>
        <?= $form->field($model, 'line_id')->dropDownList($list_lines); ?>
        <?= $form->field($model, 'vehicletype_id')->dropDownList($list_vehicletypes); ?>
        <?= $form->field($model, 'vehicle_image')->fileInput(); ?>
        
        <?= Html::img('@web/'.$model->vehicle_image, ['alt' => 'Vehicle Image', 'width' => '200px']) ?>
        <br><br>

        <div class="form-group">
            <?= Html::submitButton('Update', ['class' => 'btn btn-warning']) ?>
        </div>

        <?php ActiveForm::end(); ?>

</div>
