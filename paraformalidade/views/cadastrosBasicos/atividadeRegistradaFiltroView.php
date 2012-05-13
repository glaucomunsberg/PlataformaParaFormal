<?=$this->load->view("../../static/_views/headerGlobalView");?>

	<?=path_bread($path_bread);?>

	<?=begin_ToolBar(array('abrir', 'salvar', 'imprimir' ));?>
	<?=end_ToolBar();?>

	<?=begin_TabPanel('tabAtividadesRegistradas');?>
		<?=begin_Tab(lang('atividadesRegistradasFiltro'));?>
			<?=form_label('lblDescricao', lang('atividadesRegistradasDescricao'), 80);?>
			<?=form_textField('txtDescricao', '', 300, '');?>
		<?=end_Tab();?>
	<?=end_TabPanel();?>
	
	<?=begin_JqGridPanel('gridAtividadeRegistrada', 'auto', '', base_url().'paraformalidade/cadastrosBasicos/atividadeRegistrada/listaAtividadesRegistradas/', array('sortname'=> 'descricao', 'autowidth'=> true, 'pager'=> true, 'caption'=>lang('atividadesRegistradasLista')));?>
		<?=addJqGridColumn('id', 'ID', 0, 'right', array('sortable'=>true, 'hidden'=> true));?>
		<?=addJqGridColumn('descricao', lang('atividadesRegistradasDescricao'), 300, 'left', array('sortable'=>true));?>
		<?=addJqGridColumn('dt_cadastro', lang('atividadesRegistradasDtCadastro'), 70, 'center', array('sortable'=>true));?>
	<?=end_JqGridPanel();?>
	
<?=$this->load->view("../../static/_views/footerGlobalView");?>

<script>
	function ajuda(){
    	window.open ('<?=WIKI;?>Atividades Registradas');
    }
	function pesquisar(){
               gridAtividadeRegistrada.addParam('descricao', $('#txtDescricao').val());
               gridAtividadeRegistrada.load();
     }
	
	function novo(){
		location.href = BASE_URL+'paraformalidade/cadastrosBasicos/atividadeRegistrada/novo/';
	}
 
	
	function gridAtividadeRegistrada_click(id){
		location.href = BASE_URL+'paraformalidade/cadastrosBasicos/atividadeRegistrada/editar/'+id;
	}

	function excluir(){		
		if(getSelectedRows('gridAtividadeRegistrada').length == 0)
			messageErrorBox('<?=lang('nenhumRegistroSelecionado')?>');
		else
			messageConfirm('<?=lang('excluirRegistros')?>', excluirAtividadeRegistrada);
	}
	
	function excluirAtividadeRegistrada(confirmaExclusao){
		if(confirmaExclusao){
			var atividadeRegistrada
			var atividadeGrid = getSelectedRows('gridAtividadeRegistrada');
			for(var i = 0; i < atividadeGrid.length; i++)
				if( atividadeRegistrada == '')
					 atividadeRegistrada = NotaTiposGrid[i];
				else
					 atividadeRegistrada += ',' + atividadeGrid[i];

			$.post(BASE_URL+'paraformalidade/cadastrosBasicos/atividadeRegistrada/excluir/', {id:  atividadeRegistrada}, 
				function(data){
					if(data.success)
						messageBox("<?=lang('registroExcluido')?>", pesquisar);
					else
						messageErrorBox("<?=lang('registroNaoExcluido')?>");
				});
		}
	}		

</script>