<?=begin_ToolBar(array('imprimir', 'abrir', 'ajuda', 'pesquisar', 'voltar-pagina', 'novo', 'excluir'));?>
<?=end_ToolBar()?>

<?=begin_TabPanel('tabPermissoes');?>
	<?=begin_Tab(lang('usuarioTab3'));?>
		<?=form_hidden('txtProgramaId', $programaId);?>
		<?=form_hidden('txtGrupoAcessoId', $grupoAcessoId);?>
		<?=begin_JqGridPanel('gridClasseMetodo', 150, '', base_url().'gerenciador/grupoAcesso/listaMetodosGrid/'.$programaId.'/', array('autoload'=> true, 'sortname'=> 'classe', 'pager'=>false, 'autowidth'=> true, 'caption'=> lang('usuarioListaPermissoes')));?>
			<?=addJqGridColumn('id', 'ID', 0, 'right', array('hidden'=> true));?>
			<?=addJqGridColumn('classe', lang('usuarioPermissaoClasse'), 200, 'left');?>
			<?=addJqGridColumn('metodo', lang('usuarioPermissaoMetodo'), 200, 'left');?>
			<?=addJqGridColumn('privado', lang('usuarioPermissaoPrivado'), 60, 'center');?>
		<?=end_JqGridPanel();?>
	<?=end_Tab();?>
<?=end_TabPanel();?>

<script type="text/javascript">

    function salvarPopUp(){
        $.post(BASE_URL+'gerenciador/grupoAcesso/salvarPermissoes/', {grupoAcessoId: $('#txtGrupoAcessoId').val(), programaId: $('#txtProgramaId').val(), metodos: gridClasseMetodo.serializeSelectedRows()},
        function(data){
            if (data.success == 'true') {
                messageBox("<?= lang('registroGravado'); ?>");
            } else {
                messageErrorBox("<?= lang('registroNaoGravado'); ?>");
            }
        });
    }

    function gridClasseMetodo_loadComplete(){
        var programaId = $('#txtProgramaId').val();
        var grupoAcessoId = $('#txtGrupoAcessoId').val();
        $.post(BASE_URL+'gerenciador/grupoAcesso/listaMetodosGrupoAcesso', {grupoAcessoId: grupoAcessoId, programaId: programaId},
        function(data){
            for (var i = 0; i < data.grupoAcessoPermissoes.length; i++) {
                gridClasseMetodo.setSelectRow(data.grupoAcessoPermissoes[i].sys_metodo_id);
            }
        }, 'json');
    }

</script>