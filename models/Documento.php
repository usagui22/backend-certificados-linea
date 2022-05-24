<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "documento".
 *
 * @property int $id_documento
 * @property string $nombre
 * @property string $hash
 * @property string|null $fecha_confirmacion
 * @property int $id_evento
 * @property int $id_plantilla
 * @property int|null $nota_valoracion
 * @property string|null $path
 *
 * @property Evento $evento
 * @property Plantilla $plantilla
 */
class Documento extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'documento';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nombre', 'hash', 'id_evento', 'id_plantilla'], 'required'],
            [['nombre', 'hash', 'path'], 'string'],
            [['fecha_confirmacion'], 'safe'],
            [['id_evento', 'id_plantilla', 'nota_valoracion'], 'default', 'value' => null],
            [['id_evento', 'id_plantilla', 'nota_valoracion'], 'integer'],
            [['id_evento'], 'exist', 'skipOnError' => true, 'targetClass' => Evento::className(), 'targetAttribute' => ['id_evento' => 'id_evento']],
            [['id_plantilla'], 'exist', 'skipOnError' => true, 'targetClass' => Plantilla::className(), 'targetAttribute' => ['id_plantilla' => 'id_plantilla']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_documento' => 'Id Documento',
            'nombre' => 'Nombre',
            'hash' => 'Hash',
            'fecha_confirmacion' => 'Fecha Confirmacion',
            'id_evento' => 'Id Evento',
            'id_plantilla' => 'Id Plantilla',
            'nota_valoracion' => 'Nota Valoracion',
            'path' => 'Path',
        ];
    }

    /**
     * Gets query for [[Evento]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getEvento()
    {
        return $this->hasOne(Evento::className(), ['id_evento' => 'id_evento']);
    }

    /**
     * Gets query for [[Plantilla]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPlantilla()
    {
        return $this->hasOne(Plantilla::className(), ['id_plantilla' => 'id_plantilla']);
    }
}
