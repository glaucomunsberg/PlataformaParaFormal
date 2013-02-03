<?=$this->load->view("../../static/_views/headerGlobalView");?>

	<?=path_bread($path_bread);?>

	<?=begin_ToolBar(array('abrir', 'salvar', 'imprimir' ));?>
	<?=end_ToolBar();?>

	<?=begin_TabPanel('tabEquipamentoInstalacoes');?>
		<?=begin_Tab(lang('equipamentoInstalacoesFiltro'));?>
			<?=form_label('lblDescricao', lang('equipamentoInstalacoesDescricao'), 80);?>
			<?=form_textField('txtDescricao', '', 300, '');?>
		<?=end_Tab();?>
	<?=end_TabPanel();?>
	
	<?=begin_JqGridPanel('gridEquipamentoInstalacoes', 'auto', '', base_url().'paraformalidade/cadastrosBasicos/equipamentoInstalacoes/listaEquipamentoInstalacoes/', array('sortname'=> 'descricao', 'autowidth'=> true, 'pager'=> true, 'caption'=>lang('equipamentoInstalacoesLista')));?>
		<?=addJqGridColumn('id', 'ID', 0, 'right', array('sortable'=>true, 'hidden'=> true));?>
		<?=addJqGridColumn('descricao', lang('equipamentoInstalacoesDescricao'), 300, 'left', array('sortable'=>true));?>
		<?=addJqGridColumn('dt_cadastro', lang('equipamentoInstalacoesDtCadastro'), 70, 'center', array('sortable'=>true));?>
	<?=end_JqGridPanel();?>
	
<?=$this->load->view("../../static/_views/footerGlobalView");?>

<script>
	function ajuda(){
    	window.open ('<?=WIKI;?>EquipamentoInstalacoes');
    }
	function pesquisar(){
               gridEquipamentoInstalacoes.addParam('descricao', $('#txtDescricao').val());
               gridEquipamentoInstalacoes.load();
     }
	
	function novo(){
		location.href = BASE_URL+'paraformalidade/cadastrosBasicos/equipamentoInstalacoes/novo/';
	}
 
	
	function gridEquipamentoInstalacoes_click(id){
		location.href = BASE_URL+'paraformalidade/cadastrosBasicos/equipamentoInstalacoes/editar/'+id;
	}

	function excluir(){		
		if(getSelectedRows('gridEquipamentoInstalacoes').length == 0)
			messageErrorBox('<?=lang('nenhumRegistroSelecionado')?>');
		else
			messageConfirm('<?=lang('excluirRegistros')?>', excluirEquipamentoInstalacoes);
	}
	
	function excluirEquipamentoInstalacoes(confirmaExclusao){
		if(confirmaExclusao){
			var gridEquipamentoInstalacoes
			var instalacoesGrid = getSelectedRows('gridEquipamentoInstalacoes');
			for(var i = 0; i < instalacoesGrid.length; i++)
				if( gridEquipamentoInstalacoes == '')
					 gridEquipamentoInstalacoes = NotaTiposGrid[i];
				else
					 gridEquipamentoInstalacoes += ',' + instalacoesGrid[i];

			$.post(BASE_URL+'paraformalidade/cadastrosBasicos/equipamentoInstalacoes/excluir/', {id:  gridEquipamentoInstalacoes}, 
				function(data){
					if(data.success)
						messageBox("<?=lang('registroExcluido')?>", pesquisar);
					else
						messageErrorBox("<?=lang('registroNaoExcluido')?>");
				});
		}
	}		

</script>