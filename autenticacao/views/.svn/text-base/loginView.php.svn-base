<?=$this->load->view("../../static/_views/headerLoginView");?>

	<div style="margin: 5px;">
		<div style="right: auto; left: 35%; position: fixed; margin-top: 100px; padding: 2px 2px 0px 2px;">
			<?=begin_TabPanel();?>
				<?=begin_Tab(lang('acessoSistema'));?>
					<?=begin_form('autenticacao/login/entrar', 'formLogin');?>
						<?=form_label('lblEmail', lang('login'), 60);?>
						<?=form_textField('txtEmail', '', 240);?>
						<?=new_line();?>
						<?=form_label('lblSenha', lang('usuarioSenha'), 60);?>
						<?=form_textField('txtSenha', '', 240, '', '', array('type' => 'password'));?>
						<?=new_line();?>
						<input id="btnEntrar" name="btnEntrar" type="submit" value="<?=lang('entrar');?>" style="margin-bottom: 0px;"/>
					<?=end_form();?>
				<?=end_Tab();?>
			<?=end_TabPanel();?>
			<span style="float: right;"><!-- Versão do manager aqui --></span>
		</div>
	</div>

<script type="text/javascript">
    function init(){
        $("#btnEntrar").bind('click', entrar);
        $('#txtEmail').focus();
    }

    function entrar(){
        $("#btnEntrar").blur();
        formLogin_submit();
    }

    function formLogin_callback(data){
        if (data.error != undefined) {
            messageErrorBox(data.error.message, data.error.field);
        } else {
            if (data.success != undefined) {
                location.href = BASE_URL+'dashboard';
            }
        }
    }

</script>

<?=$this->load->view("../../static/_views/footerLoginView");?>
