<?php
use yii\widgets\ListView;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\LinkPager;

/* @var $this yii\web\View */
$this->title = 'My Yii Application';
?>


<div class="body-content">
    <div class="row">
        <div class="col-lg-3">
	    <h5>Categories</h5>
	    <?= Html::a(Html::encode("All"), ['index']) ?>
	    <?= ListView::widget([
	        'dataProvider' => $categoryData,
		'itemView' => function ($model, $key, $index, $widget) {
		    return Html::a(Html::encode($model->title), ['index', 'cat' => $model->id]);
    		},
		'summary'=>'', 
		]);
	    ?>
	</div>

	<div class="col-lg-6">
    	    <h3>News</h3>
	    <?php foreach ($newsData as $model):?>
	        <div class="row">
		    <?php if( $model->filename) {?>
			<div class="col-xs-3">
			<?= Html::img($model->filename, array('width'=>100,'height'=>100)); ?>
			</div>
		    <?php } ?>

		    <div class="col-xs-4">
			<h3> <?= Html::a(Html::encode($model->header), ['news/view', 'id' => $model->id]) ?> </h3>
			<?= substr(Html::encode($model->content), 0, 200); ?>
			<p>Created: <?= Yii::$app->formatter->asDate( $model->date, "php:Y-m-d") ?> </p>

		    </div>
		</div>
	    <?php endforeach ?>
	    <?= LinkPager::widget(['pagination' => $pagination]) ?>
	</div>

    </div>
</div>
