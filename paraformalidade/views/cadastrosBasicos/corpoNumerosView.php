<?=$this->load->view("../../static/_views/headerGlobalView");?>

	<?=path_bread($path_bread);?>

	<?=begin_ToolBar(array('imprimir', 'abrir', 'pesquisar'));?>
	<?=end_ToolBar();?>

	<?=begin_TabPanel('tabPonte');?>
		<?=begin_Tab(lang('corpoNumerosFiltro'));?>
			<?=begin_form('paraformalidade/cadastrosBasicos/corpoNumeros/salvar', 'formCorpoNumeros');?>
				<?=form_hidden('txtCorpoNumerosId', @$corpo_numeros->id);?>

				<?=form_label('lblDescricao', lang('corpoNumerosDescricao'), 80);?>
				<?=form_textField('txtDescricao', @$corpo_numeros->descricao, 400, '');?>

			<?=end_form();?>
		<?=end_Tab();?>
	<?=end_TabPanel();?>

<?=$this->load->view("../../static/_views/footerGlobalView");?>

<script>
	function ajuda(){
    	window.open ('<?=WIKI;?>Pontes');
        }

	function novo(){
		location.href = BASE_URL+'paraformalidade/cadastrosBasicos/corpoNumeros/novo/';
	}

	function listaCorpoNumeros(){
		location.href = BASE_URL+'paraformalidade/cadastrosBasicos/corpoNumeros/';
	}

	function salvar(){
		formCorpoNumeros_submit();
	}
	
	function formCorpoNumeros_callback(data){
		if(data.error != undefined){
			messageErrorBox(data.error.message, data.error.field);
		} else {
			if(data.success != undefined) {
				$('#txtCorpoNumerosId').val(data.corpo_numeros.id);
                        messageBox(data.success.message, listaCorpoNumeros);
			}
	    }
	} 

	function excluir(){
		if($('#txtCorpoNumerosId').val() == ''){
			messageErrorBox("<?=lang('nenhumRegistroSelecionado')?>");
		}else{
			messageConfirm('<?=lang('excluirRegistros')?>', excluirCorpoNumeros);
		}
	}

	function excluirCorpoNumeros(confirmaExclusao){
		if(confirmaExclusao){
			$.post(BASE_URL+'paraformalidade/cadastrosBasicos/corpoNumeros/excluir/', {id: $('#txtCorpoNumerosId').val()}, 
				function(data){
					if(data.success)
						messageBox("<?=lang('registroExcluido')?>", listaCorpoNumeros);
					else
						messageErrorBox("<?=lang('registroNaoExcluido')?>");
				});
		}
	}	
	
</script>