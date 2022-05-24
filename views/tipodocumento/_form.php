<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\TipoDocumento */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="tipo-documento-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'nombre_documento')->textInput() ?>

    <?= $form->field($model, 'descripcion_tipo_documento')->textInput() ?>

    <?= $form->field($model, 'plantilla_tipo_documento')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
