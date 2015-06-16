<?php
    use yii\helpers\Html;
    use yii\widgets\ActiveForm;
    use yii\helpers\Url;

    $this->title = 'List Company';
    $this->params['breadcrumbs'][] = ['label' => 'Company', 'url' => ['company/index']];
    $this->params['breadcrumbs'][] = $this->title;
    
?>
<div class="site-create">
    
        <a class="btn btn-success" href="<?php echo Url::toRoute('company/create') ?>">Create new Company</a>

        <?php if(Yii::$app->session->get('message') != null) : ?>
            <p class="bg-success"> <?php echo htmlentities(Yii::$app->session->getFlash('message')); ?></p>
        <?php endif; ?>

        <br><br>
        <?php
            if (isset($_GET['message'])) {
                ?>
                    <style type="text/css">
                        .bg-primary {
                            padding: 15px;
                        }
                    </style>
                    <p class="bg-primary"> <?php echo htmlentities($_GET['message']); ?></p>
                <?php
            }
        ?>
        <table class="table table-hover">
            <tr>
                <th>ID</th>
                <th>Company Name</th>
                <th>Company Description</th>
                <th>Company Image</th>
                <th>Action</th>
            </tr>
            <?php
                foreach ($companies as $company) {
                    ?>
                        <tr>
                            <td>
                                <?php echo $company->company_id ?>
                            </td>
                            <td>
                                <?php echo $company->company_name ?>
                            </td>
                            <td>
                                <?php echo $company->company_description ?>
                            </td>
                            <td>
                                <a href="<?php echo Url::to('@web/'.$company->company_image); ?>" data-toggle="lightbox" data-title="View Full Size">
                                    <img width="100px" src="<?php echo Url::to('@web/'.$company->company_image); ?>" class="img-responsive">
                                </a>
                            </td>
                            <td>
                                <a title="Edit" class="btn btn-warning" href="<?php echo Url::toRoute('company/edit').'?company='.$company->company_id ?>">
                                    <i class="glyphicon glyphicon-refresh"></i>
                                </a>
                                <a data-confirm="Are you sure you want to delete?" title="Remove" class="btn btn-danger" href="<?php echo Url::toRoute('company/delete').'?company='.$company->company_id ?>">
                                    <i class="glyphicon glyphicon-remove"></i>
                                </a>
                               
                            </td>
                        </tr>
                    <?php
                }
            ?>
        </table>

</div>
