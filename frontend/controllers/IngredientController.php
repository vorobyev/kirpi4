<?php

namespace frontend\controllers;

use Yii;
use app\models\Ingredient;
use app\classes\Relations;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * IngredientController implements the CRUD actions for Ingredient model.
 */
class IngredientController extends Controller
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
     * Lists all Ingredient models.
     * @return mixed
     */
    public function actionIndex()
    {
        if ((isset(Yii::$app->user->identity))&&(Yii::$app->user->identity->role == 1)){
            $dataProvider = new ActiveDataProvider([
                'query' => Ingredient::find(),
            ]);

            return $this->render('index', [
                'dataProvider' => $dataProvider,
            ]);
        } else {
            return $this->redirect(['/site/index']);
        }
    }

    /**
     * Displays a single Ingredient model.
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
     * Creates a new Ingredient model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        if ((isset(Yii::$app->user->identity))&&(Yii::$app->user->identity->role == 1)){
            $model = new Ingredient();

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
     * Updates an existing Ingredient model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        if ((isset(Yii::$app->user->identity))&&(Yii::$app->user->identity->role == 1)){
            $model = $this->findModel($id);
            if (($rels = Relations::getRelations($this::className(),$id)) == false){
                $answer = false;
            } else {
                $answer = true;
            }

            if ($model->load(Yii::$app->request->post()) && $model->save()) {
                return $this->redirect(['index']);
            } else {
                return $this->render('update', [
                    'model' => $model,
                    'answer' => $answer
                ]);
            }
        } else {
            return $this->redirect(['/site/index']);
        }
    }

    /**
     * Deletes an existing Ingredient model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        if ((isset(Yii::$app->user->identity))&&(Yii::$app->user->identity->role == 1)){
            if (($rels = Relations::getRelations($this::className(),$id)) == false){
                $this->findModel($id)->delete();
            } else {
                $rels = implode  ("<br>" , $rels );
                return $this->render('error',['name'=>'Ошибка','message'=>'Не удалось удалить объект, т.к. на него имеются ссылки в следующих объектах:<br>'.$rels]);
            }

            return $this->redirect(['index']);
        } else {
            return $this->redirect(['/site/index']);
        }            
    }

    /**
     * Finds the Ingredient model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Ingredient the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if ((isset(Yii::$app->user->identity))&&(Yii::$app->user->identity->role == 1)){
            if (($model = Ingredient::findOne($id)) !== null) {
                return $model;
            } else {
                throw new NotFoundHttpException('The requested page does not exist.');
            }
        } else {
            return $this->redirect(['/site/index']);
        }
    }
}
