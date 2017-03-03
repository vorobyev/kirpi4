<?php

namespace frontend\controllers;

use Yii;
use app\models\Taskuser;
use app\models\Process;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * TaskuserController implements the CRUD actions for Taskuser model.
 */
class TaskuserController extends Controller
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
     * Lists all Taskuser models.
     * @return mixed
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Taskuser::find()->where(['id_user'=>Yii::$app->user->identity->id])->orderBy('id DESC'),
        ]);
        $model = Taskuser::find()->where(['id_user'=>Yii::$app->user->identity->id])->orderBy('id DESC')->one();
        $id = ($model == null)?"":$model->id;
        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'id'=>$id
        ]);
    }

    
    public function actionNewtaskid()
    {
        $model = Taskuser::find()->where(['id_user'=>Yii::$app->user->identity->id])->orderBy('id DESC')->one();
        $id = ($model == null)?"":$model->id;
        return $id;
    }
    
    /**
     * Displays a single Taskuser model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    public function actionTask($id)
    {
        $task = Taskuser::findOne($id);
        if ($task->status == 0){
            $task->status = 1;
            $task->save(false, NULL, true);
        }
        $error = null;
        $post = Yii::$app->request->post('Process');

        if (isset($post['all'])){
            $processes = Process::find()->where(['id_task'=>$id])->all();
            foreach ($processes as $proc) {
                $proc->count_fact = $proc->count;
                $proc->save();
            }
            $task->status = 3;
            $task->save(false,null,true);
        }
        
        if (isset($post['id'])){
            $process = Process::findOne($post['id']);
            $count = Yii::$app->request->post('Process')['count_add'];
            if ($count > ($process->count - $process->count_fact)){
                $error = "Общее количество ингредиента больше, чем в задании!";
            } else {
                $process->count_fact = $process->count_fact + $count;
                $process->save();
                if ($task->status < 2) {
                    $task->status = 2;
                    $task->save(false,null,true);
                };
                $success = true;
                $processes = Process::find()->where(['id_task'=>$id])->all();
                foreach ($processes as $proc) {
                    if ($proc->count != $proc->count_fact) {
                        $success = false;
                        break;
                    }
                }
                if ($success == true) {
                    $task->status = 3;
                    $task->save(false,null,true);
                }
                
            }
        }
        $processes = Process::find()->where(['id_task'=>$id])->all();
        $provider = new ActiveDataProvider([
            'query' => Process::find()->where(['id_task'=>$id])->orderBy('order ASC'),
        ]);

        return $this->render('task', [
            'task' => $task,
            'processes' => $processes,
            'provider' => $provider,
            'error' => $error
        ]);
    }
    
    /**
     * Creates a new Taskuser model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Taskuser();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Taskuser model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Taskuser model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        if ($this->findModel($id)->status == 2) {
            return $this->render('error',['name'=>'Ошибка','message'=>'Нельзя удалять задачу, которая имеет статус "В процессе"']);
        }
        $this->findModel($id)->delete();
        
        return $this->redirect(['index']);
    }

    /**
     * Finds the Taskuser model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Taskuser the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Taskuser::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
