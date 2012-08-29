<?= $this->load->view("../../static/_views/headerGlobalView"); ?>

	<?=path_bread($path_bread);?>

	<?=begin_ToolBar(array('salvar', 'abrir', 'imprimir', 'excluir'));?>
	<?=end_ToolBar();?>

	<?=begin_TabPanel(45);?>
		<?=begin_Tab(lang('pessoaFiltro'));?>
			<?=form_label('lblNome', lang('pessoaNome'), 80);?>
			<?=form_textField('txtNome', '', 300, '');?>
			<?=new_line();?>
			<?=form_label('lblNome', 'Pessoa Tipo', 80);?>
			<?=form_combo('cmbPessoaTipo', @$cmbPessoaTipo, '', 200);?>
		<?=end_Tab();?>
	<?=end_TabPanel();?>
        <?=begin_JqGridPanel('gridPessoa', 'auto', '', base_url().'gerenciador/pessoa/listaPessoas/', array('sortname'=> 'nome', 'autowidth'=> true, 'pager'=> true, 'caption'=>lang('pessoaListaPessoas')));?>
		<?=addJqGridColumn('id', 'ID', 0, 'right', array('sortable'=>true, 'hidden'=> true));?>
                <?=addJqGridColumn('nome', 'Nome', 60, 'left', array('sortable'=>true));?>
                <?=addJqGridColumn('tipo', 'tipo', 25, 'left', array('sortable'=>true));?>
		<?=addJqGridColumn('dt_cadastro', 'Dt_cadastro', 15, 'center', array('sortable'=>true));?>
	<?=end_JqGridPanel();?>

<script type="text/javascript">
    function ajuda(){
    	window.open ('<?=WIKI;?>Pessoas');
    }
    
    function pesquisar(){
        
        gridPessoa.addParam('txtNome', txtNome.val());
        gridPessoa.addParam('cmbComboTipoPessoa', cmbPessoaTipo.val());
        gridPessoa.load();
    }
    
    function gridPessoa_click(id){
        location.href = BASE_URL+'gerenciador/pessoa/editar/'+id;
    }
    
    function novo(){
        location.href = BASE_URL+'gerenciador/pessoa/novo/';
    }
</script>

<?= $this->load->view("../../static/_views/footerGlobalView"); ?>
