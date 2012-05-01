<?=$this->load->view("../../static/_views/headerGlobalView");?>
    <?= path_bread($path_bread) ?>
	<?=begin_ToolBar(array('imprimir', 'abrir', 'pesquisar'));?>
	<?=end_ToolBar();?>

	<?=begin_TabPanel();?>
		<?=begin_Tab(lang('colaboradorColaborador'));?>
			<?=begin_form('paraformalidade/cadastrosBasicos/colaborador/salvar', 'formColaborador');?>
                                <?=form_hidden('txtColaboradorId', @$colaborador->id);?>

                                <?=form_label('lblNome', lang('colaboradorNome'), 80);?>
				<?=form_textField('txtColaboradorNome', @$colaborador->nome, 250, '');?>

                                <?= form_label("lblSexo", lang('colaboradorSexo'), 40) ?>
                                <?= form_combo("cmbColaboradorSexo", $sexo, @$colaborador->sexo, 90) ?>
                                <?=new_line();?>
                                
                                <?=form_label('lblCidade', lang('colaboradorCidade'), 80);?>
                                <?= form_textFieldAutoComplete('txtColaboradorCidadeId', BASE_URL . 'paraformalidade/cadastrosBasicos/colaborador/buscarCidade', @$colaborador->cidade_id, @$colaboradorCidade->nome, 400) ?>
                                <?=form_hidden('txtCidadeNome', @$colaboradorCidade->nome);?>
                                <?=new_line();?>

                                <?=form_label('lblEmail', lang('colaboradorEmail'), 80);?>
				<?=form_textField('txtColaboradorEmail', @$colaborador->email, 250, '');?>
				<?=new_line();?>

			<?=end_form();?>
		<?=end_Tab();?>
	<?=end_TabPanel()?>

<script type="text/javascript">
    function ajuda(){
    	window.open ('<?=WIKI;?>Colaborador');
    }
    
    function novo(){
        location.href = BASE_URL+'paraformalidade/cadastrosBasicos/colaborador/novo';
    }
    
    function salvar(){
	formColaborador_submit();
        location.href = BASE_URL+'paraformalidade/cadastrosBasicos/colaborador/';
    }
    
    function formColaborador_callback(data){
        if(data.error != undefined){
            messageErrorBox(data.error.message, data.error.field);
        } else if(data.success != undefined) {
            $("#txtColaboradorId").val(data.colaborador.id);
            $("#txtColaboradorNome").val(data.colaborador.nome);
            $("#cmbColaboradorSexo").val(data.colaborador.sexo);
            messageBox(data.success.message, 'txtColaboradorNome');
        }
    }
    
    function listaColaborador(){
	location.href = BASE_URL+'paraformalidade/cadastrosBasicos/colaborador/';
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
                $.post(BASE_URL+'paraformalidade/cadastrosBasicos/colaborador/excluir/', {id: $('#txtColaboradorId').val()}, 
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
