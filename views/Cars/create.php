<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Cars $model */

$this->title =  Yii::t('main', 'Добавить автомобил');
$this->params['breadcrumbs'][] = ['label' => 'Оператор', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>


<div class="container">
    <!-- Topbar -->
    <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">
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
                            Yii::t('main', 'Выйти') . ' (' . Yii::$app->user->identity->username . ')',
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
    <div class="Добавить автомобил">

        <h1><?= Html::encode($this->title) ?></h1>

        <?= $this->render('_form', [
            'model' => $model,
        ]) ?>

    </div>
</div>