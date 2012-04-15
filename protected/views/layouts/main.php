<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="language" content="en" />

	<!-- blueprint CSS framework -->
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/screen.css" media="screen, projection" />
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/print.css" media="print" />
	<!--[if lt IE 8]>
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/ie.css" media="screen, projection" />
	<![endif]-->

	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/main.css" />
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/form.css" />

	<title><?php echo CHtml::encode($this->pageTitle); ?></title>
</head>

<body>

<div class="container" id="page">

	<div id="header">
		<div id="logo"><?php echo CHtml::encode(Yii::app()->name); ?></div>
	</div><!-- header -->

	<div id="mainmenu">
		<?php $this->widget('zii.widgets.CMenu',array(
			'items'=>array(
				array('label'=>Yii::t('lang', 'home')	, 'url'=>array('/site/index')),
				array('label'=>Yii::t('lang','logar')	, 'url'=>array('/site/login'), 'visible'=>Yii::app()->user->isGuest),
				
				array('label'=>Yii::t('lang','appGrupoCategoria'),'url'=>array('/grupo_categorias_tipos/', 'view'=>'index'), 'visible'=>!Yii::app()->user->isGuest),
				array('label'=>Yii::t('lang','appCidades'),'url'=>array('/cidades/', 'view'=>'index'), 'visible'=>!Yii::app()->user->isGuest),
				array('label'=>Yii::t('lang','contato')	,'url'=>array('/site/contact'), 'visible'=>!Yii::app()->user->isGuest),
				array('label'=>Yii::t('lang','sobre')	, 'url'=>array('/site/page', 'view'=>'about')),
				array('label'=>Yii::t('lang','logout').'('.Yii::app()->user->name.')', 'url'=>array('/site/logout'), 'visible'=>!Yii::app()->user->isGuest)
			),
		)); ?>
	</div><!-- mainmenu -->
	<?php if(isset($this->breadcrumbs)):?>
		<?php $this->widget('zii.widgets.CBreadcrumbs', array(
			'links'=>$this->breadcrumbs,
		)); ?><!-- breadcrumbs -->
	<?php endif?>

	<?php echo $content; ?>

	<div class="clear"></div>

 <!--
  PE DA PAGINA 
 -->
	<div id="footer">
		Copyright &copy; <?php echo date('Y'); ?> <?php echo Yii::t('lang','aoGrupo') ?><br/>
		<?php echo Yii::t('lang','todosDireitosReservados') ?><br/>
		<?php echo Yii::powered(); ?>
	</div><!-- footer -->

</div><!-- page -->

</body>
</html>
