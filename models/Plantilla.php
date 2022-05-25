<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "plantilla".
 *
 * @property int $id_plantilla
 * @property string $nombre
 * @property string|null $descripcion
 * @property string|null $plantilla
 *
 * @property Documento[] $documentos
 */
class Plantilla extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'plantilla';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nombre'], 'required'],
            [['nombre', 'descripcion', 'plantilla'], 'string'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_plantilla' => 'Id Plantilla',
            'nombre' => 'Nombre',
            'descripcion' => 'Descripcion',
            'plantilla' => 'Plantilla',
        ];
    }

    /**
     * Gets query for [[Documentos]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getDocumentos()
    {
        return $this->hasMany(Documento::className(), ['id_plantilla' => 'id_plantilla']);
    }
}