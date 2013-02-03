<?=$this->load->view("../../static/_views/headerGlobalView");?>

	<?=path_bread($path_bread);?>

	<?=begin_ToolBar(array('imprimir', 'abrir', 'pesquisar'));?>
	<?=end_ToolBar();?>

	<?=begin_TabPanel('tabQuantidadesRegistrada');?>
		<?=begin_Tab(lang('quantidadessRegistradasFiltro'));?>
			<?=begin_form('paraformalidade/cadastrosBasicos/quantidadesRegistrada/salvar', 'formQuantidadesRegistrada');?>
				<?=form_hidden('txtQuantidadesRegistradaId', @$quantidadess_registradas->id);?>

				<?=form_label('lblDescricao', lang('quantidadessRegistradasDescricao'), 80);?>
				<?=form_textField('txtDescricao', @$quantidadess_registradas->descricao, 400, '');?>
			<?=end_form();?>
		<?=end_Tab();?>
	<?=end_TabPanel();?>

<?=$this->load->view("../../static/_views/footerGlobalView");?>

<script>
	function ajuda(){
    	window.open ('<?=WIKI;?>Quantidadess Registradas');
        }

	function novo(){
		location.href = BASE_URL+'paraformalidade/cadastrosBasicos/quantidadesRegistrada/novo/';
	}

	function listaQuantidadessRegistradas(){
		location.href = BASE_URL+'paraformalidade/cadastrosBasicos/quantidadesRegistrada/';
	}

	function salvar(){
		formQuantidadesRegistrada_submit();
	}
	
	function formQuantidadesRegistrada_callback(data){
		if(data.error != undefined){
			messageErrorBox(data.error.message, data.error.field);
		} else {
			if(data.success != undefined) {
				$('#txtQuantidadesRegistradaId').val(data.quantidadess_registradas.id);
                        messageBox(data.success.message, listaQuantidadessRegistradas);
			}
	    }
	} 

	function excluir(){
		if($('#txtQuantidadesRegistradaId').val() == ''){
			messageErrorBox("<?=lang('nenhumRegistroSelecionado')?>");
		}else{
			messageConfirm('<?=lang('excluirRegistros')?>', excluirQuantidadesRegistrada);
		}
	}

	function excluirQuantidadesRegistrada(confirmaExclusao){
		if(confirmaExclusao){
			$.post(BASE_URL+'paraformalidade/cadastrosBasicos/quantidadesRegistrada/excluir/', {id: $('#txtQuantidadesRegistradaId').val()}, 
				function(data){
					if(data.success)
						messageBox("<?=lang('registroExcluido')?>", listaLocais);
					else
						messageErrorBox("<?=lang('registroNaoExcluido')?>");
				});
		}
	}	
	
</script>