<?= $this->load->view("../../static/_views/headerGlobalView"); ?>

	<?=path_bread($path_bread);?>

	<?=begin_ToolBar(array('salvar', 'abrir', 'imprimir'));?>
	<?=end_ToolBar();?>

	<?=begin_TabPanel();?>
		<?=begin_Tab(lang('pessoaFiltro'));?>
			<?=form_label('lblNome', lang('tipoPessoa'), 80);?>
			<?=form_textField('txtNomeTipoPessoa', '', 300, '');?>
		<?=end_Tab();?>
	<?=end_TabPanel();?>

	<?=begin_JqGridPanel('gridPessoaTipos', 'auto', '', base_url().'gerenciador/pessoaTipo/listaPessoasTipos', array('sortname'=> 'tipo', 'autowidth'=> true, 'pager'=> false, 'caption'=>lang('tipoPessoaGrid')));?>
		<?=addJqGridColumn('id', 'ID', 0, 'right', array('sortable'=>true, 'hidden'=> true));?>
                <?=addJqGridColumn('tipo', lang('tipoPessoaTipo'), 80, 'left', array('sortable'=>true));?>
                <?=addJqGridColumn('dt_cadastro', lang('pessoaDtCadastro'), 20, 'center', array('sortable'=>true));?>
	<?=end_JqGridPanel();?>

<script type="text/javascript">
    function ajuda(){
    	window.open ('<?=WIKI;?>Pessoa_Tipo');
    }
    
    function novo(){
        location.href = BASE_URL+'gerenciador/pessoaTipo/novo';
    }
    
    function pesquisar(){
        gridPessoaTipos.addParam('tipo', $('#txtNomeTipoPessoa').val());
        gridPessoaTipos.load();
    }
    
    function gridPessoaTipos_click(id){
        location.href = BASE_URL+'gerenciador/pessoaTipo/editar/'+id;
    }
    
    function excluir(){		
	if(getSelectedRows('gridPessoaTipos').length == 0)
		messageErrorBox('<?=lang('nenhumRegistroSelecionado')?>');
	else
		messageConfirm('<?=lang('excluirRegistros')?>', excluirPessoaTipo);
    }
    
    function excluirPessoaTipo(confirmaExclusao){
	if(confirmaExclusao){
            var pessoasTipos
            var pessoasTiposGrid = getSelectedRows('gridPessoaTipos');
                for(var i = 0; i < pessoasTiposGrid.length; i++)
                    if(pessoasTipos == '')
                        pessoasTipos = pessoasTiposGrid[i];
                    else
                        pessoasTipos += ',' + pessoasTiposGrid[i];

		$.post(BASE_URL+'gerenciador/pessoaTipo/excluir/', {id: pessoasTipos}, 
                    function(data){
                        if(data.success)
                            messageBox("<?=lang('registroExcluido')?>", pesquisar);
                        else
                            messageErrorBox("<?=lang('registroNaoExcluido')?>");
				});
		}
	
     }
</script>

<?= $this->load->view("../../static/_views/footerGlobalView"); ?>