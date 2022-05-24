<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Integrante */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="integrante-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'id_usuario')->textInput() ?>

    <?= $form->field($model, 'id_evento')->textInput() ?>

    <?= $form->field($model, 'id_tipo_valoracion')->textInput() ?>

    <?= $form->field($model, 'tipo_integrante')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
