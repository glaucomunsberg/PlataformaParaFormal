<?$this->CI =& get_instance();
if(@$_COOKIE['8qq5tzydi0nyd9p7mo6l3xhjvvadpzek'] == '')
	echo $this->CI->load->view("../../static/_views/headerLoginView");	
else	
	echo $this->CI->load->view("../../static/_views/headerGlobalView");
?>
	<div id="dialog-message-error" class="ui-widget-content ui-state-error ui-corner-all" style="margin: 0px; padding: 10px;">
		<span class="ui-icon ui-icon-alert" style="float: left; margin: 2px 10px 2px 2px;"></span>		
		<?php echo $message; ?>
		<br /><a style="font-size: 14px;" href="javascript:history.go(-1);">Voltar</a>
	</div>
<?=$this->CI->load->view("../../static/_views/footerGlobalView");?>