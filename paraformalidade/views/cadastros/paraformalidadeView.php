<?=$this->load->view("../../static/_views/headerGlobalView");?>

	<?=path_bread($path_bread);?>

	<?=begin_ToolBar(array('imprimir', 'abrir', 'pesquisar'));?>
	<?=end_ToolBar();?>
	<?=begin_TabPanel('tabParaformalidade');?>
		<?=begin_Tab(lang('paraformalidadesFiltro'));?>
			<?=begin_form('paraformalidade/cadastros/paraformalidade/salvar', 'formParaformalidade');?>
                                <input type="hidden" name="txtParaformalidadeId" id="txtParaformalidadeId" value="" />
                                <input type="hidden" name="txtLatParaformalidade" id="txtLatParaformalidade" value="" />
                                <input type="hidden" name="txtLngParaformalidade" id="txtLngParaformalidade" value="" />
                                <input type="hidden" name="enderecoBaseImagem" id="enderecoBaseImagem" value="<?=BASE_URL;?>" />

                                <?=form_hidden('txtGrupoAtividadeId', @$grupo_atividade->id);?>
                                <?=form_hidden('txtLatOrigem', @$grupo_atividade->geocode_origem_lat); ?>
                                <?=form_hidden('txtLngOrigem', @$grupo_atividade->geocode_origem_lng); ?>
                                <?=form_hidden('txtLatDestino', @$grupo_atividade->geocode_origem_lat); ?>
                                <?=form_hidden('txtLngDestino', @$grupo_atividade->geocode_origem_lng); ?>
                                
                                
                                <div id="editarNovo" style="display:block">
                                    <div style="float: left;">
                                        <?=form_label('lblColorador', lang('paraformalidadesImagemPequena'), 110);?>
					<img id="imagem_visualizacao" src="<?=IMG;?>/default_avatar.jpg" style="display: block; float: left; margin-right: 5px; width: 100px;" class="ui-widget ui-state-default ui-corner-tl ui-corner-bl ui-button-icon-only"/>
                                    </div>
                                    <?=new_line();?>
                                    <?=new_line();?>
                                    
                                    <?=form_label('lblEnviarArquivo', lang('paraformalidadesEnviarImagem'), 110);?>
                                    <?=form_file('arquivoImportacao', '', '', 'doc');?>
                                    <?=new_line();?>

                                    <?=form_label('lblColorador', lang('paraformalidadesColaborador'), 110);?>
                                    <?=form_textFieldAutoComplete('txtColaboradorId', BASE_URL . 'paraformalidade/cadastrosBasicos/colaborador/buscarColaborador', @$paraformalidade->colaboradorId, @$paraformalidade->colaboradorNome, 365) ?>
                                    <?=new_line();?>
                                    
                                    <?=form_label('lblDescricao', lang('grupoAtividadeDescricao'), 110);?>
                                    <?=form_textArea('txtDescricao', '', 365);?>
                                    <?=new_line();?>
                                    
                                    <?=form_label('lblTipoPonte', lang('paraformalidadesLocalizacao'), 110);?>
                                    <?=form_MapWithMarker('marcador', @$grupo_atividade->geocode_origem_lat, @$grupo_atividade->geocode_origem_lng, '370', '250', 'map', true, true)?>
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
                                    
                                    <?=form_label('lblColorador', lang('paraformalidadesVisibilidade'), 110);?>
                                    <?=form_checkbox('chkParaformalidadeAtivo', 'chkParaformalidadeAtivo', 'S', (@$grupo_atividade->esta_ativo == 'S' || @$grupo_atividade->esta_ativo == '' ? true : false));?>
                                    <?=new_line();?>
                                    
                                </div>                                
			<?=end_form();?>
		<?=end_Tab();?>
                <?=begin_Tab(lang('paraformalidadesVerImagem'));?>
                                <div style="float: left;">
                                        <?=form_label('lblColorador', lang('paraformalidadesImagem'), 80);?>
					<img id="imagem_visualizacao_640x480" src="<?=IMG;?>/default_avatar.jpg" style="display: block; float: left; margin-right: 5px; width: 100px;" class="ui-widget ui-state-default ui-corner-tl ui-corner-bl ui-button-icon-only"/>
                                </div>                           
                <?=end_Tab();?>
	<?=end_TabPanel();?>
                               <?=begin_JqGridPanel('gridParaformalidades', 'auto', '', base_url().'paraformalidade/cadastros/paraformalidade/listaParaformalidades/', array('sortname'=> 'nome,esta_ativo', 'autowidth'=> true, 'pager'=> true, 'autoload'=>false));?>
                                        <?=addJqGridColumn('id', 'ID', 0, 'right', array('sortable'=>true, 'hidden'=> true));?>
                                        <?=addJqGridColumn('descricao', lang('paraformalidadesDescricao'), 15, 'left', array('sortable'=>true));?>
                                        <?=addJqGridColumn('nome', lang('paraformalidadesColaborador'), 10, 'left', array('sortable'=>true));?>
                                        <?=addJqGridColumn('tipo_registro_atividade', lang('paraformalidadesTipoRegistroAtividade'), 10, 'center', array('sortable'=>true));?>
                                        <?=addJqGridColumn('tipo_local', lang('paraformalidadesTipoLocal'), 10, 'center', array('sortable'=>true));?>
                                        <?=addJqGridColumn('tipo_condicao_ambiental', lang('paraformalidadesTipoCondicaoAmbiental'), 10, 'center', array('sortable'=>true));?>
                                        <?=addJqGridColumn('tipo_elemento_descricao', lang('paraformalidadesTipoElemento'), 10, 'center', array('sortable'=>true));?>
                                        <?=addJqGridColumn('tipo_ponte', lang('paraformalidadesTipoPonte'), 10, 'center', array('sortable'=>true));?>
                                        <?=addJqGridColumn('esta_ativo', lang('paraformalidadeVisibilidadeGrid'), 10, 'left', array('sortable'=>true));?>
                                        <?=addJqGridColumn('dt_cadastro', lang('grupoAtividadeDtCadastro'), 5, 'center', array('sortable'=>true));?>      
                                <?=end_JqGridPanel();?>
