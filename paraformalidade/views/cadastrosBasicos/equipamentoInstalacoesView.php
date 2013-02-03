<?=$this->load->view("../../static/_views/headerGlobalView");?>

	<?=path_bread($path_bread);?>

	<?=begin_ToolBar(array('imprimir', 'abrir', 'pesquisar'));?>
	<?=end_ToolBar();?>

	<?=begin_TabPanel('tabPonte');?>
		<?=begin_Tab(lang('equipamentoInstalacoesFiltro'));?>
			<?=begin_form('paraformalidade/cadastrosBasicos/equipamentoInstalacoes/salvar', 'formEquipamentoInstalacoes');?>
				<?=form_hidden('txtEquipamentoInstalacoesId', @$equipamento_instalacoes->id);?>

				<?=form_label('lblDescricao', lang('equipamentoInstalacoesDescricao'), 80);?>
				<?=form_textField('txtDescricao', @$equipamento_instalacoes->descricao, 400, '');?>

			<?=end_form();?>
		<?=end_Tab();?>
	<?=end_TabPanel();?>

<?=$this->load->view("../../static/_views/footerGlobalView");?>

<script>
	function ajuda(){
    	window.open ('<?=WIKI;?>Pontes');
        }

	function novo(){
		location.href = BASE_URL+'paraformalidade/cadastrosBasicos/equipamentoInstalacoes/novo/';
	}

	function listaEquipamentoInstalacoes(){
		location.href = BASE_URL+'paraformalidade/cadastrosBasicos/equipamentoInstalacoes/';
	}

	function salvar(){
		formEquipamentoInstalacoes_submit();
	}
	
	function formEquipamentoInstalacoes_callback(data){
		if(data.error != undefined){
			messageErrorBox(data.error.message, data.error.field);
		} else {
			if(data.success != undefined) {
				$('#txtEquipamentoInstalacoesId').val(data.equipamento_instalacoes.id);
                        messageBox(data.success.message, listaEquipamentoInstalacoes);
			}
	    }
	} 

	function excluir(){
		if($('#txtEquipamentoInstalacoesId').val() == ''){
			messageErrorBox("<?=lang('nenhumRegistroSelecionado')?>");
		}else{
			messageConfirm('<?=lang('excluirRegistros')?>', excluirEquipamentoInstalacoes);
		}
	}

	function excluirEquipamentoInstalacoes(confirmaExclusao){
		if(confirmaExclusao){
			$.post(BASE_URL+'paraformalidade/cadastrosBasicos/equipamentoInstalacoes/excluir/', {id: $('#txtEquipamentoInstalacoesId').val()}, 
				function(data){
					if(data.success)
						messageBox("<?=lang('registroExcluido')?>", listaEquipamentoInstalacoes);
					else
						messageErrorBox("<?=lang('registroNaoExcluido')?>");
				});
		}
	}	
	
</script>