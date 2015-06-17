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
                        <tr>
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
                                <a data-toggle="modal" data-target="#modal_vehicletype_<?php echo $vehicletype->vehicletype_id ?>" title="View" class="btn btn-primary" href="#">
                                    View Vehicle
                                </a>
                                <a title="Edit" class="btn btn-warning" href="<?php echo Url::toRoute('vehicletype/edit') ?>/<?php echo $vehicletype->vehicletype_id ?>">
                                    <i class="glyphicon glyphicon-edit"></i>
                                </a>
                                <a data-confirm="Are you sure you want to delete?" title="Remove" class="btn btn-danger" href="<?php echo Url::toRoute('vehicletype/delete') ?>/<?php echo $vehicletype->vehicletype_id ?>">
                                    <i class="glyphicon glyphicon-remove"></i>
                                </a>


                                <!-- Start Modal Station -->
                                <div class="modal fade" id="modal_vehicletype_<?php echo $vehicletype->vehicletype_id ?>">
                                  <div class="modal-dialog">
                                    <div class="modal-content">
                                      <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                        <h4 class="modal-title">List Vehicles have type <?php echo $vehicletype->vehicletype_name ?></h4>
                                      </div>
                                      <div class="modal-body">
                                        <?php if(!empty($vehicletype->vehicles)) : ?>
                                            <ul>
                                                <?php
                                                    foreach ($vehicletype->vehicles as $vehicle) {
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
                                        <a class="btn btn-success" href="<?php echo Url::toRoute('vehicle/create').'?vehicletype='.$vehicletype->vehicletype_id ?>">Create new Vehicle</a>
                                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                                <!-- End Modal Station -->
                            </td>
                        </tr>
                    <?php
                }
            ?>
        </table>

</div>
