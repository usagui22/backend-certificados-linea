<?php

namespace app\controllers;

use app\models\Unidad;
use app\models\unidadSearch;
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * UnidadController implements the CRUD actions for Unidad model.
 */
class UnidadController extends Controller
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
                        
                        'crear-unidad' => ['POST'],
                        'actualizar-unidad'=>['POST'],
                        'eliminar-unidad'=>['POST','GET']
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
     * Lists all Unidad models.
     *
     * @return string
     */
    public function actionIndex()
    {
        
       return Unidad::find()->all();
        //$unidadSearch = new unidadSearch();
        //$dataProvider = $unidadSearch->search($this->request->queryParams);

        //return $this->render('index', [
          // 'searchModel' => $unidadSearch,
            //'dataProvider' => $dataProvider,
        //]);
    }

    /**
     * Displays a single Unidad model.
     * @param int $id_unidad
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id_unidad)
    {
        return $this->render('view', [
            'model' => $this->findModel($id_unidad),
        ]);
    }

    /**
     * Creates a new Unidad model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCrearUnidad()
    {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $unidad = new Unidad();
        $params =Yii::$app->request->getBodyParams();
        return $params;
        $msj =null;

        if (!isset($unidad)) {

            $msj=["guardado"=>false,"unidad"=>$unidad->getErrors()];
            
        } else {
            
            $unidad->attributes=$params;            

            if ($unidad->validate() && $unidad->save()) {
                $msj=["guardado"=>true,"unidad"=>$unidad];
                //$this->redirect(['view', 'id_unidad' => $unidad->id_unidad]);
            }
        }

        return 
        $msj; 
        //$this->render('create', [
          //  'model' => $unidad,
        //]);
    }

    /**
     * Updates an existing Unidad model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id_unidad
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionActualizarUnidad($id_ac)
    {
        $msj=null;
        $unidad = Unidad::findOne($id_ac);                   
        Yii::$app->response->format= \yii\web\Response::FORMAT_JSON;        
        $nuevosParams=Yii::$app->request->getBodyParams();
        
        if(isset($nuevosParams)){
            $unidad->attributes=$nuevosParams;                          
            
           if($unidad->validate()){
                $unidad->save();
                $msj=["Cambiar"=>true,'unidad'=>$unidad];
            }else{
                $msj=["Cambiar"=>false,'unidad'=>$unidad->getErrors()];
            }
        }
        //if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
          //  return $this->redirect(['view', 'id_unidad' => $model->id_unidad]);
        //}

        return $msj;
        //$this->render('update', [
          //  'model' => $model,
        //]);
    }

    /**
     * Deletes an existing Unidad model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id_unidad
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionEliminarUnidad($id_eli)
    {
        $msj=null;
        //$this->findModel($id_unidad)->delete();
        $unidad=Unidad::findOne($id_eli);
        if(isset($unidad)){
            $unidad->delete();
            $msj=["borrado"=>true,"eliminado exitosamente"];
        }else{
            
            $msj=["borrado"=>false,"no se encuentra la unidad, verifique el id"];
        }
        return $msj;
        //return $this->redirect(['index']);
    }

    /**
     * Finds the Unidad model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id_unidad
     * @return Unidad the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id_unidad)
    {
        if (($model = Unidad::findOne(['id_unidad' => $id_unidad])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('La peticion no existe');
    }
    
}
