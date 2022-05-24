<?php

namespace app\controllers;

use app\models\Evento;
use app\models\eventoSearch;
use app\models\Unidad;
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * EventoController implements the CRUD actions for Evento model.
 */
class EventoController extends Controller
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
                        'crear-evento' => ['POST','GET'],
                        'actualizar-evento'=>['POST'],
                        'borrar-evento'=>['POST','GET']
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
     * Lists all Evento models.
     *
     * @return string
     */
    public function actionIndex()
    {

        //$searchModel = new eventoSearch();
        //$dataProvider = $searchModel->search($this->request->queryParams);

        return Evento::find()->all();
        //$this->render('index', [
          //  'searchModel' => $searchModel,
            //'dataProvider' => $dataProvider,
        //]);
    }

    /**
     * Displays a single Evento model.
     * @param int $id_evento Id Evento
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id_evento)
    {
        return $this->render('view', [
            'model' => $this->findModel($id_evento),
        ]);
    }

    /**
     * Creates a new Evento model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCrearEvento()
    {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $evento = new Evento();
        $datos=Yii::$app->request->getBodyParams();
        
        
        $msg=null;

        if (isset($datos)) {

            $evento['nombre_evento']=$datos['nombre_evento'];
            $evento->url_validacion=$datos['url_validacion'];
            $evento->id_unidad=$this->getIdxNombre($datos['nombre_unidad']); //id_unidad debe ser automatica dependiendo del usuario logueado
            $evento->fecha_inicio=$datos['fecha_inicio'];
            $evento->fecha_fin=$datos['fecha_fin'];

            if($evento->validate() && $evento->save()){
                $msg=["guardar"=>true,'evento'=>$evento];
            }else{
                $msg=["guardar"=>false,'evento'=>$evento->getErrors()];
            }
            //if ($model->load($this->request->post()) && $model->save()) {
              //  return $this->redirect(['view', 'id_evento' => $model->id_evento]);
            //}
        } //else {
            //$model->loadDefaultValues();
        //}

        return $msg;
        //$this->render('create', [
          //  'model' => $model,
        //]);
    }

    /**
     * Updates an existing Evento model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id_evento Id Evento
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionActualizarEvento($id_cambiar)
    {
        $evento = Evento::findOne($id_cambiar);
        $nuevosDatos=Yii::$app->request->getBodyParams();
        $actualizado=null;
        if (isset($nuevosDatos)) {
            $evento['nombre_evento']=$nuevosDatos['nombre_evento'];
            $evento['url_validacion']=$nuevosDatos['url_validacion'];
            $evento['fecha_inicio']=$nuevosDatos['fecha_inicio'];
            $evento['fecha_fin']=$nuevosDatos['fecha_fin'];
            if($evento->validate() && $evento->save()){
                $actualizado=["cambio"=>true,'evento'=>$evento];
            }else{
                $actualizado=["cambio"=>false,'evento'=>$evento->getErrors()];
            }
            //return $this->redirect(['view', 'id_evento' => $model->id_evento]);
        }

        return $actualizado;
        //$this->render('update', [
          //  'model' => $model,
        //]);
    }

    /**
     * Deletes an existing Evento model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id_evento Id Evento
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionBorrarEvento($id_borrar)
    {
        
        return Evento::findOne($id_borrar)->delete()?"eliminado":"Error";
        //$this->redirect(['index']);
    }

    /**
     * Finds the Evento model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id_evento Id Evento
     * @return Evento the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id_evento)
    {
        if (($model = Evento::findOne(['id_evento' => $id_evento])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
    protected function getIdxNombre($nombre){
        //Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $id_encontrado=null;
        $unidad=Unidad::find()
        ->select("id_unidad")
        ->where(["nombre_unidad" => $nombre])
       // ->where(['nombre_unidad' => "Facultad de Ciencias y Tecnologia"])
        //->one();
        ->one();        
        //print_r($unidad['id_unidad']);        
        $buscar=$unidad?"encontrado":"busqueda fallida";                
        if($buscar="encontrado"){
            $id_encontrado=$unidad['id_unidad'];
        }                     
        
        return $id_encontrado;
    }
}
