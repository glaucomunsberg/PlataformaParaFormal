<?=$this->load->view("../../static/_views/headerGlobalView");?>

	<?=path_bread($path_bread);?>

	<?=begin_ToolBar(array('imprimir', 'abrir', 'pesquisar'));?>
	<?=end_ToolBar();?>

	<?=begin_TabPanel('tabNotaTipo');?>
		<?=begin_Tab(lang('condicionantesAmbientaisFiltro'));?>
			<?=begin_form('paraformalidade/cadastrosBasicos/condicionantesAmbiental/salvar', 'formCondicoesAmbiental');?>
				<?=form_hidden('txtCondicaoAmbientalId', @$condicao_ambiental->id);?>
				<?=form_label('lblDescricao', lang('condicionantesAmbientaisDescricao'), 80);?>
				<?=form_textField('txtDescricao', @$condicao_ambiental->descricao, 400, '');?>
			<?=end_form();?>
		<?=end_Tab();?>
	<?=end_TabPanel();?>

<?=$this->load->view("../../static/_views/footerGlobalView");?>

<script>
	function ajuda(){
    	window.open ('<?=WIKI;?>Condições Ambientais');
        }

	function novo(){
		location.href = BASE_URL+'paraformalidade/cadastrosBasicos/condicionantesAmbiental/novo/';
	}

	function listaCondicoesAmbientais(){
		location.href = BASE_URL+'paraformalidade/cadastrosBasicos/condicionantesAmbiental/';
	}

	function salvar(){
		formCondicoesAmbiental_submit();
	}
	
	function formCondicoesAmbiental_callback(data){
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
			messageConfirm('<?=lang('excluirRegistros')?>', excluirCondicoesAmbiental);
		}
	}

	function excluirCondicoesAmbiental(confirmaExclusao){
		if(confirmaExclusao){
			$.post(BASE_URL+'paraformalidade/cadastrosBasicos/condicionantesAmbiental/excluir/', {id: $('#txtCondicaoAmbientalId').val()}, 
				function(data){
					if(data.success)
						messageBox("<?=lang('registroExcluido')?>", listaCondicoesAmbientais);
					else
						messageErrorBox("<?=lang('registroNaoExcluido')?>");
				});
		}
	}	
	
</script>