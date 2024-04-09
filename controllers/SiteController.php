<?php

namespace app\controllers;

use Yii;
use app\models\Cars;
use yii\web\Response;
use yii\web\Controller;
use app\models\LoginForm;
use app\models\ContactForm;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        if (Yii::$app->user->isGuest) {
            return $this->redirect('/site/login');
        }


        $model = Cars::find()->all();
        $new = Cars::find()->where(['status' => 'in_progress'])->count();
        $accepted = Cars::find()->where(['status' => 'accepted'])->count();
        $rejected = Cars::find()->where(['status' => 'denied'])->count();
        $all = $new + $accepted + $rejected;
        return $this->render('//cars/index2', [
            'model' => $model,
            'new' => $new,
            'accepted' => $accepted,
            'rejected' => $rejected,
            'all' => $all
        ]);
    }

    public function actionNew()
    {
        $model = Cars::find()->where(['status' => 'in_progress'])->all();
        $new = Cars::find()->where(['status' => 'in_progress'])->count();
        $accepted = Cars::find()->where(['status' => 'accepted'])->count();
        $rejected = Cars::find()->where(['status' => 'denied'])->count();
        $all = $new + $accepted + $rejected;
        return $this->render('//cars/index2', [
            'model' => $model,
            'new' => $new,
            'accepted' => $accepted,
            'rejected' => $rejected,
            'all' => $all

        ]);
    }

    public function actionAccepted()
    {
        $model = Cars::find()->where(['status' => 'accepted'])->all();
        $new = Cars::find()->where(['status' => 'in_progress'])->count();
        $accepted = Cars::find()->where(['status' => 'accepted'])->count();
        $rejected = Cars::find()->where(['status' => 'denied'])->count();
        $all = $new + $accepted + $rejected;
        return $this->render('//cars/index2', [
            'model' => $model,
            'new' => $new,
            'accepted' => $accepted,
            'rejected' => $rejected,
            'all' => $all,
        ]);
    }

    public function actionRejected()
    {
        $model = Cars::find()->where(['status' => 'denied'])->all();
        $new = Cars::find()->where(['status' => 'in_progress'])->count();
        $accepted = Cars::find()->where(['status' => 'accepted'])->count();
        $rejected = Cars::find()->where(['status' => 'denied'])->count();
        $all = $new + $accepted + $rejected;
        return $this->render('//cars/index2', [
            'model' => $model,
            'new' => $new,
            'accepted' => $accepted,
            'rejected' => $rejected,
            'all' => $all

        ]);;
    }

    /**
     * Login action.
     *
     * @return Response|string
     */
    public function actionLogin()
    {
        $this->layout = false;

        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }

        $model->password = '';
        return $this->render('login2', [
            'model' => $model,
        ]);
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        $this->layout = false;

        Yii::$app->user->logout();


        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }

        $model->password = '';
        return $this->redirect('/site/login');
    }

    /**
     * Displays contact page.
     *
     * @return Response|string
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        }
        return $this->render('contact', [
            'model' => $model,
        ]);
    }

    /**
     * Displays about page.
     *
     * @return string
     */
    public function actionAbout()
    {
        $startDate = Yii::$app->request->get('start-date');
        $endDate = Yii::$app->request->get('end-date');

        // Преобразование формата даты, если заданы начальная и конечная даты
        if ($startDate !== null && $endDate !== null) {
            $startDate = \DateTime::createFromFormat('d/m/Y', $startDate)->format('Y-m-d');
            $endDate = \DateTime::createFromFormat('d/m/Y', $endDate)->format('Y-m-d');

            // Добавление времени к начальной и конечной датам
            $startDate .= ' 00:00:00';
            $endDate .= ' 23:59:59';
        } else {
            $startDate = date('Y-m-01 00:00:00'); // Первый день текущего месяца
            $endDate = date('Y-m-t 23:59:59');
        }

        // Запрос к базе данных с учетом диапазона дат или без него
        $accepted = Cars::find()
            ->andWhere(['between', 'arrivedDate', $startDate, $endDate])
            ->count();

        $rejected = Cars::find()
            ->where(['status' => 'denied'])
            ->andWhere(['between', 'departureDate', $startDate, $endDate])
            ->count();

        $totalCost = Cars::find()
            ->where(['status' => 'denied'])
            ->andWhere(['between', 'departureDate', $startDate, $endDate])
            ->sum('cost');

        // Запрос общее кол-во машин на стоянке
        $all = Cars::find()
            ->where([
                'status' => [
                    'in_progress',
                    'accepted',
                ]
            ])
            ->count();

        // Перевод начальной и конечной дат обратно в формат 'd/m/Y'
        $startDate = \DateTime::createFromFormat('Y-m-d H:i:s', $startDate)->format('d/m/Y');
        $endDate = \DateTime::createFromFormat('Y-m-d H:i:s', $endDate)->format('d/m/Y');

        return $this->render('about', [
            'accepted' => $accepted,
            'rejected' => $rejected,
            'all' => $all,
            'totalCost' => $totalCost,
            'startDate' => $startDate,
            'endDate' => $endDate,
        ]);
    }
}
