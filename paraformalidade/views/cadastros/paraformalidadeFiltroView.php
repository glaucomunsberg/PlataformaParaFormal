<?= $this->load->view("../../static/_views/headerGlobalView"); ?>

	<?=path_bread($path_bread);?>

	<?=begin_ToolBar(array('salvar', 'abrir', 'imprimir', 'novo', 'excluir'));?>
	<?=end_ToolBar();?>

	<?=begin_TabPanel();?>
		<?=begin_Tab(lang('paraformalidadesFiltro'));?>

                    <?=form_label('lblCidade', lang('paraformalidadesCidade'), 100);?>
                    <?=form_textFieldAutoComplete('txtGrupoAtividadeCidadeId', BASE_URL . 'paraformalidade/cadastros/colaboradores/buscarCidade', '', '', 260) ?>
                    <?=new_line();?>

                    <?=form_label('lblNome', lang('grupoAtividadeGrup'), 100);?>
                    <?=form_textField('txtAtividadeNome', '', 260, '');?>
                    <?=new_line();?>

                    <?=form_label('lblCena', lang('cenasCena'), 100);?>
                    <?=form_textField('txtCenaNome', '', 260, '');?>
                    <?=new_line();?>

                <?=end_Tab();?>
	<?=end_TabPanel();?>

        <?=begin_JqGridPanel('gridCenas', 'auto', '', base_url().'paraformalidade/cadastros/cenas/listaCenas/', array('sortname'=> 'descricao', 'multiselect'=>false,'autoload'=>true,'autowidth'=> true, 'pager'=> true, 'caption'=>lang('cenasCenasporGA'),
            'grouping' => true, 'groupingView' => '##{groupField:[\'grupo_atividade\'], groupColumnShow: [false], groupSummary: [false], groupDataSorted: true, groupOrder: [\'desc\'], showSummaryOnHide: false, groupText : [\'<b style="display: block; float: left; margin: 2px;">{0}</b>\']}##'));?>
                <?=addJqGridColumn('id', 'ID', 0, 'right', array('sortable'=>true, 'hidden'=> true));?>
                <?=addJqGridColumn('grupo_atividade', 'Ano/Período', 20, 'center', array('hidden' => true));?>
                <?=addJqGridColumn('descricao', lang('cenasDescricao'), 70, 'left', array('sortable'=>true));?>
                <?=addJqGridColumn('estaativo', lang('cenasEstaAtivo'), 10, 'center', array('sortable'=>true));?>
                <?=addJqGridColumn('dt_ocorrencia', lang('cenasDtOcorrencia'), 10, 'center', array('sortable'=>true));?>
        <?=end_JqGridPanel();?>

<script type="text/javascript">    
    function ajuda(){
    	window.open ('<?=WIKI;?>Paraformalidade');
    }
    
    function pesquisar(){
            gridCenas.addParam('txtGrupoAtividadeCidadeId', $('#txtGrupoAtividadeCidadeId').val());
            gridCenas.addParam('txtAtividadeNome', $('#txtAtividadeNome').val());
            gridCenas.addParam('txtCenaNome', $('#txtCenaNome').val());
            gridCenas.load();
    }
    
    function form_MapWithMarker_position(lat,longi){
        $('#txtLatitude').val(lat);
        $('#txtLongitude').val(longi);
    }
    
    function gridCenas_click(id){
        location.href = BASE_URL+'paraformalidade/cadastros/paraformalidade/paraformalidadesDaCena/'+id;
    }
    
</script>

<?= $this->load->view("../../static/_views/footerGlobalView"); ?>
