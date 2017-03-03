<?php

namespace frontend\controllers;

use Yii;
use app\models\RecipeCompose;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\Recipe;

/**
 * RecipeComposeController implements the CRUD actions for RecipeCompose model.
 */
class RecipeComposeController extends Controller
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
     * Lists all RecipeCompose models.
     * @return mixed
     */
    public function actionIndex()
    {
        $id_recipe = Yii::$app->request->get('id_recipe');
        if (isset($id_recipe)){
            $recipe = Recipe::findOne(Yii::$app->request->get('id_recipe'));
            if ($recipe == null) {
                return $this->render('error',['name'=>'Ошибка','message'=>'Не найдена рецептура с идентификатором '.Yii::$app->request->get('id_recipe')]);
            }
        } else {
            return $this->render('error',['name'=>'Ошибка','message'=>'Не указан идентификатор рецептуры в get']);
        }
        $dataProvider = new ActiveDataProvider([
            'query' => RecipeCompose::find()->where(['id_recipe'=>$recipe->id]),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'recipe' => $recipe
        ]);
    }

    /**
     * Displays a single RecipeCompose model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $id_recipe = Yii::$app->request->get('id_recipe');
        if (isset($id_recipe)){
            $recipe = Recipe::findOne(Yii::$app->request->get('id_recipe'));
            if ($recipe == null) {
                return $this->render('error',['name'=>'Ошибка','message'=>'Не найдена рецептура с идентификатором '.Yii::$app->request->get('id_recipe')]);
            }
        } else {
            return $this->render('error',['name'=>'Ошибка','message'=>'Не указан идентификатор рецептуры в get']);
        }
        
        return $this->render('view', [
            'model' => $this->findModel($id),
            'recipe' => $recipe
        ]);
    }

    /**
     * Creates a new RecipeCompose model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $id_recipe = Yii::$app->request->get('id_recipe');
        if (isset($id_recipe)){
            $recipe = Recipe::findOne(Yii::$app->request->get('id_recipe'));
            if ($recipe == null) {
                return $this->render('error',['name'=>'Ошибка','message'=>'Не найдена рецептура с идентификатором '.Yii::$app->request->get('id_recipe')]);
            }
        } else {
            return $this->render('error',['name'=>'Ошибка','message'=>'Не указан идентификатор рецептуры в get']);
        }
        
        $model = new RecipeCompose();

        if ($model->load(Yii::$app->request->post()) && $model->save(false, null, $recipe->id)) {
            return $this->redirect(['index', 'id_recipe'=>$recipe->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
                'recipe' => $recipe
            ]);
        }
    }

    /**
     * Updates an existing RecipeCompose model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        
        $id_recipe = Yii::$app->request->get('id_recipe');
        if (isset($id_recipe)){
            $recipe = Recipe::findOne(Yii::$app->request->get('id_recipe'));
            if ($recipe == null) {
                return $this->render('error',['name'=>'Ошибка','message'=>'Не найдена рецептура с идентификатором '.Yii::$app->request->get('id_recipe')]);
            }
        } else {
            return $this->render('error',['name'=>'Ошибка','message'=>'Не указан идентификатор рецептуры в get']);
        }
        
        if ($model->load(Yii::$app->request->post()) && $model->save(false, null, $recipe->id)) {
            return $this->redirect(['index', 'id_recipe'=>$recipe->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
                'recipe' => $recipe
            ]);
        }
    }

    /**
     * Deletes an existing RecipeCompose model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();
        $id_recipe = Yii::$app->request->get('id_recipe');
        if (isset($id_recipe)){
            $recipe = Recipe::findOne(Yii::$app->request->get('id_recipe'));
            if ($recipe == null) {
                return $this->render('error',['name'=>'Ошибка','message'=>'Не найдена рецептура с идентификатором '.Yii::$app->request->get('id_recipe')]);
            }
        } else {
            return $this->render('error',['name'=>'Ошибка','message'=>'Не указан идентификатор рецептуры в get']);
        }
        return $this->redirect(['index', 'id_recipe'=>$recipe->id]);
    }

    /**
     * Finds the RecipeCompose model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return RecipeCompose the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = RecipeCompose::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
