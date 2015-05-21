<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\News */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="news-form">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

    <?= $form->field($model, 'header')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'content')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'is_active')->checkbox(['label' => 'Active']) ?>

    <?= Html::activeDropDownList($model, 'c_id', $categories) ?>

    <?php
	if( $model->filename) {
	?>
	<div>
	<?= Html::img($model->filename, array('width'=>100,'height'=>100)); ?>
	<?= Html::a('Remove Image', ['clear-img', 'id' => $model->id]); ?>
	</div>
    <?php
        }
    ?>



    <?= $form->field($model, 'file')->fileInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
