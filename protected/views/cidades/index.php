<?php
$this->breadcrumbs=array(
	Yii::t('lang', 'cidades'),
);

$this->menu=array(
	array('label'=> Yii::t('lang', 'cidadeCriar'), 'url'=>array('create')),
	array('label'=>Yii::t('lang', 'cidadeGerenciar'), 'url'=>array('admin')),
);
?>

<h1>Cidades</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
