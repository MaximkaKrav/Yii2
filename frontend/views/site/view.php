
<h2>Подробно о вот этом</h2>
<?php

use frontend\models\TablesDeviceAndStoreModel;
use yii\data\ActiveDataProvider;
use yii\widgets\DetailView;

echo DetailView::widget([
    'model' => $model,
    'attributes' => [
        'id',
        'serial_number',
        'store_id',
        'about',
        'created_at',
        'updated_at',

    ],
]);


?>