<?=$this->load->view("../../static/_views/headerGlobalView");?>

	<?=path_bread($path_bread);?>

	<?=begin_ToolBar(array('abrir', 'salvar', 'imprimir', 'excluir'));?>
	<?=end_ToolBar();?>

	<?=begin_TabPanel('tabCidadeFiltro');?>
		<?=begin_Tab(lang('cidadeFiltro'));?>
                        
                    <?=form_label('lblNome', lang('cidadeCidade'), 80);?>
                    <?=form_textField('txtCidade', '', 300, '');?>
                    <?=new_line();?>
                    <?=form_label('lblCmbEstado', lang('cidadeEstado'), 80);?>
                    <?=form_combo('cmbEstado', @$estado, '', 150);?>
                    <?=new_line();?>

		<?=end_Tab();?>
	<?=end_TabPanel();?>
	
	<?=begin_JqGridPanel('gridCidades', 'auto', '', base_url().'gerenciador/cidade/listaCidades/', array('sortname'=> 'cidade', 'autowidth'=> true, 'pager'=> true, 'multiselect' => FALSE, 'caption'=>lang('cidadeLista'))); ?>
		<?=addJqGridColumn('id', 'ID', 0, 'right', array('sortable'=>true, 'hidden'=> true));?>
		<?=addJqGridColumn('cidade', lang('cidadeNome'), 60, 'left', array('sortable'=>true));?>
                <?=addJqGridColumn('estado', lang('cidadeEstado'), 30, 'center', array('sortable'=>true));?>
		<?=addJqGridColumn('dt_cadastro', lang('cidadeDtCadastro'), 10, 'center', array('sortable'=>true, 'formatter'=> 'date'));?>
	<?=end_JqGridPanel();?>
	
<?=$this->load->view("../../static/_views/footerGlobalView");?>

<script>
	function ajuda(){
            window.open ('<?=WIKI;?>Cidades');
        }
        
	function pesquisar(){
               gridCidades.addParam('txtCidade', $('#txtCidade').val());
               gridCidades.addParam('cmbEstado', $('#cmbEstado').val());
               gridCidades.load();
        }
	
	function novo(){
		location.href = BASE_URL+'gerenciador/cidade/novo/';
	}

	function gridCidades_click(id){
        location.href = BASE_URL+'gerenciador/cidade/editar/'+id;
    } 
		
</script>