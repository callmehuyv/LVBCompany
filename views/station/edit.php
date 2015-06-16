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
    
        <a class="btn btn-success" href="<?php echo Url::toRoute('line/index') ?>">View all Lines</a>

        <?php if(Yii::$app->session->get('message') != null) : ?>
            <p class="bg-success"> <?php echo htmlentities(Yii::$app->session->getFlash('message')); ?></p>
        <?php endif; ?>

        <br><br>
    
        <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]) ?>

        <?= $form->field($model, 'station_name') ?>
        <?= $form->field($model, 'station_description') ?>
        <?= $form->field($model, 'line_id')->dropDownList($array_list_lines, ['option' => [$model->line_id => ['selected' => true]]]); ?>
        <?= $form->field($model, 'station_image')->fileInput() ?>
        
        <?= Html::img('@web/'.$model->station_image, ['alt' => 'Station Image', 'width' => '200px']) ?>
        <br><br>

        <div class="form-group">
            <?= Html::submitButton('Update', ['class' => 'btn btn-warning']) ?>
        </div>

        <?php ActiveForm::end(); ?>

</div>
