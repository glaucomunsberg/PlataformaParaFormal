<?=$this->load->view("../../static/_views/headerGlobalView");?>

	<?=path_bread($path_bread);?>

	<?=begin_ToolBar(array('abrir', 'salvar', 'imprimir' ));?>
	<?=end_ToolBar();?>

	<?=begin_TabPanel('tabElementosSituacoes');?>
		<?=begin_Tab(lang('elementosSituacoesFiltro'));?>
			<?=form_label('lblDescricao', lang('elementosSituacoesDescricao'), 80);?>
			<?=form_textField('txtDescricao', '', 300, '');?>
		<?=end_Tab();?>
	<?=end_TabPanel();?>
	
	<?=begin_JqGridPanel('gridElementoSituacao', 'auto', '', base_url().'paraformalidade/cadastrosBasicos/elementoSituacao/listaElementosSituacoes/', array('sortname'=> 'descricao', 'autowidth'=> true, 'pager'=> true, 'caption'=>lang('elementosSituacoesLista')));?>
		<?=addJqGridColumn('id', 'ID', 0, 'right', array('sortable'=>true, 'hidden'=> true));?>
		<?=addJqGridColumn('descricao', lang('elementosSituacoesDescricao'), 300, 'left', array('sortable'=>true));?>
		<?=addJqGridColumn('dt_cadastro', lang('elementosSituacoesDtCadastro'), 70, 'center', array('sortable'=>true));?>
	<?=end_JqGridPanel();?>
	
<?=$this->load->view("../../static/_views/footerGlobalView");?>

<script>
	function ajuda(){
    	window.open ('<?=WIKI;?>Elementos Situação');
    }
	function pesquisar(){
               gridElementoSituacao.addParam('descricao', $('#txtDescricao').val());
               gridElementoSituacao.load();
     }
	
	function novo(){
		location.href = BASE_URL+'paraformalidade/cadastrosBasicos/elementoSituacao/novo/';
	}
 
	
	function gridElementoSituacao_click(id){
		location.href = BASE_URL+'paraformalidade/cadastrosBasicos/elementoSituacao/editar/'+id;
	}

	function excluir(){		
		if(getSelectedRows('gridElementoSituacao').length == 0)
			messageErrorBox('<?=lang('nenhumRegistroSelecionado')?>');
		else
			messageConfirm('<?=lang('excluirRegistros')?>', excluirElementoSituacao);
	}
	
	function excluirElementoSituacao(confirmaExclusao){
		if(confirmaExclusao){
			var Elemento_situacao
			var elementoGrid = getSelectedRows('gridElementoSituacao');
			for(var i = 0; i < elementoGrid.length; i++)
				if( Elemento_situacao == '')
					 Elemento_situacao = NotaTiposGrid[i];
				else
					 Elemento_situacao += ',' + elementoGrid[i];

			$.post(BASE_URL+'paraformalidade/cadastrosBasicos/elementoSituacao/excluir/', {id:  Elemento_situacao}, 
				function(data){
					if(data.success)
						messageBox("<?=lang('registroExcluido')?>", pesquisar);
					else
						messageErrorBox("<?=lang('registroNaoExcluido')?>");
				});
		}
	}		

</script>