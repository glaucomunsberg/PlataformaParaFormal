<?=$this->load->view("../../static/_views/headerGlobalView");?>

	<?=path_bread($path_bread);?>

	<?=begin_ToolBar(array('imprimir', 'abrir', 'pesquisar'));?>
	<?=end_ToolBar();?>

	<?=begin_TabPanel('tabParaformalidade');?>
		<?=begin_Tab(lang('ponteFiltro'));?>
			<?=begin_form('paraformalidade/cadastros/paraformalidade/salvar', 'formParaformalidade');?>
				
                                <?=form_hidden('txtParaformalidadeId', '');?>
                                <?=form_hidden('txtLatParaformalidade',''); ?>
                                <?=form_hidden('txtLngParaformalidade', ''); ?>
                                <?=form_hidden('enderecoBaseImagem', BASE_URL); ?>

                                <?=form_hidden('txtGrupoAtividadeId', @$grupo_atividade->id);?>
                                <?=form_hidden('txtLatOrigem', @$grupo_atividade->geocode_origem_lat); ?>
                                <?=form_hidden('txtLngOrigem', @$grupo_atividade->geocode_origem_lng); ?>
                                <?=form_hidden('txtLatDestino', @$grupo_atividade->geocode_origem_lat); ?>
                                <?=form_hidden('txtLngDestino', @$grupo_atividade->geocode_origem_lng); ?>

                                <div id="editarNovo" style="display:block">
                                    <div style="float: left;">
                                        <?=form_label('lblColorador', lang('paraformalidadesImagemPequena'), 110);?>
					<? if(@$grupo_atividade->imagem_id == '') {?>
						<img id="imagem_visualizacao" src="<?=IMG;?>/default_avatar.jpg" style="display: block; float: left; margin-right: 5px; width: 100px;"/>
					<? }else{?>
						<img id="imagem_visualizacao" src="<?=IMG;?>util/download/arquivo/<?=$pessoa->nome_gerado;?>/3x4" style="display: block; float: left; margin-right: 5px; width: 100px;"/>
					<? }?>
                                                

                                    </div>
                                    <?=new_line();?>
                                    
                                    <?=form_label('lblEnviarArquivo', lang('paraformalidadesEnviarImagem'), 110);?>
                                    <?=form_file('arquivoImportacao', '', '', 'jpg');?>
                                    <?=new_line();?>

                                    <?=form_label('lblColorador', lang('paraformalidadesColaborador'), 110);?>
                                    <?=form_textFieldAutoComplete('txtColaboradorId', BASE_URL . 'paraformalidade/cadastrosBasicos/colaborador/buscarColaborador', @$paraformalidade->colaboradorId, @$paraformalidade->colaboradorNome, 365) ?>
                                    <?=new_line();?>
                                    
                                    <?=form_label('lblDescricao', lang('grupoAtividadeDescricao'), 110);?>
                                    <?=form_textArea('txtDescricao', '', 365);?>
                                    <?=new_line();?>
                                    

                                    <?=form_label('lblTipoRegistroAtividade', lang('paraformalidadesRegistroAtividade'), 110);?>
                                    <?=form_combo('cmbTipoRegistroAtividade', @$tipo_registros_atividades, '', 150, '');?>
                                    <?=new_line();?>
                                    
                                    <?=form_label('lblTipoLocal', lang('paraformalidadesLocal'), 110);?>
                                    <?=form_combo('cmbTipoLocal', @$tipo_local, '', 150, '');?>
                                    <?=new_line();?>
                                    
                                    <?=form_label('lblTipoCondicoesAmbientais', lang('paraformalidadesCondicaoAmbiental'), 110);?>
                                    <?=form_combo('cmbTipoCondicaoAmbiental', @$tipo_condicoes_ambientais, '', 150, '');?>
                                    <?=new_line();?>
                                    
                                    <?=form_label('lblTipoElementoSituacao', lang('paraformalidadesElementoSituacao'), 110);?>
                                    <?=form_combo('cmbTipoElementoSituacao', @$tipo_elemento_situacao, '', 150, '');?>
                                    <?=new_line();?>
                                    
                                    <?=form_label('lblTipoPonte', lang('paraformalidadesPonte'), 110);?>
                                    <?=form_combo('cmbTipoPonte', @$tipo_ponte, '', 150, '');?>
                                    <?=new_line();?>
                                    
                                    <?=form_label('lblTipoPonte', lang('paraformalidadesLocalizacao'), 110);?>
                                    <?=form_MapWithMarker('marcador', @$grupo_atividade->geocode_origem_lat, @$grupo_atividade->geocode_origem_lng, '260', '250', 'map', true, true)?>
                                    <?=new_line();?>
                                </div>

                                <?=new_line();?>

                                <?=begin_JqGridPanel('gridParaformalidades', 'auto', '', base_url().'paraformalidade/cadastros/paraformalidade/listaParaformalidades/', array('sortname'=> 'descricao', 'autowidth'=> true, 'pager'=> true, 'autoload'=>false));?>
                                        <?=addJqGridColumn('id', 'ID', 0, 'right', array('sortable'=>true, 'hidden'=> true));?>
                                        <?=addJqGridColumn('descricao', lang('paraformalidadesDescricao'), 15, 'left', array('sortable'=>true));?>
                                        <?=addJqGridColumn('nome', lang('paraformalidadesColaborador'), 10, 'left', array('sortable'=>true));?>
                                        <?=addJqGridColumn('tipo_registro_atividade', lang('paraformalidadesTipoRegistroAtividade'), 10, 'center', array('sortable'=>true));?>
                                        <?=addJqGridColumn('tipo_local', lang('paraformalidadesTipoLocal'), 10, 'center', array('sortable'=>true));?>
                                        <?=addJqGridColumn('tipo_condicao_ambiental', lang('paraformalidadesTipoCondicaoAmbiental'), 10, 'center', array('sortable'=>true));?>
                                        <?=addJqGridColumn('tipo_elemento_descricao', lang('paraformalidadesTipoElemento'), 10, 'center', array('sortable'=>true));?>
                                        <?=addJqGridColumn('tipo_ponte', lang('paraformalidadesTipoPonte'), 10, 'center', array('sortable'=>true));?>
                                        <?=addJqGridColumn('dt_cadastro', lang('grupoAtividadeDtCadastro'), 5, 'center', array('sortable'=>true));?>      
                                <?=end_JqGridPanel();?>
                                
			<?=end_form();?>
		<?=end_Tab();?>
	<?=end_TabPanel();?>

