<?php
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;
use yii\helpers\Url;

/* @var $this \yii\web\View */
/* @var $content string */

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
    <script type="text/javascript" src="<?php echo Url::to('@web/js/jquery.min.js'); ?>"></script>
</head>
<body>

<?php $this->beginBody() ?>
    <div class="wrap">
        <?php
            NavBar::begin([
                'brandLabel' => 'LVB Company',
                'brandUrl' => Yii::$app->homeUrl,
                'options' => [
                    'class' => 'navbar-inverse',
                ],
                'renderInnerContainer' => false
            ]);

            if (Yii::$app->user->isGuest) {
                echo Nav::widget([
                    'options' => ['class' => 'navbar-nav navbar-right'],
                    'items' => [
                        ['label' => 'Home', 'url' => ['/site/index']],
                        ['label' => 'User', 'url' => ['/user/index']],
                        ['label' => 'Line', 'url' => ['/line/index']],
                        ['label' => 'Station', 'url' => ['/station/index']],
                        ['label' => 'Vehicle Type', 'url' => ['/vehicletype/index']],
                        ['label' => 'Vehicle', 'url' => ['/vehicle/index']],
                        ['label' => 'Company', 'url' => ['/company/index']],
                        ['label' => 'Driver', 'url' => ['/driver/index']],
                        ['label' => 'Login', 'url' => ['/site/login']]
                    ],
                ]);
            } else {
                echo Nav::widget([
                    'options' => ['class' => 'navbar-nav navbar-right'],
                    'items' => [
                        ['label' => 'Home', 'url' => ['/site/index']],
                        ['label' => 'User', 'url' => ['/user/index']],
                        ['label' => 'Line', 'url' => ['/line/index']],
                        ['label' => 'Station', 'url' => ['/station/index']],
                        ['label' => 'Vehicle Type', 'url' => ['/vehicletype/index']],
                        ['label' => 'Vehicle', 'url' => ['/vehicle/index']],
                        ['label' => 'Company', 'url' => ['/company/index']],
                        ['label' => 'Driver', 'url' => ['/driver/index']],
                        ['label' => 'Logout (' . Yii::$app->user->identity->user_first_name . ')',
                                'url' => ['/site/logout'],
                                'linkOptions' => ['data-method' => 'post']],
                    ],
                ]);
            }
            NavBar::end();
        ?>

        <div class="fluid-container">
            <?= Breadcrumbs::widget([
                'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
            ]) ?>
            <?= $content ?>
        </div>
    </div>

    <footer class="footer">
        <div class="container">
            <p class="pull-left">&copy; LVB Company <?= date('Y') ?></p>
            <p class="pull-right"><?= Yii::powered() ?></p>
        </div>
    </footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
