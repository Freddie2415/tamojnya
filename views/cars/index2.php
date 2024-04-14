<?php

use yii\helpers\Url;
use yii\bootstrap4\Html;
use app\models\Countries;
?>
<link href="<?= Yii::getAlias('@web/vendor/datatables/dataTables.bootstrap4.min.css') ?>" rel="stylesheet">

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
                <?php
                if (Yii::$app->language == 'uz') {
                ?>
                    <li><a class='nav-link active mt-3 ' href='<?php echo Url::to(['', 'language' => 'uz']) ?>'>Uz</a></li>
                <?php } else {
                ?><li><a class='nav-link mt-3' href='<?php echo Url::to(['', 'language' => 'uz']) ?>'>Uz</a></li>
                <?php }
                if (Yii::$app->language == 'ru') {
                ?><li><a class='nav-link active  mt-3' href='<?php echo Url::to(['', 'language' => 'ru']) ?>'>Ru</a></li>
                <?php } else {
                ?><li><a class='nav-link  mt-3' href='<?php echo Url::to(['', 'language' => 'ru']) ?>'>Ru</a></li>
                <?php }

                ?>
                <li class="nav-item dropdown no-arrow " style="color:black;">
                    <?php echo
                    Yii::$app->user->isGuest
                        ? ['label' => Yii::t('main', 'Войти'), 'url' => ['/site/login2']]
                        : '<li class="nav-item">'
                        . Html::beginForm(['/site/logout'])
                        . Html::submitButton(
                            Yii::t('main', 'Выйти') . ' (' . Yii::$app->user->identity->username . ')',
                            ['class' => 'nav-link btn btn-link logout']
                        )
                        . Html::endForm()
                        . '</li>'
                    ?>
                </li>
            </ul>

        </nav>
        <!-- End of Topbar -->

        <!-- Begin Page Content -->
        <div class="container-fluid">

            <!-- Page Heading -->
            <div class="d-sm-flex align-items-center justify-content-between mb-4">
                <?php if (!Yii::$app->user->isGuest && Yii::$app->user->identity->username == 'operator') : ?>
                    <h1 class="h3 mb-0 text-gray-800"> <?= Yii::t('main', 'Оператор') ?></h1>
                <?php elseif (!Yii::$app->user->isGuest && Yii::$app->user->identity->username == 'post') : ?>
                    <h1 class="h3 mb-0 text-gray-800"><?= Yii::t('main', 'Таможенный пост Airitom') ?></h1>
                <?php else : ?>
                    <h1 class="h3 mb-0 text-gray-800"><?= Yii::t('main', 'Руководитель') ?></h1>
                <?php endif; ?>
            </div>

            <!-- Content Row -->
            <div class="row">
                <!-- Pending Requests Card Example -->
                <div class="col-xl-3 col-md-6 mb-4">
                    <a href="<?= Url::home($schema = null) ?>">

                        <div class="card border-left-primary shadow h-100 py-2">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                            <?= Yii::t('main', 'Общее количество машин на стоянке') ?> </div>
                                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $all ?></div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="fas fa-comments fa-2x text-gray-300"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>

                <!-- Pending Requests Card Example -->
                <div class="col-xl-3 col-md-6 mb-4">
                    <a href="<?= Url::toRoute('site/new') ?>">
                        <div class="card border-left-warning shadow h-100 py-2">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                            <?= Yii::t('main', 'Количество машин на стоянке') ?> </div>
                                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $new ?></div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="fas fa-comments fa-2x text-gray-300"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>

                <!-- Pending Requests Card Example -->
                <div class="col-xl-3 col-md-6 mb-4">
                    <a href="<?= Url::toRoute('site/accepted') ?>">

                        <div class="card border-left-success shadow h-100 py-2">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                            <?= Yii::t('main', 'Количество машин приехало') ?> </div>
                                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $accepted ?></div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="fas fa-comments fa-2x text-gray-300"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>

                <!-- Pending Requests Card Example -->
                <div class="col-xl-3 col-md-6 mb-4">
                    <a href="<?= Url::toRoute('site/rejected') ?>">

                        <div class="card border-left-danger shadow h-100 py-2">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">
                                            <?= Yii::t('main', 'Количество машин уехало') ?> </div>
                                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $rejected ?></div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="fas fa-comments fa-2x text-gray-300"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
            <!-- DataTales Example -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <?php if (!Yii::$app->user->isGuest && Yii::$app->user->identity->username == 'operator' || Yii::$app->user->identity->username == 'admin') : ?>
                        <p style="text-align: end;">
                            <?= Html::a(Yii::t('main', 'Добавить'), ['cars/create'], ['class' => 'btn btn-success']) ?>
                        </p>
                    <?php endif; ?>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>№</th>
                                    <th><?= Yii::t('main', 'Страна автомобиля') ?></th>
                                    <th><?= Yii::t('main', 'Номер автомобиля') ?></th>
                                    <th><?= Yii::t('main', 'Марка автомобиля') ?></th>
                                    <th><?= Yii::t('main', 'Номер телефона') ?></th>
                                    <th><?= Yii::t('main', 'Дата въезда') ?></th>
                                    <th><?= Yii::t('main', 'Дата выезда') ?></th>
                                    <th><?= Yii::t('main', 'Стоимость') ?></th>
                                    <th><?= Yii::t('main', 'Статус') ?></th>
                                    <th class="text-center" id="eye"><i class="fa fa-eye" aria-hidden="true"></i></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                foreach ($model as $item) {
                                    $countries = Countries::find()->where(['id' => $item->country_id])->one();

                                    if ($item->status == 'accepted') {
                                ?>
                                        <tr class="text-success" style="font-weight: bold;">
                                            <td><?= $item->id ?></td>
                                            <td><?= $countries->name_ru; ?></td>
                                            <td><?= $item->car_number ?></td>
                                            <td><?= $item->model ?></td>
                                            <td><?= $item->phoneNumber ?></td>
                                            <td><?= $item->arrivedDate ?></td>
                                            <td><?= $item->departureDate ?></td>
                                            <td>
                                                <?php
                                                if ($item->cost == null) {
                                                    echo "0 сум";
                                                } else {
                                                    echo number_format($item->cost, 0, '.', ',') . " сум";
                                                }
                                                ?>
                                            </td>
                                            <?php if ($item->status == 'in_progress') {
                                                echo "<td class='text-warning text-center' style='font-weight:bold'>" . Yii::t('main', 'На проверке') . "</td>";
                                            } else if ($item->status == 'denied') {
                                                echo "<td class='text-danger  text-center' style='font-weight:bold'>" . Yii::t('main', 'Покинул стоянку ТКЦ') . "</td>";
                                            } else if ($item->status == 'accepted') {
                                                echo "<td class='text-success text-center' style='font-weight:bold'>" . Yii::t('main', 'Одобрено таможней') . "</td>";
                                            }
                                            ?>
                                            <td class="text-center">
                                                <span><a href="<?= Url::to(['cars/view', 'id' => $item->id]) ?>"><i class="fa fa-eye" aria-hidden="true"></i></a></span>
                                                <span> <a href="<?= Url::to(['cars/update', 'id' => $item->id]) ?>"><i class="fa fa-edit" aria-hidden="true"></i></a></span>

                                                <?php if (!Yii::$app->user->isGuest && Yii::$app->user->identity->username == 'admin') : ?>
                                                    <span><?= Html::a(
                                                                '<i class="fa fa-trash" aria-hidden="true"></i>',
                                                                ['cars/delete', 'id' => $item->id],
                                                                [
                                                                    'data-confirm' => "Are you sure you want to delete this item?",
                                                                    'linkOptions' => [
                                                                        'data' => [
                                                                            'method' => 'post'
                                                                        ]
                                                                    ],
                                                                    'class' => 'delete-car',
                                                                ]
                                                            ) ?>
                                                    </span>
                                                <?php endif; ?>
                                            </td>

                                        </tr>
                                    <?php } else { ?>
                                        <tr>
                                            <td><?= $item->id ?></td>
                                            <td><?= $countries->name_ru; ?></td>
                                            <td><?= $item->car_number ?></td>
                                            <td><?= $item->model ?></td>
                                            <td><?= $item->phoneNumber ?></td>
                                            <td><?= $item->arrivedDate ?></td>
                                            <td><?= $item->departureDate ?></td>
                                            <td>
                                                <?php
                                                if ($item->cost == null) {
                                                    echo "0 сум";
                                                } else {
                                                    echo number_format($item->cost, 0, '.', ',') . " сум";
                                                }
                                                ?>
                                            </td>
                                            <?php if ($item->status == 'in_progress') {
                                                echo "<td class='text-warning text-center' style='font-weight:bold'>" . Yii::t('main', 'На проверке') . "</td>";
                                            } else if ($item->status == 'denied') {
                                                echo "<td class='text-danger  text-center' style='font-weight:bold'>" . Yii::t('main', 'Покинул стоянку ТКЦ') . "</td>";
                                            } else if ($item->status == 'accepted') {
                                                echo "<td class='text-success text-center' style='font-weight:bold'>" . Yii::t('main', 'Одобрено таможней') . "</td>";
                                            }
                                            ?>
                                            <td class="text-center">
                                                <span><a href="<?= Url::to(['cars/view', 'id' => $item->id]) ?>"><i class="fa fa-eye" aria-hidden="true"></i></a></span>

                                                <span> <a href="<?= Url::to(['cars/update', 'id' => $item->id]) ?>"><i class="fa fa-edit" aria-hidden="true"></i></a></span>

                                                <?php if (!Yii::$app->user->isGuest && Yii::$app->user->identity->username == 'admin') : ?>
                                                    <span><?= Html::a(
                                                                '<i class="fa fa-trash" aria-hidden="true"></i>',
                                                                ['cars/delete', 'id' => $item->id],
                                                                [
                                                                    'data-confirm' => "Are you sure you want to delete this item?",
                                                                    'linkOptions' => [
                                                                        'data' => [
                                                                            'method' => 'post'
                                                                        ]
                                                                    ],
                                                                    'class' => 'delete-car',
                                                                ]
                                                            ) ?>
                                                    </span>
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
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
<script>
    $(document).ready(function() {
        var languageUrl = 'https://cdn.datatables.net/plug-ins/2.0.3/i18n/';
        var lang = 'uz'; // Default language

        // Check if site language is Russian
        if (document.documentElement.lang === 'ru') {
            lang = 'ru';
        }

        $('#dataTable').DataTable({
            language: {
                url: languageUrl + lang + '.json'
            }
        });
    });
</script>