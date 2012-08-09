<?=$this->load->view("../../static/_views/headerGlobalView");?>

	<?=path_bread($path_bread);?>

	<?=begin_ToolBar(array('abrir', 'salvar', 'imprimir','excluir' ));?>
	<?=end_ToolBar();?>
	<?=new_line();?>

	<?=begin_TabPanel('tabAtividadeRegistro');?>
		<?=begin_Tab(lang('registroAtividadeFiltro'));?>

			<?=form_label('lblDtInicio', lang('registroAtividadePeriodo'), 80);?>
			<?=form_dateField('txtDtInicioRegistro');?>
			<?=form_label('lblAte', 'à', 15, array('style' => 'text-align: center;'));?>
			<?=form_dateField('txtDtFimRegistro');?>
		<?=end_Tab();?>
	<?=end_TabPanel();?>

	<?=begin_JqGridPanel('gridAtividade', '', '', base_url().'paraformalidade/equipe/registroAtividade/listaAtividadesRegistradas/', array('sortname'=> 'id', 'sortorder' => 'desc', 'multiselect' => false,'autowidth'=> true, 'pager'=> true, 'caption'=>lang('registroAtividadeLista')));?>
		<?=addJqGridColumn('id', 'ID', 0, 'right', array('sortable'=>true, 'hidden'=> true));?>
		<?=addJqGridColumn('entrada_saida', lang('registroAtividadeEntradaSaída'), 20, 'center', array('sortable'=>true));?>
		<?=addJqGridColumn('atividade', lang('registroAtividadeAtividade'), 200, 'left', array('sortable'=>true));?>
		<?=addJqGridColumn('dt_cadastro', lang('registroAtividadeDtCadastro'), 30, 'center', array('sortable'=>true, 'formatter' => 'datetime'));?>
	<?=end_JqGridPanel();?>

<?=$this->load->view("../../static/_views/footerGlobalView");?>

<script>

	function ajuda(){
    	window.open ('<?=WIKI;?>Registros de Atividades');
    }

	function pesquisar(){
		gridAtividade.addParam('dt_inicio', $('#txtDtInicioRegistro').val());
		gridAtividade.addParam('dt_fim', $('#txtDtFimRegistro').val());


		gridAtividade.load();
	}

	function novo(){
		location.href = BASE_URL+'paraformalidade/equipe/registroAtividade/novo/';
	}




</script>