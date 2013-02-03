<?=$this->load->view("../../static/_views/headerGlobalView");?>

	<?=path_bread($path_bread);?>

	<?=begin_ToolBar(array('imprimir', 'abrir', 'pesquisar'));?>
	<?=end_ToolBar();?>

	<?=begin_TabPanel('tabPonte');?>
		<?=begin_Tab(lang('equipamentoMobilidadesFiltro'));?>
			<?=begin_form('paraformalidade/cadastrosBasicos/equipamentoMobilidades/salvar', 'formEquipamentoMobilidades');?>
				<?=form_hidden('txtEquipamentoMobilidadesId', @$equipamento_mobilidades->id);?>

				<?=form_label('lblDescricao', lang('equipamentoMobilidadesDescricao'), 80);?>
				<?=form_textField('txtDescricao', @$equipamento_mobilidades->descricao, 400, '');?>

			<?=end_form();?>
		<?=end_Tab();?>
	<?=end_TabPanel();?>

<?=$this->load->view("../../static/_views/footerGlobalView");?>

<script>
	function ajuda(){
    	window.open ('<?=WIKI;?>Pontes');
        }

	function novo(){
		location.href = BASE_URL+'paraformalidade/cadastrosBasicos/equipamentoMobilidades/novo/';
	}

	function listaEquipamentoMobilidades(){
		location.href = BASE_URL+'paraformalidade/cadastrosBasicos/equipamentoMobilidades/';
	}

	function salvar(){
		formEquipamentoMobilidades_submit();
	}
	
	function formEquipamentoMobilidades_callback(data){
		if(data.error != undefined){
			messageErrorBox(data.error.message, data.error.field);
		} else {
			if(data.success != undefined) {
				$('#txtEquipamentoMobilidadesId').val(data.equipamento_mobilidades.id);
                        messageBox(data.success.message, listaEquipamentoMobilidades);
			}
	    }
	} 

	function excluir(){
		if($('#txtEquipamentoMobilidadesId').val() == ''){
			messageErrorBox("<?=lang('nenhumRegistroSelecionado')?>");
		}else{
			messageConfirm('<?=lang('excluirRegistros')?>', excluirEquipamentoMobilidades);
		}
	}

	function excluirEquipamentoMobilidades(confirmaExclusao){
		if(confirmaExclusao){
			$.post(BASE_URL+'paraformalidade/cadastrosBasicos/equipamentoMobilidades/excluir/', {id: $('#txtEquipamentoMobilidadesId').val()}, 
				function(data){
					if(data.success)
						messageBox("<?=lang('registroExcluido')?>", listaEquipamentoMobilidades);
					else
						messageErrorBox("<?=lang('registroNaoExcluido')?>");
				});
		}
	}	
	
</script>