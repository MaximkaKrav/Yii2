<?php

namespace frontend\models;
use frontend\models\Device;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\helpers\Console;

class SearchDevices extends Model
{
    public $store_id;

    public function search($params): ActiveDataProvider
    {

        $query = Device::find();


        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);


        $this->load($params);


        if ($this->store_id !== null) {
            $query->andWhere(['name_store' =>name_store]);
        }


        return $dataProvider;
    }
}
