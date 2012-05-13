<?=$this->load->view("../../static/_views/headerGlobalView");?>

	<?=path_bread($path_bread);?>

	<?=begin_ToolBar(array('imprimir', 'abrir', 'pesquisar'));?>
	<?=end_ToolBar();?>

	<?=begin_TabPanel('tabNotaTipo');?>
		<?=begin_Tab(lang('condicoesAmbientaisFiltro'));?>
			<?=begin_form('paraformalidade/cadastrosBasicos/condicaoAmbiental/salvar', 'formCondicaoAmbiental');?>
				<?=form_hidden('txtCondicaoAmbientalId', @$condicao_ambiental->id);?>

				<?=form_label('lblDescricao', lang('condicoesAmbientaisDescricao'), 80);?>
				<?=form_textField('txtDescricao', @$condicao_ambiental->descricao, 400, '');?>

			<?=end_form();?>
		<?=end_Tab();?>
	<?=end_TabPanel();?>

<?=$this->load->view("../../static/_views/footerGlobalView");?>

<script>
	function ajuda(){
    	window.open ('<?=WIKI;?>condicoes ambientais');
        }

	function novo(){
		location.href = BASE_URL+'paraformalidade/cadastrosBasicos/condicaoAmbiental/novo/';
	}

	function listaCondicoesAmbientais(){
		location.href = BASE_URL+'paraformalidade/cadastrosBasicos/condicaoAmbiental/';
	}

	function salvar(){
		formCondicaoAmbiental_submit();
	}
	
	function formCondicaoAmbiental_callback(data){
		if(data.error != undefined){
			messageErrorBox(data.error.message, data.error.field);
		} else {
			if(data.success != undefined) {
				$('#txtCondicaoAmbientalId').val(data.condicao_ambiental.id);
                        messageBox(data.success.message, listaCondicoesAmbientais);
			}
	    }
	} 

	function excluir(){
		if($('#txtCondicaoAmbientalId').val() == ''){
			messageErrorBox("<?=lang('nenhumRegistroSelecionado')?>");
		}else{
			messageConfirm('<?=lang('excluirRegistros')?>', excluirCondicaoAmbiental);
		}
	}

	function excluirCondicaoAmbiental(confirmaExclusao){
		if(confirmaExclusao){
			$.post(BASE_URL+'paraformalidade/cadastrosBasicos/condicaoAmbiental/excluir/', {id: $('#txtCondicaoAmbientalId').val()}, 
				function(data){
					if(data.success)
						messageBox("<?=lang('registroExcluido')?>", listaCondicoesAmbientais);
					else
						messageErrorBox("<?=lang('registroNaoExcluido')?>");
				});
		}
	}	
	
</script>