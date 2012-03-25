<?php
/**
 * responsável por administrar o programa, nesse caso cidade
 */
$this->breadcrumbs=array(
	'Cidades'=>array('index'),
	Yii::t('lang', 'cidadeGerenciar'),
);

$this->menu=array(
	array('label'=>Yii::t('lang', 'cidadeListar'), 'url'=>array('index')),
	array('label'=>Yii::t('lang', 'cidadeCriar'), 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('cidades-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1><?php echo Yii::t('lang', 'cidadeGerenciar')?></h1>

<p>
<?php echo Yii::t('mensagem', 'mensagemComparacaoDeValores')?>
</p>


<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'cidades-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'descricao',
		'longitude',
		'latitude',
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
