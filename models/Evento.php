<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "evento".
 *
 * @property int $id_evento
 * @property string $nombre_evento
 * @property string $url_validacion
 * @property int $id_unidad
 * @property string $fecha_inicio
 * @property string $fecha_fin
 *
 * @property Documento[] $documentos
 * @property Integrante[] $integrantes
 * @property Unidad $unidad
 */
class Evento extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'evento';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nombre_evento', 'url_validacion', 'id_unidad', 'fecha_inicio', 'fecha_fin'], 'required'],
            [['nombre_evento', 'url_validacion'], 'string'],
            [['id_unidad'], 'default', 'value' => null],
            [['id_unidad'], 'integer'],
            [['fecha_inicio', 'fecha_fin'], 'safe'],
            [['id_unidad'], 'exist', 'skipOnError' => true, 'targetClass' => Unidad::className(), 'targetAttribute' => ['id_unidad' => 'id_unidad']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_evento' => 'Id Evento',
            'nombre_evento' => 'Nombre Evento',
            'url_validacion' => 'Url Validacion',
            'id_unidad' => 'Id Unidad',
            'fecha_inicio' => 'Fecha Inicio',
            'fecha_fin' => 'Fecha Fin',
        ];
    }

    /**
     * Gets query for [[Documentos]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getDocumentos()
    {
        return $this->hasMany(Documento::className(), ['id_evento' => 'id_evento']);
    }

    /**
     * Gets query for [[Integrantes]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getIntegrantes()
    {
        return $this->hasMany(Integrante::className(), ['id_evento' => 'id_evento']);
    }

    /**
     * Gets query for [[Unidad]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUnidad()
    {
        return $this->hasOne(Unidad::className(), ['id_unidad' => 'id_unidad']);
    }
}
