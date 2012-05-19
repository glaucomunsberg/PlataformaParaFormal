<?=$this->load->view("../../static/_views/headerGlobalView");?>

	<?=path_bread($path_bread);?>

	<?=begin_ToolBar(array('abrir', 'salvar', 'imprimir','excluir', 'novo' ));?>
	<?=end_ToolBar();?>
	<?=new_line();?>

	<?=begin_TabPanel('tabVerAtividadeRegistro');?>
		<?=begin_Tab(lang('verRegistroAtividadeFiltro'));?>
                        <?=form_label('lblDescricao', lang('verRegistroAtividadePessoa'), 80);?>
			<?=form_textField('txtNome', '', 300, '');?>
		<?=end_Tab();?>
	<?=end_TabPanel();?>

	<?=begin_JqGridPanel('gridEquipe', 'auto', '', base_url().'paraformalidade/equipe/verRegistroAtividade/listaEquipeComRegistradas/', array('sortname'=> 'id', 'sortorder' => 'desc', 'multiselect' => false,'autowidth'=> true, 'pager'=> true));?>
		<?=addJqGridColumn('id', 'ID', 0, 'right', array('sortable'=>true, 'hidden'=> true));?>
		<?=addJqGridColumn('nome', lang('verRegistroAtividadeMembroDaEquipe'), 100, 'left', array('sortable'=>true));?>
	<?=end_JqGridPanel();?>

<?=$this->load->view("../../static/_views/footerGlobalView");?>

<script>

	function ajuda(){
    	window.open ('<?=WIKI;?>ver Atividade Registrada');
    }

	function pesquisar(){
		gridEquipe.addParam('nome', $('#txtNome').val());
		gridEquipe.load();
	}
        
        function gridEquipe_click(id){
		location.href = BASE_URL+'paraformalidade/equipe/verRegistroAtividade/verRegistrosDeAtividade/'+id;
	}




</script>