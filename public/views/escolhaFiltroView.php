<?=$this->load->view("../../static/_views/headerPublicView");?>
<div id='container' class='container'>
    <div class="row">
        <div class='span12'>
            <h3>
                    <?=lang('escolhaPlataforma');?><small><?=lang('escolhaPlataformaApreensao');?></small>
            </h3>
                
            <div class='hero-unit'>
                
                <p>
                    <?=lang('escolhaMensagem');?>
                </p>
                <p>
                     <div class="btn-toolbar">
                        <div class="btn-group">
                          <button class="btn btn-success dropdown-toggle" data-toggle="dropdown">Escolha uma cidade <span class="caret"></span></button>
                          <ul class="dropdown-menu">
                              
                             <?
                                    foreach (@$cidades_atividades as $cidade){
                                        echo '<li><a href="'.BASE_URL.'public/escolha/exibir/'.+$cidade['id'].'">'.$cidade['descricao'].'</a></li>';
                                    }
                              ?> 
                          </ul>
                        </div><!-- /btn-group -->
                    </div>
                </p> 
            </div>
            <p><span class="label label-info"><?=lang('escolhaBemVindo')?></span><?=lang('escolhaBemVindoMensagem')?></p>
        </div>
    </div>
</div>
<p>
                            
</p>




<?=$this->load->view("../../static/_views/footerPublicView");?>
<script>
    $('#container').css('height',$(document).height()-106);
    $('#footer').css('background-color','#c5c5c5');
    $('#footer').css('background-image','none');
    $('#footer').css('border','none');
</script>