<?=$this->load->view("../../static/_views/headerPublicView");?>
<div id='container' class='container'>
    <?=form_hidden('txtLatOrigem', '')?>
    <?=form_hidden('txtLngOrigem', '')?>
    <?=form_hidden('txtParaformaliadeId', @$paraformalidade->id)?>
    <div class="row" style="margin-top: 20px">
        <div class='span12'>
            <h2><?=lang('contribuirComo')?><small><?=lang('contribuirComoMensagem')?></small></h2>
            <div class="row">
                <div id="alert" class="alert alert-info" style="display: none">
                    <button onClick="$('#alert').hide()" class="close" data-dismiss="alert">×</button>
                    <div id="alertMensagem"></div>
                </div>
                <div class="span3" >
                    <ul class="nav nav-list" >
                      <li class="nav-header"><?=lang('')?></li>
                      <li id="bottonPosicaoCorrecao"><a href="#"><i class="icon-map-marker"></i><?=lang('contribuirPosicaoErrada')?></a></li>
                      <li id="bottonNovaImagem"><a href="#"><i class="icon-camera"></i><?=lang('contribuirNovaImagem')?></a></li>
                      <li id="bottonDescricaoIncorreta"><a href="#"><i class="icon-pencil"></i><?=lang('contribuirDescricaoErrada')?></a></li>
                      <li id="bottonNaoExisteMais"><a href="#"><i class="icon-time"></i><?=lang('contribuirNaoExiste')?></a></li>
                      <li class="nav-header"><?=lang('contribuirOutros')?></li>
                      <li id="bottonNovaCena"><a href="#"><i class="icon-file"></i><?=lang('contribuirUmaNovaCena')?></a></li>
                      <li id="bottonOutraCidade"><a href="#"><i class="icon-folder-open"></i><?=lang('contribuirOutraCidade')?></a></li>
                      <li class="divider"></li>
                      <li id="bottonDenunciar"><a href="#"><i class="icon-flag"></i><?=lang('contribuirDenunciar')?></a></li>
                    </ul>
                </div>
                <div id="opcoes">
                   <!-- PARFORMALIDADE INFO-->
                   <div id="paraformalidadeInfo" class='span9'>
                        <img id="paraformalidade" style="height:500px;width: auto" src="<?=base_url()?>archives/<?=@$paraformalidade->nome_gerado?>">
                        <div class="caption">
                            <h3><?=lang('contribuirInfo')?></h3>
                            <p><?=@$paraformalidade->descricao?></p>
                            <button class="btn btn-success" onClick="window.history.go(-1) "><?=lang('contribuirDesejoVoltar')?></button>
                        </div>
                   </div>
                   <!-- Nova Imagem-->
                   <div id="Novaimagem" class='span9' style="display: none">
                       <div class="hero-unit">
                           <p>
                              <span class="label label-info"><?=lang('contribuirImagem')?></span><?=lang('contribuirImagemMensagem')?>
                            </p>
                           <form class="form-horizontal" novalidate="novalidate">
                                <fieldset>
                                    <div class="control-group">
                                          <label class="control-label"><?=lang('contribuirSeuNome')?></label>
                                          <div class="controls">
                                              <input type="text" class="input-xlarge" id="txtNomeImagem">
                                          </div>
                                    </div> 
                                    <div class="control-group">
                                          <label class="control-label"><?=lang('contribuirSeuEmail')?></label>
                                          <div class="controls">
                                              <input type="text" class="input-xlarge" id="txtEmailImagem">
                                          </div>
                                    </div> 
                                    <div class="control-group">
                                          <label class="control-label"><?=lang('contribuirImagem')?></label>
                                          <div class="controls">
                                              <?=form_file('txtFileImage', '', '','')?>
                                          </div>
                                    </div> 
                                    <div class="control-group">
                                          <label class="control-label"><?=lang('contribuirPqModificarImagem')?></label>
                                          <div class="controls">
                                              <textarea class="input-xlarge" id="txtPqImagem" rows="3"></textarea>
                                          </div>
                                    </div>
                                    <div class="form-actions">
                                        <button type="submit" class="btn btn-primary" onClick="submeterImagem()" ><?=lang('contribuirEnviarImagem')?></button>
                                        <button class="btn" onClick="home()"><?=lang('contribuirCancelar')?></button>
                                    </div>
                                </fieldset>
                            </form>
                           <br>
                       </div>
                   </div>
                   <!-- DENUNCIAR -->
                   <div id="denunciar" class='span9' style="display: none">
                        <div class="hero-unit">
                            <p>
                              <span class="label label-warning"><?=lang('contribuirDenunciar')?></span> <?=lang('contribuirDenunciarMensagem')?>
                            </p>
                            <form class="form-horizontal" novalidate="novalidate">
                                <fieldset>
                                    <div class="control-group">
                                      <label class="control-label" for="input01"><?=lang('contribuirSeuNome')?></label>
                                        <div class="controls">
                                          <input type="text" class="input-xlarge" id="txtNomeDenunciar">
                                        </div>
                                      </div>
                                      <div class="control-group">
                                        <label class="control-label" for="input01"><?=lang('contribuirSeuEmail')?></label>
                                        <div class="controls">
                                          <input type="text" class="input-xlarge" id="txtEmailDenunciar">

                                        </div>
                                      </div>
                                    <div class="control-group">
                                          <label class="control-label"><?=lang('contribuirLinkDenunciar')?></label>
                                          <div class="controls">
                                              <input type="text" class="input-xlarge" id="txtLinkDenunciar">
                                          </div>
                                    </div> 
                                    <div class="control-group">
                                          <label class="control-label"><?=lang('contribuirPqDenunciar')?></label>
                                          <div class="controls">
                                              <textarea class="input-xlarge" id="txtPqDenunciar" rows="3"></textarea>
                                          </div>
                                    </div>
                                    <div class="form-actions">
                                        <button type="submit" onClick="submeterDenunciar()" class="btn btn-danger"><?=lang('contribuirDenunciar')?></button>
                                        <button class="btn" onClick="home()"><?=lang('contribuirCancelar')?></button>
                                    </div>
                                </fieldset>
                            </form>
                            <br>
                        </div>
                       <br>
                    </div>
                    <!-- POSICAO DE CORREÇÃO  -->
                    <div id="posicaoCorrecao" class="span9" style="display: none">
                        <div class="hero-unit">
                            <p>
                              <span class="label label-info"><?=lang('contribuirPosicao')?></span><?=lang('contribuirPosicaoMensagem')?>
                            </p>
                            <form class="form-horizontal" novalidate="novalidate">
                                <fieldset>
                                  <div class="control-group">
                                    <label class="control-label" for="input01"><?=lang('contribuirSeuNome')?></label>
                                    <div class="controls">
                                      <input type="text" class="input-xlarge" id="txtNomePosicao">
                                    </div>
                                  </div>
                                  <div class="control-group">
                                    <label class="control-label" for="input01"><?=lang('contribuirSeuEmail')?></label>
                                    <div class="controls">
                                      <input type="text" class="input-xlarge" id="txtEmailPosicao">

                                    </div>
                                  </div>
                                  <div class="control-group">
                                    <label class="control-label" for="input01"><?=lang('contribuirContePq')?></label>
                                    <div class="controls">
                                      <textarea class="input-xlarge" id="txtNaoPosicao" rows="3"></textarea>
                                    </div>
                                  </div>
                                    <div style="width: 100%">
                                        <?=form_MapWithMarker('maps', $paraformalidade->geo_latitude, $paraformalidade->geo_longitude, '500', '200', 'SATELLITE', true, true, '15')?>
                                    </div>
                                    <div class="form-actions">
                                        <button type="submit" onClick="submeterPosicao()" class="btn btn-primary" onClick="submeterPosicao()"><?=lang('contribuirSubmeterPosicao')?></button>
                                        <button class="btn" onClick="home()"><?=lang('contribuirCancelar')?></button>
                                    </div>
                                </fieldset>
                            </form>
                            <br>
                        </div> 
                    </div>
                     <!-- DESCRICAO ERRADA  -->
                    <div id="descricaoIncorreta"class="span9" style="display:none">
                        <div class="hero-unit">
                            <p>
                              <span class="label label-info"><?=lang('contribuirDescricao')?></span><?=lang('contribuirDescricaoMensagem')?>
                            </p>
                            <form class="form-horizontal" novalidate="novalidate">
                                <fieldset>
                                  <div class="control-group">
                                    <label class="control-label" for="input01"><?=lang('contribuirSeuNome')?></label>
                                    <div class="controls">
                                      <input type="text" class="input-xlarge" id="txtNomeIncorreto">
                                    </div>
                                  </div>
                                  <div class="control-group">
                                    <label class="control-label" for="input01"><?=lang('contribuirSeuEmail')?></label>
                                    <div class="controls">
                                      <input type="text" class="input-xlarge" id="txtEmailIncorreto">

                                    </div>
                                  </div>
                                  <div class="control-group">
                                    <label class="control-label" for="input01"><?=lang('contribuirPqModificarImagem')?></label>
                                    <div class="controls">
                                      <textarea class="input-xlarge" id="textPqIncorreto" rows="4"></textarea>
                                      
                                    </div>
                                  </div>
                                  
                                  <div class="form-actions">
                                    <button type="submit" onClick="submeterDescricao()" class="btn btn-primary"><?=lang('contribuirEnviar')?></button>
                                    <button class="btn" onClick="home()"><?=lang('contribuirCancelar')?></button>
                                  </div>
                                </fieldset>
                              </form>
                                <br>
                            </div>
                        </div>
                    <!-- NÃO EXISTE MAIS  -->
                    <div id="naoPresenteMais"class="span9" style="display:none">
                        <div class="hero-unit">
                            <p>
                              <span class="label label-info"><?=lang('contribuirNaoExiste')?></span><?=lang('contribuirNaoExisteMensagem')?>
                            </p>
                            <form class="form-horizontal" novalidate="novalidate">
                                <fieldset>
                                  <div class="control-group">
                                    <label class="control-label" for="input01"><?=lang('contribuirSeuNome')?></label>
                                    <div class="controls">
                                      <input type="text" class="input-xlarge" id="txtNomeNaoPresente">
                                    </div>
                                  </div>
                                  <div class="control-group">
                                    <label class="control-label" for="input01"><?=lang('contribuirSeuEmail')?></label>
                                    <div class="controls">
                                      <input type="text" class="input-xlarge" id="txtEmailNaoPresente">

                                    </div>
                                  </div>
                                  <div class="control-group">
                                    <label class="control-label" for="input01"><?=lang('contribuirNaoExisteMaisPq')?></label>
                                    <div class="controls">
                                      <textarea class="input-xlarge" id="textNaoPresente" rows="3"></textarea>
                                      
                                    </div>
                                  </div>
                                  
                                  <div class="form-actions">
                                    <button type="submit" onClick="submeterNaoExiste()" class="btn btn-primary"><?=lang('contribuirEnviar')?></button>
                                    <button class="btn" onClick="home()"><?=lang('contribuirCancelar')?></button>
                                  </div>
                                </fieldset>
                              </form>
                                <br>
                            </div>
                        </div>
                    <br>
                    
                </div>
                
            </div>
        </div>
        
    </div>
