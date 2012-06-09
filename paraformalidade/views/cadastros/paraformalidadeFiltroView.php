<?= $this->load->view("../../static/_views/headerGlobalView"); ?>

	<?=path_bread($path_bread);?>

	<?=begin_ToolBar(array('salvar', 'abrir', 'imprimir', 'novo', 'excluir'));?>
	<?=end_ToolBar();?>

	<?=begin_TabPanel();?>
		<?=begin_Tab(lang('pessoaFiltro'));?>
                    <?=form_label('lblNome', lang('colaboradorNome'), 80);?>
                    <?=form_textField('txtColaboradorNome', '', 260, '');?>
                    <?=new_line();?>

                    <?=form_label('lblCidade', lang('colaboradorCidade'), 80);?>
                    <?= form_textFieldAutoComplete('txtColaboradorCidadeId', BASE_URL . 'paraformalidade/cadastrosBasicos/colaborador/buscarCidade', '', '', 260) ?>
                    <?=new_line();?>

                    <?=form_label('lblEmail', lang('colaboradorEmail'), 80);?>
                    <?=form_textField('txtColaboradorEmail', '', 260, '');?>
                    <?=new_line();?>

                    <?=form_label('lblEmail', 'Localização', 80);?>
                    <?=form_MapWithMarker('marcador', '-31.771083', '-52.325821', '260', '250', 'map', true, true)?>
                    <?=new_line();?>

                    <?=form_label('lblCidade', 'Lat e Long', 80);?>
                    <?=form_textField('txtLatitude', '', 125, '','','',true);?>
                    <?=form_textField('txtLongitude', '', 125, '','','', true);?>
                    <?=new_line();?>
                <?=end_Tab();?>
	<?=end_TabPanel();?>

	<?=begin_JqGridPanel('gridGrupoAtividade', 'auto', '', base_url().'paraformalidade/cadastros/grupoAtividade/listaGruposAtividades/', array('sortname'=> 'descricao', 'autowidth'=> true, 'pager'=> true, 'caption'=>lang('ponteLista')));?>
		<?=addJqGridColumn('id', 'ID', 0, 'right', array('sortable'=>true, 'hidden'=> true));?>
		<?=addJqGridColumn('descricao', lang('ponteDescricao'), 70, 'left', array('sortable'=>true));?>
                <?=addJqGridColumn('nomecidade', lang('ponteDescricao'), 20, 'left', array('sortable'=>true));?>
		<?=addJqGridColumn('dt_ocorrencia', lang('ponteDtCadastro'), 10, 'center', array('sortable'=>true));?>
	<?=end_JqGridPanel();?>

<script type="text/javascript">    
    function ajuda(){
    	window.open ('<?=WIKI;?>Colaborador');
    }
    
    function pesquisar(){
            gridGrupoAtividade.addParam('txtDescricao', $('#txtDescricao').val());
            gridGrupoAtividade.addParam('Dt_Ocorrencia', $('#Dt_Ocorrencia').val());
            gridGrupoAtividade.addParam('txtGrupoAtividadeCidadeId', $('#txtGrupoAtividadeCidadeId').val());
            gridGrupoAtividade.load();
    }
    
    function form_MapWithMarker_position(lat,longi){
        $('#txtLatitude').val(lat);
        $('#txtLongitude').val(longi);
    }
    
    function gridGrupoAtividade_click(id){
        location.href = BASE_URL+'paraformalidade/casdastro/paraformalidade/nova/'+id;
    }
    
</script>

<?= $this->load->view("../../static/_views/footerGlobalView"); ?>
