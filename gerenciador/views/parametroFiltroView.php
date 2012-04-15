<?= $this->load->view("../../static/_views/headerGlobalView"); ?>

	<?=path_bread($path_bread); ?>

	<?=begin_ToolBar(array('salvar', 'abrir', 'imprimir', 'ajuda', 'pesquisar'));?>	
	<?=end_ToolBar();?>

	<?=begin_JqGridPanel('gridParametro', 'auto', '', base_url().'gerenciador/parametro/listaParametros/', array('autowidth'=> true, 'pager'=> true, 'caption'=> 'Lista de Parâmetros'));?>
		<?=addJqGridColumn('id', 'ID', 0, 'right', array('sortable'=>true, 'hidden'=> true));?>
		<?=addJqGridColumn('nome', lang('parametroNome'), 200, 'left', array('sortable'=>false));?>
		<?=addJqGridColumn('descricao', lang('parametroDescricao'), 200, 'left', array('sortable'=>false));?>
		<?=addJqGridColumn('valor', lang('parametroValor'), 50, 'right', array('sortable'=>false));?>
		<?=addJqGridColumn('dt_cadastro', lang('parametroDtCadastro'), 50, 'center', array('sortable'=>false));?>
	<?=end_JqGridPanel();?>

<?= $this->load->view("../../static/_views/footerGlobalView");?>

<script>

	function pesquisar(){
		$("#gridParametro").setGridParam({url:BASE_URL+'gerenciador/parametro/listaParametros/',page:1}).trigger("reloadGrid");
	}

	function novo(){
		location.href = BASE_URL+'gerenciador/parametro/novo';
	}

	function gridParametro_click(id){
		location.href = BASE_URL+'gerenciador/parametro/editar/'+id;
	}

	function excluir(){
		if(getSelectedRows('gridParametro').length > 0)
			messageConfirm("<?=lang('excluirRegistros')?>", excluirParametro);
		else
			messageErrorBox("<?=lang('nenhumRegistroSelecionado')?>");
	}

	function excluirParametro(confirmaExclusao){
		if(confirmaExclusao){
			var parametros
			var parametrosGrid = getSelectedRows('gridParametro');
			for(var i = 0; i < parametrosGrid.length; i++)
				if(parametros == '')
					parametros = parametrosGrid[i];
				else
					parametros += ',' + parametrosGrid[i];

			$.post(BASE_URL+'gerenciador/parametro/excluir', {id: parametros}, parametroExcluido);
		}
	}

	function parametroExcluido(data){
		if(data.sucess == "false")
			messageErrorBox("<?=lang('registroNaoExcluido')?>");
		else
			messageBox("<?=lang('registroExcluido')?>", pesquisar);
	}

</script>