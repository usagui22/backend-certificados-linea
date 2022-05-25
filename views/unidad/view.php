<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Unidad */

$this->title = $model->id_unidad;
$this->params['breadcrumbs'][] = ['label' => 'Unidads', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="unidad-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id_unidad' => $model->id_unidad], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id_unidad' => $model->id_unidad], [
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
            'id_unidad',
            'nombre_unidad',
            'abreviatura_unidad',
            'telefono_unidad',
            'pagina_referencia_unidad',
            'correo_contacto_unidad',
            'telefono_alternativo_unidad',
            'ubicacion_unidad',
        ],
    ]) ?>

</div>
