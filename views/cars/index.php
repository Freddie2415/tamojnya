<?php

use app\models\Cars;
use yii\helpers\Url;
use yii\helpers\Html;
use yii\grid\GridView;
use app\models\Countries;
use yii\grid\ActionColumn;

/** @var yii\web\View $this */
/** @var app\models\CarsSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Оператор';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="cars-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Добавить', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); 
    ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'car_number',
            'country_id',
            'model',
            'phoneNumber',
            'arrivedDate',
            'departureDate',
            'status',
            'cost',
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, Cars $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                }
            ],
        ],
    ]); ?>


</div>


<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Все заявки</h6>
        
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>№</th>
                        <th>Страна автомобиля</th>
                        <th>Номер автомобиля</th>
                        <th>Марка автомобиля</th>
                        <th>Номер телефона</th>
                        <th>Дата въезда</th>
                        <th>Дата выезда</th>
                        <th>Стоимсть</th>
                        <th>Статус</th>
                        <th class="text-center" id="eye"><i class="fa fa-eye" aria-hidden="true"></i></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($model as $item) {
                        $countries = Countries::find()->where(['id' => $item->country_id])->one();
                    ?>
                        <tr>
                            <td><?= $item->id ?></td>
                            <td><?= $countries->name_ru; ?></td>
                            <td><?= $item->car_number ?></td>
                            <td><?= $item->model ?></td>
                            <td><?= $item->phoneNumber ?></td>
                            <td><?= $item->arrivedDate ?></td>
                            <td><?= $item->departureDate ?></td>
                            <td><?= $item->cost ?></td>
                            <?php if ($item->status == 'in_progress') {
                                echo "<td class='text-warning text-center' style='font-weight:bold'>На проверке</td>";
                            } else if ($item->status == 'denied') {
                                echo "<td class='text-danger  text-center' style='font-weight:bold'>Покинул базу</td>";
                            } else {
                                echo "<td class='text-success text-center' style='font-weight:bold'>Одобрено</td>";
                            }
                            ?>
                            <td class="text-center"><a href="<?= Url::to(['cars/view', 'id' => $item->id]) ?>"><i class="fa fa-eye" aria-hidden="true"></i></a></td>
                        </tr>
                    <?php  }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>