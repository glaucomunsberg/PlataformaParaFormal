<?php header("Content-Type: text/html; charset=UTF-8",true);?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<?
			if(PRODUCAO){
				if($_SERVER["HTTPS"] != "on") {
					header("HTTP/1.1 301 Moved Permanently");
					header("Location: https://". $_SERVER["SERVER_NAME"] . $_SERVER["REQUEST_URI"]);
					exit();
				}
			}
		?>
		<title><?=lang('titulo');?></title>
		<?=$this->load->view('../../static/_views/headerScripts');?>		
	</head>
	<?php flush();?>
	<!--[if lt IE 7 ]> <body class="ui-widget-content ie ie6" style="border: none !important; margin: 0px;"> <![endif]-->
	<!--[if (gt IE 9)|!(IE)]><!--> <body class="ui-widget-content" style="border: none !important; margin: 0px;"> <!--<![endif]-->
		<div class="ui-layout-north ui-widget-content">
			<div id="carregando" class="ui-state-active ui-widget ui-state-default ui-corner-all">
				Carregando <img src="<?=IMG;?>/ajax-loader.gif" style="margin-right: 5px; margin-left: 2px;" width="16px" height="11px"/>
			</div>
			<div class="logo"><!-- --></div>
			<h1 style="float: left; background:none !important; border: none !important; font-size: 21px; padding: 0px; margin-top: 15px; margin-bottom: 0px;" class="ui-widget-content">
				<?=lang("sigla")?>
			</h1>
		</div>
		<span style="clear:both;"><!-- --></span>
		<div class="ui-layout-center ui-widget-content" style="background: none !important; overflow: hidden !important; border: none !important">
