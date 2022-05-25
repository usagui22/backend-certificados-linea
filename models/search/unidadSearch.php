<?php

namespace app\models\search;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Unidad;

/**
 * unidadSearch represents the model behind the search form of `app\models\Unidad`.
 */
class unidadSearch extends Unidad
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_unidad'], 'integer'],
            [['nombre_unidad', 'abreviatura_unidad', 'telefono_unidad', 'pagina_referencia_unidad', 'correo_contacto_unidad', 'telefono_alternativo_unidad', 'ubicacion_unidad'], 'safe'],
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
        $query = Unidad::find();

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
            'id_unidad' => $this->id_unidad,
        ]);

        $query->andFilterWhere(['ilike', 'nombre_unidad', $this->nombre_unidad])
            ->andFilterWhere(['ilike', 'abreviatura_unidad', $this->abreviatura_unidad])
            ->andFilterWhere(['ilike', 'telefono_unidad', $this->telefono_unidad])
            ->andFilterWhere(['ilike', 'pagina_referencia_unidad', $this->pagina_referencia_unidad])
            ->andFilterWhere(['ilike', 'correo_contacto_unidad', $this->correo_contacto_unidad])
            ->andFilterWhere(['ilike', 'telefono_alternativo_unidad', $this->telefono_alternativo_unidad])
            ->andFilterWhere(['ilike', 'ubicacion_unidad', $this->ubicacion_unidad]);

        return $dataProvider;
    }
}
