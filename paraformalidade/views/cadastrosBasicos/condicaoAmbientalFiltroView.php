<?=$this->load->view("../../static/_views/headerGlobalView");?>

	<?=path_bread($path_bread);?>

	<?=begin_ToolBar(array('abrir', 'salvar', 'imprimir' ));?>
	<?=end_ToolBar();?>

	<?=begin_TabPanel('tabCondicoesAmbientais');?>
		<?=begin_Tab(lang('condicoesAmbientaisFiltro'));?>
			<?=form_label('lblDescricao', lang('condicoesAmbientaisDescricao'), 80);?>
			<?=form_textField('txtDescricao', '', 300, '');?>
		<?=end_Tab();?>
	<?=end_TabPanel();?>
	
	<?=begin_JqGridPanel('gridCondicaoAmbiental', '', '', base_url().'paraformalidade/cadastrosBasicos/condicaoAmbiental/listaCondicoesAmbientais/', array('sortname'=> 'descricao', 'autowidth'=> true, 'pager'=> true, 'caption'=>lang('condicoesAmbientaisLista')));?>
		<?=addJqGridColumn('id', 'ID', 0, 'right', array('sortable'=>true, 'hidden'=> true));?>
		<?=addJqGridColumn('descricao', lang('condicoesAmbientaisDescricao'), 300, 'left', array('sortable'=>true));?>
		<?=addJqGridColumn('dt_cadastro', lang('condicoesAmbientaisDtCadastro'), 70, 'center', array('sortable'=>true));?>
	<?=end_JqGridPanel();?>
	
<?=$this->load->view("../../static/_views/footerGlobalView");?>

<script>
	function ajuda(){
    	window.open ('<?=WIKI;?>Condicoes Ambientais');
    }
	function pesquisar(){
               gridCondicaoAmbiental.addParam('descricao', $('#txtDescricao').val());
               gridCondicaoAmbiental.load();
     }
	
	function novo(){
		location.href = BASE_URL+'paraformalidade/cadastrosBasicos/condicaoAmbiental/novo/';
	}
 
	
	function gridCondicaoAmbiental_click(id){
		location.href = BASE_URL+'paraformalidade/cadastrosBasicos/condicaoAmbiental/editar/'+id;
	}

	function excluir(){		
		if(getSelectedRows('gridCondicaoAmbiental').length == 0)
			messageErrorBox('<?=lang('nenhumRegistroSelecionado')?>');
		else
			messageConfirm('<?=lang('excluirRegistros')?>', excluirNotaTipo);
	}
	
	function excluirNotaTipo(confirmaExclusao){
		if(confirmaExclusao){
			var notaTipos
			var notaTiposGrid = getSelectedRows('gridCondicaoAmbiental');
			for(var i = 0; i < notaTiposGrid.length; i++)
				if(notaTipos == '')
					notaTipos = NotaTiposGrid[i];
				else
					notaTipos += ',' + notaTiposGrid[i];

			$.post(BASE_URL+'paraformalidade/cadastrosBasicos/condicaoAmbiental/excluir/', {id: notaTipos}, 
				function(data){
					if(data.success)
						messageBox("<?=lang('registroExcluido')?>", pesquisar);
					else
						messageErrorBox("<?=lang('registroNaoExcluido')?>");
				});
		}
	}		

</script>