<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "integrante".
 *
 * @property int $id_integrante
 * @property int $id_usuario
 * @property int $id_evento
 * @property string $tipo_integrante
 *
 * @property Evento $evento
 * @property Usuario $usuario
 */
class Integrante extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'integrante';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['tipo_integrante'], 'required'],
            [['tipo_integrante'], 'string'],
            [['id_evento'], 'exist', 'skipOnError' => true, 'targetClass' => Evento::className(), 'targetAttribute' => ['id_evento' => 'id_evento']],
            [['id_usuario'], 'exist', 'skipOnError' => true, 'targetClass' => Usuario::className(), 'targetAttribute' => ['id_usuario' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_integrante' => 'Id Integrante',
            'id_usuario' => 'Id Usuario',
            'id_evento' => 'Id Evento',
            'tipo_integrante' => 'Tipo Integrante',
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
     * Gets query for [[Usuario]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUsuario()
    {
        return $this->hasOne(Usuario::className(), ['id' => 'id_usuario']);
    }
}
