<?=$this->load->view("../../static/_views/headerGlobalView");?>

	<?=path_bread($path_bread);?>

	<?=begin_ToolBar(array('novo', 'excluir', 'pesquisar', 'abrir', 'imprimir', 'ajuda'))?>
	<?=end_ToolBar()?>

	<?=begin_TabPanel();?>
		<?=begin_Tab('Opções Log Tabela');?>
			<?=begin_form('gerenciador/logTabelas/salvarLogTabela', 'formLogTabela');?>
				<?=form_hidden('txtEsquema', $esquema);?>
				<?=form_hidden('txtTabela', $tabela);?>
				<?=form_hidden('txtColunas');?>

				<?=begin_JqGridPanel('gridColunas', 'auto', '', base_url().'gerenciador/logTabelas/listaColunas/'.$esquema.'/'.$tabela, array('autoload'=> true, 'sortname'=> 'ordinal_position', 'autowidth'=> true, 'toppager' => false, 'pager'=> false, 'caption'=>'Lista de colunas da tabela '.$esquema.'.'.$tabela));?>
					<?=addJqGridColumn('id', 'ID', 0, 'right', array('sortable'=>true, 'hidden'=> true));?>
					<?=addJqGridColumn('ordinal_position', 'Ordem', 40, 'center', array('sortable'=>false));?>
					<?=addJqGridColumn('column_name', 'Nome', 150, 'left', array('sortable'=>false));?>
					<?=addJqGridColumn('data_type', 'Tipo', 100, 'left', array('sortable'=>false));?>
					<?=addJqGridColumn('column_default', 'Valor default', 300, 'left', array('sortable'=>false));?>
				<?=end_JqGridPanel();?>
			<?=end_form();?>
		<?=end_Tab();?>
		<?=begin_Tab('Visualizar Log Tabela');?>
			<?=begin_JqGridPanel('gridLogTabela', 'auto', '', base_url().'gerenciador/logTabelas/listaLogTabela/'.$esquema.'/'.$tabela, array('autoload'=> true, 'sortname'=> 'lt.dt_register', 'sortorder' => 'desc', 'autowidth'=> true, 'toppager' => true, 'rowNum' => 25, 'pager'=> true, 'search'=> true, 'caption'=>'Lista de logs da tabela '.$esquema.'.'.$tabela));?>
				<?=addJqGridColumn('id', 'ID', 0, 'right', array('sortable'=>true, 'hidden'=> true));?>
				<?=addJqGridColumn('id_tabela', 'Id Tabela', 40, 'center', array('sortable'=>true, 'index'=>'lt.table_id'));?>
				<?=addJqGridColumn('acao', 'Ação', 80, 'left', array('sortable'=>true, 'index'=>'flg_action'));?>
				<?=addJqGridColumn('campo', 'Campo', 80, 'left', array('sortable'=>true, 'index'=>'lf.field_name'));?>
				<?=addJqGridColumn('valor_antigo', 'Valor anterior', 150, 'left', array('sortable'=>true, 'index'=>'lf.old_value'));?>
				<?=addJqGridColumn('valor_novo', 'Valor atual', 150, 'left', array('sortable'=>true, 'index'=>'lf.new_value'));?>
				<?=addJqGridColumn('dt_registro', 'Dt. registro', 80, 'center', array('sortable'=>true, 'index'=>'lt.dt_register'));?>
			<?=end_JqGridPanel();?>
		<?=end_Tab();?>
	<?=end_TabPanel();?>

<script type="text/javascript">

    function salvar(){
        $('#txtColunas').val(gridColunas.serializeSelectedRows());
        formLogTabela_submit();
    }

    function formLogTabela_callback(data){
        if (data.success == true) {
            messageBox("<?= lang('registroGravado'); ?>");
        } else {
            messageErrorBox("<?= lang('registroNaoGravado'); ?>");
        }
    }

    function gridColunas_loadComplete(){
        var tabela = $('#txtTabela').val();
        $.post(BASE_URL+'gerenciador/logTabelas/buscaColunasLogTabela', {tabela: tabela},
        function(data){
            for (var i = 0; i < data.colunas.length; i++) {
                gridColunas.setSelectRow(data.colunas[i].field_name);
            }
        }, 'json');
    }

</script>

<?=$this->load->view("../../static/_views/footerGlobalView");?>
