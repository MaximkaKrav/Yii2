<?php


use frontend\models\TablesDeviceAndStoreModel;
use yii\data\ActiveDataProvider;
use yii\grid\GridView;


echo GridView::widget([
    'dataProvider' => $dataProvider,
    'columns' => [
        ['class' => 'yii\grid\SerialColumn'],
        'id',
        'created_at',
        'about',
        ['class' => 'yii\grid\ActionColumn'],
    ],
]);
?>