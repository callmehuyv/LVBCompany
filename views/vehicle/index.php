<?php
    use yii\helpers\Html;
    use yii\widgets\ActiveForm;
    use yii\helpers\Url;
    use yii\widgets\LinkPager;

    $this->title = 'List Vehicle';
    $this->params['breadcrumbs'][] = ['label' => 'Vehicle', 'url' => ['vehicle/index']];
    $this->params['breadcrumbs'][] = $this->title;
    
?>
<div class="site-create">
    
        <a class="btn btn-success" href="<?php echo Url::toRoute('vehicle/create') ?>">Create new Vehicle</a>
        <input id="currentUrl" type="hidden" value="<?php echo Url::toRoute('vehicle/index') ?>">

        <?php
            if ($selected_line != null) {
                ?>
                    <a class="btn btn-primary" href="<?php echo Url::toRoute('vehicle/index') ?>">View all Vehicle</a>
                    <script type="text/javascript">
                        $(document).ready(function() {
                            $('#selectLine').val(<?= $selected_line ?>);
                        });
                    </script>
                <?php
            }
             if ($selected_company != null) {
                ?>
                    <a class="btn btn-primary" href="<?php echo Url::toRoute('vehicle/index') ?>">View all Vehicle</a>
                    <script type="text/javascript">
                        $(document).ready(function() {
                            $('#selectCompany').val(<?= $selected_company ?>);
                        });
                    </script>
                <?php
            }
             if ($selected_vehicletype != null) {
                ?>
                    <a class="btn btn-primary" href="<?php echo Url::toRoute('vehicle/index') ?>">View all Vehicle</a>
                    <script type="text/javascript">
                        $(document).ready(function() {
                            $('#selectVehicletype').val(<?= $selected_vehicletype ?>);
                        });
                    </script>
                <?php
            }
        ?>
        <div class="form-group" style="float: right; width: 280px; margin-left: 10px;">
            <div class="input-group">
                <div class="input-group-addon">Line</div>
                <select id="selectLine" class="form-control">
                    <option value="null">View all</option>
                    <?php
                        foreach($list_lines as $line) {
                            ?>
                                <option value="<?php echo $line->line_id ?>"><?php echo $line->line_name ?></option>
                            <?php
                        }
                    ?>
                </select>
            </div>
        </div>
        <div class="form-group" style="float: right; width: 280px; margin-left: 10px;">
            <div class="input-group">
                <div class="input-group-addon">Company</div>
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
        <div class="form-group" style="float: right; width: 280px; margin-left: 10px;">
            <div class="input-group">
                <div class="input-group-addon">Vehicle Type</div>
                <select id="selectVehicletype" class="form-control">
                    <option value="null">View all</option>
                    <?php
                        foreach($list_vehicletypes as $vehicletype) {
                            ?>
                                <option value="<?php echo $vehicletype->vehicletype_id ?>"><?php echo $vehicletype->vehicletype_name ?></option>
                            <?php
                        }
                    ?>
                </select>
            </div>
        </div>


        <?php messageSystems() ?>

        <table class="table table-hover">
            <tr>
                <th>ID</th>
                <th>Vehicle Number</th>
                <th>Company</th>
                <th>Line</th>
                <th>Vehicle Type</th>
                <th>Driver</th>
                <th>Vehicle Image</th>
                <?php if(!Yii::$app->user->isGuest) : ?>
                    <th>Action</th>
                <?php endif; ?>
            </tr>
            <?php
                foreach ($vehicles as $vehicle) {
                    ?>
                        <tr id="vehicle_<?php echo $vehicle->vehicle_id ?>">
                            <td>
                                <?php echo $vehicle->vehicle_id ?>
                            </td>
                            <td>
                                <?php echo $vehicle->vehicle_number ?>
                            </td>
                            <td>
                                <?php echo $vehicle->company->company_name ?>
                            </td>
                            <td>
                                <?php echo $vehicle->line->line_name ?>
                            </td>
                            <td>
                                <?php echo $vehicle->vehicletype->vehicletype_name ?>
                            </td>
                            <td>
                                <?php echo $vehicle->driver->driver_name ?>
                            </td>
                            <td>
                                <a href="<?php echo Url::to('@web/'.$vehicle->vehicle_image); ?>" data-toggle="lightbox" data-title="View Full Size">
                                    <img width="100px" src="<?php echo Url::to('@web/'.$vehicle->vehicle_image); ?>" class="img-responsive">
                                </a>
                            </td>
                            <?php if(!Yii::$app->user->isGuest) : ?>
                                <td>
                                    <a title="Edit" class="btn btn-warning" href="<?php echo Url::toRoute('vehicle/edit').'?vehicle='.$vehicle->vehicle_id ?>">
                                        <i class="glyphicon glyphicon-edit"></i>
                                    </a>
                                    <a title="Remove" class="btn btn-danger deleteConfirm" data-type="vehicle" data-id="<?php echo $vehicle->vehicle_id ?>" data-url="<?php echo Url::toRoute('vehicle/delete') ?>" href="#">
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
