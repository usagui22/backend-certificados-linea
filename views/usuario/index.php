<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\search\usuarioSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Usuarios';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="usuario-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Usuario', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id_usuario',
            'nombres_usuario',
            'apellido_paterno_usuario',
            'apellido_materno_usuario',
            'genero_usuario',
            //'fecha_nacimiento_usuario',
            //'lugar_nacimiento_usuario',
            //'ubicacion_actual_usuario',
            //'ocupacion_usuario',
            //'correo_usuario',
            //'correo_alternativo_usuario',
            //'telefono_usuario',
            //'celular_usuario',
            //'ci_usuario',
            //'lugar_expedito_ci_usuario',
            //'imagen_usuario',
            //'estado_civil_usuario',
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, Usuario $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id_usuario' => $model->id_usuario]);
                 }
            ],
        ],
    ]); ?>


</div>
