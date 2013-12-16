<?=$this->load->view("../../static/_views/headerGlobalView");?>

	<?=path_bread($path_bread);?>

	<?=begin_ToolBar(array('abrir', 'salvar', 'imprimir','novo','excluir' ));?>
	<?=end_ToolBar();?>

	<?=begin_TabPanel('tabAtualizacoes');?>
		<?=begin_Tab(lang('corpoNumerosFiltro'));?>
			<?=form_label('lblDescricao', lang('atualizacaoFiltro'), 80);?>
			<?=form_textField('txtDescricao', '', 300, '');?>
		<?=end_Tab();?>
	<?=end_TabPanel();?>
	
	<?=begin_JqGridPanel('gridAtualizacoes', 'auto', '', base_url().'paraformalidade/gerenciar/atualizacoes/listaColaboracoes/', array('sortname'=> 'descricao', 'multiselect'=>false,'autoload'=>true,'autowidth'=> true, 'pager'=> true, 'caption'=>lang('atualizacaoLista'),
            'grouping' => true, 'groupingView' => '##{groupField:[\'grupo_atividade\'], groupColumnShow: [false], groupSummary: [false], groupDataSorted: true, groupOrder: [\'desc\'], showSummaryOnHide: false, groupText : [\'<b style="display: block; float: left; margin: 2px;">{0}</b>\']}##'));?>
                <?=addJqGridColumn('id', 'ID', 0, 'right', array('sortable'=>true, 'hidden'=> true));?>
                <?=addJqGridColumn('grupo_atividade', 'Grupo de Atividade', 20, 'center', array('hidden' => true));?>
                <?=addJqGridColumn('descricao', lang('cenasDescricao'), 70, 'left', array('sortable'=>true));?>
                <?=addJqGridColumn('dt_cadastro', lang('cenasDtOcorrencia'), 10, 'center', array('sortable'=>true));?>
        <?=end_JqGridPanel();?>
	
<?=$this->load->view("../../static/_views/footerGlobalView");?>

<script>
	function ajuda(){
            window.open ('<?=WIKI;?>Denuncias');
        }
	function pesquisar(){
               gridAtualizacoes.addParam('descricao', $('#txtDescricao').val());
               gridAtualizacoes.load();
        } 
	
	function gridAtualizacoes_click(id){
		location.href = BASE_URL+'paraformalidade/gerenciar/atualizacoes/editar/'+id;
	}
		

</script>