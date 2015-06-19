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
                                <a data-toggle="modal" data-target="#modal_driver_<?php echo $company->company_id ?>" title="View" class="btn btn-primary" href="#">
                                    View Driver
                                </a>
                                <a data-toggle="modal" data-target="#modal_vehicle_<?php echo $company->company_id ?>" title="View" class="btn btn-info" href="#">
                                    View Vehicle
                                </a>
                                <?php if(!Yii::$app->user->isGuest) : ?>
                                    <a title="Edit" class="btn btn-warning" href="<?php echo Url::toRoute('company/edit').'?company='.$company->company_id ?>">
                                        <i class="glyphicon glyphicon-edit"></i>
                                    </a>
                                    <a data-confirm="Are you sure you want to delete?" title="Remove" class="btn btn-danger" href="<?php echo Url::toRoute('company/delete').'?company='.$company->company_id ?>">
                                        <i class="glyphicon glyphicon-remove"></i>
                                    </a>
                                <?php endif; ?>

                                <!-- Start Modal Vehicle -->
                                <div class="modal fade" id="modal_vehicle_<?php echo $company->company_id ?>">
                                  <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                      <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                        <h4 class="modal-title">List Vehicle belong Company <?php echo $company->company_name ?></h4>
                                      </div>
                                      <div class="modal-body">
                                        <?php
                                            if (empty($company->vehicles)) {
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
                                                            foreach ($company->vehicles as $vehicle) {
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
                                            <a class="btn btn-success" href="<?php echo Url::toRoute('vehicle/create').'?company='.$company->company_id ?>">Create new Vehicle</a>
                                        <?php endif; ?>
                                        <a class="btn btn-warning" href="<?php echo Url::toRoute('vehicle/index').'?company='.$company->company_id ?>">View on Vehicle screen</a>
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
