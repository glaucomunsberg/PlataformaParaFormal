<?=$this->load->view("../../static/_views/headerGlobalView");?>

	<?=path_bread($path_bread);?>

	<?=begin_ToolBar(array('imprimir', 'abrir', 'pesquisar'));?>
	<?=end_ToolBar();?>
	<?=begin_TabPanel('tabParaformalidade');?>
		<?=begin_Tab(lang('paraformalidadeParaformalidade'));?>
			<?=begin_form('paraformalidade/cadastros/paraformalidade/salvar', 'formParaformalidade');?>

                                <?=form_hidden('txtParaformalidadeId', ''); ?>
                                <?=form_hidden('enderecoBaseImagem', BASE_URL) ?>
                                
                                <?=form_hidden('txtCenaId', @$cena->id);?>
                                <?=form_hidden('txtCenaOcorrencia', @$cena->dt_ocorrencia);?>
                                <?=form_hidden('txtLatOrigem', @$grupo_atividade->geocode_origem_latitude)?>
                                <?=form_hidden('txtLngOrigem', @$grupo_atividade->geocode_origem_longitude)?>
                                
                                <?=form_label('lblIsLink', lang('paraformalidadesIsLink'), 110);?>
                                <?=form_checkbox('chkParaformalidadeLink', 'chkParaformalidadeLink', '',false);?>
                                <?=new_line();?>
                                
                                <div id="imagem" >
                                    <div style="float: left;">
                                        <?=form_label('lblImagem', lang('paraformalidadesImagemPequena'), 110);?>
					<img id="imagem_visualizacao" src="<?=IMG;?>/default_avatar.jpg" style="display: block; float: left; margin-right: 5px; width: 100px;" class="ui-widget ui-state-default ui-corner-tl ui-corner-bl ui-button-icon-only"/>
                                    </div>
                                    <?=new_line();?>
                                    <?=new_line();?>
                                    
                                    <?=form_label('lblEnviarArquivo', lang('paraformalidadesEnviarImagem'), 110);?>
                                    <?=form_file('txtArquivoImportacao', '', '', '');?>
                                    <?=new_line();?>
                               </div>
                               <div id="link" style="display:none">
                                   <?=form_label('lblLink', lang('paraformalidadesLink'), 110);?>
                                   <?=form_textField('txtLink', '', 365, '');?>
                                   <?=new_line();?>
                               </div>
                                    
                                    <?=form_label('lblDescricao', lang('grupoAtividadeDescricao'), 110);?>
                                    <?=form_textArea('txtDescricao', '', 365);?>
                                    <?=new_line();?>
                                    
                                    <?=form_label('lblParaformlaidadeLocalizacao', lang('paraformalidadesLocalizacao'), 110);?>
                                    <?=form_MapWithMarker('marcador', @$grupo_atividade->geocode_origem_latitude, @$grupo_atividade->geocode_origem_longitude, '370', '250', 'map', true, true)?>
                                    <?=new_line();?>
       
                                    <?=form_label('lblAtivo', lang('paraformalidadesVisibilidade'), 110);?>
                                    <?=form_checkbox('chkParaformalidadeAtivo', 'chkParaformalidadeAtivo', 'S','S');?>
                                    <?=new_line();?>
                                    <?=begin_JqGridPanel('gridParaformalidades', 'auto', '', base_url().'paraformalidade/cadastros/paraformalidade/listaParaformalidades/', array('sortname'=> 'estaativa,id', 'autowidth'=> true, 'pager'=> false, 'autoload'=>false,'caption'=>lang('paraformalidadeParaformalidade')));?>
                                        <?=addJqGridColumn('id', 'ID', 0, 'right', array('sortable'=>true, 'hidden'=> true));?>
                                        <?=addJqGridColumn('descricao', lang('paraformalidadesDescricao'), 45, 'left', array('sortable'=>true));?>
                                        <?=addJqGridColumn('nome_original', lang('paraformalidadesNomeArquivo'), 25, 'center', array('sortable'=>true));?>
                                        <?=addJqGridColumn('estaativa', lang('paraformalidadeVisibilidadeGrid'), 15, 'left', array('sortable'=>true));?>
                                        <?=addJqGridColumn('dt_ocorrencia', lang('cenasDtOcorrencia'), 15, 'center', array('sortable'=>true));?>
                                    <?=end_JqGridPanel();?>
                <?=end_Tab();?>
                <?=begin_Tab(lang('paraformalidadeDadosAuxiliares'));?>
                        <?=form_label('lblTurnoOcorrencia', lang('paraformalidadesTurnoOcorrencia'), 150);?>
                        <?=form_combo('cmbTurnoOcorrencia', @$turnos_ocorrencia, '', 150, '');?>
                        <?=new_line();?>
                        
                        <?=form_label('lblAtividadeRegistrada', lang('paraformalidadesAtividadeRegistrada'), 150);?>
                        <?=form_combo('cmbAtividadeRegistrada', @$atividades_registradas, '', 150, '');?>
                        <?=new_line();?>

                        <?=form_label('lblQuantidadeRegistrada', lang('paraformalidadesQuantidadeRegistrada'), 150);?>
                        <?=form_combo('cmbQuantidadeRegistrada', @$quantidades_registradas, '', 150, '');?>
                        <?=new_line();?>

                        <?=form_label('lblEspacoLocalizacao', lang('paraformalidadesEspacoLocalizacao'), 150);?>
                        <?=form_combo('cmbEspacoLocalizacao', @$espacos_localizacoes, '', 150, '');?>
                        <?=new_line();?>

                        <?=form_label('lblCorpoPosicao', lang('paraformalidadesCorpoPosicao'), 150);?>
                        <?=form_combo('cmbCorpoPosicao', @$corpo_posicoes, '', 150, '');?>
                        <?=new_line();?>

                        <?=form_label('lblCorposNumero', lang('paraformalidadesCorposNumero'), 150);?>
                        <?=form_combo('cmbCorposNumero', @$corpos_numeros, '', 150, '');?>
                        <?=new_line();?>

                        <?=form_label('lblEquipamentoPorte', lang('paraformalidadesEquipamentoPorte'), 150);?>
                        <?=form_combo('cmbEquipamentoPorte', @$equipamento_portes, '', 150, '');?>
                        <?=new_line();?>

                        <?=form_label('lblEquipamentoMobilidade', lang('paraformalidadesEquipamentoMobilidade'), 150);?>
                        <?=form_combo('cmbEquipamentoMobilidade', @$equipamento_mobilidades, '', 150, '');?>
                        <?=new_line();?>
                        <?=end_form();?>

                <?=end_Tab();?>
                <?=begin_Tab(lang('paraformalidadesFinalizarCadastro'));?>
                        <!-- Colaboradores-->
                        <b><?=form_label('lblColorador', lang('paraformalidadesColaborador'), 110);?></b>
                        <?=new_line();?>
                        <hr>
                        <?=form_textFieldAutoComplete('txtColaboradorId', BASE_URL . 'paraformalidade/cadastros/colaboradores/buscarColaborador', @$paraformalidade->colaboradorId, @$paraformalidade->colaboradorNome, 365) ?>
                        <?=form_button('inserirColaborador', lang('paraformalidadesInserir'), 'inserirColaborador()', 100) ?>
                        <?=new_line();?>
                        
                        <?=begin_JqGridPanel('gridColaboradores', 'auto', '', base_url().'paraformalidade/cadastros/paraformalidade/listaColaboradores/', array('sortname'=> 'nome', 'multiselect'=>true,'autoload'=>false,'autowidth'=> true, 'pager'=> false));?>
                            <?=addJqGridColumn('id', 'ID', 0, 'right', array('sortable'=>true, 'hidden'=> true));?>
                            <?=addJqGridColumn('nome', lang('paraformalidadesColaborador'), 70, 'left', array('sortable'=>true));?>
                        <?=end_JqGridPanel();?>
                        <?=form_button('excluirColaborador', lang('paraformalidadesRemover'), 'removerColaborador()', 100) ?>
                        <?=new_line();?>
                        <?=new_line();?>
                        <?=new_line();?>
                        
                        <!-- SENTIDOS-->
                        <b><?=form_label('lblSentidos', lang('paraformalidadesSentidos'), 150);?></b>
                        <?=new_line();?>
                        <hr>
                        <?=form_combo('cmbSentidos', @$sentidos, '', 150, '');?>
                        <?=form_button('inserirSentido', lang('paraformalidadesInserir'), 'inserirSentido()', 100) ?>
                        <?=new_line();?>
                        
                        <?=begin_JqGridPanel('gridSentidos', 'auto', '', base_url().'paraformalidade/cadastros/paraformalidade/listaSentidos/', array('sortname'=> 'descricao', 'multiselect'=>true,'autoload'=>false,'autowidth'=> true, 'pager'=> false));?>
                            <?=addJqGridColumn('id', 'ID', 0, 'right', array('sortable'=>true, 'hidden'=> true));?>
                            <?=addJqGridColumn('descricao', lang('paraformalidadesSentidos'), 70, 'left', array('sortable'=>true));?>
                        <?=end_JqGridPanel();?>
                        <?=form_button('excluirSentido', lang('paraformalidadesRemover'), 'removerSentido()', 100) ?>
                        <?=new_line();?>
                        <?=new_line();?>
                        <?=new_line();?>
                        
                        <!-- CONDICIONANTES-->
                        <b><?=form_label('lblCondicionantes', lang('paraformalidadesContidionantesAmbientais'), 150);?></b>
                        <?=new_line();?>
                        <hr>
                        <?=form_combo('cmbCondicionantes', @$condicionantes_ambientais, '', 150, '');?>
                        <?=form_button('inserirCondicionante', lang('paraformalidadesInserir'), 'inserirCondicionante()', 100) ?>
                        <?=new_line();?>
                        
                        <?=begin_JqGridPanel('gridCondicionantes', 'auto', '', base_url().'paraformalidade/cadastros/paraformalidade/listaCondicionantes/', array('sortname'=> 'descricao', 'multiselect'=>true,'autoload'=>false,'autowidth'=> true, 'pager'=> false));?>
                            <?=addJqGridColumn('id', 'ID', 0, 'right', array('sortable'=>true, 'hidden'=> true));?>
                            <?=addJqGridColumn('descricao', lang('paraformalidadesContidionanteAmbiental'), 70, 'left', array('sortable'=>true));?>
                        <?=end_JqGridPanel();?>
                        <?=form_button('excluirCondicionante', lang('paraformalidadesRemover'), 'removerCondicionante()', 100) ?>
                        <?=new_line();?>
                        <?=new_line();?>
                        <?=new_line();?>
                        
                        <!-- Instalacoes-->
                        <b><?=form_label('lblInstalacoes', lang('paraformalidadesInstalacoes'), 150);?></b>
                        <?=new_line();?>
                        <hr>
                        <?=form_combo('cmbInstalacoes', @$equipamento_instalacoes, '', 150, '');?>
                        <?=form_button('inserirInstalacao', lang('paraformalidadesInserir'), 'inserirInstalacao()', 100) ?>
                        <?=new_line();?>
                        
                        <?=begin_JqGridPanel('gridInstalacoes', 'auto', '', base_url().'paraformalidade/cadastros/paraformalidade/listaInstalacoes/', array('sortname'=> 'descricao', 'multiselect'=>true,'autoload'=>false,'autowidth'=> true, 'pager'=> false));?>
                            <?=addJqGridColumn('id', 'ID', 0, 'right', array('sortable'=>true, 'hidden'=> true));?>
                            <?=addJqGridColumn('descricao', lang('paraformalidadesInstalacao'), 70, 'left', array('sortable'=>true));?>
                        <?=end_JqGridPanel();?>
                        <?=form_button('excluirInstalacao', lang('paraformalidadesRemover'), 'removerInstalacao()', 100) ?>
                        <?=new_line();?>
                        <?=new_line();?>
                        <?=new_line();?>
                        
                        <!-- Clima-->
                        <b><?=form_label('lblClimas', lang('paraformalidadesClimas'), 150);?></b>
                        <?=new_line();?>
                        <hr>
                        <?=form_combo('cmbClimas', @$climas, '', 150, '');?>
                        <?=form_button('inserirClima', lang('paraformalidadesInserir'), 'inserirClima()', 100) ?>
                        <?=new_line();?>
                        
                        <?=begin_JqGridPanel('gridClimas', 'auto', '', base_url().'paraformalidade/cadastros/paraformalidade/listaClimas/', array('sortname'=> 'descricao', 'multiselect'=>true,'autoload'=>false,'autowidth'=> true, 'pager'=> false));?>
                            <?=addJqGridColumn('id', 'ID', 0, 'right', array('sortable'=>true, 'hidden'=> true));?>
                            <?=addJqGridColumn('descricao', lang('paraformalidadesClima'), 70, 'left', array('sortable'=>true));?>
                        <?=end_JqGridPanel();?>
                        <?=form_button('excluirClima', lang('paraformalidadesRemover'), 'removerClima()', 100) ?>
                        <?=new_line();?>
                        <?=new_line();?>
                        <?=new_line();?>

                <?=end_TabPanel();?>
                <?=begin_Tab(lang('paraformalidadesVerImagem'));?>
                        <div style="text-align: center;">
                                <?=form_label('lblColorador', lang('paraformalidadesImagem'), 80);?>
                                <img id="imagem_visualizacao_640x480" src="<?=IMG;?>/default_avatar.jpg" style="display: block; float: left; margin-right: 5px; width: 100px;" class="ui-widget ui-state-default ui-corner-tl ui-corner-bl ui-button-icon-only"/>
                        </div>                           
                <?=end_Tab();?>
