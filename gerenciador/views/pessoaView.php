<?=$this->load->view("../../static/_views/headerGlobalView");?>

	<?=begin_ToolBar(array('imprimir', 'abrir', 'pesquisar'));?>
	<?=end_ToolBar();?>

	<?=begin_TabPanel(217);?>
		<?=begin_Tab(lang('pessoaTituloTab'));?>
			<?=begin_form('gerenciador/pessoa/salvar','formPessoas');?>

				<?=form_label('lblNome', lang('pessoaNome'), 80);?>
				<?=form_textField('txtNome', @$pessoa->nome, 300, '');?>
				<?=new_line();?>

                                <?=form_label('lblEmail', lang('usuarioEmail'), 80);?>
				<?=form_textField('txtEmail', @$pessoa->email, 300, '');?>
				<?=new_line();?>

                                <?=form_label('lblcmbPessoaTipo', lang('pessoaTipo'), 80);?>
                                <?=form_combo('cmbPessoaTipo', @$cmbPessoaTipo, @$pessoa->pessoa_tipo_id, 200);?>
				<?=new_line();?>

                                <?=form_label('lblcmbPessoaSexo', lang('pessoaSexo'), 80);?>
                                <?=form_combo('cmbSexo', @$sexo, @$pessoa->sexo, 200);?>
				<?=new_line();?>

		<?=end_Tab();?>
                <?=begin_Tab(lang('pessoaMais'));?>

                                <?=form_label('lblAte',lang('pessoaDtNacimento'), 80);?>
                                <?=form_dateField('txtDtNascimento', '');?>
                                <?=new_line();?>

                                <?=form_label('lblFone', lang('pessoaTelefone'), 80);?>
				<?=form_textField('txtTelefone', @$pessoa->telefone, 100, 'telefone');?>
				<?=new_line();?>
                                <?=new_line();?>

				<?=form_label('lblCodigo', 'Código', 80);?>
				<?=form_textField('txtCodigo', @$pessoa->id, 40, '', 4, array('readonly' => 'true', 'style' => 'text-align:right;',));?>
				<?=new_line();?>

				<?=form_label('lblDtCadastro', lang('pessoaDtCadastro'), 80);?>
				<?=form_dateField('dtCadastro', @$pessoa->dt_cadastro, array('disabled'=>'true'));?>
				<?=new_line();?>
                <?=end_Tab();?>
                    			<?=end_form();?>
	<?=end_TabPanel()?>

<script type="text/javascript">
    function ajuda(){
    	window.open ('<?=WIKI;?>Pessoas');
    }
    
    function novo(){
        location.href = '<?= base_url() . "gerenciador/pessoa/novo" ?>';
    }

    function salvar(){
        formPessoas_submit();
    }

    function formPessoas_callback(data){
		if(data.error != undefined){
			messageErrorBox(data.error.message, data.error.field);
		} else {
			if(data.success != undefined) {
				$('#txtCodigo').val(data.pessoa.id);
                        messageBox(data.success.message, listaPessoas);
			}
	    }
    }
    
    function listaPessoas(){
        location.href = '<?= base_url() . "gerenciador/pessoa/" ?>';
    }

    function excluir(){
		if($('#txtCodigo').val() == ''){
			messageErrorBox("<?=lang('nenhumRegistroSelecionado')?>");
		}else{
			messageConfirm('<?=lang('excluirRegistros')?>', excluirPessoa);
		}
    }

    function excluirPessoa(confirmaExclusao){
            if(confirmaExclusao){
                    $.post(BASE_URL+'gerenciador/pessoa/excluir/', {id: $('#txtCodigo').val()}, 
                            function(data){
                                    if(data.success)
                                            messageBox("<?=lang('registroExcluido')?>", listaPessoas);
                                    else
                                            messageErrorBox("<?=lang('registroNaoExcluido')?>");
                            });
            }
    }
</script>

<?=$this->load->view("../../static/_views/footerGlobalView")?>
