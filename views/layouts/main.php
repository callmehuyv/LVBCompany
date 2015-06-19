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
    <meta name="robots" content="noindex nofollow">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
    <script type="text/javascript" src="<?php echo Url::to('@web/js/jquery.min.js'); ?>"></script>
    <script type="text/javascript" src="<?php echo Url::to('@web/js/script.js'); ?>"></script>

    <script type="text/javascript">
        function sleep(time){
            var dt = new Date();
            dt.setTime(dt.getTime() + time);
            while (new Date().getTime() < dt.getTime());
        }
        function messageSystems(content) {
            $(document).ready(function(){
                $('#messageSystems .modal-body').html(content)
                $('#messageSystems').modal('show');
            })
        }
        $(document).ready(function(){
            $(".deleteConfirm").confirm({
                text: "Are you sure you want to delete?",
                title: "Please Confirm",
                confirm: function(button) {
                    type = $(button).attr("data-type");
                    id = $(button).attr("data-id");
                    url = $(button).attr("data-url");
                    var data = {};
                    data[type] = id;

                    $.ajax({
                        type: "POST",
                        dataType: "json",
                        url: url,
                        data: data,
                        success: function(data) {
                            if (data['status'] == true) {
                                $(data['element']).fadeOut(1000, function() { $(this).remove(); });
                            } else {
                                messageSystems('Something Wrong! Please try again later');
                            }
                        },
                        error: function(data){
                            messageSystems('Something Wrong! Please try again later');
                        }
                    });
                },
                confirmButton: "Yes I am",
                cancelButton: "No",
                post: true,
                confirmButtonClass: "btn-danger",
                cancelButtonClass: "btn-default",
                dialogClass: "modal-dialog"
            });
        })
    </script>
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

<div id="messageSystems" class="modal fade">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Message From System</h4>
      </div>
      <div class="modal-body">
        <p>One fine body&hellip;</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Ok. I know</button>
      </div>
    </div>
  </div>
</div>

</body>
</html>
<?php $this->endPage() ?>
