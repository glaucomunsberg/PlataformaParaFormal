<?=$this->load->view("../../static/_views/headerGlobalView");?>

	<?=path_bread($path_bread);?>

	<?=begin_ToolBar(array('imprimir', 'abrir', 'pesquisar'));?>
	<?=end_ToolBar();?>

	<?=begin_TabPanel('tabPonte');?>
		<?=begin_Tab(lang('espacoLocalizacoesFiltro'));?>
			<?=begin_form('paraformalidade/cadastrosBasicos/espacoLocalizacoes/salvar', 'formEspacoLocalizacoes');?>
				<?=form_hidden('txtEspacoLocalizacoesId', @$espaco_localizacoes->id);?>

				<?=form_label('lblDescricao', lang('espacoLocalizacoesDescricao'), 80);?>
				<?=form_textField('txtDescricao', @$espaco_localizacoes->descricao, 400, '');?>

			<?=end_form();?>
		<?=end_Tab();?>
	<?=end_TabPanel();?>

<?=$this->load->view("../../static/_views/footerGlobalView");?>

<script>
	function ajuda(){
    	window.open ('<?=WIKI;?>EspacoLocalizacoes');
        }

	function novo(){
		location.href = BASE_URL+'paraformalidade/cadastrosBasicos/espacoLocalizacoes/novo/';
	}

	function listaEspacoLocalizacoes(){
		location.href = BASE_URL+'paraformalidade/cadastrosBasicos/espacoLocalizacoes/';
	}

	function salvar(){
		formEspacoLocalizacoes_submit();
	}
	
	function formEspacoLocalizacoes_callback(data){
		if(data.error != undefined){
			messageErrorBox(data.error.message, data.error.field);
		} else {
			if(data.success != undefined) {
				$('#txtEspacoLocalizacoesId').val(data.espaco_localizacoes.id);
                        messageBox(data.success.message, listaEspacoLocalizacoes);
			}
	    }
	} 

	function excluir(){
		if($('#txtEspacoLocalizacoesId').val() == ''){
			messageErrorBox("<?=lang('nenhumRegistroSelecionado')?>");
		}else{
			messageConfirm('<?=lang('excluirRegistros')?>', excluirEspacoLocalizacoes);
		}
	}

	function excluirEspacoLocalizacoes(confirmaExclusao){
		if(confirmaExclusao){
			$.post(BASE_URL+'paraformalidade/cadastrosBasicos/espacoLocalizacoes/excluir/', {id: $('#txtEspacoLocalizacoesId').val()}, 
				function(data){
					if(data.success)
						messageBox("<?=lang('registroExcluido')?>", listaEspacoLocalizacoes);
					else
						messageErrorBox("<?=lang('registroNaoExcluido')?>");
				});
		}
	}	
	
</script>