<?=$this->load->view("../../static/_views/headerGlobalView");?>

	<?=path_bread($path_bread);?>

	<?=begin_ToolBar(array('imprimir', 'abrir', 'pesquisar', 'excluir'));?>
	<?=end_ToolBar();?>
        <?=warning('warning', lang('gruposDeAtividadesDevidoProblema'), false, true);?>
	<?=begin_TabPanel('tabPonte');?>
		<?=begin_Tab(lang('grupoAtividadeFiltro'));?>
			<?=begin_form('paraformalidade/cadastros/grupoAtividade/salvar', 'formGrupoAtividade');?>
				<?=form_hidden('txtGrupoAtividadeId', @$grupo_atividade->id);?>

                                <?=form_hidden('txtLatOrigem', @$grupo_atividade->geocode_origem_lat); ?>
                                <?=form_hidden('txtLngOrigem', @$grupo_atividade->geocode_origem_lng); ?>
                                <?=form_hidden('txtLatDestino', @$grupo_atividade->geocode_destino_lat); ?>
                                <?=form_hidden('txtLngDestino', @$grupo_atividade->geocode_destino_lng); ?>

                                <?=form_label('lblCidade', lang('grupoAtividadeCidade'), 80);?>
                                <?= form_textFieldAutoComplete('txtGrupoAtividadeCidadeId', BASE_URL . 'paraformalidade/cadastrosBasicos/colaborador/buscarCidade', @$grupo_atividade->cidade_id, @$grupo_atividade_cidade->nome, 400) ?>
                                <?=new_line();?>                               
                                
				<?=form_label('lblDescricao', lang('grupoAtividadeDescricao'), 80);?>
				<?=form_textArea('txtDescricao', @$grupo_atividade->descricao, 400);?>
                                <?=new_line();?>

                                <?=form_hidden('txtCidadeNome', @$grupo_atividade_cidade->nome);?>
                                <?=form_label('lblDtInicio', lang('grupoAtividadeData'), 80);?>
                        	<?=form_dateField('Dt_Ocorrencia');?>
                                <?=new_line();?>

                                <?=form_label('lblDtInicio', lang('grupoAtividadeMetragem'), 80);?>
                                <?=form_textField('txtRotaEmKm', '', 50, '','','', true);?>
                                <?=form_label('lblDtInicio', lang('grupoAtividadeKm'), 80);?>
                                <?=new_line();?>

                                <?=form_label('lblDtInicio', lang('grupoAtividadeRota'), 80);?>
                                <?=form_MapWithRoute('MapaWithRoute', @$grupo_atividade->geocode_origem_lat, @$grupo_atividade->geocode_origem_lng, @$grupo_atividade->geocode_destino_lat, @$grupo_atividade->geocode_destino_lng,'map','405','250', false); ?>
                                <?=new_line();?>
                                
			<?=end_form();?>
		<?=end_Tab();?>
	<?=end_TabPanel();?>

<?=$this->load->view("../../static/_views/footerGlobalView");?>

<script>
	function ajuda(){
    	window.open ('<?=WIKI;?>Grupos de Atividade');
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
		if($('#txtGrupoAtividadeId').val() == ''){
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
            $('#txtLatOrigem').val(origem.lat());
            $('#txtLngOrigem').val(origem.lng());
            $('#txtLatDestino').val(destino.lat());
            $('#txtLngDestino').val(destino.lng());
            $('#txtRotaEmKm').val(total);
        }
</script>