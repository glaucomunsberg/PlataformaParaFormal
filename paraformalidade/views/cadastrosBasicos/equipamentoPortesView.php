<?=$this->load->view("../../static/_views/headerGlobalView");?>

	<?=path_bread($path_bread);?>

	<?=begin_ToolBar(array('imprimir', 'abrir', 'pesquisar'));?>
	<?=end_ToolBar();?>

	<?=begin_TabPanel('tabPonte');?>
		<?=begin_Tab(lang('equipamentoPortesFiltro'));?>
			<?=begin_form('paraformalidade/cadastrosBasicos/equipamentoPortes/salvar', 'formEquipamentoPortes');?>
				<?=form_hidden('txtEquipamentoPortesId', @$equipamento_portes->id);?>

				<?=form_label('lblDescricao', lang('equipamentoPortesDescricao'), 80);?>
				<?=form_textField('txtDescricao', @$equipamento_portes->descricao, 400, '');?>

			<?=end_form();?>
		<?=end_Tab();?>
	<?=end_TabPanel();?>

<?=$this->load->view("../../static/_views/footerGlobalView");?>

<script>
	function ajuda(){
    	window.open ('<?=WIKI;?>Pontes');
        }

	function novo(){
		location.href = BASE_URL+'paraformalidade/cadastrosBasicos/equipamentoPortes/novo/';
	}

	function listaEquipamentoPortes(){
		location.href = BASE_URL+'paraformalidade/cadastrosBasicos/equipamentoPortes/';
	}

	function salvar(){
		formEquipamentoPortes_submit();
	}
	
	function formEquipamentoPortes_callback(data){
		if(data.error != undefined){
			messageErrorBox(data.error.message, data.error.field);
		} else {
			if(data.success != undefined) {
				$('#txtEquipamentoPortesId').val(data.equipamento_portes.id);
                        messageBox(data.success.message, listaEquipamentoPortes);
			}
	    }
	} 

	function excluir(){
		if($('#txtEquipamentoPortesId').val() == ''){
			messageErrorBox("<?=lang('nenhumRegistroSelecionado')?>");
		}else{
			messageConfirm('<?=lang('excluirRegistros')?>', excluirEquipamentoPortes);
		}
	}

	function excluirEquipamentoPortes(confirmaExclusao){
		if(confirmaExclusao){
			$.post(BASE_URL+'paraformalidade/cadastrosBasicos/equipamentoPortes/excluir/', {id: $('#txtEquipamentoPortesId').val()}, 
				function(data){
					if(data.success)
						messageBox("<?=lang('registroExcluido')?>", listaEquipamentoPortes);
					else
						messageErrorBox("<?=lang('registroNaoExcluido')?>");
				});
		}
	}	
	
</script>