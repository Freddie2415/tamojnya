<?php

/** @var yii\web\View $this */
/** @var yii\bootstrap4\ActiveForm $form */

/** @var app\models\LoginForm $model */

use yii\bootstrap4\ActiveForm;
use yii\bootstrap4\Html;

$this->title = 'Login';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="container">
    <div class="screen">
        <div class="screen__content">
            <?php $form = ActiveForm::begin([
                'options' => [
                    'class' => 'login'
                ]
            ]); ?>
            <div class="login__field">
                <i class="login__icon fas fa-user"></i>
                <?= $form
                    ->field($model, 'username')
                    ->textInput([
                        'maxlength' => true,
                        'placeholder' =>  Yii::t('main', 'Логин'),
                        'class' => 'login__input',
                    ])
                    ->label(false)
                ?>
            </div>
            <div class="login__field">
                <i class="login__icon fas fa-lock"></i>
                <?= $form
                    ->field($model, 'password')
                    ->passwordInput([
                        'maxlength' => true,
                        'placeholder' =>  Yii::t('main', 'Пароль'),
                        'class' => 'login__input',
                    ])
                    ->label(false)
                ?>
            </div>
            <?= Html::submitButton( Yii::t('main', 'Войти'), [
                'class' => 'button login__submit'
            ]) ?>
            <?php ActiveForm::end(); ?>
        </div>
        <div class="screen__background">
            <span class="screen__background__shape screen__background__shape4"></span>
            <span class="screen__background__shape screen__background__shape3"></span>
            <span class="screen__background__shape screen__background__shape2"></span>
            <span class="screen__background__shape screen__background__shape1"></span>
        </div>
    </div>
</div>
<style>
    @import url('https://fonts.googleapis.com/css?family=Raleway:400,700');

    * {
        box-sizing: border-box;
        margin: 0;
        padding: 0;
        font-family: Raleway, sans-serif;
    }

    body {
        background: white;
    }

    .container {
        display: flex;
        align-items: center;
        justify-content: center;
        min-height: 100vh;
    }

    .screen {
        background: rgb(44, 44, 44);
        background: -moz-linear-gradient(90deg, rgba(44, 44, 44, 1) 0%, rgba(44, 44, 44, 1) 26%, rgba(164, 164, 164, 1) 100%);
        background: -webkit-linear-gradient(90deg, rgba(44, 44, 44, 1) 0%, rgba(44, 44, 44, 1) 26%, rgba(164, 164, 164, 1) 100%);
        background: linear-gradient(90deg, rgba(44, 44, 44, 1) 0%, rgba(44, 44, 44, 1) 26%, rgba(164, 164, 164, 1) 100%);
        filter: progid:DXImageTransform.Microsoft.gradient(startColorstr="#2c2c2c", endColorstr="#a4a4a4", GradientType=1);
        position: relative;
        height: 600px;
        width: 360px;
        box-shadow: 0px 0px 24px #5C5696;
    }

    .screen__content {
        z-index: 1;
        position: relative;
        height: 100%;
    }

    .screen__background {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        z-index: 0;
        -webkit-clip-path: inset(0 0 0 0);
        clip-path: inset(0 0 0 0);
        background-color: #2c2c2c;
    }

    .screen__background__shape {
        transform: rotate(45deg);
        position: absolute;
    }

    .screen__background__shape1 {
        height: 520px;
        width: 520px;
        background: #FFF;
        top: -50px;
        right: 120px;
        border-radius: 0 72px 0 0;
    }

    .screen__background__shape2 {
        height: 220px;
        width: 220px;
        background: #f68e00;
        top: -172px;
        right: 0;
        border-radius: 32px;
    }

    .screen__background__shape3 {
        height: 540px;
        width: 190px;
        background: #f68e00;
        top: -24px;
        right: 0;
        border-radius: 32px;
    }

    .screen__background__shape4 {
        height: 400px;
        width: 200px;
        background: #f68e00;
        ;
        top: 420px;
        right: 50px;
        border-radius: 60px;
    }

    .login {
        width: 320px;
        padding: 30px;
        padding-top: 156px;
    }

    .login__field {
        padding: 20px 0px;
        position: relative;
    }

    .login__icon {
        position: absolute;
        top: 30px;
        color: #7875B5;
    }

    .login__input {
        border: none;
        border-bottom: 2px solid #D1D1D4;
        background: none;
        padding: 10px;
        padding-left: 24px;
        font-weight: 700;
        width: 75%;
        transition: .2s;
    }

    .login__input:active,
    .login__input:focus,
    .login__input:hover {
        outline: none;
        border-bottom-color: #6A679E;
    }

    .login__submit {
        background: #fff;
        font-size: 14px;
        margin-top: 30px;
        padding: 16px 20px;
        border-radius: 26px;
        border: 1px solid #D4D3E8;
        text-transform: uppercase;
        font-weight: 700;
        display: flex;
        align-items: center;
        width: 100%;
        color: #eb8d0d;
        box-shadow: 0px 2px 2px #5C5696;
        cursor: pointer;
        transition: .2s;
    }

    .login__submit:active,
    .login__submit:focus,
    .login__submit:hover {
        border-color: #6A679E;
        outline: none;
    }

    .button__icon {
        font-size: 24px;
        margin-left: auto;
        color: #7875B5;
    }

    .social-login {
        position: absolute;
        height: 140px;
        width: 160px;
        text-align: center;
        bottom: 0px;
        right: 0px;
        color: #fff;
    }

    .social-icons {
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .social-login__icon {
        padding: 20px 10px;
        color: #fff;
        text-decoration: none;
        text-shadow: 0px 0px 8px #7875B5;
    }

    .social-login__icon:hover {
        transform: scale(1.5);
    }
</style>