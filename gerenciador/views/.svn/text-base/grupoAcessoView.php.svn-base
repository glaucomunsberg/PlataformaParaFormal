<?=$this->load->view("../../static/_views/headerGlobalView");?>

	<?=path_bread($path_bread);?>

	<?=begin_ToolBar(array('imprimir', 'abrir', 'ajuda', 'pesquisar'));?>
	<?=end_ToolBar();?>

	<?=begin_TabPanel();?>
		<?=begin_Tab('Grupo acesso');?>
			<?=begin_form('gerenciador/grupoAcesso/salvarGrupoAcesso', 'formGrupoAcesso');?>
				<?=form_hidden('txtGrupoAcessoId', @$grupoAcesso->id);?>

				<?=form_label('lblNome', 'Nome', 80);?>
				<?=form_textField('txtNome', @$grupoAcesso->nome, 300, '');?>

			<?=end_form();?>
		<?=end_Tab();?>
		<?=begin_Tab('Setores/Módulos');?>
			<?=begin_form('gerenciador/grupoAcesso/salvarGrupoAcessoEmpresa', 'formGrupoAcessoEmpresa');?>
				<?=form_hidden('txtGrupoAcessoIdEmpresa', @$grupoAcesso->id);?>
				<?=form_hidden('txtPerfis');?>

				<?=form_label('lblSetor', 'Setor', 100);?>
				<?=form_combo('cmbSetor', $empresas, '', 304);?>
				<?=new_line();?>

				<?=begin_JqGridPanel('gridEmpresa', 'auto', '', base_url().'gerenciador/grupoAcesso/listaEmpresas', array('autoload'=> false, 'sortname'=> 'nome', 'autowidth'=> true, 'caption'=> 'Setores'));?>
					<?=addJqGridColumn('id', 'ID', 0, 'right', array('hidden'=> true));?>
					<?=addJqGridColumn('nome', 'Nome', 440, 'left');?>
				<?=end_JqGridPanel();?>
				<?=new_line();?>

				<?=form_button('btnNovoEmpresa', lang('novo').' setor', 'novoEmpresa()');?>
				<?=form_button('btnIncluirEmpresa', lang('incluir').' setor', 'incluirEmpresa()');?>
				<?=form_button('btnExcluirEmpresa', lang('excluir').' setor', 'excluirEmpresa()');?>
				<?=new_line();?>
			<?=end_form();?>

			<?=begin_JqGridPanel('gridPerfil', 'auto', '', base_url().'gerenciador/empresa/listaPerfisEmpresaGrid', array('autoload'=> false, 'sortname'=> 'nome_perfil', 'autowidth'=> true, 'caption'=> 'Perfis'));?>
				<?=addJqGridColumn('id', 'ID', 0, 'right', array('hidden'=> true));?>
				<?=addJqGridColumn('nome_perfil', lang('usuarioPerfil'), 520, 'left');?>
			<?=end_JqGridPanel();?>
			<?=new_line();?>

			<?=form_button('btnSalvarPerfis', lang('salvar'). ' perfis', 'salvarPerfis()');?>
		<?=end_Tab();?>
		<?=begin_Tab('Permissões');?>
			<?=begin_form('gerenciador/grupoAcesso/salvarGrupoAcessoPrograma', 'formGrupoAcessoPrograma');?>
				<?=form_hidden('txtGrupoAcessoIdPrograma', @$grupoAcesso->id);?>

				<?=begin_ToolBar(array('imprimir', 'abrir', 'ajuda', 'pesquisar', 'voltar-pagina', 'novo', 'salvar', 'excluir'));?>
					<?=addButtonToolBar('Marcar/Desmarcar todos programas', 'marcarDesmarcarTodos()', 'btnMarcarDesmarcarTodos', 'ui-icon-check');?>
				<?=end_ToolBar();?>

				<ul id="permissao_aplicativos" class="ui-widget treeview-gray" style="white-space: nowrap; background-color:none !important; overflow: auto !important">
					<li class="no-tabs">
						<span>/</span>
						<ul style="background: none !important;">
							<?=$permissao_aplicativos;?>
						</ul>
					</li>
				</ul>
			<?=end_form();?>
		<?=end_Tab();?>
	<?=end_TabPanel();?>

