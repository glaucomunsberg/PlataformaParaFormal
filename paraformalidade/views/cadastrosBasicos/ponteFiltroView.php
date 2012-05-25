<?=$this->load->view("../../static/_views/headerGlobalView");?>

	<?=path_bread($path_bread);?>

	<?=begin_ToolBar(array('abrir', 'salvar', 'imprimir' ));?>
	<?=end_ToolBar();?>

	<?=begin_TabPanel('tabPontes');?>
		<?=begin_Tab(lang('ponteFiltro'));?>
			<?=form_label('lblDescricao', lang('ponteDescricao'), 80);?>
			<?=form_textField('txtDescricao', '', 300, '');?>
		<?=end_Tab();?>
	<?=end_TabPanel();?>
	
	<?=begin_JqGridPanel('gridPonte', 'auto', '', base_url().'paraformalidade/cadastrosBasicos/ponte/listaPontes/', array('sortname'=> 'descricao', 'autowidth'=> true, 'pager'=> true, 'caption'=>lang('ponteLista')));?>
		<?=addJqGridColumn('id', 'ID', 0, 'right', array('sortable'=>true, 'hidden'=> true));?>
		<?=addJqGridColumn('descricao', lang('ponteDescricao'), 300, 'left', array('sortable'=>true));?>
		<?=addJqGridColumn('dt_cadastro', lang('ponteDtCadastro'), 70, 'center', array('sortable'=>true));?>
	<?=end_JqGridPanel();?>
	
<?=$this->load->view("../../static/_views/footerGlobalView");?>

<script>
	function ajuda(){
    	window.open ('<?=WIKI;?>Pontes');
    }
	function pesquisar(){
               gridPonte.addParam('descricao', $('#txtDescricao').val());
               gridPonte.load();
     }
	
	function novo(){
		location.href = BASE_URL+'paraformalidade/cadastrosBasicos/ponte/novo/';
	}
 
	
	function gridPonte_click(id){
		location.href = BASE_URL+'paraformalidade/cadastrosBasicos/ponte/editar/'+id;
	}

	function excluir(){		
		if(getSelectedRows('gridPonte').length == 0)
			messageErrorBox('<?=lang('nenhumRegistroSelecionado')?>');
		else
			messageConfirm('<?=lang('excluirRegistros')?>', excluirPonte);
	}
	
	function excluirPonte(confirmaExclusao){
		if(confirmaExclusao){
			var pontes
			var ponteGrid = getSelectedRows('gridPonte');
			for(var i = 0; i < ponteGrid.length; i++)
				if( pontes == '')
					 pontes = NotaTiposGrid[i];
				else
					 pontes += ',' + ponteGrid[i];

			$.post(BASE_URL+'paraformalidade/cadastrosBasicos/ponte/excluir/', {id:  pontes}, 
				function(data){
					if(data.success)
						messageBox("<?=lang('registroExcluido')?>", pesquisar);
					else
						messageErrorBox("<?=lang('registroNaoExcluido')?>");
				});
		}
	}		

</script>