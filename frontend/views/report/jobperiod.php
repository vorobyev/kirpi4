<?php
use kartik\widgets\DateTimePicker;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
use common\models\User;
use app\models\Task;
use app\models\Process;
use app\models\Transport;

$this->title = 'Отчет: Использованные ингредиенты за период';
$this->params['breadcrumbs'][] = $this->title;
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
?>
    <?php $form = ActiveForm::begin();?>
<div class="col-lg-3">
<?= $form->field($model, 'datebegin')->widget(DateTimePicker::className(),[
        'pluginOptions'=>['format'=>'dd.mm.yyyy hh:ii'],
        'language'=>'ru',
        'options' => [
            'style' => 'width:200px'
        ]
])->label('Дата начала');  ?>
</div>
<div class="col-lg-3">
<?= $form->field($model, 'dateend')->widget(DateTimePicker::className(),[
        'pluginOptions'=>['format'=>'dd.mm.yyyy hh:ii'],
        'language'=>'ru',
            'options' => [
            'style' => 'width:200px'
        ]
])->label('Дата окончания');  ?>
</div>
<div class="col-lg-3">
<?= $form->field($model, 'operator')->dropDownList(ArrayHelper::merge([0=>"Ничего не выбрано..."],ArrayHelper::map(User::find()->where(['role'=>2])->all(), 'id', 'username')))->label('Оператор') ?>
</div>
<div class="form-group col-lg-12">
    <?= Html::submitButton('Сформировать', ['class' => 'btn btn-info btn-outline']) ?>
</div>
<hr class="col-lg-12">
<?php ActiveForm::end(); ?>
<div class="col-lg-12">
<?php
if (($report)&&($model->operator == 0)){
    echo "Выберите оператора!";
}
if (($report)&&($model->operator != 0)) {
    $datebegin = date_format(date_create_from_format('d.m.Y H:i', $model->datebegin),"Y-m-d H:i:s");
    $dateend = date_format(date_create_from_format('d.m.Y H:i', $model->dateend),"Y-m-d H:i:s");
    //$tasks = Task::find()->where(['status'=>3])->andWhere(['>=', 'date_success', $datebegin])->andWhere(['<=', 'date_success', $dateend])->andWhere(['id_user'=> $model->operator]);
    $cont = Html::tag("th", "№ задачи");
    $cont = $cont.Html::tag("th", "Дата выполнения");
    $cont = $cont.Html::tag("th", "Ингредиент");
    $cont = $cont.Html::tag("th", "План");
    $cont = $cont.Html::tag("th", "Факт");
    $cont = Html::tag("tr", $cont);
    $cont = Html::tag("thead", $cont);
    
    $transports = Transport::find()->orderBy('id ASC')->all();
    if (isset($transports)){
        $operator = User::findOne($model->operator);
        echo "<div>".$this->title."<br>Период: с ".$model->datebegin." по ".$model->dateend."<br>Оператор: ".$operator->username."</div>";
        foreach ($transports as $transport) {
            $tasks_group_by_transport = Task::find()->where(['status'=>3])->andWhere(['>=', 'date_success', $datebegin])->andWhere(['<=', 'date_success', $dateend])->andWhere(['id_user'=> $model->operator])->andWhere(['id_transport'=>$transport->id])->all();
            if (isset($tasks_group_by_transport)) {
                echo "<h3>Транспорт: ".$transport->name."</h3>";
                $cont_inner = "";
                foreach ($tasks_group_by_transport as $task){
                    $processes = Process::find()->where(['id_task'=>$task->id])->orderBy('id ASC')->all();
                    $par_task = Html::tag("td", $task->id);
                    $par_date = Html::tag("td", date('d.m.Y H:i', strtotime($task->date_success)));
                    foreach ($processes as $process) {
                        $par_ingredient = Html::tag("td", $process->ingredient->name);
                        $par_count = Html::tag("td", $process->count);
                        $par_count_fact = Html::tag("td", $process->count_fact);
                        $cont_inner = $cont_inner.Html::tag("tr", $par_task.$par_date.$par_ingredient.$par_count.$par_count_fact);
                    }
                }
                $cont_inner = Html::tag("tbody", $cont_inner);
                $cont_result = Html::tag("table", $cont.$cont_inner,['class'=>'table']);
                echo Html::tag("div", $cont_result, ['class'=>'table-responsive']);
            }
        }
    }
    

    
}

?>
</div>