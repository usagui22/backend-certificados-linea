<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "evento".
 *
 * @property int $id_evento
 * @property string $nombre
 * @property int $id_unidad
 * @property string|null $url_convocatoria
 * @property string $fecha_inicio
 * @property string|null $registro_fin
 * @property string|null $inicio_actividades
 * @property string|null $fin_actividades
 * @property string|null $inicio_emision
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
            [['nombre', 'fecha_inicio', 'fecha_fin'], 'required'],
            [['nombre', 'url_convocatoria', 'fecha_inicio', 'registro_fin', 'inicio_actividades', 'fin_actividades', 'inicio_emision', 'fecha_fin'], 'string'],
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
            'nombre' => 'Nombre',
            'id_unidad' => 'Id Unidad',
            'url_convocatoria' => 'Url Convocatoria',
            'fecha_inicio' => 'Fecha Inicio',
            'registro_fin' => 'Registro Fin',
            'inicio_actividades' => 'Inicio Actividades',
            'fin_actividades' => 'Fin Actividades',
            'inicio_emision' => 'Inicio Emision',
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
