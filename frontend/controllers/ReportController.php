<?php

namespace frontend\controllers;

use Yii;
use app\models\Task;
use app\models\Jobperiod;
use app\models\Process;
use app\classes\Relations;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ProductController implements the CRUD actions for Product model.
 */
class ReportController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Product models.
     * @return mixed
     */
    public function actionJob_period()
    {
        if ((isset(Yii::$app->user->identity))&&(Yii::$app->user->identity->role == 1)){
        $model = new Jobperiod();
        $report = false;
        if ($model->load(Yii::$app->request->post())) {
            $report = true;
        }
        return $this->render('jobperiod', [
            'model' => $model,
            'report' => $report
        ]);
        } else {
            return $this->redirect(['/site/index']);
        }
    }

    protected function findModel($id)
    {
        if (($model = Product::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
