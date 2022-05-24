<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\TipoValoracion */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="tipo-valoracion-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'nota_valoracion')->textInput() ?>

    <?= $form->field($model, 'estado_valoracion')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
