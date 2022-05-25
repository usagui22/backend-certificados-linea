<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\TipoDocumento */

$this->title = $model->id_tipo_documento;
$this->params['breadcrumbs'][] = ['label' => 'Tipo Documentos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="tipo-documento-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id_tipo_documento' => $model->id_tipo_documento], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id_tipo_documento' => $model->id_tipo_documento], [
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
            'id_tipo_documento',
            'nombre_documento',
            'descripcion_tipo_documento',
            'plantilla_tipo_documento',
        ],
    ]) ?>

</div>
