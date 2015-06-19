<?php
    use yii\helpers\Html;
    use yii\widgets\ActiveForm;
    use yii\helpers\Url;

    $this->title = 'Edit User';
    $this->params['breadcrumbs'][] = ['label' => 'User', 'url' => ['user/index']];
    $this->params['breadcrumbs'][] = $this->title;
    
?>
<div class="site-create">
    
        <a class="btn btn-success" href="<?php echo Url::toRoute('user/index') ?>">View all User</a>

        <?php messageSystems(); ?>

        <br><br>
    
        <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($model, 'user_email') ?>
        <?= $form->field($model, 'user_first_name') ?>
        <?= $form->field($model, 'user_last_name') ?>
        <?= $form->field($model, 'user_phone') ?>
        <?= $form->field($model, 'user_password')->passwordInput(['maxlength' => true]) ?>

        <div class="form-group">
            <?= Html::submitButton('Update', ['class' => 'btn btn-warning']) ?>
        </div>

        <?php ActiveForm::end(); ?>

</div>
