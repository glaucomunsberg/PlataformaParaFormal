<div id="screen" style="width:520px; height:370px; margin: 10px;"></div>

<?=new_line();?>

<?=form_hidden('paramUploadId', $objectId);?>
<?=form_hidden('paramUploadName', $objectName);?>

<?=begin_ToolBar(array('imprimir', 'abrir', 'ajuda', 'pesquisar', 'voltar-pagina', 'novo', 'excluir', 'salvar'));?>	
	<?=addButtonToolBar('Capturar Imagem', 'capturarImagem()', 'btnCapturarImagem', 'ui-icon-image');?>
	<?=addButtonToolBar('Enviar Imagem', 'iniciarUpload()', 'btnIniciarUpload', 'ui-icon-transferthick-e-w');?>
	<?=addButtonToolBar('Cancelar', 'cancelarUpload()', 'btnCancelarUpload', 'ui-icon-cancel');?>	
<?=end_ToolBar();?>

<script type="text/javascript">

	function initPopUp(){
		disableSendImage();		
		var screen = $('#screen');		

		webcam.set_swf_url(BASE_URL+'static/_webcam/webcam.swf');
		webcam.set_api_url(BASE_URL+'util/upload/enviarImagemWebCam');
		webcam.set_quality(100);
		webcam.set_shutter_sound(false, BASE_URL+'static/_webcam/shutter.mp3');

		screen.html(webcam.get_html(screen.width(), screen.height()));

		webcam.set_hook('onComplete', function(data){
			data = $.parseJSON(data);
			if(data.success){
				var paramUploadId 	= $("#paramUploadId").val();
				var paramUploadName = $("#paramUploadName").val();
				$("#"+paramUploadId).val(data.upload.id);
				$("#"+paramUploadName).val(data.upload.nome_original);
				disableSendImage();
				try{uploadCallBack(<?=(@$methodReturn == '' ? 'none' : @$methodReturn);?>);}catch(err){}
			}else{
				messageErrorBox(data.error.message, disableSendImage);
			}
		});
	}

	function capturarImagem(){
		webcam.freeze();
		enableSendImage();
		return false;
	}

	function iniciarUpload(){
		webcam.upload();
		webcam.reset();		
		return false;
	}
	
	function cancelarUpload(){
		webcam.reset();
		disableSendImage();
	}	

	function disableSendImage(){
		$('#btnIniciarUpload').button('disable');
		$('#btnCancelarUpload').button('disable');
		$('#btnCapturarImagem').button('enable');
		$('#btnCapturarImagem').focus();		
	}

	function enableSendImage(){
		$('#btnCancelarUpload').button('enable');
		$('#btnIniciarUpload').button('enable');
		$('#btnIniciarUpload').focus();
		$('#btnCapturarImagem').button('disable');		
	}

</script>