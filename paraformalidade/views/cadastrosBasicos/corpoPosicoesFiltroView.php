<?=$this->load->view("../../static/_views/headerGlobalView");?>

	<?=path_bread($path_bread);?>

	<?=begin_ToolBar(array('abrir', 'salvar', 'imprimir' ));?>
	<?=end_ToolBar();?>

	<?=begin_TabPanel('tabCorpoPosicoes');?>
		<?=begin_Tab(lang('corpoPosicoesFiltro'));?>
			<?=form_label('lblDescricao', lang('corpoPosicoesDescricao'), 80);?>
			<?=form_textField('txtDescricao', '', 300, '');?>
		<?=end_Tab();?>
	<?=end_TabPanel();?>
	
	<?=begin_JqGridPanel('gridCorpoPosicoes', 'auto', '', base_url().'paraformalidade/cadastrosBasicos/corpoPosicoes/listaCorpoPosicoes/', array('sortname'=> 'descricao', 'autowidth'=> true, 'pager'=> true, 'caption'=>lang('corpoPosicoesLista')));?>
		<?=addJqGridColumn('id', 'ID', 0, 'right', array('sortable'=>true, 'hidden'=> true));?>
		<?=addJqGridColumn('descricao', lang('corpoPosicoesDescricao'), 300, 'left', array('sortable'=>true));?>
		<?=addJqGridColumn('dt_cadastro', lang('corpoPosicoesDtCadastro'), 70, 'center', array('sortable'=>true));?>
	<?=end_JqGridPanel();?>
	
<?=$this->load->view("../../static/_views/footerGlobalView");?>

<script>
	function ajuda(){
    	window.open ('<?=WIKI;?>CorpoPosicoes');
    }
	function pesquisar(){
               gridCorpoPosicoes.addParam('descricao', $('#txtDescricao').val());
               gridCorpoPosicoes.load();
     }
	
	function novo(){
		location.href = BASE_URL+'paraformalidade/cadastrosBasicos/corpoPosicoes/novo/';
	}
 
	
	function gridCorpoPosicoes_click(id){
		location.href = BASE_URL+'paraformalidade/cadastrosBasicos/corpoPosicoes/editar/'+id;
	}

	function excluir(){		
		if(getSelectedRows('gridCorpoPosicoes').length == 0)
			messageErrorBox('<?=lang('nenhumRegistroSelecionado')?>');
		else
			messageConfirm('<?=lang('excluirRegistros')?>', excluirCorpoPosicoes);
	}
	
	function excluirCorpoPosicoes(confirmaExclusao){
		if(confirmaExclusao){
			var pontes
			var ponteGrid = getSelectedRows('gridCorpoPosicoes');
			for(var i = 0; i < ponteGrid.length; i++)
				if( pontes == '')
					 pontes = NotaTiposGrid[i];
				else
					 pontes += ',' + ponteGrid[i];

			$.post(BASE_URL+'paraformalidade/cadastrosBasicos/corpoPosicoes/excluir/', {id:  pontes}, 
				function(data){
					if(data.success)
						messageBox("<?=lang('registroExcluido')?>", pesquisar);
					else
						messageErrorBox("<?=lang('registroNaoExcluido')?>");
				});
		}
	}		

</script>