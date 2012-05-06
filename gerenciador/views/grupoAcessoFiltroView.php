<?=$this->load->view("../../static/_views/headerGlobalView");?>

	<?=path_bread($path_bread);?>

	<?=begin_ToolBar(array('salvar', 'abrir', 'imprimir', 'ajuda'))?>
	<?=end_ToolBar()?>

	<?=begin_TabPanel();?>
		<?=begin_Tab('Filtro');?>
			<?=form_label('lblNome', 'Nome', 80);?>
			<?=form_textField('txtNome', '', 300);?>
		<?=end_Tab();?>
	<?=end_TabPanel();?>

	<?=begin_JqGridPanel('gridGrupoAcesso', 'auto', '', base_url().'gerenciador/grupoAcesso/listaGrupos', array('sortname'=> 'nome', 'autowidth'=> true, 'toppager' => false, 'rowNum' => 25, 'pager'=> true, 'caption'=>'Lista de Grupos de acesso'));?>
		<?=addJqGridColumn('id', 'ID', 0, 'right', array('sortable'=>true, 'hidden'=> true));?>
		<?=addJqGridColumn('nome', 'Nome', 300, 'left', array('sortable'=>true));?>
		<?=addJqGridColumn('dt_cadastro', 'Dt. cadastro', 80, 'center', array('sortable'=>true));?>
	<?=end_JqGridPanel();?>

<script type="text/javascript">

    function novo(){
        location.href = BASE_URL+'gerenciador/grupoAcesso/novo';
    }

    function gridGrupoAcesso_click(id){
        location.href = BASE_URL+'gerenciador/grupoAcesso/editar/'+id;
    }

</script>

<?=$this->load->view("../../static/_views/footerGlobalView");?>
