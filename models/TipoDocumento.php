<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tipo_documento".
 *
 * @property int $id_tipo_documento
 * @property string $nombre_documento
 * @property string|null $descripcion_tipo_documento
 * @property string|null $plantilla_tipo_documento
 *
 * @property Documento[] $documentos
 */
class TipoDocumento extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tipo_documento';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nombre_documento'], 'required','message'=>'El campo solo contiene caracteres alfabeticos'],
            [['nombre_documento'],'match','pattern'=>'/^[A-Za-z]','max'=>20],
            [['nombre_documento', 'descripcion_tipo_documento'], 'string'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_tipo_documento' => 'Id Tipo Documento',
            'nombre_documento' => 'Nombre Documento',
            'descripcion_tipo_documento' => 'Descripcion Tipo Documento',
            'plantilla_tipo_documento' => 'Plantilla Tipo Documento',
        ];
    }

    /**
     * Gets query for [[Documentos]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getDocumentos()
    {
        return $this->hasMany(Documento::class, ['id_tipo_documento' => 'id_tipo_documento']);
    }
}
