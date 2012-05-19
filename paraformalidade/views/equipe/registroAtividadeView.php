<?=$this->load->view("../../static/_views/headerGlobalView");?>

	<?=path_bread($path_bread);?>

	<?=begin_ToolBar(array( 'abrir', 'pesquisar','excluir','imprimir'));?>
	<?=end_ToolBar();?>

	<?=begin_TabPanel('tabAtividades');?>
		<?=begin_Tab(lang('registroAtividadeFiltro'));?>
			<?=begin_form('paraformalidade/equipe/registroAtividade/salvar', 'formAtividade');?>
				<?=form_hidden('txtPessoaId', $pessoaId);?>

				<?=form_label('lblEntradaSaida', lang('registroAtividadeEntradaSaída'), 100);?>
			 	<?=form_combo('cmbEntradaSaida', $entrada_saida, null, 130);?>
				<?=new_line();?>
				<?=form_label('lblAtividade', lang('registroAtividadeAtividade'), 100);?>
				<?=form_textArea('txtAtividade', null, 400, 8, 500);?>
				

			<?=end_form();?>
		<?=end_Tab();?>
	<?=end_TabPanel();?>

<?=$this->load->view("../../static/_views/footerGlobalView");?>

<script>

	function init(){		
	}

	function ajuda(){
    	window.open ('<?=WIKI;?>areaFiltro');
    }

	function novo(){
		location.href = BASE_URL+'paraformalidade/equipe/registroAtividade/novo/';
	}

	function listaRegistrosAtividades(){
		location.href = BASE_URL+'paraformalidade/equipe/registroAtividade/novo/';
	}

	function salvar(){
		formAtividade_submit();
	}
	
		
	function formAtividade_callback(data){
		if(data.error != undefined){
			messageErrorBox(data.error.message, data.error.field);
		} else {
			if(data.success != undefined) {
				$('#txtBolsistaId').val(data.atividade.id);
				messageBox(data.success.message,listaRegistrosAtividades);
			}
	    }
	} 



	
</script>