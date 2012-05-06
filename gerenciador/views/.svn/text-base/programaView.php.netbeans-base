<?=$this->load->view("../../static/_views/headerGlobalView");?>

	<?=path_bread($path_bread);?>

	<?=begin_ToolBar(array('imprimir', 'abrir', 'ajuda', 'pesquisar'));?>
	<?=end_ToolBar();?>

	<?=begin_TabPanel();?>
		<?=begin_Tab(lang('programaTab1'));?>
			<?=begin_form('gerenciador/programa/salvar');?>
				<?=form_label('lblCodigo', 'Código', 80);?>
				<?=form_textField('txtCodigo', @$programa->id, 40, '', 4, array('readonly' => 'true', 'style' => 'text-align:right;',));?>
				<?=new_line();?>

				<?=form_label('lblNome', lang('programaNome'), 80);?>
				<?=form_textField('txtNome', @$programa->nome, 400, '');?>
				<?=new_line();?>

				<?=form_label('lblDescricao', lang('programaDescricao'), 80);?>
				<?=form_textField('txtDescricao', @$programa->descricao, 400, '');?>
				<?=new_line();?>

				<?=form_label('lblLink', lang('programaLink'), 80);?>
				<?=form_textField('txtLink', @$programa->link, 400, '');?>
				<?=new_line();?>

				<?=form_label('lblOnClick', lang('programaOnClick'), 80);?>
				<?=form_textField('txtOnClick', @$programa->onclick, 400, '');?>
				<?=new_line();?>

				<?=form_label('lblDtCadastro', lang('programaDtCadastro'), 80);?>
				<?=form_dateField('dtCadastro', @$programa->dt_cadastro, array('disabled' => 'true'));?>
				<?=new_line();?>
			<?=end_form();?>
		<?=end_Tab();?>
		<?=begin_Tab('Parâmetros');?>
			<?=begin_form('gerenciador/programa/salvarProgramaParametro/', 'formProgramaParametro');?>
				<?=form_hidden('txtIdPrograma', @$programa->id);?>
				<?=form_hidden('txtProgramaParametroId');?>

				<?=form_label('lblParametro', 'Parâmetro', 80);?>
				<?=form_textField('txtParametro', '', 400, '');?>
				<?=new_line();?>

				<?=begin_JqGridPanel('gridProgramasParametros', 150, '', base_url().'gerenciador/programa/listaParametrosProgramas/',
					array('autoload'=> false, 'sortname'=> 'nome', 'autowidth'=> true, 'multiselect' => true, 'caption'=> 'Lista de Parâmetros'));?>
					<?=addJqGridColumn('id', 'ID', 0, 'right', array('hidden'=> true));?>
					<?=addJqGridColumn('nome', 'Parâmetro', 600, 'left');?>
				<?=end_JqGridPanel();?>

				<?=form_button('btnNovoProgramaParametro', lang('novo').' parâmetro', 'novoProgramaParametro()');?>
				<?=form_button('btnIncluirProgramaParametro', lang('incluir').' parâmetro', 'incluirProgramaParametro()');?>
				<?=form_button('btnExcluirProgramaParametro', lang('excluir').' parâmetro', 'excluirProgramaParametro()');?>
				<?=new_line();?>
			<?=end_form();?>
		<?=end_Tab();?>
	<?=end_TabPanel();?>

<script type="text/javascript">

    var loadGridProgramasParametros = false;

    function init(){
        if ($('#txtCodigo').val() == '') {
            $("#tab").tabs('disable', 1);
        }
    }

    function tabShow(index){
        if (index == 1 && $('#txtCodigo').val() != '' && !loadGridProgramasParametros) {
            loadGridProgramasParametros = true;
            $("#gridProgramasParametros").setGridParam({url:BASE_URL+'gerenciador/programa/listaParametrosProgramas/?programaId='+$('#txtCodigo').val(), page:1}).trigger("reloadGrid");
        }
    }

    function novo(){
        location.href = BASE_URL+'gerenciador/programa/novo';
    }

    function salvar(){
        formDefault_submit();
    }

    function formDefault_callback(data){
        if (data.error != undefined) {
            messageErrorBox(data.error.message, data.error.field);
        } else {
            if (data.success != undefined) {
                $('#txtCodigo').val(data.programa.id);
                $('#txtIdPrograma').val(data.programa.id);
                $('#dtCadastro').val(data.programa.dt_cadastro);
                messageBox(data.success.message);
            }
        }
    }

    function excluir(){
        if ($('#txtCodigo').val() == '') {
            messageErrorBox("<?= lang('nenhumRegistroSelecionado') ?>");
        } else {
            messageConfirm('<?= lang('excluirRegistros') ?>', excluirPrograma);
        }
    }

    function excluirPrograma(confirmaExclusao){
        if (confirmaExclusao) {
            $.post(BASE_URL+'gerenciador/programa/excluir', {id: $("#txtCodigo").val()},
            function(data){
                if (data.success) {
                    messageBox("<?= lang('registroExcluido') ?>", novo);
                } else {
                    messageErrorBox("<?= lang('registroNaoExcluido') ?>");
                }
            });
        }
    }

    function incluirProgramaParametro(){
        formProgramaParametro_submit();
    }

    function formProgramaParametro_callback(data){
        if(data.error != undefined){
            messageErrorBox(data.error.message, data.error.field);
        } else {
            if (data.success != undefined) {
                $('#txtProgramaParametroId').val(data.programa_parametro.id);
                messageBox(data.success.message, novoProgramaParametro);
            }
        }
    }

    function excluirProgramaParametro(){
        if (getSelectedRows('gridProgramasParametros').length == 0) {
            messageErrorBox('<?= lang('nenhumRegistroSelecionado') ?>');
        } else {
            messageConfirm('<?= lang('excluirRegistros') ?>', excluirProgramaParametros);
        }
    }

    function excluirProgramaParametros(confirmaExclusao){
        if (confirmaExclusao) {
            var programasParametros
            var programasParametrosGrid = getSelectedRows('gridProgramasParametros');
            for (var i = 0; i < programasParametrosGrid.length; i++) {
                if (programasParametros == '') {
                    programasParametros = programasParametrosGrid[i];
                } else {
                    programasParametros += ',' + programasParametrosGrid[i];
                }
            }
            $.post(BASE_URL+'gerenciador/programa/excluirParametrosProgramas/', {id: programasParametros},
            function(data){
                if (data.success) {
                    messageBox("<?= lang('registroExcluido') ?>", novoProgramaParametro);
                } else {
                    messageErrorBox("<?= lang('registroNaoExcluido') ?>");
                }
            });
        }
    }

    function novoProgramaParametro(){
        $("#txtProgramaParametroId").val('');
        $("#txtParametro").val('');
        $("#gridProgramasParametros").setGridParam({url:BASE_URL+'gerenciador/programa/listaParametrosProgramas/?programaId='+$('#txtCodigo').val(), page:1}).trigger("reloadGrid");
    }

    function gridProgramasParametros_click(id){
        $.post(BASE_URL+'gerenciador/programa/editarProgramaParametro/'+id, '',
        function(data){
            $("#txtProgramaParametroId").val(data.programa_parametro.id);
            $("#txtParametro").val(data.programa_parametro.nome);
        });
    }

</script>

<?=$this->load->view("../../static/_views/footerGlobalView");?>
