<?php

namespace app\models\search;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Evento;

/**
 * eventoSearch represents the model behind the search form of `app\models\Evento`.
 */
class eventoSearch extends Evento
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_evento', 'id_unidad'], 'integer'],
            [['nombre_evento', 'url_validacion', 'fecha_inicio', 'fecha_fin'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Evento::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id_evento' => $this->id_evento,
            'id_unidad' => $this->id_unidad,
            'fecha_inicio' => $this->fecha_inicio,
            'fecha_fin' => $this->fecha_fin,
        ]);

        $query->andFilterWhere(['ilike', 'nombre_evento', $this->nombre_evento])
            ->andFilterWhere(['ilike', 'url_validacion', $this->url_validacion]);

        return $dataProvider;
    }
}
