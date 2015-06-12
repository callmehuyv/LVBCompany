<?php
use yii\helpers\Html;

/* @var $this yii\web\View */
$this->title = 'About';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-about">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?php
        	foreach ($users as $user) {
        		echo $user->account .'<br/>';
        	}
        ?>
    </p>
    <code><?= __FILE__ ?></code>
</div>
