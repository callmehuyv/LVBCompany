<?php
    use yii\helpers\Html;
    use yii\widgets\ActiveForm;
    use yii\helpers\Url;

    $this->title = 'List Driver';
    $this->params['breadcrumbs'][] = ['label' => 'Driver', 'url' => ['driver/index']];
    $this->params['breadcrumbs'][] = $this->title;
    
?>
<div class="site-create">
    
        <a class="btn btn-success" href="<?php echo Url::toRoute('driver/create') ?>">Create new Driver</a>

        <?php
            if ($selected_company != null) {
                ?>
                    <a class="btn btn-primary" href="<?php echo Url::toRoute('driver/index') ?>">View all Driver</a>
                    <script type="text/javascript">
                        $(document).ready(function() {
                            $('#selectCompanyOnDriver').val(<?php echo $selected_company ?>);
                        });
                    </script>
                <?php
            }
        ?>
        <div class="form-group" style="float: right; width: 300px;">
            <div class="input-group">
                <div class="input-group-addon">Filter by Company</div>
                <input id="linkCompanyOnDriver" type="hidden" value="<?php echo Url::toRoute('driver/index') ?>">
                <select id="selectCompanyOnDriver" class="form-control">
                    <?php
                        foreach($list_companies as $company) {
                            ?>
                                <option value="<?php echo $company->company_id ?>"><?php echo $company->company_name ?></option>
                            <?php
                        }
                    ?>
                </select>
            </div>
        </div>

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
                <th>Driver Name</th>
                <th>Driver Address</th>
                <th>Driver Phone</th>
                <th>Driver Image</th>
                <th>Driver Company</th>
                <th>Action</th>
            </tr>
            <?php
                foreach ($drivers as $driver) {
                    ?>
                        <tr>
                            <td>
                                <?php echo $driver->driver_id ?>
                            </td>
                            <td>
                                <?php echo $driver->driver_name ?>
                            </td>
                            <td>
                                <?php echo $driver->driver_address ?>
                            </td>
                            <td>
                                <?php echo $driver->driver_phone ?>
                            </td>
                            <td>
                                <a href="<?php echo Url::to('@web/'.$driver->driver_image); ?>" data-toggle="lightbox" data-title="View Full Size">
                                    <img width="100px" src="<?php echo Url::to('@web/'.$driver->driver_image); ?>" class="img-responsive">
                                </a>
                            </td>
                            <td>
                                <a href="<?php echo Url::toRoute('driver/index').'?company='.$driver->company->company_id ?>">
                                    <?php echo $driver->company->company_name ?>
                                </a>
                            </td>
                            <td>
                                <?php if(!Yii::$app->user->isGuest) : ?>
                                    <a title="Edit" class="btn btn-warning" href="<?php echo Url::toRoute('driver/edit').'?driver='.$driver->driver_id ?>">
                                        <i class="glyphicon glyphicon-edit"></i>
                                    </a>
                                    <a data-confirm="Are you sure you want to delete?" title="Remove" class="btn btn-danger" href="<?php echo Url::toRoute('driver/delete').'?driver='.$driver->driver_id ?>">
                                        <i class="glyphicon glyphicon-remove"></i>
                                    </a>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php
                }
            ?>
        </table>

</div>
