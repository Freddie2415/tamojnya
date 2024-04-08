<?php

use app\controllers\CarsController;
use yii\helpers\Url;
use yii\helpers\Html;
use app\models\Countries;
use yii\widgets\ActiveForm;
use yii\web\View;

$countries = Countries::find()->where(['id' => $item->country_id])->one();
?>

<!-- Content Wrapper -->
<div id="content-wrapper" class="d-flex flex-column">

    <!-- Main Content -->
    <div id="content">
        <!-- Topbar -->
        <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

            <!-- Sidebar Toggle (Topbar) -->
            <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                <i class="fa fa-bars"></i>
            </button>

            <!-- Topbar Navbar -->
            <ul class="navbar-nav ml-auto">
                <div class="topbar-divider d-none d-sm-block"></div>
                <!-- Nav Item - User Information -->
                <li class="nav-item dropdown no-arrow">
                    <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <span class="mr-2 d-none d-lg-inline text-gray-600 small">Admin </span>
                        <img class="img-profile rounded-circle" src="<?= Yii::getAlias('@web/img/undraw_profile.svg') ?>">
                    </a>
                </li>
            </ul>
        </nav>
        <!-- End of Topbar -->
        <!-- Begin Page Content -->
        <div class="container-fluid">
            <!-- Page Heading -->
            <div class="d-sm-flex align-items-center justify-content-between mb-4">
                <h1 class="h3 mb-0 text-gray-800">Заявка № <?= $item->id ?></h1>
            </div>
            <!-- DataTales Example -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Данные</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" width="100%" cellspacing="0">
                            <tbody>
                                <tr>
                                    <th>№:</th>
                                    <td><?= $item->id ?></td>
                                </tr>
                                <tr>
                                    <th>Страна автомобиля:</th>
                                    <td><?= $countries->name_ru ?></td>
                                </tr>
                                <tr>
                                    <th>Номер автомобиля:</th>
                                    <td><?= $item->car_number ?></td>
                                </tr>
                                <tr>
                                    <th>Марка автомобиля:</th>
                                    <td><?= $item->model ?></td>
                                </tr>
                                <tr>
                                    <th>Номер телефона:</th>
                                    <td><?= $item->phoneNumber; ?></td>
                                </tr>
                                <tr>
                                    <th>Дата въезда:</th>
                                    <td><?= $item->arrivedDate ?></td>
                                </tr>
                                <tr>
                                    <th>Дата выезда:</th>
                                    <td><?= $item->departureDate ?></td>
                                </tr>
                                <tr>
                                    <th>Стоимсть:</th>

                                    <td>
                                        <?php
                                        if ($item->cost == null) {
                                            echo "0 сум";
                                        } else {
                                            echo $item->cost . " сум"; // Add a space before "сум" for better readability
                                        }
                                        ?>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Статус:</th>
                                    <?php if ($item->status == 'in_progress') {
                                        echo "<td class='text-warning text-center' style='font-weight:bold'>На проверке</td>";
                                    } else if ($item->status == 'denied') {
                                        echo "<td class='text-danger  text-center' style='font-weight:bold'>Покинул базу</td>";
                                    } else {
                                        echo "<td class='text-success text-center' style='font-weight:bold'>Одобрено</td>";
                                    }
                                    ?>
                                </tr>
                            </tbody>
                        </table>
                        <div style="float:right;">
                            <?php if (!Yii::$app->user->isGuest && Yii::$app->user->identity->username == 'post') : ?>
                                <?php if ($item->status == 'in_progress') { ?>
                            <a href="#" class="btn btn-success btn-icon-split" data-toggle="modal" data-target="#confirmRejectModal">     <span class="icon text-white-50">
                                            <i class="fas fa-check"></i>
                                        </span>
                                        <span class="text">Одобрить</span></a>

                                <?php }
                                ?>
                            <?php endif; ?>

                            <?php if (!Yii::$app->user->isGuest && Yii::$app->user->identity->username == 'operator') : ?>
                                <?php if ($item->status == 'accepted') { ?>
                                    <button id="saveDataLink" type="button" class="btn btn-danger"  data-toggle="modal" data-target="#exampleModalCenter">
                                        Оформить на выезд
                                    </button>
                                <?php }
                                ?>
                            <?php endif; ?>



                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.container-fluid -->
    </div>
    <!-- End of Main Content -->
    <!-- Modal -->
    <div class="modal fade" id="confirmRejectModal" tabindex="-1" role="dialog" aria-labelledby="confirmRejectModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="confirmRejectModalLabel">Одобрить авто</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Вы уверены, что хотите одобрить авто?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Отмена</button>
                    <a href="<?= Url::to(['cars/accept', 'id' => $item->id]) ?>" class="btn btn-success btn-icon-split">
                        <span class="icon text-white-50">
                            <i class="fas fa-check"></i>
                        </span>
                        <span class="text">Одобрить</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalCenterTitle">Оформить автомобиль № <?= $item->id ?> на выезд </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body text-center" id="modalBody">

                </div>
            </div>
        </div>
    </div>
    <!-- Modal end  -->

    <!-- Modal -->
    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Save changes</button>
                </div>
            </div>
        </div>
    </div>



    <!-- Footer -->
    <footer class="sticky-footer bg-white">
        <div class="container my-auto">
            <div class="copyright text-center my-auto">
                <!-- <span></span> -->
            </div>
        </div>
    </footer>
    <!-- End of Footer -->

</div>
<!-- End of Content Wrapper -->
<script src='https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js'></script>


<script>
    $(document).ready(function() {
        $('#saveDataLink').click(function(event) {
            event.preventDefault(); // Prevent default link behavior

            var url = "<?= Url::to(['cars/change-status-to-rejected', 'id' => $item->id]) ?>"; // Get the URL from the link
            console.log(url);
            // $('#exampleModalCenter').modal('show');
            // Perform a GET request to the controller action URL
            $.get(url)
                .done(function(data) {
                    // Success: Handle the data
                    console.log('Data received:', data);
                })
                .fail(function(jqXHR, textStatus, errorThrown) {
                    // Error: Log the error
                    console.error('AJAX request failed:', errorThrown);
                });

            $.get(url, function(data) {
                // Update modal content with the response from the controller action
                $('#modalBody').html('<form action="/cars/reject?id=' + data.id + '" method="post">' +
                    '<span>Сумма к оплате:</span>' +
                    '<h5>' + data.cost + ' сум</h5>' +
                    '<button type="submit" class="btn btn-danger btn-icon-split" style="font-size: initial; padding: 0.5rem 1rem;">Оформить</button>' +
                    '</form>');

                // Open the modal
                $('#exampleModalCenter').modal('show');
            });
        });
    });
</script>

<script>
    $(document).ready(function() {
        $('#confirmRejectButton').click(function() {
            var itemId = <?= $item->id ?>;
            $.ajax({
                url: '<?= Yii::$app->urlManager->createUrl(['cars/accept']) ?>',
                type: 'post',
                data: {
                    id: itemId
                },
                success: function(response) {
                    // Handle success
                    // You can redirect to another page or update UI as needed
                    window.location.href = '<?= Yii::$app->urlManager->createUrl(['cars/view', 'id' => $item->id]) ?>';
                },
                error: function(xhr, status, error) {
                    // Handle error
                    console.error('AJAX request failed:', error);
                }
            });
        });
    });
</script>