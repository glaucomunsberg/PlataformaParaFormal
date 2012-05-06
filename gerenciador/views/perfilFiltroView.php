<?= $this->load->view("../../static/_views/headerGlobalView");?>

	<?=path_bread($path_bread);?>

	<?=begin_ToolBar(array('salvar', 'abrir', 'imprimir', 'ajuda'));?>
	<?=end_ToolBar();?>

	<?=begin_JqGridPanel('gridPerfil', 'auto', '', base_url().'gerenciador/perfil/listaPerfis/', array('sortname'=> 'nome_perfil', 'pager'=> true, 'autowidth'=> true, 'caption'=> 'Lista de Módulos'));?>
		<?=addJqGridColumn('id', 'ID', 0, 'right', array('sortable'=>true, 'hidden'=> true));?>
		<?=addJqGridColumn('nome_perfil', lang('perfilNome'), 300, 'left', array('sortable'=>true));?>
		<?=addJqGridColumn('flg_ativo', lang('perfilAtivo'), 50, 'center', array('sortable'=>true));?>
		<?=addJqGridColumn('dt_cadastro', lang('perfilDtCadastro'), 80, 'center', array('sortable'=>false));?>
	<?=end_JqGridPanel();?>

<script type="text/javascript">

    function pesquisar(){
        $("#gridPerfil").setGridParam().trigger("reloadGrid");
    }

    function novo(){
        location.href = BASE_URL+'gerenciador/perfil/novo';
    }

    function excluir(){
        if (getSelectedRows('gridPerfil').length == 0) {
            messageErrorBox('<?= lang('nenhumRegistroSelecionado') ?>');
        } else {
            messageConfirm('<?= lang('excluirRegistros') ?>', confirmaExcluirPerfil);
        }
    }

    function confirmaExcluirPerfil(excluirPerfil){
        if (excluirPerfil) {
            var perfis
            var perfisGrid = getSelectedRows('gridPerfil');
            for(var i = 0; i < perfisGrid.length; i++){
                if (perfis == '') {
                    perfis = perfisGrid[i];
                } else {
                    perfis += ',' + perfisGrid[i];
                }
            }
            $.post(BASE_URL+'gerenciador/perfil/excluir/', {perfis: perfis}, perfilExcluido);
        }
    }

    function perfilExcluido(data){
        if (data.success) {
            messageBox("<?= lang('registroExcluido') ?>", pesquisar);
        } else {
            messageErrorBox("<?= lang('registroNaoExcluido') ?>");
        }
    }

    function gridPerfil_click(id){
        location.href = BASE_URL+'gerenciador/perfil/editar/'+id;
    }

</script>

<?= $this->load->view("../../static/_views/footerGlobalView");?>
