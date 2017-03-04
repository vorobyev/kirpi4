<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Product */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="product-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true])->label('Наименование и гос. номер') ?>

    <div class="form-group">
        <?php
            $message = ((isset($answer)&&($answer == true)))?"Этот объект уже используется. Его изменение может повлиять на другие объекты. Продолжить?":false;
        ?>
        <?= Html::submitButton($model->isNewRecord ? 'Создать' : 'Изменить', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary','data-confirm'=>$message]) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
