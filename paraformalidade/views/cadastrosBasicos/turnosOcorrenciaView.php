<?=$this->load->view("../../static/_views/headerGlobalView");?>

	<?=path_bread($path_bread);?>

	<?=begin_ToolBar(array('imprimir', 'abrir', 'pesquisar'));?>
	<?=end_ToolBar();?>

	<?=begin_TabPanel('tabPonte');?>
		<?=begin_Tab(lang('turnosOcorrenciaFiltro'));?>
			<?=begin_form('paraformalidade/cadastrosBasicos/turnosOcorrencia/salvar', 'formTurnosOcorrencia');?>
				<?=form_hidden('txtTurnoOcorrenciaId', @$turnos_ocorrencia->id);?>

				<?=form_label('lblDescricao', lang('turnosOcorrenciaDescricao'), 80);?>
				<?=form_textField('txtDescricao', @$turnos_ocorrencia->descricao, 400, '');?>

			<?=end_form();?>
		<?=end_Tab();?>
	<?=end_TabPanel();?>

<?=$this->load->view("../../static/_views/footerGlobalView");?>

<script>
	function ajuda(){
    	window.open ('<?=WIKI;?>Pontes');
        }

	function novo(){
		location.href = BASE_URL+'paraformalidade/cadastrosBasicos/turnosOcorrencia/novo/';
	}

	function listaTurnosOcorrencia(){
		location.href = BASE_URL+'paraformalidade/cadastrosBasicos/turnosOcorrencia/';
	}

	function salvar(){
		formTurnosOcorrencia_submit();
	}
	
	function formTurnosOcorrencia_callback(data){
		if(data.error != undefined){
			messageErrorBox(data.error.message, data.error.field);
		} else {
			if(data.success != undefined) {
				$('#txtTurnoOcorrenciaId').val(data.turnos_ocorrencia.id);
                        messageBox(data.success.message, listaTurnosOcorrencia);
			}
	    }
	} 

	function excluir(){
		if($('#txtTurnoOcorrenciaId').val() == ''){
			messageErrorBox("<?=lang('nenhumRegistroSelecionado')?>");
		}else{
			messageConfirm('<?=lang('excluirRegistros')?>', excluirTurnosOcorrencia);
		}
	}

	function excluirTurnosOcorrencia(confirmaExclusao){
		if(confirmaExclusao){
			$.post(BASE_URL+'paraformalidade/cadastrosBasicos/turnosOcorrencia/excluir/', {id: $('#txtTurnoOcorrenciaId').val()}, 
				function(data){
					if(data.success)
						messageBox("<?=lang('registroExcluido')?>", listaTurnosOcorrencia);
					else
						messageErrorBox("<?=lang('registroNaoExcluido')?>");
				});
		}
	}	
	
</script>