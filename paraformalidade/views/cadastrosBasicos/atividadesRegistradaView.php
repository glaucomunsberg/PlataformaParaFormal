<?=$this->load->view("../../static/_views/headerGlobalView");?>

	<?=path_bread($path_bread);?>

	<?=begin_ToolBar(array('imprimir', 'abrir', 'pesquisar'));?>
	<?=end_ToolBar();?>

	<?=begin_TabPanel('tabAtividadeRegistrada');?>
		<?=begin_Tab(lang('atividadesRegistradasFiltro'));?>
			<?=begin_form('paraformalidade/cadastrosBasicos/atividadesRegistrada/salvar', 'formAtividadesRegistrada');?>
				<?=form_hidden('txtAtividadeRegistradaId', @$atividades_registradas->id);?>

				<?=form_label('lblDescricao', lang('atividadesRegistradasDescricao'), 80);?>
				<?=form_textField('txtDescricao', @$atividades_registradas->descricao, 400, '');?>
			<?=end_form();?>
		<?=end_Tab();?>
	<?=end_TabPanel();?>

<?=$this->load->view("../../static/_views/footerGlobalView");?>

<script>
	function ajuda(){
    	window.open ('<?=WIKI;?>Atividades Registradas');
        }

	function novo(){
		location.href = BASE_URL+'paraformalidade/cadastrosBasicos/atividadesRegistrada/novo/';
	}

	function listaAtividadesRegistradas(){
		location.href = BASE_URL+'paraformalidade/cadastrosBasicos/atividadesRegistrada/';
	}

	function salvar(){
		formAtividadesRegistrada_submit();
	}
	
	function formAtividadesRegistrada_callback(data){
		if(data.error != undefined){
			messageErrorBox(data.error.message, data.error.field);
		} else {
			if(data.success != undefined) {
				$('#txtAtividadeRegistradaId').val(data.atividades_registradas.id);
                        messageBox(data.success.message, listaAtividadesRegistradas);
			}
	    }
	} 

	function excluir(){
		if($('#txtAtividadeRegistradaId').val() == ''){
			messageErrorBox("<?=lang('nenhumRegistroSelecionado')?>");
		}else{
			messageConfirm('<?=lang('excluirRegistros')?>', excluirAtividadeRegistrada);
		}
	}

	function excluirAtividadeRegistrada(confirmaExclusao){
		if(confirmaExclusao){
			$.post(BASE_URL+'paraformalidade/cadastrosBasicos/atividadesRegistrada/excluir/', {id: $('#txtAtividadeRegistradaId').val()}, 
				function(data){
					if(data.success)
						messageBox("<?=lang('registroExcluido')?>", listaLocais);
					else
						messageErrorBox("<?=lang('registroNaoExcluido')?>");
				});
		}
	}	
	
</script>