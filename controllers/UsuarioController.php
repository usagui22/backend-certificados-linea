<?php

namespace app\controllers;

use app\models\Documento;
use app\models\Usuario;
use app\models\usuarioSearch;
use phpDocumentor\Reflection\PseudoTypes\True_;
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * UsuarioController implements the CRUD actions for Usuario model.
 */
class UsuarioController extends Controller
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
                        'crear-usuario'=>['POST'],
                        'actualizar-usuario'=>['POST'],
                        'eliminar-usuario' => ['POST','GET'],
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
     * Lists all Usuario models.
     *
     * @return string
     */
    public function actionIndex()
    {

        //$searchModel = new usuarioSearch();
        //$dataProvider = $searchModel->search($this->request->queryParams);

        return Usuario::find()->all();
        //$this->render('index', [
          //  'searchModel' => $searchModel,
            //'dataProvider' => $dataProvider,
        //]);
    }

    /**
     * Displays a single Usuario model.
     * @param int $id_usuario Id Usuario
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id_usuario)
    {
        return $this->render('view', [
            'model' => $this->findModel($id_usuario),
        ]);
    }

    /**
     * Creates a new Usuario model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCrearUsuario()
    {
        $usuario = new Usuario();
        $params=Yii::$app->request->getBodyParams();
        $msj=null;
        if (isset($params)) {
            $usuario=$this->ingresoMasivo($params);
            if ($usuario->save()) {
                $msj=["guardado"=>true,'usuario'=>$usuario];
                //return $this->redirect(['view', 'id_usuario' => $usuario->id_usuario]);
            }else {
                $msj=["guardado"=>false,'usuario'=>$usuario->getErrors()];
            }
        } 

        return $msj;
        //$this->render('create', [
          //  'model' => $usuario,
        //]);
    }

    /**
     * Updates an existing Usuario model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id_usuario Id Usuario
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionActualizarUsuario($id_usu_act)
    {
        $usuario = Usuario::findOne($id_usu_act);
        $params=Yii::$app->request->getBodyParams();
        $actual=null;
        if(isset($params)){
            $usuario->attributes=$params;
            if($usuario->save()){
                $actual=["cambio"=>true,'usuario'=>$usuario];
            }else{
                $actual=["cambio"=>false,'usuario'=>$usuario->getErrors()];
            }
        }
       // if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
         //   return $this->redirect(['view', 'id_usuario' => $model->id_usuario]);
        //}

        return $actual;
        //$this->render('update', [
          //  'model' => $model,
        //]);
    }

    /**
     * Deletes an existing Usuario model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id_usuario Id Usuario
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionElimiarUsuario($id_usu_eli)
    {
        $this->findModel($id_usu_eli)->delete();

        return $this->redirect(['index']);
        //Usuario::findOne($id_usu_eli)->delete();
        
    }

    /**
     * Finds the Usuario model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id_usuario Id Usuario
     * @return Usuario the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id_usuario)
    {
        if (($model = Usuario::findOne(['id_usuario' => $id_usuario])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('La peticion no existe');
    }
    
    protected function ingresoMasivo($datos){
        $model=new Usuario;
        $model->attributes=$datos;
        return $model;
    }
    
    public function actionAccederDocumento($nuevoEstado){
        $documento=Documento::findOne(Yii::$app->require->id_user);
        $estado=null;
            if(isset($nuevoEstado)){
                $estado=true;
                $documento->confirmado=$estado;
                //renderizarVista de Documento con su atributo confimado=true
                //con hash
                
            }else{
                $estado=false;
                $documento->confirmado=$estado;
                //renderizar VIsta Documento con atributo confirmado=false
                //sin hash
            }
        return $estado;
    }
    public function actionVerPerfil(){
        
    }
}
