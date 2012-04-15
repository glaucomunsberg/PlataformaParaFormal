<?=$this->load->view("../../static/_views/headerGlobalView"); ?>

	<?=path_bread($path_bread);?>

	<?=begin_ToolBar(array('salvar', 'abrir', 'imprimir', 'ajuda', 'excluir'));?>
	<?=end_ToolBar();?>

	<?=begin_GridPanel('gridRelatorios', '', '', BASE_URL.'gerenciador/relatorios/listaRelatorios', array('autoLoad' => true, 'paginador' => false,));?>
		<?=addColumn('nome', lang('gerenciadorRelatorioNome'), 100, true, 'left', array('autoExpandColumn' => true));?>
		<?=addColumn('link', lang('gerenciadorRelatorioLink'), 500, true, 'left');?>
	<?=end_GridPanel();?>

<?=$this->load->view("../../static/_views/footerGlobalView");?>

<script>

	function pesquisar(){
		dsgridRelatorios.reload();
	}

	function gridRelatorios_dblClick(id){
		openWindow('<?=lang('gerenciadorRelatorioTitulo');?>', '<?=BASE_URL.'gerenciador/relatorios/abrir/';?>'+id, 600, 380);
	}

	function novo(){
		openWindow('<?=lang('gerenciadorRelatorioTitulo');?>', '<?=BASE_URL.'gerenciador/relatorios/novo';?>', 600, 380);
	}

</script>