<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Integrante */

$this->title = 'Create Integrante';
$this->params['breadcrumbs'][] = ['label' => 'Integrantes', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="integrante-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
