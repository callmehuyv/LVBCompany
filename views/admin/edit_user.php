<?php
    use yii\helpers\Html;
    use yii\widgets\ActiveForm;
    use yii\helpers\Url;

    $this->title = 'Edit User';
    $this->params['breadcrumbs'][] = ['label' => 'Admin', 'url' => ['admin/index']];
    $this->params['breadcrumbs'][] = $this->title;
    
?>
<div class="site-create">
    
        <a class="btn btn-success" href="<?php echo Url::toRoute('admin/user') ?>">View all User</a>
        <br><br>
    
        <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($user, 'account') ?>

        <?= $form->field($user, 'password')->passwordInput(['maxlength' => true]) ?>

        <div class="form-group">
            <?= Html::submitButton('Update', ['class' => 'btn btn-warning']) ?>
        </div>

        <?php ActiveForm::end(); ?>

</div>
