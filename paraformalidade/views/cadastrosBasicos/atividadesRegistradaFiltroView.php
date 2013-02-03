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
	
	<?=begin_JqGridPanel('gridAtividadesRegistrada', 'auto', '', base_url().'paraformalidade/cadastrosBasicos/atividadesRegistrada/listaAtividadesRegistradas/', array('sortname'=> 'descricao', 'autowidth'=> true, 'pager'=> true, 'caption'=>lang('atividadesRegistradasLista')));?>
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
               gridAtividadesRegistrada.addParam('descricao', $('#txtDescricao').val());
               gridAtividadesRegistrada.load();
     }
	
	function novo(){
		location.href = BASE_URL+'paraformalidade/cadastrosBasicos/atividadesRegistrada/novo/';
	}
 
	
	function gridAtividadesRegistrada_click(id){
		location.href = BASE_URL+'paraformalidade/cadastrosBasicos/atividadesRegistrada/editar/'+id;
	}

	function excluir(){		
		if(getSelectedRows('gridAtividadesRegistrada').length == 0)
			messageErrorBox('<?=lang('nenhumRegistroSelecionado')?>');
		else
			messageConfirm('<?=lang('excluirRegistros')?>', excluirAtividadesRegistrada);
	}
	
	function excluirAtividadesRegistrada(confirmaExclusao){
		if(confirmaExclusao){
			var atividadesRegistrada
			var atividadesGrid = getSelectedRows('gridAtividadesRegistrada');
			for(var i = 0; i < atividadesGrid.length; i++)
				if( atividadesRegistrada == '')
					 atividadesRegistrada = NotaTiposGrid[i];
				else
					 atividadesRegistrada += ',' + atividadesGrid[i];

			$.post(BASE_URL+'paraformalidade/cadastrosBasicos/atividadesRegistrada/excluir/', {id:  atividadesRegistrada}, 
				function(data){
					if(data.success)
						messageBox("<?=lang('registroExcluido')?>", pesquisar);
					else
						messageErrorBox("<?=lang('registroNaoExcluido')?>");
				});
		}
	}		

</script>