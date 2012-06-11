<?=begin_TabPanel('tabUpload');?>
	<?=begin_Tab(lang('uploadTab1'));?>
		<?=begin_form('util/upload/enviarArquivo', 'formUploadFile', array('enctype' => 'multipart/form-data',));?>
			<?=form_hidden('paramUploadAllowedTypes', $allowed_types);?>
			<input type="hidden" name="APC_UPLOAD_PROGRESS" id="progress_key" value="<?php echo uniqid();?>"/>
			<input type="file" name="userfile" id="userfile" size="32" style="display: block; float: left; margin-bottom: 5px; margin-right: 5px;"/>
		<?=end_form();?>
		<?=new_line();?>		
		<?=form_hidden('paramUploadId', $objectId);?>
		<?=form_hidden('paramUploadName', $objectName);?>
		<div id="progressbar" style="display: none; margin-bottom: 5px; margin-right: 5px; width: 480px; float: left;"></div>
		<?=form_label('lblProgressText', '0 %', 40, array('style' => 'display: none;'));?>
	<?=end_Tab();?>
<?=end_TabPanel();?>

<?=begin_ToolBar(array('imprimir', 'abrir', 'ajuda', 'pesquisar', 'voltar-pagina', 'novo', 'excluir', 'salvar'));?>
	<?=addButtonToolBar(lang('uploadLimpar'), 'limparArquivo()', 'btnLimparArquivo', 'ui-icon-document');?>
	<?=addButtonToolBar(lang('uploadIniciar'), 'iniciarUpload()', 'btnIniciarUpload', 'ui-icon-transferthick-e-w');?>
<?=end_ToolBar();?>

<script>

	var completeUpload = false;
	var errorUpload = false;

	function limparArquivo(){
		$('#userfile').val('');
		$("#progressbar").fadeOut();
		$("#lblProgressText").fadeOut();
	}

	function iniciarUpload(){
		formUploadFile_submit();
		startProgress();
	}

	function formUploadFile_callback(data){
		$("#btnLimparArquivo").button('enable');
		$("#btnIniciarUpload").button('enable');
		if(!data.success){
			errorUpload = true;
			completeUpload = false;
			messageErrorBox(data.error.message, erroUpload);
		}else{
			errorUpload = false;
			completeUpload = true;
			$("#progressbar").progressbar( "option", "value", 100);
			$("#lblProgressText").text(100 + ' %');
			if($("#paramUploadId").val() != ''){
				var paramUploadId 	= $("#paramUploadId").val();
				var paramUploadName = $("#paramUploadName").val();
				$("#"+paramUploadId).val(data.uploads[0].id);
				$("#"+paramUploadName).val(data.uploads[0].nome_original);
				try{uploadCallBack(<?=(@$methodReturn == '' ? 'none' : @$methodReturn);?>);}catch(err){}
			}
		}
	}

	function erroUpload(){
		$("#progressbar").progressbar({value: 0});
		$("#lblProgressText").text('0 %');
		var currentDate = new Date();
		$('#progress_key').val(currentDate.getTime());		
	}

	function startProgress(){
		$("#btnLimparArquivo").button('disable');
		$("#btnIniciarUpload").button('disable');
		errorUpload = false;
		completeUpload = false;
		$("#progressbar").fadeIn();
		$("#lblProgressText").fadeIn();
		$("#progressbar").progressbar({value: 0});
		$("#lblProgressText").text('0 %');
		getProgress();
	}

	function getProgress(){
		if(!errorUpload){
			if(!completeUpload){
				$.get(BASE_URL+'util/upload/progress/'+$('#progress_key').val(), '',
					function(data){						
						if(data.statusUpload.current != undefined){
							var status = data.statusUpload.current / data.statusUpload.total * 100;
							$("#progressbar").progressbar( "option", "value", status);
							$("#lblProgressText").text(parseInt(status) + ' %');
						}						
					});
				setTimeout("getProgress()", 1000);
			}
		}
	}

</script>