<?=$this->load->view("../../static/_views/footerGlobalView");?>

<script>
        (function(){
            pesquisar();
            $("#radio").buttonset();
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
	}

	function novo(){
                    $('#txtParaformalidadeId').val('');
                    $('#txtLatParaformalidade').val('');
                    $('#txtLngParaformalidade').val('');
                    $('#txtDescricao').val('');
                    $('#txtColaboradorId').val('');
                    $('#searchtxtColaboradorId').val('');
                    $('#chkParaformalidadeAtivo').attr('checked', false);
                    cmbTipoRegistroAtividade.setValueCombo('');
                    cmbTipoLocal.setValueCombo('');
                    cmbTipoCondicaoAmbiental.setValueCombo('');
                    cmbTipoElementoSituacao.setValueCombo('');
                    cmbTipoPonte.setValueCombo('');
                    carregarSrcDeImagem( $('#enderecoBaseImagem').val()+'/static/_img/default_avatar.jpg');
                    gridParaformalidades.load();
	}

	function listaParaformalidade(){
		location.href = BASE_URL+'paraformalidade/cadastros/paraformalidade/';
	}

	function salvar(){
            //Se não está editando
            if( document.getElementById('txtParaformalidadeId').value == '' ){
                if( $('#arquivoImportacaoId').val() != '' &&  $('#txtColaboradorId').val() != '' &&  $('#cmbTipoRegistroAtividade').val() != '' &&  $('#cmbTipoElementoSituacao').val() != '' &&  $('#cmbTipoLocal').val() != '' &&  $('#cmbTipoElementoSituacao').val() != '' &&  $('#txtLatOrigem').val() != ''){
                    formParaformalidade_submit();

                    gridParaformalidades.addParam('txtGrupoAtividadeId', $('#txtGrupoAtividadeId').val());
                    gridParaformalidades.load();
                }
                else{
                    messageErrorBox("<?=lang('paraformalidadeCamposDevemSerInformados')?>");
                }
            }//se está editando
            else
            {
                formParaformalidade_submit();
            }
            
	}
	
	function formParaformalidade_callback(data){
		if(data.error != undefined){
			messageErrorBox(data.error.message, data.error.field);
		} else {
			if(data.success != undefined) {
				$('#txtGrupoAtividadeId').val(data.paraformalidade.id);
                        messageBox(data.success.message, novo());
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
            $.post(BASE_URL+'paraformalidade/cadastros/paraformalidade/editar/'+id,{id:  id},function(data){
                var paraformal = data.paraformalidade;
                
                document.getElementById('txtParaformalidadeId').value = paraformal.id;
                document.getElementById('txtLatParaformalidade').value = paraformal.geocode_lat;
                document.getElementById('txtLngParaformalidade').value = paraformal.geocode_lng;
                document.getElementById('txtDescricao').value = paraformal.descricao;

                //txtParaformalidadeId.val(data.paraformalidade.paraformalidade_id);
                cmbTipoRegistroAtividade.setValueCombo(data.paraformalidade.tipo_registro_atividade_id);
                cmbTipoLocal.setValueCombo(data.paraformalidade.tipo_local_id);
                cmbTipoCondicaoAmbiental.setValueCombo(data.paraformalidade.tipo_condicao_ambiental_id);
                cmbTipoElementoSituacao.setValueCombo(data.paraformalidade.tipo_elemento_situacao_id);
                cmbTipoPonte.setValueCombo(data.paraformalidade.tipo_ponte_id);

                txtColaboradorId.val(data.paraformalidade.colaborador_id);
                searchtxtColaboradorId.val(paraformal.nome);
                $('#chkParaformalidadeAtivo').attr('checked', (data.paraformalidade.esta_ativo == 'S' ? true : false));
                carregarSrcDeImagem(document.getElementById('enderecoBaseImagem').value +'/archives/resized_640x480/'+paraformal.nome_gerado);
                form_MapWithMarker_setPosicao($('#txtLatParaformalidade').val(),$('#txtLngParaformalidade').val());
            });
            
        }
        
        function form_MapWithMarker_position(lat,longi){
            $('#txtLatParaformalidade').val(lat);
            $('#txtLngParaformalidade').val(longi);
        }
        
        function form_MapWithMarker_setPosicao($latitude,$longitude) {
            var latlng = new google.maps.LatLng($latitude, $longitude);
            window.marker.setPosition(latlng);
        }  

        function carregarSrcDeImagem(urlImagem){
                var imagemThu = document.getElementById("imagem_visualizacao");
                    imagemThu.src = urlImagem;
                var imagemMaior = document.getElementById("imagem_visualizacao_640x480");
                    imagemMaior.style.height = '480px';
                    imagemMaior.style.width = '640px';
                    imagemMaior.src = urlImagem;
        }
</script>