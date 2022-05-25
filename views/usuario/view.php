<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Usuario */

$this->title = $model->id_usuario;
$this->params['breadcrumbs'][] = ['label' => 'Usuarios', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="usuario-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id_usuario' => $model->id_usuario], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id_usuario' => $model->id_usuario], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id_usuario',
            'nombres_usuario',
            'apellido_paterno_usuario',
            'apellido_materno_usuario',
            'genero_usuario',
            'fecha_nacimiento_usuario',
            'lugar_nacimiento_usuario',
            'ubicacion_actual_usuario',
            'ocupacion_usuario',
            'correo_usuario',
            'correo_alternativo_usuario',
            'telefono_usuario',
            'celular_usuario',
            'ci_usuario',
            'lugar_expedito_ci_usuario',
            'imagen_usuario',
            'estado_civil_usuario',
        ],
    ]) ?>

</div>
