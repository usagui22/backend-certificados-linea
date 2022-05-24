<?php

namespace app\controllers;

use app\models\TipoDocumento;
use app\models\tipoDocumentoSearch;
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * TipodocumentoController implements the CRUD actions for TipoDocumento model.
 */
class TipoDocumentoController extends Controller
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
                    'class' => VerbFilter::class,
                    'actions' => [
                        'crear-tipo-documento' => ['POST'],
                        'actualizar-tipo-documento'=>['POST'],
                        'eliminar-tipo-documento'=>['POST','GET']
                    ],
                ],
            ]
        );
    }

    public function beforeAction($action)
    {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        if (Yii::$app->getRequest()->getMethod() === 'OPTIONS') {
            Yii::$app->getResponse()->getHeaders()->set('Allow', 'POST GET PUT');
            Yii::$app->end();
        }
        $this->enableCsrfValidation = false;
        return parent::beforeAction($action);
    }

    /**
     * Lists all TipoDocumento models.
     *
     * @return string
     */
    public function actionIndex()
    {        
        //$searchModel = new tipodocumentoSearch();
        //$dataProvider = $searchModel->search($this->request->queryParams);

        return TipoDocumento::find()->all();
        //$this->render('index', [
          //  'searchModel' => $searchModel,
            //'dataProvider' => $dataProvider,
        //]);
    }

    /**
     * Displays a single TipoDocumento model.
     * @param int $id_tipo_documento
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id_tipo_documento)
    {
        return $this->render('view', [
            'model' => $this->findModel($id_tipo_documento),
        ]);
    }

    /**
     * Creates a new TipoDocumento model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCrearTipoDocumento()
    {
        $tipo_documento = new TipoDocumento();
        $tipo=null;
        $params=Yii::$app->request->getBodyParams();
        if(isset($params)){
            $tipo_documento->nombre_documento=$params['nombre_documento'];
            $tipo_documento->descripcion_tipo_documento=$params['descripcion_tipo_documento'];
            if($tipo_documento->validate() && $tipo_documento->save()){
                $tipo=["guardado"=>true,'tipo_documento'=>$tipo_documento];
            }else{
                $tipo=["guardado"=>false,'tipo_documento'=>$tipo_documento->getErrors()];
            }
        }
        //if ($this->request->isPost) {
          ///  if ($model->load($this->request->post()) && $model->save()) {
             //   return $this->redirect(['view', 'id_tipo_documento' => $model->id_tipo_documento]);
            //}
        ///} else {
          //  $model->loadDefaultValues();
        //}

        return $tipo;
        //$this->render('create', [
          //  'model' => $model,
        //]);
    }

    /**
     * Updates an existing TipoDocumento model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id_tipo_documento
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionActualizarTipoDocumento($id_tipo_act)
    {
        $tipo_documento=TipoDocumento::findOne($id_tipo_act);
        $actual=null;
        //$model = $this->findModel($id_tipo_documento);
        $nparams=Yii::$app->request->getBodyParams();                
        //if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
        if($tipo_documento->validate()){
            $tipo_documento['nombre_documento']=$nparams['nombre_documento'];
            $tipo_documento['descripcion_tipo_documento']=$nparams['descripcion_tipo_documento'];
            if($tipo_documento->save()){
                $actual=["guardado"=>true,'tipo_documento'=>$tipo_documento];
            }else{
                $actual=["guardado"=>false,'tipo_documento'=>$tipo_documento->getErrors()];
            }

        }
          //  return $this->redirect(['view', 'id_tipo_documento' => $model->id_tipo_documento]);
        //}

        return $actual;
        //$this->render('update', [
          //  'model' => $model,
        //]);
    }

    /**
     * Deletes an existing TipoDocumento model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id_tipo_documento
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionEliminarTipoDocumento($id_a_eli)
    {        

//        $this->findModel($id_tipo_documento)->delete();
        return TipoDocumento::findOne($id_a_eli)->delete()?print_r("eliminado exitosamente ".true):print_r("error ID_A_ELIMINAR incorrecto ".false);
        //$this->redirect(['index']);
    }

    /**
     * Finds the TipoDocumento model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id_tipo_documento
     * @return TipoDocumento the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id_tipo_documento)
    {
        if (($model = TipoDocumento::findOne(['id_tipo_documento' => $id_tipo_documento])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
