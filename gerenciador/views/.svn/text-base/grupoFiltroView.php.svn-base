<?= $this->load->view("../../static/_views/headerGlobalView");?>

	<?=path_bread($path_bread);?>

	<?=begin_ToolBar(array('salvar', 'abrir', 'imprimir', 'ajuda'))?>
	<?=end_ToolBar()?>

	<?=begin_TabPanel(72)?>
		<?=begin_Tab(lang('grupoFiltro'))?>
			<?=form_label('lblEmpresa', lang('grupoEmpresa'), 80)?>
			<?=form_combo('cmbEmpresa', $empresas, '', 302)?>
			<?=new_line()?>
			<?=form_label('lblNome', lang('grupoNome'), 80)?>
			<?=form_textField('txtNome', '', 300)?>
			<?=new_line()?>
			<?=form_label('lblDtCadastro', lang('grupoDtCadastro'), 80)?>
			<?=form_dateField('dtCadastro')?>
		<?=end_Tab()?>
	<?=end_TabPanel()?>

	<?=begin_GridPanel('gridGrupo', '', '', base_url().'index.php/gerenciador/grupo/listaGrupos', true, true)?>
		<?=addColumn('empresa', lang('grupoEmpresa'), 250, true, 'left')?>
		<?=addColumn('nome', lang('grupoNome'), 100, true, 'left', true)?>
		<?=addColumn('dt_cadastro', lang('grupoDtCadastro'), 100, true, 'center')?>
	<?=end_GridPanel()?>

<script type="text/javascript">
    function pesquisar(){
        var idEmpresa = document.getElementById("cmbEmpresa").value;
        var nomeGrupo = document.getElementById("txtNome").value;
        var dataCadastro = document.getElementById("dtCadastro").value;
        dsgridGrupo.load({params:{start:0, limit:20, empresa_id: idEmpresa, nome: nomeGrupo, data: dataCadastro}});
    }

    function novo(){
        openWindow('<?= lang('grupoTitulo'); ?>', '<?= base_url() . "index.php/gerenciador/grupo/novo" ?>', 610, 490);
    }

    function excluir(){
        var count = gridGrupo.getSelectionModel().getCount();
        if (count > 0) {
            messageConfirm("<?= lang('excluirRegistros') ?>", 380, 80, confirmaExcluirGrupo);
        } else {
            messageBox("<?= lang('nenhumRegistroSelecionado') ?>", 250, 80);
        }
    }

    function confirmaExcluirGrupo(excluirGrupo){
        if (excluirGrupo) {
            grupo = gridGrupo.getSelectionModel().getSelected();
            $j.post("<?= base_url(); ?>index.php/gerenciador/grupo/excluir", {id: grupo.id}, grupoExcluido);
        }
    }

    function grupoExcluido(data){
        if (data.sucess == "false") {
            messageBox("<?= lang('registroNaoExcluido') ?>", 250, 80);
        } else {
            messageBox("<?= lang('registroExcluido') ?>", 250, 80, pesquisar);
        }
    }

    function gridGrupo_dblClick(id){
        openWindow('<?= lang('grupoTitulo'); ?>', '<?= base_url() . "index.php/gerenciador/grupo/buscar/" ?>'+id, 610, 490);
    }

    function gridGrupo_click(id){}
</script>

<?= $this->load->view("../../static/_views/footerGlobalView");?>
