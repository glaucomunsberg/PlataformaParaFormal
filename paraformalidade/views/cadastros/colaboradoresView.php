<?=$this->load->view("../../static/_views/headerGlobalView");?>
    <?= path_bread($path_bread) ?>
	<?=begin_ToolBar(array('imprimir', 'abrir', 'pesquisar'));?>
	<?=end_ToolBar();?>

	<?=begin_TabPanel();?>
		<?=begin_Tab(lang('colaboradorColaborador'));?>
			<?=begin_form('paraformalidade/cadastros/colaboradores/salvar', 'formColaborador');?>
                                <?=form_hidden('txtColaboradorId', @$colaborador->id);?>

                                <?=form_label('lblNome', lang('colaboradorNome'), 80);?>
				<?=form_textField('txtColaboradorNome', @$colaborador->nome, 250, '');?>

                                <?= form_label("lblSexo", lang('colaboradorSexo'), 40) ?>
                                <?= form_combo("cmbColaboradorSexo", $sexo, @$colaborador->sexo, 90) ?>
                                <?=new_line();?>
                                
                                <?=form_label('lblCidade', lang('colaboradorCidade'), 80);?>
                                <?= form_textFieldAutoComplete('txtColaboradorCidadeId', BASE_URL . 'paraformalidade/cadastros/colaboradores/buscarCidade', @$colaborador->cidade_id, @$colaboradorCidade->nome, 400) ?>
                                <?=form_hidden('txtCidadeNome', @$colaboradorCidade->nome);?>
                                <?=new_line();?>

                                <?=form_label('lblEmail', lang('colaboradorEmail'), 80);?>
				<?=form_textField('txtColaboradorEmail', @$colaborador->email, 250, '');?>
				<?=new_line();?>

                                <?=form_label('lblProfissao', lang('colaboradorProfissaoInstituicao'), 80);?>
				<?=form_textField('txtColaboradorProfissao', @$colaborador->profissao, 250, '');?>
                                <?=new_line();?>

                                <?=form_label('lblAte',lang('colaboradorProfissaoDtNacimento'), 80);?>
                                <?=form_dateField('txtDtNascimento', @$colaborador->dt_nascimento);?>
                                <?=new_line();?>

			<?=end_form();?>
		<?=end_Tab();?>
	<?=end_TabPanel()?>

<script type="text/javascript">
    function ajuda(){
    	window.open ('<?=WIKI;?>Colaboradores');
    }
    
    function novo(){
        location.href = BASE_URL+'paraformalidade/cadastros/colaboradores/novo';
    }
    
    function salvar(){
	formColaborador_submit();
        
    }
    
    function formColaborador_callback(data){
        if(data.error != undefined){
            messageErrorBox(data.error.message, data.error.field);
        } else if(data.success != undefined) {
            messageBox(data.success.message, listaColaborador);
        }
    }
    
    function listaColaborador(){
	location.href = BASE_URL+'paraformalidade/cadastros/colaboradores/';
    }
    
    function excluir(){
	if($('#txtColaboradorId').val() == ''){
		messageErrorBox("<?=lang('nenhumRegistroSelecionado')?>");
	}else{
		messageConfirm('<?=lang('excluirRegistros')?>', excluirColaborador);
            }
	}

	function excluirColaborador(confirmaExclusao){
            if(confirmaExclusao){
                $.post(BASE_URL+'paraformalidade/cadastros/colaboradores/excluir/', {id: $('#txtColaboradorId').val()}, 
                function(data){
			if(data.success)
                        	messageBox("<?=lang('registroExcluido')?>", listaColaborador);
			else
					messageErrorBox("<?=lang('registroNaoExcluido')?>");
			});
		}
	}
</script>

<?=$this->load->view("../../static/_views/footerGlobalView")?>
