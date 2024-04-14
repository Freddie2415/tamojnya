<?php

use yii\helpers\Url;
use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Cars $model */

$this->title =  Yii::t('main', 'Добавить автомобиль');
$this->params['breadcrumbs'][] = ['label' => 'Оператор', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>


<div class="container">
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
    </nav>
    <!-- End of Topbar -->
    <div class="Добавить автомобил">

        <h1><?= Html::encode($this->title) ?></h1>

        <?= $this->render('_form', [
            'model' => $model,
        ]) ?>

    </div>
</div>