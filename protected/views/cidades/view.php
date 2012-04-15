<?php
$this->breadcrumbs=array(
	'Cidades'=>array('index'),
	$model->descricao,
);

$this->menu=array(
	array('label'=>Yii::t('lang', 'cidadeListar')	, 'url'=>array('index')),
	array('label'=>Yii::t('lang', 'cidadeCriar')	, 'url'=>array('create')),
	array('label'=>Yii::t('lang', 'cidadeAtualizar'), 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>Yii::t('lang', 'cidadeDeletar')	, 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>Yii::t('lang', 'gerenciar')		, 'url'=>array('admin')),
);
?>

<h1><?php echo Yii::t('lang', 'cidadeDetalhes') . $model->descricao; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'descricao',
		'longitude',
		'latitude',
	),
)); ?>
