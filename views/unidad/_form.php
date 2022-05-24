<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Unidad */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="unidad-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'nombre_unidad')->textInput() ?>

    <?= $form->field($model, 'abreviatura_unidad')->textInput() ?>

    <?= $form->field($model, 'telefono_unidad')->textInput() ?>

    <?= $form->field($model, 'pagina_referencia_unidad')->textInput() ?>

    <?= $form->field($model, 'correo_contacto_unidad')->textInput() ?>

    <?= $form->field($model, 'telefono_alternativo_unidad')->textInput() ?>

    <?= $form->field($model, 'ubicacion_unidad')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
