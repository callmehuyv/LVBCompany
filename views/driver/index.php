<?php
    use yii\helpers\Html;
    use yii\widgets\ActiveForm;
    use yii\helpers\Url;
    use yii\widgets\LinkPager;

    $this->title = 'List Driver';
    $this->params['breadcrumbs'][] = ['label' => 'Driver', 'url' => ['driver/index']];
    $this->params['breadcrumbs'][] = $this->title;
    
?>
<div class="site-create">
    
        <a class="btn btn-success" href="<?php echo Url::toRoute('driver/create') ?>">Create new Driver</a>

        <?php
            if ($selected_company != null) {
                ?>
                    <script type="text/javascript">
                        $(document).ready(function() {
                            $('#selectCompany').val(<?php echo $selected_company ?>);
                        });
                    </script>
                <?php
            }
        ?>
        <div class="form-group" style="float: right; width: 300px;">
            <div class="input-group">
                <div class="input-group-addon">Filter by Company</div>
                <input id="currentUrl" type="hidden" value="<?php echo Url::toRoute('driver/index') ?>">
                <select id="selectCompany" class="form-control">
                    <option value="null">View all</option>
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

        <?php messageSystems(); ?>

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
                <th>Vehicle</th>
                <?php if(!Yii::$app->user->isGuest) : ?>
                    <th>Action</th>
                <?php endif; ?>
            </tr>
            <?php
                foreach ($drivers as $driver) {
                    ?>
                        <tr id="driver_<?php echo $driver->driver_id ?>">
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
                                <?php echo $driver->company->company_name ?>
                            </td>
                            <td>
                                <?php
                                    if (isset($driver->vehicle->vehicle_number)) {
                                        echo $driver->vehicle->vehicle_number;
                                    } else {
                                        echo 'Waiting for layout';
                                    }
                                ?>
                            </td>
                            <?php if(!Yii::$app->user->isGuest) : ?>
                                <td>
                                    <a title="Edit" class="btn btn-warning" href="<?php echo Url::toRoute('driver/edit').'?driver='.$driver->driver_id ?>">
                                        <i class="glyphicon glyphicon-edit"></i>
                                    </a>
                                    <a title="Remove" class="btn btn-danger deleteConfirm" data-type="driver" data-id="<?php echo $driver->driver_id ?>" data-url="<?php echo Url::toRoute('driver/delete') ?>" href="#">
                                        <i class="glyphicon glyphicon-remove"></i>
                                    </a>
                                </td>
                            <?php endif; ?>
                        </tr>
                    <?php
                }
            ?>
        </table>
        <?php
            echo LinkPager::widget([
                'pagination' => $pagination,
            ]);
        ?>
</div>
