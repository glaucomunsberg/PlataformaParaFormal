<?=$this->load->view("../../static/_views/headerGlobalView");?>

	<?=path_bread($path_bread);?>

	<?=begin_ToolBar(array('abrir', 'salvar', 'imprimir' ));?>
	<?=end_ToolBar();?>

	<?=begin_TabPanel('tabEquipamentoMobilidades');?>
		<?=begin_Tab(lang('equipamentoMobilidadesFiltro'));?>
			<?=form_label('lblDescricao', lang('equipamentoMobilidadesDescricao'), 80);?>
			<?=form_textField('txtDescricao', '', 300, '');?>
		<?=end_Tab();?>
	<?=end_TabPanel();?>
	
	<?=begin_JqGridPanel('gridEquipamentoMobilidades', 'auto', '', base_url().'paraformalidade/cadastrosBasicos/equipamentoMobilidades/listaEquipamentoMobilidades/', array('sortname'=> 'descricao', 'autowidth'=> true, 'pager'=> true, 'caption'=>lang('equipamentoMobilidadesLista')));?>
		<?=addJqGridColumn('id', 'ID', 0, 'right', array('sortable'=>true, 'hidden'=> true));?>
		<?=addJqGridColumn('descricao', lang('equipamentoMobilidadesDescricao'), 300, 'left', array('sortable'=>true));?>
		<?=addJqGridColumn('dt_cadastro', lang('equipamentoMobilidadesDtCadastro'), 70, 'center', array('sortable'=>true));?>
	<?=end_JqGridPanel();?>
	
<?=$this->load->view("../../static/_views/footerGlobalView");?>

<script>
	function ajuda(){
    	window.open ('<?=WIKI;?>EquipamentoMobilidades');
    }
	function pesquisar(){
               gridEquipamentoMobilidades.addParam('descricao', $('#txtDescricao').val());
               gridEquipamentoMobilidades.load();
     }
	
	function novo(){
		location.href = BASE_URL+'paraformalidade/cadastrosBasicos/equipamentoMobilidades/novo/';
	}
 
	
	function gridEquipamentoMobilidades_click(id){
		location.href = BASE_URL+'paraformalidade/cadastrosBasicos/equipamentoMobilidades/editar/'+id;
	}

	function excluir(){		
		if(getSelectedRows('gridEquipamentoMobilidades').length == 0)
			messageErrorBox('<?=lang('nenhumRegistroSelecionado')?>');
		else
			messageConfirm('<?=lang('excluirRegistros')?>', excluirEquipamentoMobilidades);
	}
	
	function excluirEquipamentoMobilidades(confirmaExclusao){
		if(confirmaExclusao){
			var pontes
			var ponteGrid = getSelectedRows('gridEquipamentoMobilidades');
			for(var i = 0; i < ponteGrid.length; i++)
				if( pontes == '')
					 pontes = NotaTiposGrid[i];
				else
					 pontes += ',' + ponteGrid[i];

			$.post(BASE_URL+'paraformalidade/cadastrosBasicos/equipamentoMobilidades/excluir/', {id:  pontes}, 
				function(data){
					if(data.success)
						messageBox("<?=lang('registroExcluido')?>", pesquisar);
					else
						messageErrorBox("<?=lang('registroNaoExcluido')?>");
				});
		}
	}		

</script>