<?=$this->load->view("../../static/_views/headerGlobalView");?>

	<?=path_bread($path_bread);?>

	<?=begin_ToolBar(array('imprimir', 'abrir', 'pesquisar','novo','excluir'));?>
	<?=end_ToolBar();?>

	<?=begin_TabPanel('tabPonte');?>
		<?=begin_Tab(lang('corpoNumerosFiltro'));?>
			<?=begin_form('paraformalidade/gerenciar/denuncias/salvar', 'formDenuncias');?>
				<?=form_hidden('txtDenunciaId', @$denuncia->id);?>

				<?=form_label('lblPessoa', lang('denunciaPessoa'), 80);?>
				<?=form_textField('txtNome', @$denuncia->pessoa_nome, 300, '','','',true);?>
                                <?=new_line()?>

                                <?=form_label('lblPessoaEmail', lang('denunciaPessoaEmail'), 80);?>
				<?=form_textField('txtEmail', @$denuncia->pessoa_email, 300, '','','',true);?>
                                <?=new_line()?>

                                <?=form_label('lblDenuncia', lang('denunciaDenuncia'), 80);?>
				<?=form_textarea('txtDenuncia', @$denuncia->denuncia, 300)?>
                                <?=new_line()?>

                                <?=form_label('lblLink', lang('denunciaLinkDenunciado'), 80);?>
                                <?=form_textField('txtLink', @$denuncia->link, 300, '','','',true);?>
                                <?=form_button('txtLink', 'Abrir', 'window.open(\''.@$denuncia->link.'\')')?>
                                <?=new_line();?>

                                <?=form_label('lblRevisado', lang('denunciaRevisado'), 80);?>
                                <?=form_combo('cmbRevisado', @$revisado, @$denuncia->revisado, 80, '');?>
                                <?=new_line();?>
			<?=end_form();?>
		<?=end_Tab();?>
	<?=end_TabPanel();?>

<?=$this->load->view("../../static/_views/footerGlobalView");?>

<script>
	function ajuda(){
            window.open ('<?=WIKI;?>Denuncia');
        }
        
	function listaDenuncias(){
            location.href = BASE_URL+'paraformalidade/gerenciar/denuncias/';
	}

	function salvar(){
            formDenuncias_submit();
	}
	
	function formDenuncias_callback(data){
            if(data.error != undefined){
                messageErrorBox(data.error.message, data.error.field);
            } else {
                if(data.success != undefined) {
                    $('#txtDenunciaId').val(data.denuncia.id);
                    messageBox(data.success.message, listaDenuncias);
                }
            }
	} 

</script>