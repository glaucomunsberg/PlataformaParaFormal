<?=$this->load->view("../../static/_views/headerGlobalView");?>

	<?=path_bread($path_bread);?>

	<?=begin_ToolBar(array('imprimir', 'abrir', 'pesquisar'));?>
	<?=end_ToolBar();?>

	<?=begin_TabPanel('tabElementoSituacao');?>
		<?=begin_Tab(lang('elementosSituacoesFiltro'));?>
			<?=begin_form('paraformalidade/cadastrosBasicos/elementoSituacao/salvar', 'formElementoSituacao');?>
				<?=form_hidden('txtElementoSituacaoId', @$elementos_situacoes->id);?>

				<?=form_label('lblDescricao', lang('elementosSituacoesDescricao'), 80);?>
				<?=form_textField('txtDescricao', @$elementos_situacoes->descricao, 400, '');?>
			<?=end_form();?>
		<?=end_Tab();?>
	<?=end_TabPanel();?>

<?=$this->load->view("../../static/_views/footerGlobalView");?>

<script>
	function ajuda(){
    	window.open ('<?=WIKI;?>Elementos Situação');
        }

	function novo(){
		location.href = BASE_URL+'paraformalidade/cadastrosBasicos/elementoSituacao/novo/';
	}

	function listaElementosSituacoes(){
		location.href = BASE_URL+'paraformalidade/cadastrosBasicos/elementoSituacao/';
	}

	function salvar(){
		formElementoSituacao_submit();
	}
	
	function formElementoSituacao_callback(data){
		if(data.error != undefined){
			messageErrorBox(data.error.message, data.error.field);
		} else {
			if(data.success != undefined) {
				$('#txtElementoSituacaoId').val(data.elementos_situacoes.id);
                        messageBox(data.success.message, listaElementosSituacoes);
			}
	    }
	} 

	function excluir(){
		if($('#txtElementoSituacaoId').val() == ''){
			messageErrorBox("<?=lang('nenhumRegistroSelecionado')?>");
		}else{
			messageConfirm('<?=lang('excluirRegistros')?>', excluirElmentoSituacao);
		}
	}

	function excluirElmentoSituacao(confirmaExclusao){
		if(confirmaExclusao){
			$.post(BASE_URL+'paraformalidade/cadastrosBasicos/elementosSituacao/excluir/', {id: $('#txtElementoSituacaoId').val()}, 
				function(data){
					if(data.success)
						messageBox("<?=lang('registroExcluido')?>", listaElementosSituacoes);
					else
						messageErrorBox("<?=lang('registroNaoExcluido')?>");
				});
		}
	}	
	
</script>