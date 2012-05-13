<?=$this->load->view("../../static/_views/headerGlobalView");?>

	<?=path_bread($path_bread);?>

	<?=begin_ToolBar(array('abrir', 'salvar', 'imprimir' ));?>
	<?=end_ToolBar();?>

	<?=begin_TabPanel('tabLocais');?>
		<?=begin_Tab(lang('locaisFiltro'));?>
			<?=form_label('lblDescricao', lang('locaisDescricao'), 80);?>
			<?=form_textField('txtDescricao', '', 300, '');?>
		<?=end_Tab();?>
	<?=end_TabPanel();?>
	
	<?=begin_JqGridPanel('gridLocal', 'auto', '', base_url().'paraformalidade/cadastrosBasicos/local/listaLocais/', array('sortname'=> 'descricao', 'autowidth'=> true, 'pager'=> true, 'caption'=>lang('locaisLista')));?>
		<?=addJqGridColumn('id', 'ID', 0, 'right', array('sortable'=>true, 'hidden'=> true));?>
		<?=addJqGridColumn('descricao', lang('locaisDescricao'), 300, 'left', array('sortable'=>true));?>
		<?=addJqGridColumn('dt_cadastro', lang('locaisDtCadastro'), 70, 'center', array('sortable'=>true));?>
	<?=end_JqGridPanel();?>
	
<?=$this->load->view("../../static/_views/footerGlobalView");?>

<script>
	function ajuda(){
    	window.open ('<?=WIKI;?>Locais');
    }
	function pesquisar(){
               gridLocal.addParam('descricao', $('#txtDescricao').val());
               gridLocal.load();
     }
	
	function novo(){
		location.href = BASE_URL+'paraformalidade/cadastrosBasicos/local/novo/';
	}
 
	
	function gridLocal_click(id){
		location.href = BASE_URL+'paraformalidade/cadastrosBasicos/local/editar/'+id;
	}

	function excluir(){		
		if(getSelectedRows('gridLocal').length == 0)
			messageErrorBox('<?=lang('nenhumRegistroSelecionado')?>');
		else
			messageConfirm('<?=lang('excluirRegistros')?>', excluirLocal);
	}
	
	function excluirLocal(confirmaExclusao){
		if(confirmaExclusao){
			var locais
			var localGrid = getSelectedRows('gridLocal');
			for(var i = 0; i < localGrid.length; i++)
				if( locais == '')
					 locais = NotaTiposGrid[i];
				else
					 locais += ',' + localGrid[i];

			$.post(BASE_URL+'paraformalidade/cadastrosBasicos/local/excluir/', {id:  locais}, 
				function(data){
					if(data.success)
						messageBox("<?=lang('registroExcluido')?>", pesquisar);
					else
						messageErrorBox("<?=lang('registroNaoExcluido')?>");
				});
		}
	}		

</script>