<?=$this->load->view("../../static/_views/headerGlobalView");?>

	<?=path_bread($path_bread);?>

	<?=begin_ToolBar(array('abrir', 'salvar', 'imprimir' ));?>
	<?=end_ToolBar();?>

	<?=begin_TabPanel('tabQuantidadesRegistradas');?>
		<?=begin_Tab(lang('quantidadesRegistradasFiltro'));?>
			<?=form_label('lblDescricao', lang('quantidadesRegistradasDescricao'), 80);?>
			<?=form_textField('txtDescricao', '', 300, '');?>
		<?=end_Tab();?>
	<?=end_TabPanel();?>
	
	<?=begin_JqGridPanel('gridQuantidadesRegistrada', 'auto', '', base_url().'paraformalidade/cadastrosBasicos/quantidadesRegistrada/listaQuantidadesRegistradas/', array('sortname'=> 'descricao', 'autowidth'=> true, 'pager'=> true, 'caption'=>lang('quantidadesRegistradasLista')));?>
		<?=addJqGridColumn('id', 'ID', 0, 'right', array('sortable'=>true, 'hidden'=> true));?>
		<?=addJqGridColumn('descricao', lang('quantidadesRegistradasDescricao'), 300, 'left', array('sortable'=>true));?>
		<?=addJqGridColumn('dt_cadastro', lang('quantidadesRegistradasDtCadastro'), 70, 'center', array('sortable'=>true));?>
	<?=end_JqGridPanel();?>
	
<?=$this->load->view("../../static/_views/footerGlobalView");?>

<script>
	function ajuda(){
    	window.open ('<?=WIKI;?>Quantidades Registradas');
    }
	function pesquisar(){
               gridQuantidadesRegistrada.addParam('descricao', $('#txtDescricao').val());
               gridQuantidadesRegistrada.load();
     }
	
	function novo(){
		location.href = BASE_URL+'paraformalidade/cadastrosBasicos/quantidadesRegistrada/novo/';
	}
 
	
	function gridQuantidadesRegistrada_click(id){
		location.href = BASE_URL+'paraformalidade/cadastrosBasicos/quantidadesRegistrada/editar/'+id;
	}

	function excluir(){		
		if(getSelectedRows('gridQuantidadesRegistrada').length == 0)
			messageErrorBox('<?=lang('nenhumRegistroSelecionado')?>');
		else
			messageConfirm('<?=lang('excluirRegistros')?>', excluirQuantidadesRegistrada);
	}
	
	function excluirQuantidadesRegistrada(confirmaExclusao){
		if(confirmaExclusao){
			var quantidadesRegistrada
			var quantidadesGrid = getSelectedRows('gridQuantidadesRegistrada');
			for(var i = 0; i < quantidadesGrid.length; i++)
				if( quantidadesRegistrada == '')
					 quantidadesRegistrada = NotaTiposGrid[i];
				else
					 quantidadesRegistrada += ',' + quantidadesGrid[i];

			$.post(BASE_URL+'paraformalidade/cadastrosBasicos/quantidadesRegistrada/excluir/', {id:  quantidadesRegistrada}, 
				function(data){
					if(data.success)
						messageBox("<?=lang('registroExcluido')?>", pesquisar);
					else
						messageErrorBox("<?=lang('registroNaoExcluido')?>");
				});
		}
	}		

</script>