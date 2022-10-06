<?php
namespace app\controllers;

use app\models\RolUsuario;
use app\models\Usuario;
use phpDocumentor\Reflection\File;
use PhpOffice\PhpSpreadsheet\IOFactory;
use yii\web\Controller;

class UtilController extends Controller{

    public static function  getArrayExcel($excelb64,$name='docexcel'){
        $basePhp = explode(',',$excelb64);
        $file= base64_decode($basePhp[1]);
        $path = \Yii::$app->basePath."/documents/" . time() . "_" . $name.'.xlsx';
        file_put_contents($path, $file);
        try {

            $type = IOFactory::identify($path);
            $reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReader($type);
//            $reader->setReadDataOnly(true);
            $reader->setReadDataOnly(true);

            $spreadsheet = $reader->load($path);
        } catch(\Exception $e) {
            die('Error loading file "'.pathinfo($file,PATHINFO_BASENAME).'": '.$e->getMessage());
        }

        $sheet = $spreadsheet->getSheet(0);
        $highestRow= $sheet->getHighestRow();
        $highestColumn  = $sheet->getHighestColumn();
        $registros_excel = [];
        for ($row = 1; $row <= $highestRow; $row++){
            //  La letra A de abajo indica desde que columna voy a empezar a leer la hoja.
            $rowData = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row,
                NULL,
                TRUE,
                FALSE);

            $registros_excel[]  =array_slice($rowData[0],0,self::getIndexByChar("H"));
        }
        $labels = [];
        for ($i=0;$i< count($registros_excel[0]);$i++ ) {
            $labels []  = $registros_excel[0][$i];
        }
        $participantes =[];
        for ($i=1;$i< count($registros_excel);$i++ ){
            for($j=0;$j<count($registros_excel[$i]);$j++){
                $p[$labels[$j]] = $registros_excel[$i][$j];
            }
            $participantes [] =$p;
        }

        return ["participantes"=>$participantes,"path"=>$path];
    }

    public static function getAbcedario() {
        $array = array();
        for ($i = 65; $i <= 90; $i++) {
            $array[] = chr($i);
        }
        return $array;
    }
    public static function getIndexByChar($character = NULL) {
        $abc = static::getAbcedario();
        foreach ($abc as $key=>$value) {
            if ($value == $character) {
                return $key;
            }
        }
        $contador = 26;
        foreach ($abc as $value1) {
            foreach ($abc as $value2) {
                if ($value1.$value2 == $character) {
                    return $contador;
                }
                $contador++;
            }
        }
    }
    public static function generatePassword() {
        $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
        return substr(str_shuffle($chars),0,8);
    }

    public static function asignarRol($id_usuario)
    {
        // $data = [
        //     "id_usuario"=>$id_usuario,
        //     "id_rol"=>2
        // ];
        //$model = new RolUsuario($data);
        $model=Usuario::findOne($id_usuario);
        $model->id_rol=2;
        if($model->save()){
            return true;
        }else{
            return false;
        }
    }

    
}