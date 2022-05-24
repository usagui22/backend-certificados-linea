<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "documento".
 *
 * @property int $id_documento
 * @property string $nombre_documento
 * @property string|null $confirmado
 * @property string|null $hash
 * @property int $id_evento
 * @property int $id_tipo_documento
 *
 * @property Evento $evento
 * @property TipoDocumento $tipoDocumento
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
            [['tipo_documento', 'id_evento', 'id_tipo_documento'], 'required'],
            [['tipo_documento', 'hash'], 'string'],
            [['confirmado'], 'safe'],
            [['id_evento', 'id_tipo_documento'], 'default', 'value' => null],
            [['id_evento', 'id_tipo_documento'], 'integer'],
            [['id_evento'], 'exist', 'skipOnError' => true, 'targetClass' => Evento::class, 'targetAttribute' => ['id_evento' => 'id_evento']],
            [['id_tipo_documento'], 'exist', 'skipOnError' => true, 'targetClass' => TipoDocumento::class, 'targetAttribute' => ['id_tipo_documento' => 'id_tipo_documento']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_documento' => 'Id Documento',
            'nombre_documento' => 'Nombre Documento',
            'confirmado' => 'Confirmado',
            'hash' => 'Hash',
            'id_evento' => 'Id Evento',
            'id_tipo_documento' => 'Id Tipo Documento',
        ];
    }

    /**
     * Gets query for [[Evento]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getEvento()
    {
        return $this->hasOne(Evento::class, ['id_evento' => 'id_evento']);
    }

    /**
     * Gets query for [[TipoDocumento]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTipoDocumento()
    {
        return $this->hasOne(TipoDocumento::class, ['id_tipo_documento' => 'id_tipo_documento']);
    }
}
