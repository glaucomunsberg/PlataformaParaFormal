<?php
$this->breadcrumbs=array(
	'Cidades'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>Yii::t('lang', 'cidadeListar'), 'url'=>array('index')),
	array('label'=>Yii::t('lang', 'cidadeGerenciar'), 'url'=>array('admin')),
);
?>

<h1><?php echo Yii::t('lang', 'cidadeCriar')?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>