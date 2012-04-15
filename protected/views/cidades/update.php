<?php
$this->breadcrumbs=array(
	'Cidades'=>array('index'),
	$model->id=>array('view','id'=>$model->descricao),
	'Update',
);

$this->menu=array(
	array('label'=>Yii::t('lang', 'cidadeListar'), 'url'=>array('index')),
	array('label'=>Yii::t('lang', 'cidadeCriar'), 'url'=>array('create')),
	array('label'=>Yii::t('lang', 'cidadeDetalhar'), 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>Yii::t('lang', 'cidadeGerenciar'), 'url'=>array('admin')),
);
?>

<h1><?php echo Yii::t('lang', 'cidadeDetalhes') . $model->descricao; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>