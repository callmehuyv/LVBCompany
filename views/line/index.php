<?php
    use yii\helpers\Html;
    use yii\widgets\ActiveForm;
    use yii\helpers\Url;

    $this->title = 'List Line';
    $this->params['breadcrumbs'][] = ['label' => 'Line', 'url' => ['line/index']];
    $this->params['breadcrumbs'][] = $this->title;
    
?>
<div class="site-create">
    
        <a class="btn btn-success" href="<?php echo Url::toRoute('line/create') ?>">Create new Line</a>


        <?php
            if ($selected_vehicletype != null) {
                ?>
                    <a class="btn btn-primary" href="<?php echo Url::toRoute('line/index') ?>">View all Lines</a>
                    <script type="text/javascript">
                        $(document).ready(function() {
                            $('#selectVehicletype').val(<?php echo $selected_vehicletype ?>);
                        });
                    </script>
                <?php
            }
        ?>

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
                        <tr>
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
                                <a data-toggle="modal" data-target="#modal_vehicle_<?php echo $line->line_id ?>" title="View" class="btn btn-primary" href="#">
                                    View Vehicle
                                </a>
                                <?php if(!Yii::$app->user->isGuest) : ?>
                                    <a title="Edit" class="btn btn-warning" href="<?php echo Url::toRoute('line/edit').'?line='.$line->line_id ?>">
                                        <i class="glyphicon glyphicon-edit"></i>
                                    </a>
                                    <a data-confirm="Are you sure you want to delete?" title="Remove" class="btn btn-danger" href="<?php echo Url::toRoute('line/delete').'?line='.$line->line_id ?>">
                                        <i class="glyphicon glyphicon-remove"></i>
                                    </a>
                                <?php endif; ?>
                                
                                <!-- Start Modal Station -->
                                <div class="modal fade" id="modal_line_<?php echo $line->line_id ?>">
                                  <div class="modal-dialog">
                                    <div class="modal-content">
                                      <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                        <h4 class="modal-title">List Stations On Line <?php echo $line->line_name ?></h4>
                                      </div>
                                      <div class="modal-body">
                                        <?php if(!empty($line->stations)) : ?>
                                            <ul>
                                                <?php
                                                    foreach ($line->stations as $station) {
                                                        ?>
                                                            <li><?php echo $station->station_name ?></li>
                                                        <?php
                                                    }
                                                ?>
                                            </ul>
                                        <?php else : ?>
                                            <ul>
                                                <li>This Line don't have any Station</li>
                                            </ul>
                                        <?php endif; ?>
                                      </div>
                                      <div class="modal-footer">
                                        <a class="btn btn-success" href="<?php echo Url::toRoute('station/create').'?line='.$line->line_id ?>">Create new Station</a>
                                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                                <!-- End Modal Station -->

                                <!-- Start Modal Vehicle -->
                                <div class="modal fade" id="modal_vehicle_<?php echo $line->line_id ?>">
                                  <div class="modal-dialog">
                                    <div class="modal-content">
                                      <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                        <h4 class="modal-title">List Vehicle On Line <?php echo $line->line_name ?></h4>
                                      </div>
                                      <div class="modal-body">
                                        <?php if(!empty($line->vehicles)) : ?>
                                            <ul>
                                                <?php
                                                    foreach ($line->vehicles as $vehicle) {
                                                        ?>
                                                            <li><?php echo $vehicle->vehicle_number ?></li>
                                                        <?php
                                                    }
                                                ?>
                                            </ul>
                                        <?php else : ?>
                                            <ul>
                                                <li>This Line don't have any Vehicle</li>
                                            </ul>
                                        <?php endif; ?>
                                      </div>
                                      <div class="modal-footer">
                                        <a class="btn btn-success" href="<?php echo Url::toRoute('vehicle/create').'?line='.$line->line_id ?>">Create new Vehicle</a>
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
