<?=$this->load->view("../../static/_views/headerGlobalView");?>

	<?=begin_ToolBar(array('imprimir', 'abrir', 'ajuda', 'pesquisar'));?>
	<?=end_ToolBar();?>

	<?=begin_TabPanel(300);?>
		<?=begin_Tab(lang('gerenciadorRelatorioTab1'));?>
			<?=begin_form('gerenciador/relatorios/salvar', 'formRelatorio');?>
				<?=form_hidden('txtPerfisSelecionados');?>
				<?=form_label('lblCodigo', lang('gerenciadorRelatorioCodigo'), 80);?>
				<?=form_textField('txtRelatorioId', @$relatorio->id, 40, '', 4, array('readonly' => 'true', 'style' => 'text-align:right;',));?>
				<?=new_line();?>
				<?=form_label('lblNome', lang('gerenciadorRelatorioNome'), 80);?>
				<?=form_textField('txtNome', @$relatorio->nome, 450);?>
				<?=new_line();?>
				<?=form_label('lblLink', lang('gerenciadorRelatorioLink'), 80);?>
				<?=form_textField('txtLink', @$relatorio->link, 450, '');?>
				<?=new_line();?>
				<?=form_label('lblModulosAcesso', lang('gerenciadorRelatorioModulosAcesso'), 200, array('style' => 'font-weight: bold;',));?>
				<?=new_line();?>
				<?=begin_GridPanel('gridPerfil', 200, 560, BASE_URL.'gerenciador/relatorios/listaPerfis', array('autoLoad' => true, 'paginador' => false, 'multiSelecao' => true,));?>
					<?=addColumn('nome_perfil', lang('perfilNome'), 513, false, 'left');?>
				<?=end_GridPanel();?>
			<?=end_form();?>
		<?=end_Tab();?>
	<?=end_Tab();?>

<script type="text/javascript">

    function novo(){
        parent.pesquisar();
        location.href = '<?= BASE_URL . 'gerenciador/relatorios/novo'; ?>';
    }

    function salvar(){
        var perfisRelatorio = '';
        var perfisRelatorioGrid = gridPerfil.getSelectionModel().getSelections();
        for (var i = 0; i < perfisRelatorioGrid.length; i++) {
            if (perfisRelatorio == '') {
                perfisRelatorio = perfisRelatorioGrid[i].id;
            } else {
                perfisRelatorio += ',' + perfisRelatorioGrid[i].id;
            }
        }
        $j('#txtPerfisSelecionados').val(perfisRelatorio);
        formRelatorio_submit();
    }

    function gridPerfil_init(){
        if ($j('#txtRelatorioId').val() != '') {
            $j.post('<?= BASE_URL . 'gerenciador/relatorios/listaPerfisRelatorio'; ?>', {relatorioId: $j('#txtRelatorioId').val()},
            function(data){
                var perfisRelatorio = new Array();
                for (var i = 0 ; i < data.perfisRelatorio.length ; i++) {
                    perfisRelatorio[i] = dsgridPerfil.getById(data.perfisRelatorio[i].perfil_id);
                }
                gridPerfil.getSelectionModel().selectRecords(perfisRelatorio);
            });
        }
    }

    function formRelatorio_callback(data){
        if (data.error != undefined) {
            messageErrorBox(data.error.message, 293, 90, data.error.field);
        } else {
            if (data.success != undefined) {
                messageBox(data.success.message, 280, 90, novo);
            }
        }
    }

    function excluir(){
        if ($j('#txtRelatorioId').val() == '') {
            messageBox("<?= lang('nenhumRegistroSelecionado') ?>", 250, 80);
        } else {
            messageConfirm("<?= lang('excluirRegistro') ?>", 370, 80, excluirRelatorio);
        }
    }

    function excluirRelatorio(confirmaExclusao){
        if (confirmaExclusao) {
            $j.post('<?= BASE_URL . 'gerenciador/relatorios/excluir'; ?>', {id: $j('#txtRelatorioId').val()},
            function(data){
                if (data.success) {
                    messageBox("<?= lang('registroExcluido') ?>", 250, 80, novo);
                } else {
                    messageErrorBox("<?= lang('registroNaoExcluido') ?>", 250, 80);
                }
            });
        }
    }

</script>

<?=$this->load->view("../../static/_views/footerGlobalView");?>
