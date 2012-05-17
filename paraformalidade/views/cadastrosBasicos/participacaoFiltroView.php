<?=$this->load->view("../../static/_views/headerGlobalView");?>

	<?=path_bread($path_bread);?>

	<?=begin_ToolBar(array('abrir', 'salvar', 'imprimir' ));?>
	<?=end_ToolBar();?>

	<?=begin_TabPanel('tabLocais');?>
		<?=begin_Tab(lang('particupacaoFiltro'));?>
			<?=form_label('lblDescricao', lang('particupacaoDescricao'), 80);?>
			<?=form_textField('txtDescricao', '', 300, '');?>
		<?=end_Tab();?>
	<?=end_TabPanel();?>
	
	<?=begin_JqGridPanel('gridParticipacao', 'auto', '', base_url().'paraformalidade/cadastrosBasicos/participacao/listaParticipacoes/', array('sortname'=> 'descricao', 'autowidth'=> true, 'pager'=> true, 'caption'=>lang('particupacaoLista')));?>
		<?=addJqGridColumn('id', 'ID', 0, 'right', array('sortable'=>true, 'hidden'=> true));?>
		<?=addJqGridColumn('descricao', lang('particupacaoDescricao'), 300, 'left', array('sortable'=>true));?>
		<?=addJqGridColumn('dt_cadastro', lang('particupacaoDtCadastro'), 70, 'center', array('sortable'=>true));?>
	<?=end_JqGridPanel();?>
	
<?=$this->load->view("../../static/_views/footerGlobalView");?>

<script>
	function ajuda(){
    	window.open ('<?=WIKI;?>Participações');
    }
	function pesquisar(){
               gridParticipacao.addParam('descricao', $('#txtDescricao').val());
               gridParticipacao.load();
     }
	
	function novo(){
		location.href = BASE_URL+'paraformalidade/cadastrosBasicos/participacao/novo/';
	}
 
	
	function gridParticipacao_click(id){
		location.href = BASE_URL+'paraformalidade/cadastrosBasicos/participacao/editar/'+id;
	}

	function excluir(){		
		if(getSelectedRows('gridParticipacao').length == 0)
			messageErrorBox('<?=lang('nenhumRegistroSelecionado')?>');
		else
			messageConfirm('<?=lang('excluirRegistros')?>', excluirParticipacao);
	}
	
	function excluirParticipacao(confirmaExclusao){
		if(confirmaExclusao){
			var locais
			var localGrid = getSelectedRows('gridParticipacao');
			for(var i = 0; i < localGrid.length; i++)
				if( locais == '')
					 locais = NotaTiposGrid[i];
				else
					 locais += ',' + localGrid[i];

			$.post(BASE_URL+'paraformalidade/cadastrosBasicos/participacao/excluir/', {id:  locais}, 
				function(data){
					if(data.success)
						messageBox("<?=lang('registroExcluido')?>", pesquisar);
					else
						messageErrorBox("<?=lang('registroNaoExcluido')?>");
				});
		}
	}		

</script>