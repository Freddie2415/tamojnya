<?php

namespace app\controllers;

use Yii;
use app\models\Cars;
use yii\web\Controller;
use app\models\CarsSearch;
use yii\filters\VerbFilter;
use yii\web\NotFoundHttpException;
use yii\web\Response;

/**
 * CarsController implements the CRUD actions for Cars model.
 */
class CarsController extends BaseController
{
    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'index'  => ['get'],
                    'view'   => ['get'],
                    'create' => ['get', 'post'],
                    'update' => ['get', 'put', 'post'],
                ],
            ],
        ];
    }

    /**
     * Lists all Cars models.
     *
     * @return string
     */
    public function actionIndex()
    {
        if (Yii::$app->user->isGuest) {
            return $this->redirect("/site/login");
        }


        $model = Cars::find()->all();
        $new = Cars::find()->where(['status' => 'in_progress'])->count();
        $accepted = Cars::find()->where(['status' => 'accepted'])->count();
        $rejected = Cars::find()->where(['status' => 'denied'])->count();
        $all = $new + $accepted + $rejected;

        return $this->render('index2', [
            'model' => $model,
            'new' => $new,
            'accepted' => $accepted,
            'rejected' => $rejected,
            'all' => $all,
        ]);
    }


    /**
     * Displays a single Cars model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        if (Yii::$app->user->isGuest) {
            return $this->redirect("/site/login");
        }

        $item = Cars::find()->where(['id' => $id])->one();
        return $this->render('view', [
            'item' => $item,
        ]);
    }

    /**
     * Creates a new Cars model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $this->layout = 'main';
        $model = new Cars();
        $type = null;
        $model->status = 'in_progress';

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            }
        } else {
            $model->loadDefaultValues();
        }
        $model->arrivedDate = Yii::$app->formatter->asDatetime('now', 'php:Y-m-d H:i:s');
        return $this->render('create', [
            'model' => $model,
            'type' => $type,
        ]);
    }

    /**
     * Updates an existing Cars model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Cars model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }
    public function actionAccept($id)
    {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        $item = Cars::findOne(['id' => $id]);
        $item->status = 'accepted';

        $item->save(false);
        return $this->redirect(['view', 'id' => $id]);
    }

    public function actionReject($id)
    {
        $item = Cars::findOne(['id' => $id]);

        $item->status = 'denied';
        $item->save(false);
        return $this->redirect(['view', 'id' => $id]);
    }

    public static function actionChangeStatusToRejected($id)
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        $item = Cars::findOne(['id' => $id]);

        if ($item) {
            $item->departureDate = Yii::$app->formatter->asDatetime('now', 'php:Y-m-d H:i:s');
            $datetime1 = new \DateTime($item->arrivedDate);
            $datetime2 = new \DateTime($item->departureDate);
            $interval = $datetime1->diff($datetime2);

            // Calculate cost based on interval (assuming $interval is in days)
            if ($interval->days == 0) {
                $cost = 10000;
            } else {
                $cost = floatval($interval->days) * 10000;
            }
            $item->cost = $cost;

            if ($item->save(false)) {
                // Return success response with updated data
                return ['success' => true, 'message' => 'Status changed to accepted', 'cost' =>  $cost, 'id' => $id, 'days' => $interval->days];
            } else {
                // Return failure response if save operation fails
                return ['success' => false, 'message' => 'Failed to change status'];
            }
        } else {
            // Return failure response if item is not found
            return ['success' => false, 'message' => 'Item not found'];
        }
    }

    /**
     * Finds the Cars model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Cars the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Cars::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
