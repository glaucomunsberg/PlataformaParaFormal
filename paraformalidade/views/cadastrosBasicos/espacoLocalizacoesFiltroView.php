<?=$this->load->view("../../static/_views/headerGlobalView");?>

	<?=path_bread($path_bread);?>

	<?=begin_ToolBar(array('abrir', 'salvar', 'imprimir' ));?>
	<?=end_ToolBar();?>

	<?=begin_TabPanel('tabEspacoLocalizacoes');?>
		<?=begin_Tab(lang('espacoLocalizacoesFiltro'));?>
			<?=form_label('lblDescricao', lang('espacoLocalizacoesDescricao'), 80);?>
			<?=form_textField('txtDescricao', '', 300, '');?>
		<?=end_Tab();?>
	<?=end_TabPanel();?>
	
	<?=begin_JqGridPanel('gridEspacoLocalizacoes', 'auto', '', base_url().'paraformalidade/cadastrosBasicos/espacoLocalizacoes/listaEspacoLocalizacoes/', array('sortname'=> 'descricao', 'autowidth'=> true, 'pager'=> true, 'caption'=>lang('espacoLocalizacoesLista')));?>
		<?=addJqGridColumn('id', 'ID', 0, 'right', array('sortable'=>true, 'hidden'=> true));?>
		<?=addJqGridColumn('descricao', lang('espacoLocalizacoesDescricao'), 300, 'left', array('sortable'=>true));?>
		<?=addJqGridColumn('dt_cadastro', lang('espacoLocalizacoesDtCadastro'), 70, 'center', array('sortable'=>true));?>
	<?=end_JqGridPanel();?>
	
<?=$this->load->view("../../static/_views/footerGlobalView");?>

<script>
	function ajuda(){
    	window.open ('<?=WIKI;?>EspacoLocalizacoes');
    }
	function pesquisar(){
               gridEspacoLocalizacoes.addParam('descricao', $('#txtDescricao').val());
               gridEspacoLocalizacoes.load();
     }
	
	function novo(){
		location.href = BASE_URL+'paraformalidade/cadastrosBasicos/espacoLocalizacoes/novo/';
	}
 
	
	function gridEspacoLocalizacoes_click(id){
		location.href = BASE_URL+'paraformalidade/cadastrosBasicos/espacoLocalizacoes/editar/'+id;
	}

	function excluir(){		
		if(getSelectedRows('gridEspacoLocalizacoes').length == 0)
			messageErrorBox('<?=lang('nenhumRegistroSelecionado')?>');
		else
			messageConfirm('<?=lang('excluirRegistros')?>', excluirEspacoLocalizacoes);
	}
	
	function excluirEspacoLocalizacoes(confirmaExclusao){
		if(confirmaExclusao){
			var pontes
			var ponteGrid = getSelectedRows('gridEspacoLocalizacoes');
			for(var i = 0; i < ponteGrid.length; i++)
				if( pontes == '')
					 pontes = NotaTiposGrid[i];
				else
					 pontes += ',' + ponteGrid[i];

			$.post(BASE_URL+'paraformalidade/cadastrosBasicos/espacoLocalizacoes/excluir/', {id:  pontes}, 
				function(data){
					if(data.success)
						messageBox("<?=lang('registroExcluido')?>", pesquisar);
					else
						messageErrorBox("<?=lang('registroNaoExcluido')?>");
				});
		}
	}		

</script>