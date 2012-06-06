<?=$this->load->view("../../static/_views/headerGlobalView");?>

	<?=path_bread($path_bread);?>

	<?=begin_ToolBar(array('imprimir', 'abrir', 'pesquisar'));?>
	<?=end_ToolBar();?>

	<?=begin_TabPanel('tabPonte');?>
		<?=begin_Tab(lang('ponteFiltro'));?>
			<?=begin_form('paraformalidade/cadastros/grupoAtividade/salvar', 'formGrupoAtividade');?>
				<?=form_hidden('txtGrupoAtividadeId', @$grupo_atividade->id);?>

				<?=form_label('lblDescricao', lang('ponteDescricao'), 80);?>
				<?=form_textField('txtDescricao', @$grupo_atividade->descricao, 400, '');?>
                                <?=new_line();?>

                                <?=form_label('lblCidade', lang('colaboradorCidade'), 80);?>
                                <?= form_textFieldAutoComplete('txtGrupoAtividadeCidadeId', BASE_URL . 'paraformalidade/cadastrosBasicos/colaborador/buscarCidade', @$grupo_atividade->cidade_id, @$grupo_atividade_cidade->nome, 400) ?>
                                <?=new_line();?>

                                <?=form_hidden('txtCidadeNome', @$grupo_atividade_cidade->nome);?>
                                <?=form_label('lblDtInicio', lang('registroAtividadePeriodo'), 80);?>
                        	<?=form_dateField('Dt_Ocorrencia');?>
                                <?=new_line();?>

                                <?=form_MapWithRoute('MapaWithRoute', @$grupo_atividade_cidade->origem_lat, @$grupo_atividade_cidade->origem_lng, @$grupo_atividade_cidade->destino_lat, @$grupo_atividade_cidade->origem_lng, 'map', '400', '400', false) ?>
			<?=end_form();?>
		<?=end_Tab();?>
	<?=end_TabPanel();?>

<?=$this->load->view("../../static/_views/footerGlobalView");?>

<script>
	function ajuda(){
    	window.open ('<?=WIKI;?>Grupos Atividades');
        }

	function novo(){
		location.href = BASE_URL+'paraformalidade/cadastros/grupoAtividade/novo/';
	}

	function listaGrupoAtividade(){
		location.href = BASE_URL+'paraformalidade/cadastros/grupoAtividade/';
	}

	function salvar(){
		formGrupoAtividade_submit();
	}
	
	function formGrupoAtividade_callback(data){
		if(data.error != undefined){
			messageErrorBox(data.error.message, data.error.field);
		} else {
			if(data.success != undefined) {
				$('#txtGrupoAtividadeId').val(data.grupo_atividade.id);
                        messageBox(data.success.message, listaGrupoAtividade);
			}
	    }
	} 

	function excluir(){
		if($('#txtPonteId').val() == ''){
			messageErrorBox("<?=lang('nenhumRegistroSelecionado')?>");
		}else{
			messageConfirm('<?=lang('excluirRegistros')?>', excluirGrupoAtividade);
		}
	}

	function excluirGrupoAtividade(confirmaExclusao){
		if(confirmaExclusao){
			$.post(BASE_URL+'paraformalidade/cadastros/grupoAtividade/excluir/', {id: $('#txtGrupoAtividadeId').val()}, 
				function(data){
					if(data.success)
						messageBox("<?=lang('registroExcluido')?>", listaGrupoAtividade);
					else
						messageErrorBox("<?=lang('registroNaoExcluido')?>");
				});
		}
	}	
        
        function form_MapWithRoute_position(origem, destino, total, caminhos ){
            alert( "Inicio e fim:" + origem.toString() + " - " + destino.toString() + " - " + total );
            alert( caminhos );
        }
</script>