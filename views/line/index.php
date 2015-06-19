<?php
    use yii\helpers\Html;
    use yii\widgets\ActiveForm;
    use yii\helpers\Url;

    $this->title = 'List Line';
    $this->params['breadcrumbs'][] = ['label' => 'Line', 'url' => ['line/index']];
    $this->params['breadcrumbs'][] = $this->title;
?>

<div class="site-create">
        <?php if(!Yii::$app->user->isGuest) : ?>
            <a class="btn btn-success" href="<?php echo Url::toRoute('line/create') ?>">Create new Line</a>
        <?php endif; ?>

        <?php
            if ($selected_vehicletype != null) {
                ?>
                    <script type="text/javascript">
                        $(document).ready(function() {
                            $('#selectVehicletype').val(<?= $selected_vehicletype ?>);
                        });
                    </script>
                <?php
            }
        ?>
        <div class="form-group" style="float: right; width: 300px;">
            <div class="input-group">
                <div class="input-group-addon">Filter by Vehicle Type</div>
                <input id="currentUrl" type="hidden" value="<?php echo Url::toRoute('line/index') ?>">
                <select id="selectVehicletype" class="form-control">
                    <option value="null">View All</option>
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

        <?php messageSystems(); ?>

        <br><br>
        <table class="table table-hover">
            <tr>
                <th>ID</th>
                <th>Line Name</th>
                <th>Vehicle Type</th>
                <th>Start Time</th>
                <th>End Time</th>
                <th>Line Image</th>
                <th>Action</th>
            </tr>
            <?php
                foreach ($list_lines as $line) {
                    ?>
                        <tr id="line_<?php echo $line->line_id ?>">
                            <td>
                                <?php echo $line->line_id ?>
                            </td>
                            <td>
                                <?php echo $line->line_name ?>
                            </td>
                            <td>
                                <a href="<?php echo Url::toRoute('line/index').'?vehicletype='.$line->vehicletype->vehicletype_id ?>">
                                    <?php echo $line->vehicletype->vehicletype_name ?>
                                </a>
                            </td>
                            <td>
                                <?php echo date('H:i',strtotime($line->line_start_time)) ?>
                            </td>
                            <td>
                                <?php echo date('H:i' ,strtotime($line->line_end_time)) ?>
                            </td>
                            <td>
                                <a href="<?php echo Url::to('@web/'.$line->line_image); ?>" data-toggle="lightbox" data-title="View Full Size">
                                    <img width="100px" src="<?php echo Url::to('@web/'.$line->line_image); ?>" class="img-responsive">
                                </a>
                            </td>
                            <td>
                                <a data-toggle="modal" data-target="#modal_line_<?php echo $line->line_id ?>" title="View" class="btn btn-primary" href="#">
                                    View Station
                                </a>
                                <a data-toggle="modal" data-target="#modal_vehicle_<?php echo $line->line_id ?>" title="View" class="btn btn-info" href="#">
                                    View Vehicle
                                </a>
                                <?php if(!Yii::$app->user->isGuest) : ?>
                                    <a title="Edit" class="btn btn-warning" href="<?php echo Url::toRoute('line/edit').'?line='.$line->line_id ?>">
                                        <i class="glyphicon glyphicon-edit"></i>
                                    </a>
                                    <a title="Remove" class="btn btn-danger deleteConfirm" data-type="line" data-id="<?php echo $line->line_id ?>" data-url="<?php echo Url::toRoute('line/delete') ?>" href="#">
                                        <i class="glyphicon glyphicon-remove"></i>
                                    </a>
                                <?php endif; ?>
                                
                                <!-- Start Modal Station -->
                                <div class="modal fade" id="modal_line_<?php echo $line->line_id ?>">
                                  <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                      <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                        <h4 class="modal-title">List Stations On Line <?php echo $line->line_name ?></h4>
                                      </div>
                                      <div class="modal-body">
                                      <?php
                                        if (empty($line->stations)) {
                                                ?>
                                                    <strong>This line don't have any Station</strong>
                                                <?php
                                            } else {
                                                ?>
                                                    <table class="table table-hover">
                                                        <tr>
                                                            <th>ID</th>
                                                            <th>Station Name</th>
                                                            <th>Station Description</th>
                                                            <th>Belong Line</th>
                                                            <th>Station Image</th>
                                                            <?php if(!Yii::$app->user->isGuest) : ?>
                                                                <th>Action</th>
                                                            <?php endif; ?>
                                                        </tr>
                                                        <?php
                                                            foreach ($line->stations as $station) {
                                                                ?>
                                                                    <tr id="station_<?php echo $station->station_id ?>">
                                                                        <td>
                                                                            <?php echo $station->station_id ?>
                                                                        </td>
                                                                        <td>
                                                                            <?php echo $station->station_name ?>
                                                                        </td>
                                                                        <td>
                                                                            <?php echo $station->station_description ?>
                                                                        </td>
                                                                        <td>
                                                                            <?php echo $station->line->line_name; ?>
                                                                        </td>
                                                                        <td>
                                                                            <a href="<?php echo Url::to('@web/'.$station->station_image); ?>" data-toggle="lightbox" data-title="View Full Size">
                                                                                <img width="100px" src="<?php echo Url::to('@web/'.$station->station_image); ?>" class="img-responsive">
                                                                            </a>
                                                                        </td>
                                                                        <?php if(!Yii::$app->user->isGuest) : ?>
                                                                            <td>
                                                                                <a title="Edit" class="btn btn-warning" href="<?php echo Url::toRoute('station/edit').'?station='.$station->station_id ?>">
                                                                                    <i class="glyphicon glyphicon-edit"></i>
                                                                                </a>
                                                                                <a title="Remove" class="btn btn-danger deleteConfirm" data-type="station" data-id="<?php echo $station->station_id ?>" data-url="<?php echo Url::toRoute('station/delete') ?>" href="#">
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
                                            }
                                        ?>
                                      </div>
                                      <div class="modal-footer">
                                        <?php if(!Yii::$app->user->isGuest) : ?>
                                            <a class="btn btn-success" href="<?php echo Url::toRoute('station/create').'?line='.$line->line_id ?>">Create new Station</a>
                                        <?php endif; ?>
                                        <a class="btn btn-warning" href="<?php echo Url::toRoute('station/index').'?line='.$line->line_id ?>">View on Station screen</a>
                                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                                <!-- End Modal Station -->

                                <!-- Start Modal Vehicle -->
                                <div class="modal fade" id="modal_vehicle_<?php echo $line->line_id ?>">
                                  <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                      <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                        <h4 class="modal-title">List Vehicle On Line <?php echo $line->line_name ?></h4>
                                      </div>
                                      <div class="modal-body">
                                        <?php
                                            if (empty($line->vehicles)) {
                                                ?>
                                                    <strong>This line don't have any Vehicle</strong>
                                                <?php
                                            } else {
                                                ?>
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
                                                            foreach ($line->vehicles as $vehicle) {
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
                                                                        <td>
                                                                            <?php if(!Yii::$app->user->isGuest) : ?>
                                                                                <a title="Edit" class="btn btn-warning" href="<?php echo Url::toRoute('vehicle/edit').'?vehicle='.$vehicle->vehicle_id ?>">
                                                                                    <i class="glyphicon glyphicon-edit"></i>
                                                                                </a>
                                                                                <a title="Remove" class="btn btn-danger deleteConfirm" data-type="vehicle" data-id="<?php echo $vehicle->vehicle_id ?>" data-url="<?php echo Url::toRoute('vehicle/delete') ?>" href="#">
                                                                                    <i class="glyphicon glyphicon-remove"></i>
                                                                                </a>
                                                                            <?php endif; ?>
                                                                        </td>
                                                                    </tr>
                                                                <?php
                                                            }
                                                        ?>
                                                    </table>
                                                <?php
                                            }
                                        ?>
                                      </div>
                                      <div class="modal-footer">
                                        <?php if(!Yii::$app->user->isGuest) : ?>
                                            <a class="btn btn-success" href="<?php echo Url::toRoute('vehicle/create').'?line='.$line->line_id ?>">Create new Vehicle</a>
                                        <?php endif; ?>
                                        <a class="btn btn-warning" href="<?php echo Url::toRoute('vehicle/index').'?line='.$line->line_id ?>">View on Vehicle screen</a>
                                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                                <!-- End Modal Vehicle -->
                            </td>
                        </tr>
                    <?php
                }
            ?>
        </table>

</div>
