<?=$this->load->view("../../static/_views/headerGlobalView");?>

	<?=path_bread($path_bread);?>

	<?=begin_ToolBar(array('imprimir', 'abrir', 'pesquisar'));?>
	<?=end_ToolBar();?>

	<?=begin_TabPanel('tabNotaTipo');?>
		<?=begin_Tab(lang('locaisFiltro'));?>
			<?=begin_form('paraformalidade/cadastrosBasicos/local/salvar', 'formLocal');?>
				<?=form_hidden('txtLocalId', @$tipos_locais->id);?>

				<?=form_label('lblDescricao', lang('locaisDescricao'), 80);?>
				<?=form_textField('txtDescricao', @$tipos_locais->descricao, 400, '');?>

			<?=end_form();?>
		<?=end_Tab();?>
	<?=end_TabPanel();?>

<?=$this->load->view("../../static/_views/footerGlobalView");?>

<script>
	function ajuda(){
    	window.open ('<?=WIKI;?>Locais');
        }

	function novo(){
		location.href = BASE_URL+'paraformalidade/cadastrosBasicos/local/novo/';
	}

	function listaLocais(){
		location.href = BASE_URL+'paraformalidade/cadastrosBasicos/local/';
	}

	function salvar(){
		formLocal_submit();
	}
	
	function formLocal_callback(data){
		if(data.error != undefined){
			messageErrorBox(data.error.message, data.error.field);
		} else {
			if(data.success != undefined) {
				$('#txtLocalId').val(data.tipos_locais.id);
                        messageBox(data.success.message, listaLocais);
			}
	    }
	} 

	function excluir(){
		if($('#txtCondicaoAmbientalId').val() == ''){
			messageErrorBox("<?=lang('nenhumRegistroSelecionado')?>");
		}else{
			messageConfirm('<?=lang('excluirRegistros')?>', excluirLocal);
		}
	}

	function excluirLocal(confirmaExclusao){
		if(confirmaExclusao){
			$.post(BASE_URL+'paraformalidade/cadastrosBasicos/local/excluir/', {id: $('#txtLocalId').val()}, 
				function(data){
					if(data.success)
						messageBox("<?=lang('registroExcluido')?>", listaLocais);
					else
						messageErrorBox("<?=lang('registroNaoExcluido')?>");
				});
		}
	}	
	
</script>