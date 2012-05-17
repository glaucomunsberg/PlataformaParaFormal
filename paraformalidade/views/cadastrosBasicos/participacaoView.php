<?=$this->load->view("../../static/_views/headerGlobalView");?>

	<?=path_bread($path_bread);?>

	<?=begin_ToolBar(array('imprimir', 'abrir', 'pesquisar'));?>
	<?=end_ToolBar();?>

	<?=begin_TabPanel('tabparticipacao');?>
		<?=begin_Tab(lang('particupacaoFiltro'));?>
			<?=begin_form('paraformalidade/cadastrosBasicos/participacao/salvar', 'formParticipacao');?>
				<?=form_hidden('txtParticipacaoId', @$participacao->id);?>

				<?=form_label('lblDescricao', lang('particupacaoDescricao'), 80);?>
				<?=form_textField('txtDescricao', @$participacao->descricao, 400, '');?>

			<?=end_form();?>
		<?=end_Tab();?>
	<?=end_TabPanel();?>

<?=$this->load->view("../../static/_views/footerGlobalView");?>

<script>
	function ajuda(){
    	window.open ('<?=WIKI;?>Participações');
        }

	function novo(){
		location.href = BASE_URL+'paraformalidade/cadastrosBasicos/participacao/novo/';
	}

	function listaParticipacoes(){
		location.href = BASE_URL+'paraformalidade/cadastrosBasicos/participacao/';
	}

	function salvar(){
		formParticipacao_submit();
	}
	
	function formParticipacao_callback(data){
		if(data.error != undefined){
			messageErrorBox(data.error.message, data.error.field);
		} else {
			if(data.success != undefined) {
				$('#txtParticipacaoId').val(data.participacao.id);
                        messageBox(data.success.message, listaParticipacoes);
			}
	    }
	} 

	function excluir(){
		if($('#txtCondicaoAmbientalId').val() == ''){
			messageErrorBox("<?=lang('nenhumRegistroSelecionado')?>");
		}else{
			messageConfirm('<?=lang('excluirRegistros')?>', excluirParticipacao);
		}
	}

	function excluirParticipacao(confirmaExclusao){
		if(confirmaExclusao){
			$.post(BASE_URL+'paraformalidade/cadastrosBasicos/participacao/excluir/', {id: $('#txtParticipacaoId').val()}, 
				function(data){
					if(data.success)
						messageBox("<?=lang('registroExcluido')?>", listaParticipacoes);
					else
						messageErrorBox("<?=lang('registroNaoExcluido')?>");
				});
		}
	}	
	
</script>