<? if(!isset($buttonHit)){?>
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
			if(!isset($path_bread)){
				$path_bread = '';
			}
		?>
		<title><?=lang('titulo');?><?=(@$path_bread != '' ? ' - ' : '').@$path_bread;?>&nbsp;</title>
		<?=$this->load->view('../../static/_views/headerScripts');?>
	</head>
	<?php flush();?>
	<!--[if lt IE 7 ]> <body class="ui-widget-content ie ie6" style="border: none !important;"> <![endif]-->
	<!--[if (gt IE 9)|!(IE)]><!--> <body class="ui-widget-content" style="border: none !important; margin: 0px;overflow-y: hidden !important;"> <!--<![endif]-->
		<div class="ui-layout-north ui-widget-content" style="background: url('<?=IMG;?>/head_paraformalidades.jpg')">
			<div id="carregando" class="ui-state-active ui-widget ui-state-default ui-corner-all">
				Carregando <img src="<?=IMG;?>/ajax-loader.gif" style="margin-right: 5px; margin-left: 2px;" width="16px" height="11px"/>
			</div>
			<div class="">
                            <a href="#" OnClick="window.open('<?=BASE_URL;?>public/escolha/','_self');" > <img src="<?=IMG;?>/cidade_mais_contemporaneidade_to_head.png" style="margin-right: 5px; margin-left: 40px; margin-top:19px; z-index:9999;position: absolute" z-index="auto" width="366px" height="82px"/></a>
                        </div>
			<h1 style="float: left; background:none !important; border: none !important; font-size: 21px; padding: 0px; margin-top: 15px; margin-bottom: 0px;" class="ui-widget-content">
                            <!--img src="<?=IMG;?>/logo_plataforma_paraformal.png"/!-->
			</h1>
		</div>
		<span style="clear:both;"><!-- --></span>


<?	}else{ ?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" style="overflow-y:auto; overflow-x:hidden;">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<?=$this->load->view('../../static/_views/headerScripts');?>
	</head>
	<body class="ui-widget-content" style="border:none !important; margin:0px !important;">		
		<div id="content-center" class="ui-layout-center ui-widget-content content-center-popup" style="border-left: none !important; margin-left: 0px; background: none !important; overflow: hidden !important">
<?	} ?>
<link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'>
<link rel="stylesheet" href="<?=CSS;?>/public.css">