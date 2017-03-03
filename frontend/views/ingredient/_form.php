<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\Measure;

/* @var $this yii\web\View */
/* @var $model app\models\Ingredient */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="ingredient-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true])->label('Наименование') ?>
    
    <?= $form->field($model, 'id_measure')->dropDownList(ArrayHelper::merge([0=>"Ничего не выбрано..."], ArrayHelper::map(Measure::find()->all(), 'id', 'name')))->label('Единица измерения по умолчанию') ?>

    <div class="form-group">
        <?php
            $message = ((isset($answer)&&($answer == true)))?"Этот объект уже используется. Его изменение может повлиять на другие объекты. Продолжить?":false;
        ?>
        <?= Html::submitButton($model->isNewRecord ? 'Создать' : 'Изменить', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary','data-confirm'=>$message]) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
