<?=$this->load->view("../../static/_views/headerGlobalView");?>

	<?=path_bread($path_bread);?>

	<?=begin_ToolBar(array('abrir', 'salvar', 'imprimir' ));?>
	<?=end_ToolBar();?>

	<?=begin_TabPanel('tabCorpoNumeros');?>
		<?=begin_Tab(lang('corpoNumerosFiltro'));?>
			<?=form_label('lblDescricao', lang('corpoNumerosDescricao'), 80);?>
			<?=form_textField('txtDescricao', '', 300, '');?>
		<?=end_Tab();?>
	<?=end_TabPanel();?>
	
	<?=begin_JqGridPanel('gridCorpoNumeros', 'auto', '', base_url().'paraformalidade/cadastrosBasicos/corpoNumeros/listaCorpoNumeros/', array('sortname'=> 'descricao', 'autowidth'=> true, 'pager'=> true, 'caption'=>lang('corpoNumerosLista')));?>
		<?=addJqGridColumn('id', 'ID', 0, 'right', array('sortable'=>true, 'hidden'=> true));?>
		<?=addJqGridColumn('descricao', lang('corpoNumerosDescricao'), 300, 'left', array('sortable'=>true));?>
		<?=addJqGridColumn('dt_cadastro', lang('corpoNumerosDtCadastro'), 70, 'center', array('sortable'=>true));?>
	<?=end_JqGridPanel();?>
	
<?=$this->load->view("../../static/_views/footerGlobalView");?>

<script>
	function ajuda(){
    	window.open ('<?=WIKI;?>CorpoNumeros');
    }
	function pesquisar(){
               gridCorpoNumeros.addParam('descricao', $('#txtDescricao').val());
               gridCorpoNumeros.load();
     }
	
	function novo(){
		location.href = BASE_URL+'paraformalidade/cadastrosBasicos/corpoNumeros/novo/';
	}
 
	
	function gridCorpoNumeros_click(id){
		location.href = BASE_URL+'paraformalidade/cadastrosBasicos/corpoNumeros/editar/'+id;
	}

	function excluir(){		
		if(getSelectedRows('gridCorpoNumeros').length == 0)
			messageErrorBox('<?=lang('nenhumRegistroSelecionado')?>');
		else
			messageConfirm('<?=lang('excluirRegistros')?>', excluirCorpoNumeros);
	}
	
	function excluirCorpoNumeros(confirmaExclusao){
		if(confirmaExclusao){
			var pontes
			var ponteGrid = getSelectedRows('gridCorpoNumeros');
			for(var i = 0; i < ponteGrid.length; i++)
				if( pontes == '')
					 pontes = NotaTiposGrid[i];
				else
					 pontes += ',' + ponteGrid[i];

			$.post(BASE_URL+'paraformalidade/cadastrosBasicos/corpoNumeros/excluir/', {id:  pontes}, 
				function(data){
					if(data.success)
						messageBox("<?=lang('registroExcluido')?>", pesquisar);
					else
						messageErrorBox("<?=lang('registroNaoExcluido')?>");
				});
		}
	}		

</script>