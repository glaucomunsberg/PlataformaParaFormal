<?= $this->load->view("../../static/_views/headerGlobalView"); ?>

	<?=path_bread($path_bread);?>

	<?=begin_ToolBar(array('salvar', 'abrir', 'imprimir', 'novo', 'excluir'));?>
	<?=end_ToolBar();?>

	<?=begin_TabPanel();?>
		<?=begin_Tab(lang('pessoaFiltro'));?>
                                <?=form_label('lblNome', lang('colaboradorNome'), 80);?>
				<?=form_textField('txtColaboradorNome', '', 250, '');?>
				<?=new_line();?>

                                <?=form_label('lblCidade', lang('colaboradorCidade'), 80);?>
                                <?= form_textFieldAutoComplete('txtColaboradorCidadeId', BASE_URL . 'paraformalidade/cadastrosBasicos/colaborador/buscarCidade', '', '', 250) ?>
                                <?=new_line();?>

                                <?=form_label('lblEmail', lang('colaboradorEmail'), 80);?>
				<?=form_textField('txtColaboradorEmail', '', 250, '');?>
                <?=end_Tab();?>
	<?=end_TabPanel();?>

	<?=begin_JqGridPanel('gridColaboradores', 'auto', '', base_url().'paraformalidade/cadastrosBasicos/colaborador/listaColaboradores', array('sortname'=> 'nome', 'autowidth'=> true,'multiselect'=>false ,'pager'=> true, 'caption'=>lang('colaboradorCidadeGrid')));?>
		<?=addJqGridColumn('id', 'ID', 0, 'right', array('sortable'=>true, 'hidden'=> true));?>
                <?=addJqGridColumn('nome', lang('colaboradorNome'), 60, 'left', array('sortable'=>true));?>
                <?=addJqGridColumn('email', lang('colaboradorEmail'), 20, 'right', array('sortable'=>true));?>
                <?=addJqGridColumn('nomecidade', lang('colaboradorCidade'), 20, 'center', array('sortable'=>true));?>
	<?=end_JqGridPanel();?>

<script type="text/javascript">    
    function ajuda(){
    	window.open ('<?=WIKI;?>Colaborador');
    }
    
    function pesquisar(){
        gridColaboradores.addParam('txtColaboradorNome', $('#txtColaboradorNome').val());
        gridColaboradores.addParam('txtColaboradorEmail', $('#txtColaboradorEmail').val());
        gridColaboradores.addParam('txtColaboradorCidadeId', $('#txtColaboradorCidadeId').val());
        gridColaboradores.load();
    }
    
    function gridColaboradores_click(id){
        location.href = BASE_URL+'paraformalidade/casdastro/paraformalidade/nova/'+id;
    }
    
</script>

<?= $this->load->view("../../static/_views/footerGlobalView"); ?>
