<?=$this->load->view("../../static/_views/headerGlobalView");?>

	<?=path_bread($path_bread);?>

	<?=begin_ToolBar(array('imprimir', 'abrir', 'pesquisar', 'excluir'));?>
	<?=end_ToolBar();?>
        <?=warning('warning', lang('gruposDeAtividadesDevidoProblema'), true, true);?>
	<?=begin_TabPanel('tabPonte');?>
		<?=begin_Tab(lang('grupoAtividadeFiltroLocal'));?>
			<?=begin_form('paraformalidade/cadastros/gruposAtividades/salvar', 'formGruposAtividades');?>
				<?=form_hidden('txtGrupoAtividadeId', @$grupo_atividade->id);?>

                                <?=form_hidden('txtLatOrigem', @$grupo_atividade->geocode_origem_latitude); ?>
                                <?=form_hidden('txtLngOrigem', @$grupo_atividade->geocode_origem_longitude); ?>
                                <?=form_hidden('txtLatDestino', @$grupo_atividade->geocode_destino_latitude); ?>
                                <?=form_hidden('txtLngDestino', @$grupo_atividade->geocode_destino_longitude); ?>

                                <?=form_label('lblCidade', lang('grupoAtividadeCidade'), 80);?>
                                <?=form_textFieldAutoComplete('txtGrupoAtividadeCidadeId', BASE_URL . 'gerenciador/cidade/buscarCidade', @$grupo_atividade->cidade_id, @$grupo_atividade_cidade->nome, 400) ?>
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
                                <?=form_MapWithRoute('MapaWithRoute', @$grupo_atividade->geocode_origem_latitude, @$grupo_atividade->geocode_origem_longitude, @$grupo_atividade->geocode_destino_latitude, @$grupo_atividade->geocode_destino_longitude,'map','405','250', false); ?>
                                <?=new_line();?>
                                
			<?=end_form();?>
		<?=end_Tab();?>
                <?=begin_Tab(lang('cenasCenas'));?>
                    <?=begin_form('paraformalidade/cadastros/cenas/salvar', 'formCenas');?>
                        <?=form_hidden('txtGrupoAtividadeid', @$grupo_atividade->id);?>
                        <?=form_hidden('txtCenaId', ''); ?>

                        <?=form_label('lblCenaNOme', lang('cenasNome'), 80);?>
                        <?=form_textField('txtCenaDescricao', '', 200, '','','');?>
                        <?=new_line();?>

                        <?=form_label('lblCenaDtInicio', lang('cenasDtOcorrencia'), 80);?>
                        <?=form_dateField('Dt_Cena_Ocorrencia');?>
                        <?=new_line();?>

                        <?=form_label('lblCenaAtivo', lang('cenasEstaAtivo'), 80);?>
                        <?=form_checkbox('chkCenaAtivo', 'chkCenaAtivo', 'S', true);?>
                        <?=new_line();?>
                    <?=end_form();?>

                    <?=form_button('novaCena', lang('cenasNovo'), 'limparCena()', 100) ?>
                    <?=form_button('salvarCena', lang('cenasSalvar'), 'salvarCena()', 100) ?>
                    <?=form_button('excluirCena', lang('cenasExcluir'), 'excluirCena()', 100) ?>
                    <?=new_line();?>

                    <?=begin_JqGridPanel('gridCenas', 'auto', '', base_url().'paraformalidade/cadastros/cenas/listaCenas/', array('sortname'=> 'descricao', 'multiselect'=>false,'autoload'=>false,'autowidth'=> true, 'pager'=> true, 'caption'=>lang('cenasCenas')));?>
                            <?=addJqGridColumn('id', 'ID', 0, 'right', array('sortable'=>true, 'hidden'=> true));?>
                            <?=addJqGridColumn('descricao', lang('cenasDescricao'), 70, 'left', array('sortable'=>true));?>
                            <?=addJqGridColumn('estaativo', lang('cenasEstaAtivo'), 10, 'center', array('sortable'=>true));?>
                            <?=addJqGridColumn('dt_ocorrencia', lang('cenasDtOcorrencia'), 10, 'center', array('sortable'=>true));?>
                    <?=end_JqGridPanel();?>


                <?=end_Tab();?>
	<?=end_TabPanel();?>

