<?php
    use yii\helpers\Html;
    use yii\widgets\ActiveForm;
    use yii\helpers\Url;
    use kartik\time\TimePicker;

    $this->title = 'Edit Driver';
    $this->params['breadcrumbs'][] = ['label' => 'Driver', 'url' => ['driver/index']];
    $this->params['breadcrumbs'][] = $this->title;
    
?>
<div class="site-create">
    
        <a class="btn btn-success" href="<?php echo Url::toRoute('driver/index') ?>">View all Driver</a>

        <?php messageSystem(); ?>
        <br><br>
    
        <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]) ?>

        <?= $form->field($model, 'driver_name') ?>
        <?= $form->field($model, 'driver_address') ?>
        <?= $form->field($model, 'driver_phone') ?>
        <?= $form->field($model, 'company_id')->dropDownList($list_companies); ?>
        <?= $form->field($model, 'driver_image')->fileInput(); ?>
        
        <?= Html::img('@web/'.$model->driver_image, ['alt' => 'Driver Image', 'width' => '200px']) ?>
        <br><br>

        <div class="form-group">
            <?= Html::submitButton('Update', ['class' => 'btn btn-warning']) ?>
        </div>

        <?php ActiveForm::end(); ?>

</div>
