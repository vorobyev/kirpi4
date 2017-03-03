<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\Measure;
use app\models\Product;

/* @var $this yii\web\View */
/* @var $model app\models\Recipe */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="recipe-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true])->label('Наименование') ?>
    
    <?= $form->field($model, 'id_product')->dropDownList(ArrayHelper::merge(['0'=>"Ничего не выбрано..."],ArrayHelper::map(Product::find()->all(), 'id', 'name')))->label('Готовый продукт') ?>

    <?= $form->field($model, 'count')->textInput()->label('Количество') ?>
    
    <?= $form->field($model, 'id_measure')->dropDownList(ArrayHelper::merge(['0'=>"Ничего не выбрано..."],ArrayHelper::map(Measure::find()->all(), 'id', 'name')))->label('Единица измерения') ?>

    <div class="form-group">
        <?php
            $message = ((isset($answer)&&($answer == true)))?"Этот объект уже используется. Его изменение может повлиять на другие объекты. Продолжить?":false;
        ?>
        <?= Html::submitButton($model->isNewRecord ? 'Создать' : 'Изменить', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary','data-confirm'=>$message]) ?>
        <?= Html::a('Перейти к составу рецептуры', ['recipe-compose/index', 'id_recipe' => $model->id],
                ['class' => 'btn btn-success btn-outline','name'=>'recipe-compose',
                    'data-confirm'=>"При переходе потеряются несохраненные данные. Перейти?",])?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
