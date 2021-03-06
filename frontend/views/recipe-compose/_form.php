<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\Recipe;
use app\models\Ingredient;
use app\models\Measure;


/* @var $this yii\web\View */
/* @var $model app\models\RecipeCompose */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="recipe-compose-form">

    <?php $form = ActiveForm::begin(); ?>

   <?= $form->field($model, 'id_ingredient')->dropDownList(ArrayHelper::merge(['0'=>"Ничего не выбрано..."],ArrayHelper::map(Ingredient::find()->all(), 'id', 'name')))->label('Ингредиент') ?>

    <?= $form->field($model, 'count')->textInput() ?>

   <?= $form->field($model, 'id_measure')->dropDownList(ArrayHelper::merge(['0'=>"Ничего не выбрано..."],ArrayHelper::map(Measure::find()->all(), 'id', 'name')))->label('Единица измерения') ?>

    <?= $form->field($model, 'order_pos')->textInput() ?>
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Создать' : 'Изменить', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>
    
    <?php ActiveForm::end(); ?>

</div>