<script type="text/javascript">

    var loadGridEmpresa = false;
    var programasChecked = false;

    function init(){
        $('.permissoes').button({text: false, icons: {primary: 'ui-icon-wrench'}}).live('click', function(){
            $('button').blur();
            openWindow(BASE_URL+'gerenciador/grupoAcesso/permissoes/'+this.id, '<?= lang('usuarioTab3'); ?> - ' + $('#p-'+this.id).text(), 700, false);
        });

        if ($('#txtGrupoAcessoId').val() == '') {
            $("#tab").tabs( "option", "disabled", [1, 2]);
        }
    }

    function enableTabs(){
        $('#tab').tabs("option","disabled",[]);
    }

    function tabShow(index){
        if(index == 1 && $('#txtGrupoAcessoId').val() != '' && !loadGridEmpresa){
            loadGridEmpresa = true;
            gridEmpresa.addParam('grupo_acesso_id', $('#txtGrupoAcessoId').val());
            gridEmpresa.load();
        }
    }

    function novo(){
        location.href = BASE_URL+'gerenciador/grupoAcesso/novo';
    }

    function salvar(){
        switch($("#tab").tabs("option", "selected")){
            case 0:
                formGrupoAcesso_submit();
                break;
            case 2:
                formGrupoAcessoPrograma_submit();
                break;
        }
    }

    function formGrupoAcesso_callback(data){
        if(data.error != undefined){
            messageErrorBox(data.error.message, data.error.field);
        }else{
            if(data.success != undefined) {
                $('#txtGrupoAcessoId').val(data.grupoAcesso.id);
                $('#txtGrupoAcessoIdEmpresa').val(data.grupoAcesso.id);
                $('#txtGrupoAcessoIdPrograma').val(data.grupoAcesso.id);
                messageBox(data.success.message, enableTabs);
            }
        }
    }

    function novoEmpresa(){
        cmbSetor.setValueCombo();
        gridEmpresa.addParam('grupo_acesso_id', $('#txtGrupoAcessoId').val());
        gridEmpresa.load();
        gridPerfil.clearGridData();
    }

    function incluirEmpresa(){
        formGrupoAcessoEmpresa_submit();
    }

    function formGrupoAcessoEmpresa_callback(data){
        if(data.error != undefined) {
            messageErrorBox(data.error.message, data.error.field);
        } else {
            if (data.success != undefined) {
                messageBox(data.success.message, novoEmpresa);
            }
        }
    }

    function excluirEmpresa(){
        if (gridEmpresa.getSelectedRows().length == 0) {
            messageErrorBox('<?= lang('nenhumRegistroSelecionado') ?>');
        } else {
            messageConfirm('<?= lang('excluirRegistros') ?>', confirmaExcluirEmpresa);
        }
    }

    function confirmaExcluirEmpresa(confirma){
        if(confirma){
            var grupoAcessoId = $('#txtGrupoAcessoIdEmpresa').val();
            var empresaId = $('#cmbSetor').val();
            $.post(BASE_URL+'gerenciador/grupoAcesso/excluirEmpresa', {grupoAcessoId: grupoAcessoId, empresaId: empresaId},
            function(data){
                if (data.success == 'false') {
                    messageErrorBox("<?= lang('registroNaoExcluido') ?>");
                } else {
                    messageBox("<?= lang('registroExcluido') ?>", novoEmpresa);
                }
            }, 'json');
        }
    }

    function gridEmpresa_click(id){
        var grupoAcessoId = id.split("chr", 2)[0];
        var empresaId = id.split("chr", 2)[1];

        $('#txtGrupoAcessoIdEmpresa').val(grupoAcessoId);
        cmbSetor.setValueCombo(empresaId);
        gridPerfil.addParam('empresaId', empresaId);
        gridPerfil.load();
    }

    function gridPerfil_loadComplete(){
        var grupoAcessoId = $('#txtGrupoAcessoIdEmpresa').val();
        var empresaId = $('#cmbSetor').val();
        if(grupoAcessoId != '' && empresaId != '')
            $.post(BASE_URL+'gerenciador/grupoAcesso/listaPerfisGrupoAcesso', {grupoAcessoId: grupoAcessoId, empresaId: empresaId},
        function(data){
            for (var i = 0; i < data.grupoAcessoPerfis.length; i++) {
                gridPerfil.setSelectRow(data.grupoAcessoPerfis[i].id);
            }
        }, 'json');
    }

    function salvarPerfis(){
        $('#txtPerfis').val(gridPerfil.serializeSelectedRows());
        $.post(BASE_URL+'gerenciador/grupoAcesso/salvarPerfis',
        {empresaId: $('#cmbSetor').val(), perfisId: $("#txtPerfis").val(), grupoAcessoId: $('#txtGrupoAcessoIdEmpresa').val()},
        function(data){
            if (data.success == 'true') {
                messageBox("<?= lang('registroGravado'); ?>");
            } else {
                messageErrorBox("<?= lang('registroNaoGravado'); ?>");
            }
        },'json');
    }

    function formGrupoAcessoPrograma_callback(data){
        if (data.error != undefined) {
            messageErrorBox(data.error.message, data.error.field);
        } else {
            if (data.success != undefined) {
                messageBox(data.success.message);
            }
        }
    }

    function marcarDesmarcarTodos(){
        if (programasChecked) {
            programasChecked = false;
        } else {
            programasChecked = true;
        }
        var programas_acessos = $('input[name="programas_acessos[]"]').get();
        for (var i =0; i < programas_acessos.length; i++) {
            $("#"+programas_acessos[i].id).attr('checked', programasChecked);
        }
    }

</script>

<?= $this->load->view("../../static/_views/footerGlobalView"); ?>
