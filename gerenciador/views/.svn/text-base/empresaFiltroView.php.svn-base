<?=$this->load->view("../../static/_views/headerGlobalView");?>

	<?=path_bread($path_bread);?>

	<?=begin_ToolBar(array('salvar', 'abrir', 'imprimir', 'ajuda'));?>
	<?=end_ToolBar();?>

	<?=begin_TabPanel();?>
		<?=begin_Tab(lang('empresaFiltro'));?>
			<?=form_label('lblNome', lang('empresaNome'), 80);?>
			<?=form_textField('txtNome', '', 300, '');?>
		<?=end_Tab();?>
	<?=end_TabPanel();?>

	<?=begin_JqGridPanel('gridEmpresa', 'auto', '', base_url().'gerenciador/empresa/listaEmpresas/', array('sortname'=> 'nome', 'autowidth'=> true, 'caption'=> 'Lista de Setores'));?>
		<?=addJqGridColumn('id', 'ID', 0, 'right', array('sortable'=>true, 'hidden'=> true));?>
		<?=addJqGridColumn('nome', 'Nome', 300, 'left', array('sortable'=>true));?>
		<?=addJqGridColumn('dt_cadastro', 'Dt. cadastro', 80, 'center', array('sortable'=>true));?>
	<?=end_JqGridPanel();?>

<script type="text/javascript">

    function pesquisar(){
        var nomeEmpresa = $('#txtNome').val();
        $("#gridEmpresa").setGridParam({url:BASE_URL+'gerenciador/empresa/listaEmpresas/?nomeEmpresa='+nomeEmpresa,page:1}).trigger("reloadGrid");
    }

    function novo(){
        location.href = BASE_URL+'gerenciador/empresa/novo';
    }

    function gridEmpresa_click(id){
        location.href = BASE_URL+'gerenciador/empresa/buscar/'+id;
    }

    function excluir(){
        if (getSelectedRows('gridEmpresa').length == 0) {
            messageErrorBox('Nenhum registro selecionado');
        } else {
            messageConfirm('Deseja excluir os registros selecionados ?', excluirEmpresa);
        }
    }

    function excluirEmpresa(confirmaExclusao){
        if (confirmaExclusao) {
            var empresas
            var empresasGrid = getSelectedRows('gridEmpresa');
            for (var i = 0; i < empresasGrid.length; i++) {
                if (empresas == '') {
                    empresas = empresasGrid[i];
                } else {
                    empresas += ',' + empresasGrid[i];
                }
            }
            $.post(BASE_URL+'gerenciador/empresa/excluir/', {empresas: empresas}, empresaExcluida);
        }
    }

    function empresaExcluida(data){
        if (data.success) {
            messageBox("<?= lang('registroExcluido') ?>", pesquisar);
        } else {
            messageErrorBox("<?= lang('registroNaoExcluido') ?>");
        }
    }

</script>

<?=$this->load->view("../../static/_views/footerGlobalView");?>
