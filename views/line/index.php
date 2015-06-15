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
                <th>Start Time</th>
                <th>End Time</th>
                <th>Line Image</th>
                <th>Stations on this Line</th>
                <th>Action</th>
            </tr>
            <?php
                foreach ($lines as $line) {
                    ?>
                        <tr>
                            <td>
                                <?php echo $line->line_id ?>
                            </td>
                            <td>
                                <?php echo $line->line_name ?>
                            </td>
                            <td>
                                <?php echo $line->line_start_time ?>
                            </td>
                            <td>
                                <?php echo $line->line_end_time ?>
                            </td>
                            <td>
                                <a href="<?php echo Url::to('@web/'.$line->line_image); ?>" data-toggle="lightbox" data-title="View Full Size">
                                    <img width="100px" src="<?php echo Url::to('@web/'.$line->line_image); ?>" class="img-responsive">
                                </a>
                            </td>
                            <td>
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
                            </td>
                            <td>
                                <a title="Edit" class="btn btn-warning" href="<?php echo Url::toRoute('line/edit') ?>?id=<?php echo $line->line_id ?>">
                                    <i class="glyphicon glyphicon-refresh"></i>
                                </a>
                                <a data-confirm="Are you sure you want to delete?" title="Remove" class="btn btn-danger" href="<?php echo Url::toRoute('line/delete') ?>?id=<?php echo $line->line_id ?>">
                                    <i class="glyphicon glyphicon-remove"></i>
                                </a>
                            </td>
                        </tr>
                    <?php
                }
            ?>
        </table>

</div>
