<?=$this->load->view("../../static/_views/headerGlobalView");?>

	<?=path_bread($path_bread); ?>
	
	<?=begin_ToolBar(array('imprimir', 'abrir', 'ajuda', 'pesquisar'));?>
	<?=end_ToolBar();?>
	
	<?=begin_TabPanel();?>
		<?=begin_Tab(lang('parametroTab'));?>
			<?=begin_form('gerenciador/parametro/salvar', 'formParametro');?>
				<?=form_label('lblCodigo', lang('parametroCodigo'), 80);?>
				<?=form_textField('txtCodigo', @$parametro->id, 40, '', 4, array('readonly' => 'true', 'style' => 'text-align:right;',));?>
				<?=new_line();?>
				
				<?=form_label('lblNome', lang('parametroNome'), 80);?>
				<?=form_textField('txtNome', @$parametro->nome, 300, '');?>
				<?=new_line();?>
				
				<?=form_label('lblDescricao', lang('parametroDescricao'), 80);?>
				<?=form_textField('txtDescricao', @$parametro->descricao, 300, '');?>
				<?=new_line();?>

				<?=form_label('lblValor', lang('parametroValor'), 80);?>
				<?=form_textField('txtValor', @$parametro->valor, 300, '');?>
				<?=new_line();?>

				<?=form_label('lblDtCadastro', lang('parametroDtCadastro'), 80);?>
				<?=form_dateField('dtCadastro', @$parametro->dt_cadastro, array('disabled'=>'true'));?>
				
			<?=end_form();?>
		<?=end_Tab();?>
	<?=end_TabPanel();?>
	
<?=$this->load->view("../../static/_views/footerGlobalView");?>

<script>

	function novo(){
		location.href = BASE_URL+'gerenciador/parametro/novo';
	}
	
	function salvar(){		
		formParametro_submit();
	}
	
	function formParametro_callback(data){
		if(data.error != undefined){
				messageErrorBox(data.error.message, data.error.field);
		} else {
			if(data.sucess != undefined) {
				$('#txtCodigo').val(data.parametro.id);
				$('#dtCadastro').val(data.parametro.dt_cadastro);
	      		messageBox(data.sucess.message);
			}
	    }
	}

	function excluir(){
		if($("#txtCodigo").val() == "")
			messageErrorBox("<?=lang('nenhumRegistroSelecionado')?>");
		else
			messageConfirm("<?=lang('excluirRegistro')?>", excluirParametro);
	}
	
	function excluirParametro(confirmaExclusao){
		if(confirmaExclusao){
			$.post(BASE_URL+"gerenciador/parametro/excluir", {id: $('#txtCodigo').val()},
				function(){
					messageBox("<?=lang('registroExcluido')?>", novo);
				});
		}
	}

</script>