<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tipo_valoracion".
 *
 * @property int $id_tipo_valoracion
 * @property string $nota_valoracion
 * @property string $estado_valoracion
 *
 * @property Integrante[] $integrantes
 */
class TipoValoracion extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tipo_valoracion';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nota_valoracion'], 'required','message'=>'El campo solo permite numeros'],
            [['nota_valoracion'], 'match','pattern'=>'/^[0-99]/'],            
            [['estado_valoracion'], 'string','length'=>[7,15]],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_tipo_valoracion' => 'Id Tipo Valoracion',
            'nota_valoracion' => 'Nota Valoracion',
            'estado_valoracion' => 'Estado Valoracion',
        ];
    }

    /**
     * Gets query for [[Integrantes]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getIntegrantes()
    {
        return $this->hasMany(Integrante::className(), ['id_tipo_valoracion' => 'id_tipo_valoracion']);
    }
}
