<?= $this->load->view("../../static/_views/headerGlobalView"); ?>

	<?=path_bread($path_bread);?>

	<?=begin_ToolBar(array('salvar', 'abrir', 'imprimir'));?>
	<?=end_ToolBar();?>

	<?=begin_TabPanel();?>
		<?=begin_Tab(lang('pessoaFiltro'));?>
                                <?=form_label('lblNome', lang('colaboradorNome'), 80);?>
				<?=form_textField('txtColaboradorNome', '', 250, '');?>

                                <?=form_label('lblSexo', lang('colaboradorSexo'), 40);?>
                                <?= form_combo('cmbColaboradorSexo', $sexo, "", 90) ?>
				<?=new_line();?>

                                <?=form_label('lblCidade', lang('colaboradorCidade'), 80);?>
                                <?= form_textFieldAutoComplete('txtColaboradorCidadeId', BASE_URL . 'paraformalidade/cadastrosBasicos/colaborador/buscarCidade', '', '', 400) ?>
                                <?=new_line();?>

                                <?=form_label('lblEmail', lang('colaboradorEmail'), 80);?>
				<?=form_textField('txtColaboradorEmail', '', 250, '');?>
				
                <?=end_Tab();?>
	<?=end_TabPanel();?>

	<?=begin_JqGridPanel('gridColaboradores', 'auto', '', base_url().'paraformalidade/cadastrosBasicos/colaborador/listaColaboradores', array('sortname'=> 'nome', 'autowidth'=> true, 'pager'=> false, 'caption'=>lang('colaboradorCidadeGrid')));?>
		<?=addJqGridColumn('id', 'ID', 0, 'right', array('sortable'=>true, 'hidden'=> true));?>
                <?=addJqGridColumn('nome', lang('colaboradorNome'), 60, 'left', array('sortable'=>true));?>
                <?=addJqGridColumn('email', lang('colaboradorEmail'), 40, 'left', array('sortable'=>true));?>
                <?=addJqGridColumn('cidadeNome', lang('colaboradorCidade'), 40, 'left', array('sortable'=>true));?>
                <?=addJqGridColumn('sexo', lang('colaboradorSexo'), 5, 'center', array('sortable'=>true));?>
                <?=addJqGridColumn('dt_cadastro', lang('pessoaDtCadastro'), 15, 'center', array('sortable'=>true));?>
	<?=end_JqGridPanel();?>

<script type="text/javascript">    
    function ajuda(){
    	window.open ('<?=WIKI;?>Colaborador');
    }
    
    function novo(){
        location.href = BASE_URL+'paraformalidade/cadastrosBasicos/colaborador/novo';
    }
    
    function pesquisar(){
        gridColaboradores.addParam('txtColaboradorNome', $('#txtColaboradorNome').val());
        gridColaboradores.addParam('cmbColaboradorSexo', $('#cmbColaboradorSexo').val());
        gridColaboradores.addParam('txtColaboradorEmail', $('#txtColaboradorEmail').val());
        gridColaboradores.addParam('txtColaboradorCidadeId', $('#txtColaboradorCidadeId').val());
        gridColaboradores.load();
    }
    
    function gridColaboradores_click(id){
        location.href = BASE_URL+'paraformalidade/cadastrosBasicos/colaborador/editar/'+id;
    }
    
    function excluir(){		
	if(getSelectedRows('gridColaboradores').length == 0)
		messageErrorBox('<?=lang('nenhumRegistroSelecionado')?>');
	else
		messageConfirm('<?=lang('excluirRegistros')?>', excluirColaborador);
    }
    
    function excluirColaborador(confirmaExclusao){
	if(confirmaExclusao){
            var colaborador
            var colaboradorGrid = getSelectedRows('gridColaboradores');
                for(var i = 0; i < colaboradorGrid.length; i++)
                    if(colaborador == '')
                        colaborador = colaboradorGrid[i];
                    else
                        colaborador += ',' + colaboradorGrid[i];

		$.post(BASE_URL+'paraformalidade/cadastrosBasicos/colaborador/excluir/', {id: colaborador}, 
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
