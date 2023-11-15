<?php

use frontend\models\Device;
use frontend\models\SearchDevices;
use frontend\models\Store;
use kartik\select2\Select2;
use yii\data\ActiveDataProvider;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;


echo Html::a('Добавить', ['create'], ['class' => 'btn btn-success']);

//// Провайдер данных для таблицы Device
//$dataProviderDevice = new \yii\data\ActiveDataProvider([
//    'query' => frontend\models\Device::find(),
//]);
//
//// Провайдер данных для таблицы Store
//$dataProviderStore = new \yii\data\ActiveDataProvider([
//    'query' => frontend\models\Store::find(),
//]);

$dataProvider = new ActiveDataProvider([
    'query' => Device::find(),
]);

$searchModel = new SearchDevices();

echo GridView::widget([
    'dataProvider' => $dataProvider,
    'filterModel' => $searchModel,
    'columns' => [
        'serial_number',
        [
            'attribute' => 'store_id',
            'format' => 'raw',
            'value' => function ($model) {
                return Html::a(
                    $model->store_id,
                    '#',
                    [
                        'data-name-store' => $model->store_id,
                        'data-target' => 'modal',
                    ]
                );
            },

            'filter' => Select2::widget([
                'model' => $searchModel,
                'attribute' => 'store_id', //
                'data' => ArrayHelper::map(Store::find()->all(),'id','id'),
                'theme' => Select2::THEME_BOOTSTRAP,
                'hideSearch' => true,
                'options' => [
                    'class' => 'form-control',
                    'placeholder' => 'Select a store ...',
                    'id'=>'storeId'
                ],
                'pluginOptions' => [
                    'allowClear' => true,
                    'selectOnClose' => true,
                ],
            ])
        ],
        'about',
        'created_at',
        ['class' => 'yii\grid\ActionColumn'],
    ],
]);
//$dataProvider = new ActiveDataProvider([
//    'query' => TablesDeviceAndStoreModel::),
//]);
?>


<style>
    /* Стили для затемнения фона */
    .modal {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.5);
    }

    /* Стили для модального окна */
    .modal-content {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        background-color: #fff;
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.3);
        animation: fadeIn 0.5s ease-in-out; /* Анимация открытия*/
    }

    /* Стили для кнопки закрытия */
    .close-button {
        position: absolute;
        top: -18px;
        right: 10px;
        font-size: 40px;
        cursor: pointer;
    }

    /* Анимация */
    @keyframes fadeIn {
        from {
            opacity: 0;
        }
        to {
            opacity: 2;
        }
    }

    .hidden {
        display: none;
    }
</style>


<!--МОдальное окно-->
<div id="modal" class="modal hidden">
    <div class="modal-content">
        <span class="close-button">&times;</span>
        <!-- Здесь будет выводиться содержимое представления store.php -->
        <div class="modal-body"></div>
    </div>
</div>

<?php
$this->registerJs(
    '
    const links = document.querySelectorAll("a[data-target=\'modal\']");
    const modal = document.getElementById("modal");
    const modalBody = modal.querySelector(".modal-body");

    links.forEach(function(link) {
        link.addEventListener("click", function(event) {
            event.preventDefault();

            const store_id = this.getAttribute("data-store-id");

            fetch("index.php?r=site/stores&store_id=" + store_id)
                .then(response => response.text())
                .then(data => {
                    modalBody.innerHTML = data;
                    modal.style.display = "block";
                });
        });
    });

    modal.querySelector(".close-button").addEventListener("click", function() {
        modal.style.display = "none";
    });
'
);
?>



<!--name_store-->
    <?php
    //$this->registerJs(
    //    '
    //    const links = document.querySelectorAll("a[data-target=\'modal\']");
    //    const modal = document.getElementById("modal");
    //    const modalBody = modal.querySelector(".modal-body");
    //
    //    links.forEach(function(link) {
    //        link.addEventListener("click", function(event) {
    //            event.preventDefault();
    //
    //            const name_store = this.getAttribute("data-name-store");
    //
    //            fetch("index.php?r=site/stores&name_store=" + name_store)
    //                .then(response => response.text())
    //                .then(data => {
    //                    modalBody.innerHTML = data;
    //                    modal.style.display = "block";
    //                });
    //        });
    //    });
    //
    //    modal.querySelector(".close-button").addEventListener("click", function() {
    //        modal.style.display = "none";
    //    });
    //'
    //);
    //?>
