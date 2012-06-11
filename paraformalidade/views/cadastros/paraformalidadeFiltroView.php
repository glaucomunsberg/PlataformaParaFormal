<?= $this->load->view("../../static/_views/headerGlobalView"); ?>

	<?=path_bread($path_bread);?>

	<?=begin_ToolBar(array('salvar', 'abrir', 'imprimir', 'novo', 'excluir'));?>
	<?=end_ToolBar();?>

	<?=begin_TabPanel();?>
		<?=begin_Tab(lang('paraformalidadesFiltro'));?>

                    <?=form_label('lblCidade', lang('paraformalidadesCidade'), 80);?>
                    <?=form_textFieldAutoComplete('txtGrupoAtividadeCidadeId', BASE_URL . 'paraformalidade/cadastrosBasicos/colaborador/buscarCidade', '', '', 260) ?>
                    <?=new_line();?>

                <?=end_Tab();?>
	<?=end_TabPanel();?>

	<?=begin_JqGridPanel('gridGrupoAtividade', 'auto', '', base_url().'paraformalidade/cadastros/grupoAtividade/listaGruposAtividades/', array('sortname'=> 'dt_ocorrencia', 'autowidth'=> true,'multiselect'=> false, 'pager'=> true, 'caption'=>lang('grupoAtividadeLista')));?>
		<?=addJqGridColumn('id', 'ID', 0, 'right', array('sortable'=>true, 'hidden'=> true));?>
		<?=addJqGridColumn('descricao', lang('grupoAtividadeDescricao'), 70, 'left', array('sortable'=>false));?>
                <?=addJqGridColumn('nomecidade', lang('grupoAtividadeCidade'), 20, 'left', array('sortable'=>true));?>
		<?=addJqGridColumn('dt_ocorrencia', lang('grupoAtividadeDtCadastro'), 10, 'center', array('sortable'=>true));?>
	<?=end_JqGridPanel();?>

<script type="text/javascript">    
    function ajuda(){
    	window.open ('<?=WIKI;?>Colaborador');
    }
    
    function pesquisar(){
            gridGrupoAtividade.addParam('txtGrupoAtividadeCidadeId', $('#txtGrupoAtividadeCidadeId').val());
            gridGrupoAtividade.load();
    }
    
    function form_MapWithMarker_position(lat,longi){
        $('#txtLatitude').val(lat);
        $('#txtLongitude').val(longi);
    }
    
    function gridGrupoAtividade_click(id){
        location.href = BASE_URL+'paraformalidade/cadastros/paraformalidade/verParaformalidades/'+id;
    }
    
</script>

<?= $this->load->view("../../static/_views/footerGlobalView"); ?>
