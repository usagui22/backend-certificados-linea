<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\search\tipoDocumentoSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Tipo Documentos';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tipo-documento-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Tipo Documento', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id_tipo_documento',
            'nombre_documento',
            'descripcion_tipo_documento',
            'plantilla_tipo_documento',
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, TipoDocumento $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id_tipo_documento' => $model->id_tipo_documento]);
                 }
            ],
        ],
    ]); ?>


</div>
