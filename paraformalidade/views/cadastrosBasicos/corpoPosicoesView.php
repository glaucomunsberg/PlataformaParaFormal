<?=$this->load->view("../../static/_views/headerGlobalView");?>

	<?=path_bread($path_bread);?>

	<?=begin_ToolBar(array('imprimir', 'abrir', 'pesquisar'));?>
	<?=end_ToolBar();?>

	<?=begin_TabPanel('tabPonte');?>
		<?=begin_Tab(lang('corpoPosicoesFiltro'));?>
			<?=begin_form('paraformalidade/cadastrosBasicos/corpoPosicoes/salvar', 'formCorpoPosicoes');?>
				<?=form_hidden('txtCorpoPosicoesId', @$corpo_posicoes->id);?>

				<?=form_label('lblDescricao', lang('corpoPosicoesDescricao'), 80);?>
				<?=form_textField('txtDescricao', @$corpo_posicoes->descricao, 400, '');?>

			<?=end_form();?>
		<?=end_Tab();?>
	<?=end_TabPanel();?>

<?=$this->load->view("../../static/_views/footerGlobalView");?>

<script>
	function ajuda(){
    	window.open ('<?=WIKI;?>Pontes');
        }

	function novo(){
		location.href = BASE_URL+'paraformalidade/cadastrosBasicos/corpoPosicoes/novo/';
	}

	function listaCorpoPosicoes(){
		location.href = BASE_URL+'paraformalidade/cadastrosBasicos/corpoPosicoes/';
	}

	function salvar(){
		formCorpoPosicoes_submit();
	}
	
	function formCorpoPosicoes_callback(data){
		if(data.error != undefined){
			messageErrorBox(data.error.message, data.error.field);
		} else {
			if(data.success != undefined) {
				$('#txtCorpoPosicoesId').val(data.corpo_posicoes.id);
                        messageBox(data.success.message, listaCorpoPosicoes);
			}
	    }
	} 

	function excluir(){
		if($('#txtCorpoPosicoesId').val() == ''){
			messageErrorBox("<?=lang('nenhumRegistroSelecionado')?>");
		}else{
			messageConfirm('<?=lang('excluirRegistros')?>', excluirCorpoPosicoes);
		}
	}

	function excluirCorpoPosicoes(confirmaExclusao){
		if(confirmaExclusao){
			$.post(BASE_URL+'paraformalidade/cadastrosBasicos/corpoPosicoes/excluir/', {id: $('#txtCorpoPosicoesId').val()}, 
				function(data){
					if(data.success)
						messageBox("<?=lang('registroExcluido')?>", listaCorpoPosicoes);
					else
						messageErrorBox("<?=lang('registroNaoExcluido')?>");
				});
		}
	}	
	
</script>