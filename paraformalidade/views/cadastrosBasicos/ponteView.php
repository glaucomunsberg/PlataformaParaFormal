<?=$this->load->view("../../static/_views/headerGlobalView");?>

	<?=path_bread($path_bread);?>

	<?=begin_ToolBar(array('imprimir', 'abrir', 'pesquisar'));?>
	<?=end_ToolBar();?>

	<?=begin_TabPanel('tabPonte');?>
		<?=begin_Tab(lang('ponteFiltro'));?>
			<?=begin_form('paraformalidade/cadastrosBasicos/ponte/salvar', 'formPonte');?>
				<?=form_hidden('txtPonteId', @$tipos_pontes->id);?>

				<?=form_label('lblDescricao', lang('ponteDescricao'), 80);?>
				<?=form_textField('txtDescricao', @$tipos_pontes->descricao, 400, '');?>

			<?=end_form();?>
		<?=end_Tab();?>
	<?=end_TabPanel();?>

<?=$this->load->view("../../static/_views/footerGlobalView");?>

<script>
	function ajuda(){
    	window.open ('<?=WIKI;?>Pontes');
        }

	function novo(){
		location.href = BASE_URL+'paraformalidade/cadastrosBasicos/ponte/novo/';
	}

	function listaPontes(){
		location.href = BASE_URL+'paraformalidade/cadastrosBasicos/ponte/';
	}

	function salvar(){
		formPonte_submit();
	}
	
	function formPonte_callback(data){
		if(data.error != undefined){
			messageErrorBox(data.error.message, data.error.field);
		} else {
			if(data.success != undefined) {
				$('#txtPonteId').val(data.tipos_pontes.id);
                        messageBox(data.success.message, listaPontes);
			}
	    }
	} 

	function excluir(){
		if($('#txtPonteId').val() == ''){
			messageErrorBox("<?=lang('nenhumRegistroSelecionado')?>");
		}else{
			messageConfirm('<?=lang('excluirRegistros')?>', excluirPonte);
		}
	}

	function excluirPonte(confirmaExclusao){
		if(confirmaExclusao){
			$.post(BASE_URL+'paraformalidade/cadastrosBasicos/ponte/excluir/', {id: $('#txtPonteId').val()}, 
				function(data){
					if(data.success)
						messageBox("<?=lang('registroExcluido')?>", listaPontes);
					else
						messageErrorBox("<?=lang('registroNaoExcluido')?>");
				});
		}
	}	
	
</script>