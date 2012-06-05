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
                                <?=new_line();?>

                                <?=form_label('lblCidade', 'Localização', 80);?>
                                <?=form_textField('txtLatitude', '', 250, '');?>
                                <?=form_textField('txtLongitude', '', 250, '');?>
                                <?=new_line();?>
                                <?//=form_MapWithMarker('marcador', '-31.771083', '-52.325821', '250', '250', 'map', true, true)?>
                                <?=form_MapWithRoute('MapaWithRoute', '-31.771083', '-52.325821', '-31.771083', '-52.325821', 'map', '400', '400', false) ?>
                                
                <?=end_Tab();?>
	<?=end_TabPanel();?>

	<?=begin_JqGridPanel('gridColaboradores', 'auto', '', base_url().'paraformalidade/cadastros/paraformalidade/listaParaformalidades', array('sortname'=> 'id', 'autowidth'=> true,'multiselect'=>false ,'pager'=> true, 'caption'=>lang('colaboradorCidadeGrid')));?>
		<?=addJqGridColumn('id', 'ID', 0, 'right', array('sortable'=>true, 'hidden'=> true));?>
                <?=addJqGridColumn('descricao', lang('colaboradorNome'), 20, 'left', array('sortable'=>true));?>
                <?=addJqGridColumn('tipo_local_id', lang('colaboradorEmail'), 20, 'right', array('sortable'=>true));?>
                <?=addJqGridColumn('tipo_condicao_ambiental_id', lang('colaboradorCidade'), 20, 'center', array('sortable'=>true));?>
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
    
    function form_MapWithMarker_position(lat,longi){
        $('#txtLatitude').val(lat);
        $('#txtLongitude').val(longi);
    }
    
    function gridColaboradores_click(id){
        location.href = BASE_URL+'paraformalidade/casdastro/paraformalidade/nova/'+id;
    }
    
</script>

<?= $this->load->view("../../static/_views/footerGlobalView"); ?>
