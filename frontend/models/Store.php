<?php

namespace frontend\models;

use yii\db\ActiveRecord;

class Store extends ActiveRecord{


    public static function tableName()
    {
        return 'store';
    }
//    public function rules()
//    {
//        return [
//            [['serial_number', 'store_id','id'], 'required'],
//
//        ];
//    }

    public function getDevices(){

        return $this->hasMany(Device::className(),['store_id' => 'id']);
    }


}