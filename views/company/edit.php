<?php
    use yii\helpers\Html;
    use yii\widgets\ActiveForm;
    use yii\helpers\Url;
    use kartik\time\TimePicker;

    $this->title = 'Edit Company';
    $this->params['breadcrumbs'][] = ['label' => 'Company', 'url' => ['company/index']];
    $this->params['breadcrumbs'][] = $this->title;
    
?>
<div class="site-create">
    
        <a class="btn btn-success" href="<?php echo Url::toRoute('line/index') ?>">View all Lines</a>

        <?php messageSystems() ?>

        <br><br>
    
        <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]) ?>

        <?= $form->field($model, 'company_name') ?>
        <?= $form->field($model, 'company_description') ?>
        <?= $form->field($model, 'company_image')->fileInput(); ?>
        
        <?= Html::img('@web/'.$model->company_image, ['alt' => 'Company Image', 'width' => '200px']) ?>
        <br><br>

        <div class="form-group">
            <?= Html::submitButton('Update', ['class' => 'btn btn-warning']) ?>
        </div>

        <?php ActiveForm::end(); ?>

</div>
