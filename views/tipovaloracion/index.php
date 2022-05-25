<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\search\tipoValoracionSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Tipo Valoracions';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tipo-valoracion-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Tipo Valoracion', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id_tipo_valoracion',
            'nota_valoracion',
            'estado_valoracion',
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, TipoValoracion $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id_tipo_valoracion' => $model->id_tipo_valoracion]);
                 }
            ],
        ],
    ]); ?>


</div>
