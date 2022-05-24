<?php

namespace app\controllers;

use app\models\Integrante;
use app\models\search\integranteSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * IntegranteController implements the CRUD actions for Integrante model.
 */
class IntegranteController extends Controller
{
    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'verbs' => [
                    'class' => VerbFilter::className(),
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],
            ]
        );
    }

    /**
     * Lists all Integrante models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new integranteSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Integrante model.
     * @param int $id_integrante Id Integrante
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id_integrante)
    {
        return $this->render('view', [
            'model' => $this->findModel($id_integrante),
        ]);
    }

    /**
     * Creates a new Integrante model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Integrante();

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                return $this->redirect(['view', 'id_integrante' => $model->id_integrante]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Integrante model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id_integrante Id Integrante
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id_integrante)
    {
        $model = $this->findModel($id_integrante);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id_integrante' => $model->id_integrante]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Integrante model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id_integrante Id Integrante
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id_integrante)
    {
        $this->findModel($id_integrante)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Integrante model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id_integrante Id Integrante
     * @return Integrante the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id_integrante)
    {
        if (($model = Integrante::findOne(['id_integrante' => $id_integrante])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