<?=$this->load->view("../../static/_views/footerGlobalView");?>

<script>
        (function(){
            pesquisar();
            $("#radio").buttonset();
        })();
         jQuery(document).ready(function() {  
             $("#tabParaformalidade").tabs("option", {"disabled": [2]});
        });
        var isLink = false;
        $('#chkParaformalidadeLink').click( function(){
            if( $('#chkParaformalidadeLink').val() == false){
                $("#imagem").hide("clip");
                $("#link").show("blind");
                $("#tabParaformalidade").tabs("option", {'disabled': 3});
                $('#chkParaformalidadeLink').attr('checked', true);
            }
            else{
                $("#imagem").show("blind");
                $("#link").hide("clip");
                $("#tabParaformalidade").tabs('enable',3);
                $('#chkParaformalidadeLink').attr('checked', false);
            }
            return false;
         });
        
        function pesquisar(){
             novo();
            gridParaformalidades.addParam('txtCenaId', $('#txtCenaId').val());
            gridParaformalidades.load();
        }
        
	function ajuda(){
            window.open ('<?=WIKI;?>Paraformalidade');
        }
        
        function finishUploadarquivoImportacao(){
            messageBox("<?=lang('ParaformalidadeArquivoInserido')?>");
	}

	function novo(){
            gridParaformalidades.load(0);
            $('#txtParaformalidadeId').val('');
            $('#txtLatOrigem').val('');
            $('#txtLngOrigem').val('');
            $('#txtDescricao').val('');
            $('#txtArquivoImportacaoName').val('');
            $('#txtColaboradorId').val('');
            $('#txtArquivoImportacaoId').val('');
            $('#txtLink').val('');
            $('#chkParaformalidadeAtivo').attr('checked', true);
            $('#chkParaformalidadeLink').attr('checked', false);
            cmbTurnoOcorrencia.setValueCombo('');
            cmbAtividadeRegistrada.setValueCombo('');
            cmbQuantidadeRegistrada.setValueCombo('');
            cmbEspacoLocalizacao.setValueCombo('');
            cmbCorpoPosicao.setValueCombo('');
            cmbCorposNumero.setValueCombo('');
            cmbEquipamentoPorte.setValueCombo('');
            cmbEquipamentoMobilidade.setValueCombo('');
            carregarSrcDeImagem( $('#enderecoBaseImagem').val()+'/static/_img/default_avatar.jpg');
            $("#tabParaformalidade").tabs("option", {"disabled": [2]});
            gridParaformalidades.addParam('txtCenaId', $('#txtCenaId').val());
            gridParaformalidades.load($('#txtParaformalidadeId').val());
            loadGrids("0");
	}

	function listaParaformalidade(){
            location.href = BASE_URL+'paraformalidade/cadastros/paraformalidade/';
	}

	function salvar(){
            //Se não está editando
            if( document.getElementById('txtParaformalidadeId').value == '' ){
                if( $('#txtLngOrigem').val() !== '' && $('#txtLatOrigem').val() !== '' && $('#cmbEquipamentoMobilidade').val() !== '' && $('#cmbEquipamentoPorte').val() !== '' && $('#arquivoImportacaoId').val() !== '' &&  $('#cmbTurnoOcorrencia').val() !== '' &&  $('#cmbAtividadeRegistrada').val() !== '' &&  $('#cmbQuantidadeRegistrada').val() !== '' &&  $('#cmbEspacoLocalizacao').val() != '' &&  $('#cmbCorpoPosicao').val() !== '' &&  $('#cmbCorposNumero').val() !== ''){
                    formParaformalidade_submit();

                    gridParaformalidades.addParam('txtCenaId', $('#txtCenaId').val());
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
            novo();
           
            
	}
	
	function formParaformalidade_callback(data){
            if(data.error !== undefined){
                messageErrorBox(data.error.message, data.error.field);
            } else {
                if(data.success !== undefined) {
                    messageBox(data.success.message, pesquisar());
                }
	    }
	} 

	function excluir(){
            if( getSelectedRows('gridParaformalidades').length == 0){
                    messageErrorBox('<?=lang('nenhumRegistroSelecionado')?>');
                }else{
                    messageConfirm('<?=lang('excluirRegistros')?>', excluirParaformalidade);
                }
	}

	function excluirParaformalidade(confirmaExclusao){
            if(confirmaExclusao){
                var pontes;
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
                document.getElementById('txtLatOrigem').value = paraformal.geo_latitude;
                document.getElementById('txtLngOrigem').value = paraformal.geo_longitude;
                document.getElementById('txtDescricao').value = paraformal.descricao;
                document.getElementById('txtLink').value = paraformal.link_para;
                document.getElementById('txtArquivoImportacaoId').value = paraformal.upload_id;
                if(paraformal.estaativa == 'S'){
                    $('#chkParaformalidadeAtivo').attr('checked', true);
                }else{
                    $('#chkParaformalidadeAtivo').attr('checked', false);
                }
                cmbTurnoOcorrencia.setValueCombo(paraformal.turno_ocorrencia_id);
                cmbAtividadeRegistrada.setValueCombo(paraformal.atividade_registrada_id);
                cmbQuantidadeRegistrada.setValueCombo(paraformal.quantidade_registrada_id);
                cmbEspacoLocalizacao.setValueCombo(paraformal.espaco_localizacao_id);
                cmbCorpoPosicao.setValueCombo(paraformal.corpo_posicao_id);
                cmbCorposNumero.setValueCombo(paraformal.corpo_numero_id);
                cmbEquipamentoPorte.setValueCombo(paraformal.equipamento_porte_id);
                cmbEquipamentoMobilidade.setValueCombo(paraformal.equipamento_mobilidade_id);

                $('#txtLink').attr('checked', paraformal.estaativo);
                
                if( $("#link").val() != 'em_branco'){
                    document.getElementById('txtArquivoImportacaoId').value = paraformal.upload_id;
                    document.getElementById('txtArquivoImportacaoName').value = paraformal.nome_original;
                    carregarSrcDeImagem(document.getElementById('enderecoBaseImagem').value +'archives/'+paraformal.nome_gerado);
                    $('#txtLink').val(paraformal.link_para);
                    $("#imagem").show("clip");
                    $("#link").hide("blind");                    
                }else{
                    carregarSrcDeImagem( $('#enderecoBaseImagem').val()+'/static/_img/default_avatar.jpg');
                    $('#chkParaformalidadeLink').attr('checked', true);
                    $("#imagem").hide("blind");
                    $("#link").show("clip");                    
                }
                form_MapWithMarker_setPosicao($('#txtLatOrigem').val(),$('#txtLngOrigem').val());
                $("#tabParaformalidade").tabs('enable',2);
                loadGrids($('#txtParaformalidadeId').val());
            });
            
        }
        
        function form_MapWithMarker_position(lat,longi){
            $('#txtLatOrigem').val(lat);
            $('#txtLngOrigem').val(longi);
        }
        
        function form_MapWithMarker_setPosicao($latitude,$longitude) {
            var latlng = new google.maps.LatLng($latitude, $longitude);
            window.marker.setPosition(latlng);
        }  

        function carregarSrcDeImagem(urlImagem){
            var imagemThu = document.getElementById("imagem_visualizacao");
                imagemThu.src = urlImagem;
            var imagemMaior = document.getElementById("imagem_visualizacao_640x480");
                imagemMaior.style.height = 'auto';
                imagemMaior.style.width = 'auto';
                imagemMaior.src = urlImagem;
        }
        
        function loadGrids(id){
            $('#txtColaboradorId').val('');
            $('#searchtxtColaboradorId').val('');
            cmbSentidos.setValueCombo('');
            cmbCondicionantes.setValueCombo('');
            cmbInstalacoes.setValueCombo('');
            cmbClimas.setValueCombo('');
            gridColaboradores.addParam('txtParaformalidadeId',id);
            gridColaboradores.load();
            gridSentidos.addParam('txtParaformalidadeId',id);
            gridSentidos.load();
            gridCondicionantes.addParam('txtParaformalidadeId',id);
            gridCondicionantes.load();
            gridInstalacoes.addParam('txtParaformalidadeId',id);
            gridInstalacoes.load();
            gridClimas.addParam('txtParaformalidadeId',id);
            gridClimas.load();
        }
        
        function inserirColaborador(){
            $.post(BASE_URL+'paraformalidade/cadastros/paraformalidade/inserirColaborador/', {pessoa_id:  $('#txtColaboradorId').val(), paraformalidadeId: $('#txtParaformalidadeId').val()}, 
                    function(data){
                        if(data.success){
                            messageBox("<?=lang('registroGravado')?>", loadGrids($('#txtParaformalidadeId').val()));
                        }else{
                            messageErrorBox("<?=lang('registroNaoGravado')?>");
                        }
                            
                });
        }
        
        function removerColaborador(){
            if(getSelectedRows('gridColaboradores').length == 0){
                messageErrorBox('<?=lang('nenhumRegistroSelecionado')?>');
            }else{
                messageConfirm('<?=lang('excluirRegistros')?>', excluir_colaboradores);
            }
        }
        
        function excluir_colaboradores(confirmaExclusao){
            if(confirmaExclusao){
                var pontes;
                var ponteGrid = getSelectedRows('gridColaboradores');
               
                for(var i = 0; i < ponteGrid.length; i++)
                    if( pontes == '')
                         pontes = NotaTiposGrid[i];
                    else
                         pontes += ',' + ponteGrid[i];
                $.post(BASE_URL+'paraformalidade/cadastros/paraformalidade/excluirColaborador/', {id:  pontes}, 
                    function(data){
                        if(data.success)
                            messageBox("<?=lang('registroExcluido')?>", gridColaboradores.load('txtParaformalidadeId',$('#txtParaformalidadeId').val()));
                        else
                            messageErrorBox("<?=lang('registroNaoExcluido')?>");
                });
            }
	}
        
        function inserirSentido(){
            $.post(BASE_URL+'paraformalidade/cadastros/paraformalidade/inserirSentido/', {sentido_id:  $('#cmbSentidos').val(), paraformalidadeId: $('#txtParaformalidadeId').val()}, 
                    function(data){
                        if(data.success){
                            messageBox("<?=lang('registroGravado')?>", loadGrids($('#txtParaformalidadeId').val()));
                        }else{
                            messageErrorBox("<?=lang('registroNaoGravado')?>");
                        }
                            
                });
        }
        
        function removerSentido(){
            if(getSelectedRows('gridSentidos').length == 0){
                messageErrorBox('<?=lang('nenhumRegistroSelecionado')?>');
            }else{
                messageConfirm('<?=lang('excluirRegistros')?>', excluir_sentidos);
            }
        }
        
        function excluir_sentidos(confirmaExclusao){
            if(confirmaExclusao){
                var pontes;
                var ponteGrid = getSelectedRows('gridSentidos');
                for(var i = 0; i < ponteGrid.length; i++)
                    if( pontes == '')
                         pontes = NotaTiposGrid[i];
                    else
                         pontes += ',' + ponteGrid[i];

                $.post(BASE_URL+'paraformalidade/cadastros/paraformalidade/excluirSentido/', {id:  pontes}, 
                    function(data){
                        if(data.success)
                            messageBox("<?=lang('registroExcluido')?>", loadGrids($('#txtParaformalidadeId').val()));
                        else
                            messageErrorBox("<?=lang('registroNaoExcluido')?>");
                });
            }
	}
        
        function inserirCondicionante(){
            $.post(BASE_URL+'paraformalidade/cadastros/paraformalidade/inserirCondicionante/', { condicionante_ambiental_id:  $('#cmbCondicionantes').val(), paraformalidadeId: $('#txtParaformalidadeId').val()}, 
                    function(data){
                        if(data.success){
                            messageBox("<?=lang('registroGravado')?>", loadGrids($('#txtParaformalidadeId').val()));
                        }else{
                            messageErrorBox("<?=lang('registroNaoGravado')?>");
                        }
                            
                });
        }
        
        function removerCondicionante(){
            if(getSelectedRows('gridCondicionantes').length == 0){
                messageErrorBox('<?=lang('nenhumRegistroSelecionado')?>');
            }else{
                messageConfirm('<?=lang('excluirRegistros')?>', excluir_condicionantes);
            }
        }
        
        function excluir_condicionantes(confirmaExclusao){
            if(confirmaExclusao){
                var pontes;
                var ponteGrid = getSelectedRows('gridCondicionantes');
                for(var i = 0; i < ponteGrid.length; i++)
                    if( pontes == '')
                         pontes = NotaTiposGrid[i];
                    else
                         pontes += ',' + ponteGrid[i];

                $.post(BASE_URL+'paraformalidade/cadastros/paraformalidade/excluirCondicionante/', {id:  pontes}, 
                    function(data){
                        if(data.success)
                            messageBox("<?=lang('registroExcluido')?>", loadGrids($('#txtParaformalidadeId').val()));
                        else
                            messageErrorBox("<?=lang('registroNaoExcluido')?>");
                });
            }
	}
        
        function inserirInstalacao(){
            $.post(BASE_URL+'paraformalidade/cadastros/paraformalidade/inserirInstalacao/', { instalacao_id:  $('#cmbInstalacoes').val(), paraformalidadeId: $('#txtParaformalidadeId').val()}, 
                    function(data){
                        if(data.success){
                            messageBox("<?=lang('registroGravado')?>", loadGrids($('#txtParaformalidadeId').val()));
                        }else{
                            messageErrorBox("<?=lang('registroNaoGravado')?>");
                        }
                            
                });
        }
        
        function removerInstalacao(){
            if(getSelectedRows('gridInstalacoes').length == 0){
                messageErrorBox('<?=lang('nenhumRegistroSelecionado')?>');
            }else{
                messageConfirm('<?=lang('excluirRegistros')?>', excluir_instalacoes);
            }
        }
        
        function excluir_instalacoes(confirmaExclusao){
            if(confirmaExclusao){
                var pontes;
                var ponteGrid = getSelectedRows('gridInstalacoes');
                for(var i = 0; i < ponteGrid.length; i++)
                    if( pontes == '')
                         pontes = NotaTiposGrid[i];
                    else
                         pontes += ',' + ponteGrid[i];

                $.post(BASE_URL+'paraformalidade/cadastros/paraformalidade/excluirInstalacao/', {id:  pontes}, 
                    function(data){
                        if(data.success)
                            messageBox("<?=lang('registroExcluido')?>", loadGrids($('#txtParaformalidadeId').val()));
                        else
                            messageErrorBox("<?=lang('registroNaoExcluido')?>");
                });
            }
	}
        
        function inserirClima(){
            $.post(BASE_URL+'paraformalidade/cadastros/paraformalidade/inserirClima/', { clima_id:  $('#cmbClimas').val(), paraformalidadeId: $('#txtParaformalidadeId').val()}, 
                    function(data){
                        if(data.success){
                            messageBox("<?=lang('registroGravado')?>", loadGrids($('#txtParaformalidadeId').val()));
                        }else{
                            messageErrorBox("<?=lang('registroNaoGravado')?>");
                        }
                            
                });
        }
        
        function removerClima(){
            if(getSelectedRows('gridClimas').length == 0){
                messageErrorBox('<?=lang('nenhumRegistroSelecionado')?>');
            }else{
                messageConfirm('<?=lang('excluirRegistros')?>', excluir_climas);
            }
        }
        
        function excluir_climas(confirmaExclusao){
            if(confirmaExclusao){
                var pontes;
                var ponteGrid = getSelectedRows('gridClimas');
                for(var i = 0; i < ponteGrid.length; i++)
                    if( pontes == '')
                         pontes = NotaTiposGrid[i];
                    else
                         pontes += ',' + ponteGrid[i];

                $.post(BASE_URL+'paraformalidade/cadastros/paraformalidade/excluirClima/', {id:  pontes}, 
                    function(data){
                        if(data.success)
                            messageBox("<?=lang('registroExcluido')?>", loadGrids($('#txtParaformalidadeId').val()));
                        else
                            messageErrorBox("<?=lang('registroNaoExcluido')?>");
                });
            }
	}
</script>