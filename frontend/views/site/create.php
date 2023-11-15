<?php use yii\helpers\Html;
use yii\widgets\ActiveForm;

$form = ActiveForm::begin(); ?>

<?= $form->field($model, 'serial_number')->textInput() ?>

<?= $form->field($model, 'store_id')->textInput() ?>
<?= $form->field($model, 'about')->textInput() ?>

<?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>

<?php ActiveForm::end(); ?>