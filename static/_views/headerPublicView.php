<?php header('Content-Type: text/html; charset=utf-8') ?>
<? if(!isset($buttonHit)){?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml"
      xmlns:fb="http://www.facebook.com/2008/fbml">
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

<link rel="stylesheet" href="<?=CSS;?>/metro-boostrap/metro-bootstrap.css">
<!--script type="text/javascript" src="<?=JS?>/metro-boostrap/jquery-1.8.2.js"></script>-->
<script type="text/javascript" src="<?=JS?>/metro-boostrap/bootstrap-tooltip.js"></script>
<script type="text/javascript" src="<?=JS?>/metro-boostrap/bootstrap-alert.js"></script>
<script type="text/javascript" src="<?=JS?>/metro-boostrap/bootstrap-button.js"></script>
<script type="text/javascript" src="<?=JS?>/metro-boostrap/bootstrap-carousel.js"></script>
<script type="text/javascript" src="<?=JS?>/metro-boostrap/bootstrap-collapse.js"></script>
<script type="text/javascript" src="<?=JS?>/metro-boostrap/bootstrap-dropdown.js"></script>
<script type="text/javascript" src="<?=JS?>/metro-boostrap/bootstrap-modal.js"></script>
<!--<script type="text/javascript" src="<JS>/metro-boostrap/bootstrap-popover.js"></script> -->
<script type="text/javascript" src="<?=JS?>/metro-boostrap/bootstrap-scrollspy.js"></script>
<script type="text/javascript" src="<?=JS?>/metro-boostrap/bootstrap-tab.js"></script>
<script type="text/javascript" src="<?=JS?>/metro-boostrap/bootstrap-transition.js"></script>
<script type="text/javascript" src="<?=JS?>/metro-boostrap/bootstrap-typeahead.js"></script>
<script type="text/javascript" src="<?=JS?>/metro-boostrap/jquery.validate.js"></script>
<script type="text/javascript" src="<?=JS?>/metro-boostrap/jquery.validate.unobtrusive.js"></script>
<script type="text/javascript" src="<?=JS?>/metro-boostrap/jquery.unobtrusive-ajax.js"></script>
<div id="fb-root"></div>
<script>
  window.fbAsyncInit = function() {
    // init the FB JS SDK
    FB.init({
      appId      : '<?=$this->config->item('app_fb_id')?>',                        // App ID from the app dashboard
      channelUrl : '//<?=$this->config->item('base_url')?>/channel.html', // Channel file for x-domain comms
      status     : true,                                 // Check Facebook Login status
      xfbml      : true                                  // Look for social plugins on the page
    });

    // Additional initialization code such as adding Event Listeners goes here
  };

  // Load the SDK asynchronously
  (function(){
     // If we've already installed the SDK, we're done
     if (document.getElementById('facebook-jssdk')) {return;}

     // Get the first script element, which we'll use to find the parent node
     var firstScriptElement = document.getElementsByTagName('script')[0];

     // Create a new script element and set its id
     var facebookJS = document.createElement('script'); 
     facebookJS.id = 'facebook-jssdk';

     // Set the new script's source to the source of the Facebook JS SDK
     facebookJS.src = '//connect.facebook.net/en_US/all.js';

     // Insert the Facebook JS SDK into the DOM
     firstScriptElement.parentNode.insertBefore(facebookJS, firstScriptElement);
   }());
</script>
<div id="fb-root"></div>
