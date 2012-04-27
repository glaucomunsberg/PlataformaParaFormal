<?=$this->load->view("../../static/_views/headerGlobalView");?>

	<?=path_bread('Configurações do Usuário', false);?>

	<?=begin_ToolBar(array('imprimir', 'abrir', 'pesquisar', 'voltar-pagina', 'novo', 'ajuda', 'excluir'));?>
	<?=end_ToolBar();?>

	<?=warning('warning', '<b>Atenção</b>, para efetivar as alterações feitas no seu perfil clique no botão <b>Salvar</b>', false);?>

	<?=begin_TabPanel();?>
		<?=begin_Tab(lang('configuracaoTab0'));?>
			<?=begin_form('dashboard/configuracao/salvarGeral', 'formGeral');?>
				<?=form_label('lblNome', 'Nome', 80);?>
				<?=form_label('txtNome', getUsuarioSession()->nome_pessoa, 400, array('style'=> 'font-weight: bold;'));?>
				<?=new_line();?>
				<?=form_label('lblEmail', 'Email', 80);?>
				<?=form_textField('txtEmail', getUsuarioSession()->email, 250);?>
			<?=end_form();?>
		<?=end_Tab();?>
		<?=begin_Tab(lang('configuracaoTab1'));?>
			<?=begin_form('dashboard/configuracao/salvarSenha', 'formSenha');?>
				<?=form_label('lblSenhaAtual', lang('configuracaoSenhaAtual'), 100);?>
				<?=form_textField('txtSenhaAtual', '', 250, '', '', array('type' => 'password'));?>
				<?=new_line();?>
				<?=form_label('lblSenhaNova', lang('configuracaoSenhaNova'), 100);?>
				<?=form_textField('txtSenhaNova', '', 250, '', '', array('type' => 'password'));?>
				<?=new_line();?>
				<?=form_label('lblRepetirSenha', lang('configuracaoRepetirSenha'), 100);?>
				<?=form_textField('txtConfirmaSenha', '', 250, '', '', array('type' => 'password'));?>
			<?=end_form();?>
		<?=end_Tab();?>
		<?=begin_Tab(lang('configuracaoTab2'));?>
			<?=begin_form('dashboard/configuracao/salvarTema', 'formTema');?>
			<? for($i=0; $i<count($temas);$i++){?>
				<div style="display: block; float: left;">
					<label for="<?='tema_'.$temas[$i];?>">
						<img src="<?=IMG.'/'.$temas[$i];?>.png" width="160px" height="160px" style="margin: 5px;"/>
					</label>
					<?=new_line();?>
					<?=form_radio('tema_'.$temas[$i], 'temas', $temas[$i], ($_COOKIE['tema'] == $temas[$i] ? true : false));?>
					<?=form_label('lbl'.$temas[$i], humanize($temas[$i]), 160, array('for'=>'tema_'.$temas[$i]));?>
					<?=new_line();?>
				</div>
			<? }?>
			<?=end_form();?>
		<?=end_Tab();?>
	<?=end_TabPanel();?>

<script type="text/javascript">

    function init(){
        $("#tab").tabs({disabled: [1]});
    }

    function salvar(){
        switch($("#tab").tabs( "option", "selected")){
            case 0:
                formGeral_submit();
                break;
            case 1:
                formSenha_submit();
                break
            case 2:
                formTema_submit();
                break;
        }
    }

    function formGeral_callback(data){
        if (!data.success) {
            messageErrorBox('<?= lang('registroNaoGravado') ?>');
        } else {
            //$.cookie('avatar', data.upload.nome_gerado, {path: '/cobalto'});
            messageBox('<?= lang('registroGravado') ?>');
        }
    }

    function formSenha_callback(data){
        if (data.error != undefined) {
            messageErrorBox(data.error.message, data.error.field);
        } else {
            if (data.success != undefined) {
                messageBox(data.success.message);
            }
        }
    }

    function formTema_callback(data){
        if (data.error != undefined) {
            messageErrorBox(data.error.message, data.error.field);
        } else {
            if (data.success != undefined) {
                messageBox(data.success.message, reloadTabTemas);
            }
        }
    }

    function reloadTabTemas(){
        location.reload();
    }

    function finishUploadAvatar(){
        switch($("#tab").tabs( "option", "selected")){
            case 0:
                $.post(BASE_URL+'util/archive/getArchiveByUploadId/'+$('#avatarId').val(), '',
                function(data){
                    if (data.arquivo != undefined) {
                        $("#img_usuario").attr('src', BASE_URL+'util/download/arquivo/'+data.arquivo.nome_gerado+'/80x80');
                    }
                });
                break;
        }
    }

    function finishUploadWebCamCarteira(){
        switch($("#tab").tabs( "option", "selected")){
            case 0:
                $.post(BASE_URL+'util/archive/getArchiveByUploadId/'+$('#carteiraId').val(), '',
                function(data){
                    if (data.arquivo != undefined) {
                        $("#img_carteira").attr('src', BASE_URL+'util/download/arquivo/'+data.arquivo.nome_gerado+'/354x472');
                    }
                });
                break;
        }
    }

</script>

<?=$this->load->view("../../static/_views/footerGlobalView");?>
