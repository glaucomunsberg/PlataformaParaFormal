<?=$this->load->view("../../static/_views/headerGlobalView");?>

	<?=path_bread($path_bread);?>

	<?=begin_ToolBar(array( 'abrir', 'novo','excluir','imprimir', 'salvar'));?>
	<?=end_ToolBar();?>

	<?=begin_TabPanel('tabAtividades');?>
		<?=begin_Tab(lang('registroAtividadeFiltro'));?>
			<?=begin_form('paraformalidade/equipe/registroAtividade/salvar', 'formAtividade');?>
                            <?=form_hidden('txtPessoaId', $pessoa->id);?>
                            <?=form_label('lblDtInicio', lang('registroAtividadePeriodo'), 80);?>
                            <?=form_dateField('txtDtInicioRegistro');?>
                            <?=form_label('lblAte', 'à', 15, array('style' => 'text-align: center;'));?>
                            <?=form_dateField('txtDtFimRegistro');?>

			<?=end_form();?>
		<?=end_Tab();?>
                <?=begin_JqGridPanel('gridAtividade', 'auto', '', base_url().'paraformalidade/equipe/verRegistroAtividade/listaRegistrosDeAtividade/', array('sortname'=> 'id', 'sortorder' => 'desc', 'multiselect' => false,'autowidth'=> true, 'autoload'=>false, 'pager'=> true, 'caption'=>lang('registroAtividadeLista')));?>
                        <?=addJqGridColumn('id', 'ID', 0, 'right', array('sortable'=>true, 'hidden'=> true));?>
                        <?=addJqGridColumn('entrada_saida', lang('registroAtividadeEntradaSaída'), 20, 'center', array('sortable'=>true));?>
                        <?=addJqGridColumn('atividade', lang('registroAtividadeAtividade'), 200, 'left', array('sortable'=>true));?>
                        <?=addJqGridColumn('dt_cadastro', lang('registroAtividadeDtCadastro'), 30, 'center', array('sortable'=>true, 'formatter' => 'datetime'));?>
                <?=end_JqGridPanel();?>
	<?=end_TabPanel();?>

<?=$this->load->view("../../static/_views/footerGlobalView");?>

<script>

	function init(){
            	gridAtividade.addParam('pessoaId', $('#txtPessoaId').val());
		gridAtividade.load();
	}

	function ajuda(){
    	window.open ('<?=WIKI;?>ver Atividade Registrada');
        }
        
        function pesquisar(){
            gridAtividade.addParam('dt_inicio', $('#txtDtInicioRegistro').val());
            gridAtividade.addParam('dt_fim', $('#txtDtFimRegistro').val());
            gridAtividade.addParam('pessoaId', $('#txtPessoaId').val());
            gridAtividade.load();
	}
</script>