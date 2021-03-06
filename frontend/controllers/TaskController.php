<?php

namespace frontend\controllers;

use Yii;
use app\models\Task;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * TaskController implements the CRUD actions for Task model.
 */
class TaskController extends Controller
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
     * Lists all Task models.
     * @return mixed
     */
    public function actionIndex()
    {
        if ((isset(Yii::$app->user->identity))&&(Yii::$app->user->identity->role == 1)){
        $dataProvider = new ActiveDataProvider([
            'query' => Task::find()->orderBy("id DESC"),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
        } else {
            return $this->redirect(['/site/index']);
        }
    }

    /**
     * Displays a single Task model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        if ((isset(Yii::$app->user->identity))&&(Yii::$app->user->identity->role == 1)){
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
        } else {
            return $this->redirect(['/site/index']);
        }
    }

    /**
     * Creates a new Task model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        if ((isset(Yii::$app->user->identity))&&(Yii::$app->user->identity->role == 1)){
        $model = new Task();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
        } else {
            return $this->redirect(['/site/index']);
        }
    }

    /**
     * Updates an existing Task model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        if ((isset(Yii::$app->user->identity))&&(Yii::$app->user->identity->role == 1)){
        $model = $this->findModel($id);
        
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
        } else {
            return $this->redirect(['/site/index']);
        }
    }

    /**
     * Deletes an existing Task model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        if ((isset(Yii::$app->user->identity))&&(Yii::$app->user->identity->role == 1)){
        if ($this->findModel($id)->status == 2) {
            return $this->render('error',['name'=>'Ошибка','message'=>'Нельзя удалять задачу, которая имеет статус "В процессе"']);
        }
        $this->findModel($id)->delete();
        
        return $this->redirect(['index']);
        } else {
            return $this->redirect(['/site/index']);
        }
    }

    /**
     * Finds the Task model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Task the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Task::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
