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
	<!--[if (gt IE 9)|!(IE)]><!--> <body class="ui-widget-content" style="border: none !important;"> <!--<![endif]-->
		<div class="ui-layout-north ui-widget-content">
			<div id="carregando" class="ui-state-active ui-widget ui-state-default ui-corner-all">
				Carregando <img src="<?=IMG;?>/ajax-loader.gif" style="margin-right: 5px; margin-left: 2px;" width="16px" height="11px"/>
			</div>
			<div class="logo"><!-- --></div>
			<h1 style="float: left; background:none !important; border: none !important; font-size: 21px; padding: 0px; margin-top: 15px; margin-bottom: 0px;" class="ui-widget-content">
				<?=lang("sigla")?>
			</h1>
			<div class="ui-widget-content ui-corner-all" style="float:right; padding: 5px 0px 5px 5px; margin: 3px 5px 0px 5px; height: 60px;">
				<!--<div class="ui-state-default ui-corner-all" style="float:left; padding: 4px 3px 2px 3px;">
					<? if(!isset($_COOKIE['avatar'])){?>
					<img src="<?=IMG;?>/default_avatar.jpg" width="48px" height="48px"/>
					<? }else{?>
					<img src="<?=BASE_URL;?>util/download/arquivo/<?=$_COOKIE['avatar'];?>/48x48"/>
					<?}?>
				</div>-->
				<div style="display: block; float:left; margin: 0px;">
					<h2 style="margin: 5px 0px 6px 5px; font-size: 15px;"><?=humanize(getUsuarioSession()->nome_pessoa);?></h2>
					<button id="btnConfiguracoes" onclick="configuracoesUsuario()" style="margin: 0px 0px 0px 5px; display: block; float: left; font-weight: 11px;">Configurações</button>
					<button id="btnSair" onclick="logout()" style="margin: 0px 5px 0px; display: block; float: left;">Sair do sistema</button>
				</div>
			</div>
		</div>
		<span style="clear:both;"><!-- --></span>

		<div class="ui-widget ui-widget-content" style="background: none !important; border-left: none; border-right: none; border-top: none;">
			<div style="margin-left: 5px; float: left;">
			<?
			if (!isset($_COOKIE['showMenu'])) {
				$_COOKIE['showMenu'] = NULL;
			}
			?>
				<button id="btnCloseOpenMenu" style="margin: 3px 5px 3px 0px; height: 24px;"><?=(@$_COOKIE['showMenu'] == 'false' ? 'Exibir menu' : 'Esconder menu');?></button>
			</div>
			<div id="buscar-menu-horizontal" style="padding: 3px 0px 3px 0px; float: left; margin: 0px;">
				<div style="height: 22px; width: 25px; margin: 0px -1px 0px 0px; display: block; float: left; position: relative; padding: 0; text-decoration: none !important; text-align: center; zoom: 1; overflow: visible; border-right: none;" class="ui-widget ui-state-default ui-corner-tl ui-corner-bl ui-button-icon-only"><span class=" ui-icon ui-icon-search"></span></div>
				<input type="text" name="txtBuscaMenu" id="txtBuscaMenu" value="buscar no menu" maxlength="" class="ui-state-default ui-corner-tr ui-corner-br" style="margin-bottom: 0px; width:194px;">			
			</div>
			<div style="clear: both;"><!-- --></div>
		</div>
		<span style="clear:both;"><!-- --></span>

		<div class="ui-layout-west ui-widget ui-widget-content <?=(@$_COOKIE['showMenu'] == 'false' ? 'closed' : '');?>" style="padding-left: 0px; padding-right: 0px; background: none !important; float: left; width: 200px; overflow:hidden !important; <?=(@$_COOKIE['showMenu'] == 'false' ? 'display: none;' : 'display: block;');?>">			
			<ul id="menu" class="ui-widget treeview treeview-gray" style="background: none !important; background-color:none !important; overflow: auto !important; margin-top: 2px;">
				<li>
					<span class="menu">Menu</span>
					<ul style="background: none !important;"> 
						<?=$this->session->userdata('menu');?>
					</ul>
				</li>
			</ul>			
		</div>		
		<div id="content-center" class="ui-layout-center ui-widget-content" style="background: none !important; overflow: hidden !important">
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
