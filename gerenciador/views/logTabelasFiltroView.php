<?=$this->load->view("../../static/_views/headerGlobalView");?>

	<?=path_bread($path_bread);?>
	
	<?=begin_ToolBar(array('novo', 'excluir', 'salvar', 'abrir', 'imprimir', 'ajuda'))?>
	<?=end_ToolBar()?>

	<?=begin_TabPanel();?>
		<?=begin_Tab('Filtro');?>
			<?=form_label('lblTabela', 'Tabela', 80);?>
			<?=form_textField('txtTabela', '', 300);?>
		<?=end_Tab();?>
	<?=end_TabPanel();?>

	<?=begin_JqGridPanel('gridTabelas', 'auto', '', base_url().'gerenciador/logTabelas/listaTabelas', array('sortname'=> 'table_name', 'autowidth'=> true, 'toppager' => true, 'rowNum' => 25, 'pager'=> true, 'caption'=>'Lista de tabelas do sistema'));?>
		<?=addJqGridColumn('id', 'ID', 0, 'right', array('sortable'=>true, 'hidden'=> true));?>
		<?=addJqGridColumn('table_schema', 'table_schema', 100, 'left', array('sortable'=>true));?>
		<?=addJqGridColumn('table_name', 'table_name', 300, 'left', array('sortable'=>true));?>
	<?=end_JqGridPanel();?>

<?=$this->load->view("../../static/_views/footerGlobalView");?>

<script type="text/javascript">

	function gridTabelas_click(id){
		var esquema = id.split('chr9')[0];
		var tabela = id.split('chr9')[1];
		location.href = BASE_URL+'gerenciador/logTabelas/editar/'+esquema+'/'+tabela;
	}

	function pesquisar(){
		gridTabelas.addParam('tabela', $('#txtTabela').val());
		gridTabelas.load();
	}

</script>