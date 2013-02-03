<?=$this->load->view("../../static/_views/headerGlobalView");?>

	<?=path_bread($path_bread);?>

	<?=begin_ToolBar(array('abrir', 'salvar', 'imprimir' ));?>
	<?=end_ToolBar();?>

	<?=begin_TabPanel('tabTurnosOcorrencia');?>
		<?=begin_Tab(lang('turnosOcorrenciaFiltro'));?>
			<?=form_label('lblDescricao', lang('turnosOcorrenciaDescricao'), 80);?>
			<?=form_textField('txtDescricao', '', 300, '');?>
		<?=end_Tab();?>
	<?=end_TabPanel();?>
	
	<?=begin_JqGridPanel('gridTurnosOcorrencia', 'auto', '', base_url().'paraformalidade/cadastrosBasicos/turnosOcorrencia/listaTurnosOcorrencia/', array('sortname'=> 'descricao', 'autowidth'=> true, 'pager'=> true, 'caption'=>lang('turnosOcorrenciaLista')));?>
		<?=addJqGridColumn('id', 'ID', 0, 'right', array('sortable'=>true, 'hidden'=> true));?>
		<?=addJqGridColumn('descricao', lang('turnosOcorrenciaDescricao'), 300, 'left', array('sortable'=>true));?>
		<?=addJqGridColumn('dt_cadastro', lang('turnosOcorrenciaDtCadastro'), 70, 'center', array('sortable'=>true));?>
	<?=end_JqGridPanel();?>
	
<?=$this->load->view("../../static/_views/footerGlobalView");?>

<script>
	function ajuda(){
    	window.open ('<?=WIKI;?>TurnosOcorrencia');
    }
	function pesquisar(){
               gridTurnosOcorrencia.addParam('descricao', $('#txtDescricao').val());
               gridTurnosOcorrencia.load();
     }
	
	function novo(){
		location.href = BASE_URL+'paraformalidade/cadastrosBasicos/turnosOcorrencia/novo/';
	}
 
	
	function gridTurnosOcorrencia_click(id){
		location.href = BASE_URL+'paraformalidade/cadastrosBasicos/turnosOcorrencia/editar/'+id;
	}

	function excluir(){		
		if(getSelectedRows('gridTurnosOcorrencia').length == 0)
			messageErrorBox('<?=lang('nenhumRegistroSelecionado')?>');
		else
			messageConfirm('<?=lang('excluirRegistros')?>', excluirTurnosOcorrencia);
	}
	
	function excluirTurnosOcorrencia(confirmaExclusao){
		if(confirmaExclusao){
			var pontes
			var ponteGrid = getSelectedRows('gridTurnosOcorrencia');
			for(var i = 0; i < ponteGrid.length; i++)
				if( pontes == '')
					 pontes = NotaTiposGrid[i];
				else
					 pontes += ',' + ponteGrid[i];

			$.post(BASE_URL+'paraformalidade/cadastrosBasicos/turnosOcorrencia/excluir/', {id:  pontes}, 
				function(data){
					if(data.success)
						messageBox("<?=lang('registroExcluido')?>", pesquisar);
					else
						messageErrorBox("<?=lang('registroNaoExcluido')?>");
				});
		}
	}		

</script>