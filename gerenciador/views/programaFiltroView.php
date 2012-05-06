<?= $this->load->view("../../static/_views/headerGlobalView"); ?>

	<?=path_bread($path_bread);?>

	<?=begin_ToolBar(array('abrir', 'salvar'));?>
	<?=end_ToolBar();?>

	<?=begin_TabPanel();?>
		<?=begin_Tab(lang('programaFiltro'));?>
			<?=form_label('lblNome', lang('programaNome'), 80);?>
			<?=form_textField('txtNome', '', 300, '');?>
		<?=end_Tab();?>
	<?=end_TabPanel();?>

	<?=begin_JqGridPanel('gridPrograma', 'auto', '', base_url().'gerenciador/programa/listaProgramas/', array('sortname'=> 'nome', 'autowidth'=> true, 'pager'=> true, 'caption'=>'Lista de Programas'));?>
		<?=addJqGridColumn('id', 'ID', 0, 'right', array('sortable'=>true, 'hidden'=> true));?>
		<?=addJqGridColumn('nome', 'Nome', 300, 'left', array('sortable'=>true));?>
		<?=addJqGridColumn('link', 'Link', 200, 'left', array('sortable'=>true));?>
		<?=addJqGridColumn('dt_cadastro', 'Dt. cadastro', 100, 'center', array('sortable'=>true));?>
	<?=end_JqGridPanel();?>

<script type="text/javascript">

    function pesquisar(){
        var nome = $("#txtNome").val();
        $("#gridPrograma").setGridParam({url:BASE_URL+'gerenciador/programa/listaProgramas/?nome='+nome,page:1}).trigger("reloadGrid");
    }

    function novo(){
        location.href = BASE_URL+'gerenciador/programa/novo';
    }

    function imprimir(){
        location.href = BASE_URL+'gerenciador/programa/imprimir';
    }

    function gridPrograma_click(id){
        location.href = BASE_URL+'gerenciador/programa/editar/'+id;
    }

    function excluir(){
        if (getSelectedRows('gridPrograma').length == 0) {
            messageErrorBox('<?= lang('nenhumRegistroSelecionado') ?>');
        } else {
            messageConfirm('<?= lang('excluirRegistros') ?>', excluirProgramas);
        }
    }

    function excluirProgramas(confirmaExclusao){
        if (confirmaExclusao) {
            var programas
            var programasGrid = getSelectedRows('gridPrograma');
            for (var i = 0; i < programasGrid.length; i++) {
                if (programas == '') {
                    programas = programasGrid[i];
                } else {
                    programas += ',' + programasGrid[i];
                }
            }
            $.post(BASE_URL+'gerenciador/programa/excluir/', {id: programas},
            function(data){
                if (data.success) {
                    messageBox("<?= lang('registroExcluido') ?>", pesquisar);
                } else {
                    messageErrorBox("<?= lang('registroNaoExcluido') ?>");
                }
            });
        }
    }

</script>

<?= $this->load->view("../../static/_views/footerGlobalView"); ?>
