<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\Recipe;
use common\models\User;
use kartik\widgets\DateTimePicker;
/* @var $this yii\web\View */
/* @var $model app\models\Task */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="task-form">

    <?php $form = ActiveForm::begin(); 
        if (isset($model->dateredline)) {
           $model->dateredline = date('d.m.Y H:i', strtotime($model->dateredline));
        }
        
    ?>
    <?= $form->field($model, 'dateredline')->widget(DateTimePicker::className(),[
            'pluginOptions'=>['format'=>'dd.mm.yyyy hh:ii'],
            'language'=>'ru',
    ])->label('Срок');  ?>
    
    <?= $form->field($model, 'id_recipe')->dropDownList(ArrayHelper::merge([0=>"Ничего не выбрано..."],ArrayHelper::map(Recipe::find()->all(), 'id', 'name')))->label('Рецептура') ?>

    <?= $form->field($model, 'count')->textInput()->label('Количество') ?>
    
    <?= $form->field($model, 'id_user')->dropDownList(ArrayHelper::merge([0=>"Ничего не выбрано..."],ArrayHelper::map(User::find()->where(['role'=>2])->all(), 'id', 'username')))->label('Для пользователя') ?>

    <?= $form->field($model, 'mail')->textarea(['rows' => 6])->label('Сообщение') ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Создать' : 'Изменить', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