<?=$this->load->view("../../static/_views/footerGlobalView");?>

<script>
        (function(){
            pesquisar();
        })();
        
        function pesquisar(){
            gridParaformalidades.addParam('txtGrupoAtividadeId', $('#txtGrupoAtividadeId').val());
            gridParaformalidades.load();
        }
        
	function ajuda(){
                window.open ('<?=WIKI;?>Paraformalidade');
        }
        
        function finishUploadarquivoImportacao(){
            console.log('arquivo enviado com sucesso');
            alert('final');
	}

	function novo(){
                    $('#txtParaformalidadeId').val('');
                    $('#txtLatParaformalidade').val('');
                    $('#txtLngParaformalidade').val('');
                    $('#txtDescricao').val('');
                    $('#txtColaboradorId').val('');
                    $('#searchtxtColaboradorId').val('');
                    cmbTipoRegistroAtividade.setValueCombo('');
                    cmbTipoLocal.setValueCombo('');
                    cmbTipoCondicaoAmbiental.setValueCombo('');
                    cmbTipoElementoSituacao.setValueCombo('');
                    cmbTipoPonte.setValueCombo('');
                    carregarSrcDeImagem( $('#enderecoBaseImagem').val()+'/static/_img/default_avatar.jpg')
	}

	function listaParaformalidade(){
		location.href = BASE_URL+'paraformalidade/cadastros/paraformalidade/';
	}

	function salvar(){
            
            if( $('#arquivoImportacaoId').val() != '' &&  $('#txtColaboradorId').val() != '' &&  $('#cmbTipoRegistroAtividade').val() != '' &&  $('#cmbTipoElementoSituacao').val() != '' &&  $('#cmbTipoLocal').val() != '' &&  $('#cmbTipoElementoSituacao').val() != '' &&  $('#txtLatOrigem').val() != ''){
                formParaformalidade_submit();

                gridParaformalidades.addParam('txtGrupoAtividadeId', $('#txtGrupoAtividadeId').val());
                gridParaformalidades.load();
            }
            else{
                messageErrorBox("<?=lang('paraformalidadeCamposDevemSerInformados')?>");
            }
                    
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
		if($('#txtParaformalidadeId').val() != ''){
			messageErrorBox("<?=lang('nenhumRegistroSelecionado')?>");
		}else{
			messageConfirm('<?=lang('paraformalidadeAtencaoExcluir')?>', excluirParaformalidade);
		}
	}

	function excluirParaformalidade(confirmaExclusao){
		if(confirmaExclusao){
			var pontes
			var ponteGrid = getSelectedRows('gridParaformalidades');
			for(var i = 0; i < ponteGrid.length; i++)
				if( pontes == '')
					 pontes = NotaTiposGrid[i];
				else
					 pontes += ',' + ponteGrid[i];

			$.post(BASE_URL+'paraformalidade/cadastros/paraformalidade/excluir/', {id:  pontes}, 
				function(data){
					if(data.success)
						messageBox("<?=lang('registroExcluido')?>", pesquisar);
					else
						messageErrorBox("<?=lang('registroNaoExcluido')?>");
				});
		}
	}
	
        function gridParaformalidades_click(id){
            $.post(BASE_URL+'paraformalidade/cadastros/paraformalidade/editar/'+id,function(data){
                
                txtParaformalidadeId.val(data.paraformalidade.id);//data.paraformalidade.id
                txtLatParaformalidade.val(data.paraformalidade.geocode_lat);
                txtLngParaformalidade.val(data.paraformalidade.geocode_lng);
                txtDescricao.val(data.paraformalidade.descricao);
                txtParaformalidadeId.val(data.paraformalidade.id);
                cmbTipoRegistroAtividade.setValueCombo(data.paraformalidade.tipo_registo_atividade_id);
                cmbTipoLocal.setValueCombo(data.paraformalidade.tipo_local_id);
                cmbTipoCondicaoAmbiental.setValueCombo(data.paraformalidade.tipo_condicao_ambiental_id);
                cmbTipoElementoSituacao.setValueCombo(data.paraformalidade.tipo_elemento_situacao_id);
                cmbTipoPonte.setValueCombo(data.paraformalidade.tipo_ponte_id);

                //txtColaboradorId.val(data.paraformalidade.colaborador_id);
                //searchtxtColaboradorId.val(data.paraformalidade.colaborador);
                //carregarSrcDeImagem($('#enderecoBaseImagem').val()+'/archives/thumbs_48x48/'+data.paraformalidade.nomeimagem);
            });
                                
        }
        
        function form_MapWithMarker_position(lat,longi){
            $('#txtLatParaformalidade').val(lat);
            $('#txtLngParaformalidade').val(longi);
        }
        
        function carregarSrcDeImagem(urlImagem){
            var imagem = document.getElementById("imagem_visualizacao");
                imagem.src = urlImagem; 
        }
        
</script>