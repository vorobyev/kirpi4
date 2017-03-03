<?php
use app\models\Process;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\bootstrap\Modal;
use yii\bootstrap\Alert;
use kartik\grid\GridView;

$this->title = "Задача №".$task->id;
$this->params['breadcrumbs'][] = ['label' => 'Задачи', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

if (isset($error)) {
    echo Alert::widget([
    'options' => [
        'class' => 'alert-danger',
    ],
    'body' => $error,
]);
    
}

foreach ($processes as $process) {
    $form = ActiveForm::begin(['layout' => 'horizontal']); 
    //echo $form->field($process, 'count')->textInput()->label('Количество');
    Modal::begin([
            'header' => "<h2 align='center'>Внесение порции</h2>",
            'options'=>['id'=>'modal'.$process->id],
            'size'=>'modal-md',
            'clientOptions'=>[
                'show'=>false,
                'keyboard'=>true
            ],
        ]);
         echo "<div style='text-align:center'>";
         echo $form->field($process, 'id')->hiddenInput()->label(false);
         echo $form->field($process, 'count_add')->textInput()->label($process->ingredient->name.", ".$process->measure->name);
         echo Html::submitButton('<span class="glyphicon glyphicon-plus"></span> Внести', ['class' => 'btn btn-success btn-outline','style'=>'margin:0 auto']);
         echo "</div>";
    Modal::end();   
   
    
    ActiveForm::end(); 
}
    echo GridView::widget([
        'dataProvider' => $provider,
        'bordered'=>false,
        'striped'=>false,
        'condensed'=>false,
        'responsive'=>false,
        'hover'=>true,
        'layout'=>'{pager}{errors}{items}',
        'emptyText'=>"Ингредиенты не найдены...",
//        'panel'=>[
//            'type'=>GridView::TYPE_PRIMARY,
//            'heading'=>'Список',
//        ],
        'export'=>false,
        'options'=>[
            'class'=>'col-lg-11 col-md-11',
            'style'=>'float:none; margin:auto; '
        ],
        'tableOptions'=>[
            'class'=>'table table-borderless',
            'style'=>'border:none'
        ],
        'rowOptions'=>function ($model, $key, $index, $grid) {

            return [
                'style'=>"cursor:pointer; font-size:18pt;",
                ];
        },
            
        'columns' => [
            [   
                'attribute' => 'ingredient',
                'format' => 'raw',
                'contentOptions'=>['class'=>'alert-success','style'=>'font-weight:bold'],
                'label' => 'Ингредиент',
                'value' => function($data){
        
                    $content = $data->ingredient->name.", ".$data->measure->name;
                    return $content;
                }
            ],
            [   
                'attribute' => 'count',
                'format' => 'raw',
                'contentOptions'=>['class'=>'alert-info','style'=>'font-style:italic;text-align:center;font-weight:bold'],
                'label' => 'Количество добавить',
                'value' => function($data){
        
                    $content = $data->count;
                    return $content;
                }
            ],
            [   
                'attribute' => 'count_fact',
                'format' => 'raw',
                'contentOptions'=>['class'=>'alert-info','style'=>'font-style:italic;text-align:center;font-weight:bold'],
                'label' => 'Количество добавлено',
                'value' => function($data){
        
                    $content = $data->count_fact;
                    return $content;
                }
            ],
            [   
                'attribute' => 'count',
                'format' => 'raw',
                'contentOptions'=>['class'=>'alert-warning','style'=>'text-align:center;font-weight:bold'],
                'label' => 'Количество осталось добавить',
                'value' => function($data){
        
                    $content = ($data->count - $data->count_fact);
                    return $content;
                }
            ],
            [   
                'attribute' => 'count',
                'format' => 'raw',
                'contentOptions'=>['class'=>'alert-warning'],
                'label' => '',
                'value' => function($data){
                    $content = ($data->task->status<3)?Html::button("<span class='glyphicon glyphicon-plus'></span>",['title'=>'Внести порцию','class'=>'btn btn-success','onclick'=>"$(\"#modal".$data->id."\").modal(\"show\")"]):"";
                    return $content;
                }
            ],           

            
        ],
    ]);

if (!empty($task->mail)){
      echo "<div class = 'col-lg-12' style='text-align:center; font-size:12pt'><b>Сообщение оператору:</b> ".Alert::widget([
    'options' => ['class'=>'alert alert-info','style'=>'font-weight:bolder'],
    'body' =>$task->mail,
      'closeButton'=>false
])."</div>";
}            
            
if ($task->status == 1){
    $mess_status = "Не выполнена";
    $class = ['class'=>'alert alert-warning'];
} elseif ($task->status == 2){
    $mess_status = "В процессе";
    $class = ['class'=>'alert alert-info'];
} else {
    $mess_status = "Выполнена";
    $class = ['class'=>'alert alert-success'];
}
  


  echo "<div class = 'col-lg-12' style='text-align:center'><b>Статус задачи:</b> ".Alert::widget([
    'options' => $class,
    'body' => $mess_status,
      'closeButton'=>false
])."</div>";
  if ($task->status < 3){
      $form = ActiveForm::begin(['layout' => 'horizontal']); 
      
        echo $form->field($processes[0], 'all')->hiddenInput()->label(false);
        echo "<div style='text-align:center'>".Html::submitButton('<span class="glyphicon glyphicon-ok"></span> Выполнить задачу (внести все порции за один раз)', ['class' => 'btn btn-success btn-outline','style'=>'margin:0 auto'])."</div>";
      ActiveForm::end(); 
  }
//$task
//$processes
