<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\time\TimePicker;

/* @var $this yii\web\View */
/* @var $model app\models\Users */
/* @var $form ActiveForm */

    $this->title = 'Create Company';
    $this->params['breadcrumbs'][] = ['label' => 'Company', 'url' => ['company/index']];
    $this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-create">

    <h1>CREATE NEW COMPANY</h1>
    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]) ?>

        <?= $form->field($model, 'company_name') ?>
        <?= $form->field($model, 'company_description') ?>
        <?= $form->field($model, 'company_image')->fileInput(); ?>
        <div class="form-group">
            <?= Html::submitButton('Create', ['class' => 'btn btn-primary']) ?>
        </div>
    <?php ActiveForm::end(); ?>

</div><!-- site-create -->
