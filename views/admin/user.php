<?php
    use yii\helpers\Html;
    use yii\widgets\ActiveForm;
    use yii\helpers\Url;

    $this->title = 'Edit User';
    $this->params['breadcrumbs'][] = ['label' => 'Admin', 'url' => ['admin/index']];
    $this->params['breadcrumbs'][] = $this->title;
    
?>
<div class="site-create">
    
        <a class="btn btn-success" href="<?php echo Url::toRoute('admin/create_user') ?>">Create new User</a>

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
                <th>Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Action</th>
            </tr>
            <?php
                foreach ($users as $user) {
                    ?>
                        <tr>
                            <td>
                                <?php echo $user->user_id ?>
                            </td>
                            <td>
                                <?php
                                    echo $user->user_first_name.' '.$user->user_last_name;
                                ?>
                            </td>
                            <td>
                                <?php echo $user->user_email ?>
                            </td>
                            <td>
                                 <?php
                                    echo $user->user_phone;
                                ?>
                            </td>
                            <td>
                                <a class="btn btn-warning" href="<?php echo Url::toRoute('admin/edit_user') ?>?id=<?php echo $user->id ?>">
                                    <i class="glyphicon glyphicon-refresh"></i>
                                </a>
                                <a class="btn btn-danger" href="<?php echo Url::toRoute('admin/delete_user') ?>?id=<?php echo $user->id ?>">
                                    <i class="glyphicon glyphicon-remove"></i>
                                </a>
                            </td>
                        </tr>
                    <?php
                }
            ?>
        </table>

</div>
