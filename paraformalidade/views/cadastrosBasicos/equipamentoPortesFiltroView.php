<?=$this->load->view("../../static/_views/headerGlobalView");?>

	<?=path_bread($path_bread);?>

	<?=begin_ToolBar(array('abrir', 'salvar', 'imprimir' ));?>
	<?=end_ToolBar();?>

	<?=begin_TabPanel('tabEquipamentoPortes');?>
		<?=begin_Tab(lang('equipamentoPortesFiltro'));?>
			<?=form_label('lblDescricao', lang('equipamentoPortesDescricao'), 80);?>
			<?=form_textField('txtDescricao', '', 300, '');?>
		<?=end_Tab();?>
	<?=end_TabPanel();?>
	
	<?=begin_JqGridPanel('gridEquipamentoPortes', 'auto', '', base_url().'paraformalidade/cadastrosBasicos/equipamentoPortes/listaEquipamentoPortes/', array('sortname'=> 'descricao', 'autowidth'=> true, 'pager'=> true, 'caption'=>lang('equipamentoPortesLista')));?>
		<?=addJqGridColumn('id', 'ID', 0, 'right', array('sortable'=>true, 'hidden'=> true));?>
		<?=addJqGridColumn('descricao', lang('equipamentoPortesDescricao'), 300, 'left', array('sortable'=>true));?>
		<?=addJqGridColumn('dt_cadastro', lang('equipamentoPortesDtCadastro'), 70, 'center', array('sortable'=>true));?>
	<?=end_JqGridPanel();?>
	
<?=$this->load->view("../../static/_views/footerGlobalView");?>

<script>
	function ajuda(){
    	window.open ('<?=WIKI;?>EquipamentoPortes');
    }
	function pesquisar(){
               gridEquipamentoPortes.addParam('descricao', $('#txtDescricao').val());
               gridEquipamentoPortes.load();
     }
	
	function novo(){
		location.href = BASE_URL+'paraformalidade/cadastrosBasicos/equipamentoPortes/novo/';
	}
 
	
	function gridEquipamentoPortes_click(id){
		location.href = BASE_URL+'paraformalidade/cadastrosBasicos/equipamentoPortes/editar/'+id;
	}

	function excluir(){		
		if(getSelectedRows('gridEquipamentoPortes').length == 0)
			messageErrorBox('<?=lang('nenhumRegistroSelecionado')?>');
		else
			messageConfirm('<?=lang('excluirRegistros')?>', excluirEquipamentoPortes);
	}
	
	function excluirEquipamentoPortes(confirmaExclusao){
		if(confirmaExclusao){
			var pontes
			var ponteGrid = getSelectedRows('gridEquipamentoPortes');
			for(var i = 0; i < ponteGrid.length; i++)
				if( pontes == '')
					 pontes = NotaTiposGrid[i];
				else
					 pontes += ',' + ponteGrid[i];

			$.post(BASE_URL+'paraformalidade/cadastrosBasicos/equipamentoPortes/excluir/', {id:  pontes}, 
				function(data){
					if(data.success)
						messageBox("<?=lang('registroExcluido')?>", pesquisar);
					else
						messageErrorBox("<?=lang('registroNaoExcluido')?>");
				});
		}
	}		

</script>