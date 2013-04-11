<?=$this->load->view("../../static/_views/headerPublicView");?>
<div id='container' class='container'>
    <div class="row" style="margin-top: 20px">
        <div class='span12'>
            <h2>Como contribuir:<small> para começar nos informe o que deseja fazer.</small></h2>
            <div class="row">
                <div class="span3" >
                    <ul class="nav nav-list" >
                      <li class="nav-header">Opções</li>
                      <li id="bottonPosicaoCorrecao"><a href="#"><i class="icon-white icon-home"></i> A posição está incorreta</a></li>
                      <li><a href="#"><i class="icon-book"></i> Tenho uma nova imagem</a></li>
                      <li><a href="#"><i class="icon-pencil"></i> A descrição está incorreta</a></li>
                      <li id="bottonNaoExisteMais"><a href="#"><i class="icon-user"></i> Não existe mais</a></li>
                      <li class="nav-header">Outros</li>
                      <li><a href="#"><i class="icon-user"></i> Uma nova Cena</a></li>
                      <li><a href="#"><i class="icon-cog"></i> Em uma nova Cidade </a></li>
                      <li class="divider"></li>
                      <li id="bottonDenunciar"><a href="#"><i class="icon-flag"></i> Denunciar um abuso</a></li>
                    </ul>
                    
                    
                </div>
                <div id="opcoes">
                   <!-- PARFORMALIDADE INFO-->
                   <div id="paraformalidadeInfo" class='span9'>
                        <div class="hero-unit">
                          <ul class="thumbnails">
                                <li class="span3 tile ">
                                    <a href="#" >
                                        <img id="paraformalidade" src="<?=IMG?>/default_avatar.jpg">
                                    </a>
                                </li>
                            </ul>
                          <p>
                              <span class="label label-info">Informações:</span> Atualmente contamos com as cidades onde foram realizados capturas pelo grupo. Mas em breve, será possível você também adicionar ;)
                          </p>
                        </div>
                    </div>
                   <!-- DENUNCIAR -->
                   <div id="denunciar" class='span9'>
                        <div class="hero-unit">
                            <p>
                              <span class="label label-info">Denuncia</span> É uma pena que isso pode estar ocorrendo. Qual é a sua denúncia?
                            </p>
                            <form class="form-horizontal" novalidate="novalidate">
                                <fieldset>
                                    <div class="btn-group">
                                      <button class="btn btn-danger dropdown-toggle" data-toggle="dropdown">Tipo de denúncia <span class="caret"></span></button>
                                      <div class="control-group">
                                          <label class="control-label">Denúncia</label>
                                          <div class="controls">
                                              <ul class="dropdown-menu">
                                                <li><a href="#">A imagem não pertence a descrição</a></li>
                                                <li><a href="#">A imagem não foi permitida</a></li>
                                                <li><a href="#">A imagem causa constrangimento a alguém</a></li>
                                                <li><a href="#">Um comentário inapropriado</a></li>
                                                <li class="divider"></li>
                                                <li><a href="#">Outro Abuso </a></li>
                                              </ul>
                                          </div>
                                      </div>
                                    </div>
                                    <div class="control-group">
                                          <label class="control-label">Explique-nos</label>
                                          <div class="controls">
                                              <textarea class="input-xlarge" id="txtDenunciar" rows="3"></textarea>
                                          </div>
                                    </div>
                                    <div class="control-group">
                                          <label class="control-label">Link denunciado</label>
                                          <div class="controls">
                                              <input type="text" class="input-xlarge" id="txtDenunciarLink">
                                          </div>
                                    </div>
                                    <div class="form-actions">
                                        <button type="submit" class="btn btn-danger">Denunciar</button>
                                        <button class="btn" onClick="home()">Cancel</button>
                                    </div>
                                </fieldset>
                            </form>
                        </div>
                       <br>
                    </div>
                    <!-- POSICAO DE CORREÇÃO  -->
                    <div id="posicaoCorrecao" class="span9" style="display: none">
                        <div class="hero-unit">
                            <p>
                              <span class="label label-info">Posição Errada</span> A imagem não está na posição correta?! Nos ajude, apontando no mapa a posição correta e clicando em 'Enviar Posição'.
                            </p>
                            <form class="form-horizontal" novalidate="novalidate">
                                <fieldset>
                                    <div style="width: 100%">
                                        <?=form_MapWithMarker('maps', '', '', '200', '200', 'SATELLITE', true, true, '15')?>
                                    </div>
                                    <div class="form-actions">
                                        <button type="submit" class="btn btn-primary">Enviar Posição</button>
                                        <button class="btn" onClick="home()">Cancel</button>
                                    </div>
                                </fieldset>
                            </form>
                            <br>
                        </div>
                    </div>
                    <!-- NÃO ESTÁ PRESENTE MAIS  -->
                    <div id="naoPresenteMais"class="span9" style="display:none">
                        <div class="hero-unit">
                            <p>
                              <span class="label label-info">Não existe mais</span> A paraformalidade não existe mais? Nos conte pq e entraremos em contato caso necessário.
                            </p>
                            <form class="form-horizontal" novalidate="novalidate">
                                <fieldset>
                                  <div class="control-group">
                                    <label class="control-label" for="input01">Seu nome</label>
                                    <div class="controls">
                                      <input type="text" class="input-xlarge" id="txtNome">
                                    </div>
                                  </div>
                                  <div class="control-group">
                                    <label class="control-label" for="input01">Seu email</label>
                                    <div class="controls">
                                      <input type="text" class="input-xlarge" id="txtEmail">

                                    </div>
                                  </div>
                                  <div class="control-group">
                                    <label class="control-label" for="input01">Conte porque</label>
                                    <div class="controls">
                                      <textarea class="input-xlarge" id="textNaoPresente" rows="3"></textarea>
                                      
                                    </div>
                                  </div>
                                  
                                  <div class="form-actions">
                                    <button type="submit" class="btn btn-primary">Save changes</button>
                                    <button class="btn" onClick="home()">Cancel</button>
                                  </div>
                                </fieldset>
                              </form>
                                <br>
                            </div>
                        </div>
                    <button class="btn btn-success" onClick="window.history.go(-1) ">Oops! Desejo Voltar</button>
                </div>
            </div>
        </div>
    </div>
</div>
<?=$this->load->view("../../static/_views/footerPublicView");?>
<script>
    
    function fechar(){
        $('#posicaoCorrecao').hide();
        $('#paraformalidadeInfo').hide();
        $('#denunciar').hide();
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
    function home(){
        fechar();
        $('#paraformalidadeInfo').show();
    }
    $('#container').css('height',$(document).height()-106);
    $('#footer').css('background-color','#c5c5c5');
    $('#footer').css('background-image','none');
    $('#footer').css('border','none');
</script>