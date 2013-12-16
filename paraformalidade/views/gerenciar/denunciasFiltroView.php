<?=$this->load->view("../../static/_views/headerGlobalView");?>

	<?=path_bread($path_bread);?>

	<?=begin_ToolBar(array('abrir', 'salvar', 'imprimir','novo','excluir' ));?>
	<?=end_ToolBar();?>

	<?=begin_TabPanel('tabCorpoNumeros');?>
		<?=begin_Tab(lang('corpoNumerosFiltro'));?>
			<?=form_label('lblDescricao', lang('corpoNumerosDescricao'), 80);?>
			<?=form_textField('txtDescricao', '', 300, '');?>
		<?=end_Tab();?>
	<?=end_TabPanel();?>
	
	<?=begin_JqGridPanel('gridDenuncias', 'auto', '', base_url().'paraformalidade/gerenciar/denuncias/listaDenuncias/', array('sortname'=> 'revisor_id', 'autowidth'=> true, 'pager'=> true, 'caption'=>lang('denunciaLista')));?>
		<?=addJqGridColumn('id', 'ID', 0, 'right', array('sortable'=>true, 'hidden'=> true));?>
		<?=addJqGridColumn('foirevisado', lang('denunciaRevisado'), 50, 'left', array('sortable'=>true));?>
                <?=addJqGridColumn('pessoa_nome', lang('denunciaPessoa'), 150, 'left', array('sortable'=>true));?>
                <?=addJqGridColumn('denuncia', lang('denunciaDenuncia'), 300, 'left', array('sortable'=>true));?>
		<?=addJqGridColumn('dt_cadastro', lang('corpoNumerosDtCadastro'), 70, 'center', array('sortable'=>true));?>
	<?=end_JqGridPanel();?>
	
<?=$this->load->view("../../static/_views/footerGlobalView");?>

<script>
	function ajuda(){
            window.open ('<?=WIKI;?>Denuncias');
        }
	function pesquisar(){
               gridDenuncias.addParam('descricao', $('#txtDescricao').val());
               gridDenuncias.load();
        } 
	
	function gridDenuncias_click(id){
		location.href = BASE_URL+'paraformalidade/gerenciar/denuncias/editar/'+id;
	}
		

</script>