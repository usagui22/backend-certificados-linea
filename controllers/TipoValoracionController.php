<?php

namespace app\controllers;

use app\models\TipoValoracion;
use app\models\tipovaloracionSearch;
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * TipovaloracionController implements the CRUD actions for TipoValoracion model.
 */
class TipovaloracionController extends Controller
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
                        'crear-valoracion' => ['POST','GET'],
                        'actualizar-valoracion'=>['POST'],
                        'borrar-valoracion'=>['POST','GET']
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
     * Lists all TipoValoracion models.
     *
     * @return string
     */
    public function actionIndex()
    {
        //$searchModel = new tipovaloracionSearch();
        //$dataProvider = $searchModel->search($this->request->queryParams);

        return TipoValoracion::find()->all();
        //$this->render('index', [
           // 'searchModel' => $searchModel,
            //'dataProvider' => $dataProvider,
        //]);
    }

    /**
     * Displays a single TipoValoracion model.
     * @param int $id_tipo_valoracion
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id_tipo_valoracion)
    {
        return $this->render('view', [
            'model' => $this->findModel($id_tipo_valoracion),
        ]);
    }

    /**
     * Creates a new TipoValoracion model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCrearValoracion()
    {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $tipovaloracion = new TipoValoracion();
        $msj=null;
        $nota=Yii::$app->request->getBodyParam('nota_valoracion');
        //print($nota);
        //exit();        
        //if ($tipovaloracion->validate()) {
            
            $tipovaloracion['nota_valoracion']=$nota;

            $tipovaloracion['estado_valoracion']=$this->selectEstado($nota);

            if ($tipovaloracion->save()) {

                $msj=["guardar"=>true,"tipoValoracion"=>$tipovaloracion];
            }else {

                $msj=["guardar"=>false,"tipoValoracion"=>$tipovaloracion->getErrors()];
            }
       // }else{
         //   print("Error msj sigue null");
        //}

        return $msj;
        //$this->render('create', [
          //  'model' => $model,
        //]);
    }

    /**
     * Updates an existing TipoValoracion model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id_tipo_valoracion
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionActualizarValoracion($id_act)
    {
        $tipovaloracion = TipoValoracion::findOne($id_act);
        $est=null;
        $nuevaNota=Yii::$app->request->getBodyParam('nota_valoracion');
        if(isset($tipovaloracion)){
            $tipovaloracion['nota_valoracion']=$nuevaNota;
            
            $tipovaloracion->estado_valoracion=$this->selectEstado($nuevaNota);

            if($tipovaloracion->save()){

                $est=["cambio"=>true,"valoracion"=>$tipovaloracion];
           }else{
                $est=["cambio"=>false,"valoracion"=>$tipovaloracion->getErrors()];
            }
        }
//        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
  //          return $this->redirect(['view', 'id_tipo_valoracion' => $model->id_tipo_valoracion]);
    //    }
        return $est;
        //$this->render('update', [
          //  'model' => $model,
        //]);
    }

    /**
     * Deletes an existing TipoValoracion model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id_tipo_valoracion
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionBorrarValoracion($id_borrar)
    {
        //$this->findModel($id_tipo_valoracion)->delete();

        return TipoValoracion::findOne($id_borrar)->delete()?"Eliminado":"Error en el id: $id_borrar";
    }

    /**
     * Finds the TipoValoracion model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id_tipo_valoracion
     * @return TipoValoracion the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id_tipo_valoracion)
    {
        if (($model = TipoValoracion::findOne(['id_tipo_valoracion' => $id_tipo_valoracion])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function selectEstado($notaAprobacion)
    {
        $estado=null;
        if($notaAprobacion>=51){
            $estado="Aprobado";
        }else{
            $estado="Participacion";
        }
        return $estado;
    }
}
