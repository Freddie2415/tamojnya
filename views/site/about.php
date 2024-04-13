<?php


use yii\bootstrap4\Html;
use yii\helpers\Url;

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
                <li class="nav-item dropdown no-arrow " style="color:black;">
                    <?php echo
                    Yii::$app->user->isGuest
                        ? ['label' => Yii::t('main', 'Войти'), 'url' => ['/site/login2']]
                        : '<li class="nav-item">'
                        . Html::beginForm(['/site/logout'])
                        . Html::submitButton(
                            'Logout (' . Yii::$app->user->identity->username . ')',
                            ['class' => 'nav-link btn btn-link logout']
                        )
                        . Html::endForm()
                        . '</li>'
                    ?>
                </li>
                </li>

            </ul>

        </nav>
        <!-- End of Topbar -->
        <h1 class="h3 mb-3 text-gray-800  text-center"><?= Yii::t('main', 'Статистика') ?></h1>
        <!-- Begin Page Content -->
        <div class="container-fluid">
            <!-- Pending Requests Card Example -->
            <div class="center d-flex justify-content-center">

                <div class=" mb-4  ">
                    <a href="<?= Url::home($schema = null) ?>">

                        <div class="card border-left-primary shadow h-100 py-2 pr-5 pl-5 mb-4">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-s font-weight-bold text-primary text-uppercase mb-1 text-center">
                                            <?= Yii::t('main', 'Общее количество машин на стоянке') ?>
                                        </div>
                                        <div class="h5 mb-0 font-weight-bold text-gray-800 mt-2 text-center"><?= $all ?></div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
            <form id="statistics-filter" method="get">
                <div class="row mb-5">
                    <div class="col-3">
                        <div class="datepicker date input-group">
                            <input class="form-control"  type="text" name="daterange" value=""/>
                            <div class="input-group-append">
                                <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                            </div>
                        </div>
                    </div>
                </div>
            </form>

            <!-- Content Row -->
            <div class="row">
                <!-- Pending Requests Card Example -->
                <div class="col-xl-4 col-md-6 mb-6 mt-2">
                    <a href="<?= Url::to('accepted') ?>">

                        <div class="card border-left-success shadow h-100 py-2 mb-4">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2 text-center">
                                        <div class="text-s font-weight-bold text-success text-uppercase mb-1">
                                            <?= Yii::t('main', 'Количество машин приехало') ?>
                                        </div>
                                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $accepted ?></div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </a>
                </div>

                <!-- Pending Requests Card Example -->
                <div class="col-xl-4 col-md-6 mb-6 mt-2">
                    <a href="<?= Url::to('rejected') ?>">
                        <div class="card border-left-danger shadow h-100 py-2 mb-4">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2 text-center ">
                                        <div class="text-s font-weight-bold text-danger text-uppercase mb-3">
                                            <?= Yii::t('main', 'Количество машин уехало') ?>
                                        </div>
                                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $rejected ?></div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </a>
                </div>
                <!-- Pending Requests Card Example -->
                <div class="col-xl-4 col-md-6 mb-6 mt-2">
                    <a href="#">
                        <div class="card border-left-warning shadow h-100 py-2 mb-4">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2 text-center">
                                        <div class="text-s font-weight-bold text-warning text-uppercase mb-1 ">
                                            <?= Yii::t('main', 'Сумма приходв денежных средств') ?>
                                        </div>
                                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $totalCost ?> сум</div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            </div>

        </div>
        <!-- /.container-fluid -->

    </div>
    <!-- End of Main Content -->

    <!-- Footer -->
    <footer class="sticky-footer bg-white">
        <div class="container my-auto">
            <div class="copyright text-center my-auto">

            </div>
        </div>
    </footer>
    <!-- End of Footer -->

</div>
<!-- End of Content Wrapper -->


<!-- Datepicker -->
<script>
    $(function () {
        var startDate = '<?php echo $startDate; ?>';
        var endDate = '<?php echo $endDate; ?>';
        $('input[name="daterange"]').daterangepicker({
            opens: 'left',
            locale: {
                format: 'DD/MM/YYYY',
            },
            startDate: startDate, // Задаем начальную дату
            endDate: endDate // Задаем конечную дату
        }, function (start, end, label) {
            setTimeout(() => document.getElementById('statistics-filter').submit(), 300)
        });
    });
</script>