</div>
<?=$this->load->view("../../static/_views/footerPublicView");?>
<script>
    
    function fechar(){
        $('#naoPresenteMais').hide();
        $('#posicaoCorrecao').hide();
        $('#paraformalidadeInfo').hide();
        $('#denunciar').hide();
        $('#Novaimagem').hide();
        $('#descricaoIncorreta').hide();
    }
    $('#bottonNaoExisteMais').click(function (){
        fechar();
        $('#naoPresenteMais').show();
    });
    $('#bottonPosicaoCorrecao').click(function(){
        fechar();
        $('#posicaoCorrecao').show();
    });  
    $('#bottonDenunciar').click( function(){
        fechar();
        $('#denunciar').show();
    });
    $('#bottonNovaImagem').click( function(){
        fechar();
        $('#Novaimagem').show();
    });
    $('#bottonDescricaoIncorreta').click( function(){
        fechar();
        $('#descricaoIncorreta').show();
    });
    function home(){
        fechar();
        $('#paraformalidadeInfo').show();
    }
    $('#container').css('height',$(document).height()-106);
    $('#footer').css('background-color','#c5c5c5');
    $('#footer').css('background-image','none');
    $('#footer').css('border','none');
    
    function form_MapWithMarker_position(lat,longi){
            $('#txtLatOrigem').val(lat);
            $('#txtLngOrigem').val(longi);
      }    
    
    function submeterPosicao(){
                             
         if( $('#txtNaoPosicao').val() == '' || $('#txtEmailPosicao').val() == '' || $('#txtNomePosicao').val() == '' || $('#txtLatOrigem').val() == '' || $('#txtLngOrigem').val() == ''){

             $('#alertMensagem').html('<?=lang('contribuirPreenchaTodos')?>')
             $('#alert').show();
             $('#txtNaoPosicao').val('');
             $('#txtEmailPosicao').val('');
             $('#txtNomePosicao').val('');
         }else{
             $.post(BASE_URL+'public/colaborar/colaborarComDados/',{
                 txtParaformaliadeId: '<?=@$paraformalidade->id?>',
                 txtDescricao:  $('#txtNaoPosicao').val(),
                 txtEmail : $('#txtEmailPosicao').val(),
                 txtNome: $('#txtNomePosicao').val(),
                 txtGeoLatitude: $('#txtLatOrigem').val(),
                 txtGeoLongitude: $('#txtLngOrigem').val()
                 },function(data){
                     var colaboracao = data.colaboracao;
                     if(colaboracao){
                         $('#alertMensagem').html('<?=lang('contribuirSalvoNotificar')?>');
                         $('#alert').show();
                     }else{
                         $('#alertMensagem').html('<?=lang('contribuirFalha')?>');
                         $('#alert').show();
                     }
                     $('#txtNaoPosicao').val('');
                     $('#txtEmailPosicao').val('');
                     $('#txtNomePosicao').val('');
                     home();
             });
         }
     }
     
    function submeterImagem(){
         if( $('#txtNomeImagem').val() == '' || $('#txtEmailImagemId').val() == '' || $('#txtFileImage').val() == '' || $('#txtPqImagem').val() == ''){
             $('#alertMensagem').html('<?=lang('contribuirPreenchaTodos')?>')
             $('#alert').show();

             $('#txtNomeImagem').val('');
             $('#txtEmailImagem').val('');
             $('#txtFileImageId').val('');
             $('#txtFileImageName').val('');
             $('#txtPqImagem').val('');
         }else{
             $.post(BASE_URL+'public/colaborar/colaborarComDados/',{
                 txtParaformaliadeId: '<?=@$paraformalidade->id?>',
                 txtDescricao:  $('#txtPqImagem').val(),
                 txtEmail : $('#txtEmailImagem').val(),
                 txtNome: $('#txtNomeImagem').val(),
                 txtImagemId: $('#txtFileImageId').val()
                 },function(data){
                     var colaboracao = data.colaboracao;
                     if(colaboracao === true){
                         $('#alertMensagem').html('<?=lang('contribuirSalvoNotificar')?>');
                         $('#alert').show();
                     }else{
                         $('#alertMensagem').html('<?=lang('contribuirFalha')?>');
                         $('#alert').show();
                     }
                     $('#txtNomeImagem').val('');
                     $('#txtEmailImagem').val('');
                     $('#txtFileImageId').val('');
                     $('#txtFileImageName').val('');
                     $('#txtPqImagem').val('');
                     home();
             });
         }
      }
     
    function submeterDescricao(){
         if( $('#txtNomeIncorreto').val() == '' || $('#txtEmailIncorreto').val() == '' || $('#textPqIncorreto').val() == ''){
             $('#alertMensagem').html('<?=lang('contribuirPreenchaTodos')?>')
             $('#alert').show();

             $('#txtNomeIncorreto').val('');
             $('#txtEmailIncorreto').val('');
             $('#textPqIncorreto').val('');
         }else{
             $.post(BASE_URL+'public/colaborar/colaborarComDados/',{
                 txtParaformaliadeId: '<?=@$paraformalidade->id?>',
                 txtDescricao:  $('#textPqIncorreto').val(),
                 txtEmail : $('#txtEmailIncorreto').val(),
                 txtNome: $('#txtNomeIncorreto').val()
                 },function(data){
                     var colaboracao = data.colaboracao;
                     if(colaboracao === true){
                         $('#alertMensagem').html('<?=lang('contribuirSalvoNotificar')?>');
                         $('#alert').show();
                     }else{
                         $('#alertMensagem').html('<?=lang('contribuirFalha')?>');
                         $('#alert').show();
                     }
                     $('#txtNomeIncorreto').val('');
                     $('#txtEmailIncorreto').val('');
                     $('#textPqIncorreto').val('');
                     home();
             });
         }
      }
      
    function submeterNaoExiste(){
         if( $('#txtNomeNaoPresente').val() == '' || $('#txtEmailNaoPresente').val() == '' || $('#textPqNaoPresente').val() == ''){
             $('#alertMensagem').html('<?=lang('contribuirPreenchaTodos')?>')
             $('#alert').show();

             $('#txtNomeNaoPresente').val('');
             $('#txtEmailNaoPresente').val('');
             $('#textPqNaoPresente').val('');
         }else{
             $.post(BASE_URL+'public/colaborar/colaborarComDados/',{
                 txtParaformaliadeId: '<?=@$paraformalidade->id?>',
                 txtDescricao:  $('#textPqNaoPresente').val(),
                 txtEmail : $('#txtEmailNaoPresente').val(),
                 txtNome: $('#txtNomeNaoPresente').val()
                 },function(data){
                     var colaboracao = data.colaboracao;
                     if(colaboracao === true){
                         $('#alertMensagem').html('<?=lang('contribuirSalvoNotificar')?>');
                         $('#alert').show();
                     }else{
                         $('#alertMensagem').html('<?=lang('contribuirFalha')?>');
                         $('#alert').show();
                     }
                      $('#txtNomeNaoPresente').val('');
                      $('#txtEmailNaoPresente').val('');
                      $('#textPqNaoPresente').val('');
             });
         }
      }
      
    function submeterDenunciar(){
         if( $('#txtNomeDenunciar').val() == '' || $('#txtEmailDenunciar').val() == '' || $('#textPqDenunciar').val() == '' || $('#textLinkDenunciar').val() == ''){
             $('#alertMensagem').html('<?=lang('contribuirPreenchaTodos')?>')
             $('#alert').show();
             $('#txtNomeDenunciar').val('');
             $('#txtEmailDenunciar').val('');
             $('#textPqDenunciar').val('');
             $('#textLinkDenunciar').val('');
         }else{
             $.post(BASE_URL+'public/colaborar/colaborarDenunciar/',{
                 txtParaformaliadeId: '<?=@$paraformalidade->id?>',
                 txtDescricao:  $('#txtPqDenunciar').val(),
                 txtEmail : $('#txtEmailDenunciar').val(),
                 txtNome: $('#txtNomeDenunciar').val(),
                 txtLink: $('#textLinkDenunciar').val()
                 },function(data){
                     var colaboracao = data.colaboracao;
                     if(colaboracao === true){
                         $('#alertMensagem').html('<?=lang('contribuirSalvoNotificar')?>');
                         $('#alert').show();
                     }else{
                         $('#alertMensagem').html('<?=lang('contribuirFalha')?>');
                         $('#alert').show();
                     }
                    $('#txtNomeDenunciar').val('');
                    $('#txtEmailDenunciar').val('');
                    $('#textPqDenunciar').val('');
                    $('#textLinkDenunciar').val('');
                     home();
             });
         }
      }
</script>