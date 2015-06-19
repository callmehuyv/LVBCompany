<?php
    use yii\helpers\Html;
    use yii\widgets\ActiveForm;
    use yii\helpers\Url;

    $this->title = 'List Vehicle Type';
    $this->params['breadcrumbs'][] = ['label' => 'Vehicle Type', 'url' => ['vehicletype/index']];
    $this->params['breadcrumbs'][] = $this->title;
    
?>
<div class="site-create">
    
        <a class="btn btn-success" href="<?php echo Url::toRoute('vehicletype/create') ?>">Create new Vehicle Type</a>

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
                <th>Vehicle Type Name</th>
                <th>Vehicle Type Image</th>
                <th>Action</th>
            </tr>
            <?php
                foreach ($vehicletypes as $vehicletype) {
                    ?>
                        <tr id="vehicletype_<?php echo $vehicletype->vehicletype_id ?>">
                            <td>
                                <?php echo $vehicletype->vehicletype_id ?>
                            </td>
                            <td>
                                <?php echo $vehicletype->vehicletype_name ?>
                            </td>
                            <td>
                                <a href="<?php echo Url::to('@web/'.$vehicletype->vehicletype_image); ?>" data-toggle="lightbox" data-title="View Full Size">
                                    <img width="100px" src="<?php echo Url::to('@web/'.$vehicletype->vehicletype_image); ?>" class="img-responsive">
                                </a>
                            </td>
                            <td>
                                <a data-toggle="modal" data-target="#modal_vehicle_<?php echo $vehicletype->vehicletype_id ?>" title="View" class="btn btn-primary" href="#">
                                    View Vehicle
                                </a>
                                <a data-toggle="modal" data-target="#modal_line_<?php echo $vehicletype->vehicletype_id ?>" title="View" class="btn btn-info" href="#">
                                    View Line
                                </a>

                                <?php if(!Yii::$app->user->isGuest) : ?>
                                <a title="Edit" class="btn btn-warning" href="<?php echo Url::toRoute('vehicletype/edit').'?vehicletype='.$vehicletype->vehicletype_id ?>">
                                    <i class="glyphicon glyphicon-edit"></i>
                                </a>
                                <a title="Remove" class="btn btn-danger deleteConfirm" data-type="vehicletype" data-id="<?php echo $vehicletype->vehicletype_id ?>" data-url="<?php echo Url::toRoute('vehicletype/delete') ?>" href="#">
                                    <i class="glyphicon glyphicon-remove"></i>
                                </a>
                                <?php endif; ?>


                                <!-- Start Modal Vehicle -->
                                <div class="modal fade" id="modal_vehicle_<?php echo $vehicletype->vehicletype_id ?>">
                                  <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                      <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                        <h4 class="modal-title">List Vehicles have type <?php echo $vehicletype->vehicletype_name ?></h4>
                                      </div>
                                      <div class="modal-body">
                                        <?php if(!empty($vehicletype->vehicles)) : ?>
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
                                                    foreach ($vehicletype->vehicles as $vehicle) {
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
                                        <?php else : ?>
                                            <strong>This line don't have any Vehicle</strong>
                                        <?php endif; ?>
                                      </div>
                                      <div class="modal-footer">
                                        <?php if(!Yii::$app->user->isGuest) : ?>
                                            <a class="btn btn-success" href="<?php echo Url::toRoute('vehicle/create').'?vehicletype='.$vehicletype->vehicletype_id ?>">Create new Vehicle</a>
                                        <?php endif; ?>
                                        <a class="btn btn-warning" href="<?php echo Url::toRoute('vehicle/index').'?vehicletype='.$vehicletype->vehicletype_id ?>">View on Vehicle screen</a>
                                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                                <!-- End Modal Vehicle -->

                                <!-- Start Modal Line -->
                                <div class="modal fade" id="modal_line_<?php echo $vehicletype->vehicletype_id ?>">
                                  <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                      <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                        <h4 class="modal-title">List Vehicles have type <?php echo $vehicletype->vehicletype_name ?></h4>
                                      </div>
                                      <div class="modal-body">
                                        <?php
                                            if (empty($vehicletype->lines)) {
                                                ?> 
                                                    <strong>This Vehicle Type don't have any Line</strong>
                                                <?php
                                            } else {
                                                ?>
                                                    <table class="table table-hover">
                                                        <tr>
                                                            <th>ID</th>
                                                            <th>Line Name</th>
                                                            <th>Vehicle Type</th>
                                                            <th>Start Time</th>
                                                            <th>End Time</th>
                                                            <th>Line Image</th>
                                                            <?php if(!Yii::$app->user->isGuest) : ?>
                                                                <th>Action</th>
                                                            <?php endif; ?>
                                                        </tr>
                                                        <?php
                                                            foreach ($vehicletype->lines as $line) {
                                                                ?>
                                                                    <tr id="line_<?php echo $line->line_id ?>">
                                                                        <td>
                                                                            <?php echo $line->line_id ?>
                                                                        </td>
                                                                        <td>
                                                                            <?php echo $line->line_name ?>
                                                                        </td>
                                                                        <td>
                                                                            <?php echo $line->vehicletype->vehicletype_name ?>
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
                                                                        <?php if(!Yii::$app->user->isGuest) : ?>
                                                                            <td>
                                                                                <a title="Edit" class="btn btn-warning" href="<?php echo Url::toRoute('line/edit').'?line='.$line->line_id ?>">
                                                                                    <i class="glyphicon glyphicon-edit"></i>
                                                                                </a>
                                                                                <a title="Remove" class="btn btn-danger deleteConfirm" data-type="line" data-id="<?php echo $line->line_id ?>" data-url="<?php echo Url::toRoute('line/delete') ?>" href="#">
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
                                            <a class="btn btn-success" href="<?php echo Url::toRoute('line/create').'?vehicletype='.$vehicletype->vehicletype_id ?>">Create new Line</a>
                                        <?php endif; ?>
                                        <a class="btn btn-warning" href="<?php echo Url::toRoute('line/index').'?vehicletype='.$vehicletype->vehicletype_id ?>">View on Line screen</a>
                                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                                <!-- End Modal Line -->
                            </td>
                        </tr>
                    <?php
                }
            ?>
        </table>

</div>
