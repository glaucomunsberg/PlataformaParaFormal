<?=$this->load->view("../../static/_views/headerGlobalView");?>

	<?=path_bread($path_bread);?>

	<?=begin_ToolBar(array('abrir', 'salvar', 'imprimir', 'excluir','novo' ));?>
	<?=end_ToolBar();?>

	<?=begin_TabPanel('tabPontes');?>
		<?=begin_Tab(lang('grupoAtividadeFiltro'));?>
			<?=form_label('lblDescricao', lang('grupoAtividadeDescricao'), 80);?>
			<?=form_textField('txtDescricao', '', 300, '');?>
                        <?=new_line();?>

                        <?=form_label('lblCidade', lang('grupoAtividadeCidade'), 80);?>
                        <?= form_textFieldAutoComplete('txtGrupoAtividadeCidadeId', BASE_URL . 'paraformalidade/cadastros/gruposAtividades/buscarCidade', '', '', 300) ?>
                        <?=new_line();?>
                        
                        <?=form_label('lblDtInicio', lang('grupoAtividadeData'), 80);?>
			<?=form_dateField('Dt_Ocorrencia');?>
		<?=end_Tab();?>
	<?=end_TabPanel();?>
	
	<?=begin_JqGridPanel('gridGrupoAtividade', 'auto', '', base_url().'paraformalidade/cadastros/equipesGruposAtividades/listaGruposAtividades/', array('sortname'=> 'descricao', 'autowidth'=> true, 'pager'=> true, 'caption'=>lang('grupoAtividadeLista')));?>
		<?=addJqGridColumn('id', 'ID', 0, 'right', array('sortable'=>true, 'hidden'=> true));?>
		<?=addJqGridColumn('descricao', lang('grupoAtividadeDescricao'), 70, 'left', array('sortable'=>true));?>
                <?=addJqGridColumn('nomecidade', lang('grupoAtividadeCidade'), 20, 'left', array('sortable'=>true));?>
		<?=addJqGridColumn('dt_ocorrencia', lang('grupoAtividadeDtCadastro'), 10, 'center', array('sortable'=>true));?>
	<?=end_JqGridPanel();?>
	
<?=$this->load->view("../../static/_views/footerGlobalView");?>

<script>
    
	function ajuda(){
            window.open ('<?=WIKI;?>Grupos de Atividade');
        }
        
	function pesquisar(){
               gridGrupoAtividade.addParam('txtDescricao', $('#txtDescricao').val());
               gridGrupoAtividade.addParam('Dt_Ocorrencia', $('#Dt_Ocorrencia').val());
               gridGrupoAtividade.addParam('txtGrupoAtividadeCidadeId', $('#txtGrupoAtividadeCidadeId').val());
               gridGrupoAtividade.load();
        }
	
	function gridGrupoAtividade_click(id){
		location.href = BASE_URL+'paraformalidade/cadastros/equipesGruposAtividades/editar/'+id;
	}


</script>