<?=$this->load->view("../../static/_views/footerGlobalView");?>

<script>
        function reloadGrid(){
            limparCena();
            gridCenas.addParam('txtGrupoAtividadeId',$('#txtGrupoAtividadeId').val());
            gridCenas.load();
        }

        function ajuda(){
                window.open ('<?=WIKI;?>Grupos de Atividade');
        }

	function novo(){
		location.href = BASE_URL+'paraformalidade/cadastros/gruposAtividades/novo/';
	}

	function listaGruposAtividades(){
		location.href = BASE_URL+'paraformalidade/cadastros/gruposAtividades/';
	}

	function salvar(){
		formGruposAtividades_submit();
	}
	
	function formGruposAtividades_callback(data){
		if(data.error != undefined){
			messageErrorBox(data.error.message, data.error.field);
		} else {
			if(data.success != undefined) {
				$('#txtGrupoAtividadeId').val(data.grupo_atividade.id);
                        messageBox(data.success.message, listaGruposAtividades);
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
			$.post(BASE_URL+'paraformalidade/cadastros/gruposAtividades/excluir/', {id: $('#txtGrupoAtividadeId').val()}, 
				function(data){
					if(data.success)
						messageBox("<?=lang('registroExcluido')?>", listaGruposAtividades);
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
        
        function limparCena(){
            $('#txtCenaId').val('');
            $('#txtCenaDescricao').val('');
            $('#esta_ativo').val('N');
            $('#Dt_Cena_Ocorrencia').val('');
        }
        
        function excluirCena(){
            if($('#txtCenaId').val() == ''){
			messageErrorBox("<?=lang('nenhumRegistroSelecionado')?>");
		}else{
			messageConfirm('<?=lang('excluirRegistros')?>', excluirCenaAcao);
		}
        }
        
        function excluirCenaAcao(confirmaExclusao){
            if(confirmaExclusao){
                            $.post(BASE_URL+'paraformalidade/cadastros/cenas/excluir/', {id: $('#txtCenaId').val()}, 
                                    function(data){
                                            if(data.success)
                                                    messageBox("<?=lang('registroExcluido')?>", reloadGrid);
                                            else
                                                    messageErrorBox("<?=lang('registroNaoExcluido')?>");
                                    });
                    }
        }
        
        function salvarCena(){
            if( $('#txtCenaDescricao').val() == '' || $('#Dt_Cena_Ocorrencia').val() == ''){
                messageErrorBox("<?=lang('cenasCamposDevemSerInformados')?>");
            }else{
                formCenas_submit();
            }
            
        }
        
        function formCenas_callback(data){
		if(data.error != undefined){
			messageErrorBox(data.error.message, data.error.field);
		} else {
			if(data.success != undefined) {
				$('#txtCenaId').val(data.cena.id);
                                messageBox(data.success.message,reloadGrid);
                                limparCena();
			}
	    }
	}
        
        function gridCenas_click(cena_id){
		$.post(BASE_URL+'paraformalidade/cadastros/cenas/cena/'+cena_id, {id: cena_id},
                                    function(data){
                                            var cena = data.cena
                                                $('#txtCenaId').val(cena.id);
                                                $('#txtCenaDescricao').val(cena.descricao);
                                                $('#esta_ativo').val(cena.estaativo);
                                                $('#Dt_Cena_Ocorrencia').val(cena.dt_ocorrencia);
                                    });
	}
        
        if( $('#txtLatOrigem').val() != '' ){
            warning.showMessageWarning();
        }else{
            warning.hideMessageWarning();
        }
        reloadGrid();
        
</script>