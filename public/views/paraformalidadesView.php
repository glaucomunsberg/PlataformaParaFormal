<?=$this->load->view("../../static/_views/headerPublicView");?>
<?=form_hidden('txtCenaId', ''); ?>
<?=form_hidden('txtGrupoAtividadeId', @$grupo_atividade->id); ?>
<input type="hidden" name="enderecoBaseImagem" id="enderecoBaseImagem" value="<?=BASE_URL;?>" />
<div id="fb-root"></div>
<div id="conteudo" style='position: absolute; z-index: 20; width: 40% !important; min-height: 80%; background-color:white;display: none;'>
    <div class='row' style='margin-left: 0px'>
        <div id='geral'>
            
            <div id='cenaNome' style="margin-top: 15px;margin-left: 5px">
                <strong>Cena </strong>Descricao da cena
            </div>
            <div class="thumbnail" >
                    <img id='imageVisualizador' src="http://placehold.it/260x180" alt="">
                    <div class="caption" style='margin-top: -10px'>
                        <p>
                            <div class="pagination pagination-centered" style='margin-top: -5px'>
                                <ul id='paginas'>

                                </ul>  
                            </div>
                        <div id="informacoesGerais">
                            <p >
                                <dl class="dl-horizontal" id='descricao' style='margin-top: -15px' >
                                    <dt><?=lang('escolhaColaborador')?></dt>
                                        <div id='paraPessoas'></div>
                                    <dt><?=lang('escolhaDescricao')?></dt>
                                        <dd ><div id='paraDescricao'></div></dd>
                                    <dt><?=lang('escolhaAtividadeRegistrada')?></dt>
                                        <dd><div id='atividadeRegistrada'></div></dd>
                                    <dt><?=lang('escolhaMobilidade')?></dt>
                                        <dd><div id='equipamentoMobilidade'></div></dd>
                                    <dt><?=lang('escolhaSentido')?></dt>
                                        <div id='paraSentidos'></div>
                                    <dt><?=lang('escolhaEspaco')?></dt>
                                        <dd><div id='espacoLocalizacao'></div></dd>
                                   <dt><?=lang('escolhaCapturado')?></dt>
                                        <dd><div id='paraData'></div></dd>
                                    <dt><?=lang('escolhaPeriodo')?></dt>
                                        <dd><div id='turnoOcorrencia'></div></dd>
                               </dl>
                                <div class="btn-group">
                                  <button class="btn btn-primary" OnClick="comentar()"><?=lang('escolhaComentar')?></button>
                                  <button class="btn btn-primary dropdown-toggle" data-toggle="dropdown"><span class="caret"></span></button>
                                  <ul class="dropdown-menu">
                                    <li><a href="#" OnClick="compartilhar()"><?=lang('escolhaCompartilhar')?></a></li>
                                    <li><a href="#" OnClick="outrosdados()"><?=lang('escolhaVerOutrosDados')?></a></li>
                                    <li><a href="#" OnClick="sobreGrupoAtividade()"><?=lang('escolhaSobreGrupoAtividade')?></a></li>
                                    
                                    <li class="divider"></li>
                                    <li><a OnClick="contribuir()"><?=lang('escolhaAtualizarDados')?></a></li>
                                  </ul>
                                  <button class="btn" style='margin-left: 3px' OnClick="fechar()"><?=lang('escolhaFechar')?></button>
                                </div>
                            </p>
                        </div>
                        <div id='comentar' style='display: none'>
                            <div id="comments"></div>
                            <button class="btn" href="#" OnClick="voltar()"><?=lang('escolhaVoltar')?></button>
                        </div>
                        <div id='outrosDados' style='display: none'>
                            <p >
                                <dl class="dl-horizontal" id='descricao' style='margin-top: -15px' >
                                    <dt><?=lang('escolhaInstalacoes')?></dt>
                                        <div id=instalacoes></div>
                                    <dt><?=lang('escolhaClima')?></dt>
                                        <div id='clima'></div>
                                    <dt><?=lang('escolhaDtCadastro')?></dt>
                                        <dd><div id='dt_cadastro'></div></dd>
                                    
                               </dl>
                                
                            </p>
                            <button class="btn" href="#" OnClick="voltar()"><?=lang('escolhaVoltar')?></button>
                        </div>
                        <div id='sobre' style='display: none'>
                            <p >
                                <div id="sobreGrupo" style="text-align: justify">
                                </div>
                            </p>
                            <button class="btn" href="#" OnClick="voltar()"><?=lang('escolhaVoltar')?></button>
                        </div>
                        <div id='compartilhar' style='display: none'>
                            <p >
                                <p>
                                    <a href="#" class="btn btn-primary" OnClick="facebookBrag()"><?=lang('escolhaFacebook')?></a> <a href="#" class="btn btn-warning" OnClick="twitter()"><?=lang('escolhaTwitter')?></a>
                                </p>
                                
                            </p>
                            <button class="btn" OnClick="voltar()" href="#"><?=lang('escolhaVoltar')?></button>
                        </div>
                        
                        <div id='contribuir' style='display: none'>
                            <p>
                                <span class="label label-info"><?=lang('escolhaQuerAjudar')?></span>
                                 <?=lang('escolhaQuerAjudarMensagem')?>
                            </p>
                            <button class="btn btn-primary" href="#" OnClick="colaborar()"><?=lang('paraformalidadesContribuir')?></button><button class="btn"  style='margin-left: 3px'href="#" OnClick="voltar()"><?=lang('paraformalidadesContribuirOutraHora')?></button>
                       </div>
                    </div>
                </div>
        </div>
        <div id='share' style='display: none' class='row'>
            
        </div>
        
    </div>
    
</div> 


<?=form_MapForParaformal('marcador', @$grupo_atividade->geocode_origem_latitude, @$grupo_atividade->geocode_origem_longitude, @$paraformalidadesToMaps, 'map', true, false)?>

<?=$this->load->view("../../static/_views/footerPublicView");?>
<script> 
    var paraformalidadesListadas;
    var paraformalidadeVingenteId;
    var descricao;
    var cenaId;
    var imagem;
    function getIdFromMaps($id){
       var para_id = $id;
       $.post(BASE_URL+'public/escolha/exibirCena/',{ id:  para_id},function(data){
                var paraformal = data.paraformalidade;
               $('#sobreGrupo').html(paraformal.grupo_descricao);
               $('#cenaNome').html('<strong>'+paraformal.cidade_nome+'</strong> '+paraformal.cena_descricao);
               $('#paraData').text(paraformal.dt_ocorrencia);
               $('#dt_cadastro').text(paraformal.dt_cadastro);
               $('#txtCenaId').text(paraformal.id);
               cenaId = paraformal.id;
               $('#paraDescricao').text(paraformal.para_descricao);
               $('#atividadeRegistrada').text(paraformal.atividade_registrada);
               $('#equipamentoMobilidade').text(paraformal.equipamento_mobilidade);
               $('#espacoLocalizacao').text(paraformal.espaco_localizacao);
               $('#turnoOcorrencia').text(paraformal.turno_ocorrencia);
               var pagina = '';
               if( paraformal.num_paraformalidades != '1'){
                   for(var a =0; a < paraformal.num_paraformalidades; a++){
                       posi = a+1;
                       pagina+='<li><a OnClick="mudarParaformalidade('+a+')">'+posi+'</a></li>';
                   }
               }
               $('#paginas').html(pagina);
               paraformalidadeVingenteId = paraformal.para_id;
               carregarSrcDeImagem(BASE_URL+'archives/'+paraformal.nome_gerado);
               carregaColaboradores(paraformal.para_id);
               carregaSentidos(paraformal.para_id);
               carregaParaformPaginar(paraformal.id);
               carregaClimas(paraformal.para_id);
               carregaInstalacoes(paraformal.para_id);
               descricao = paraformal.cena_descricao;
               image = BASE_URL+'archives/'+paraformal.nome_gerado;
               mudarComments();
            });
            $('#conteudo').show();
    }
    
    function carregarSrcDeImagem(urlImagem){
        var imagemThu = document.getElementById("imageVisualizador");
        imagemThu.style.height = 'auto';
        imagemThu.style.width = '200px';
        imagemThu.src = urlImagem;
        $('#imageVisualizador').css('width','350px auto');
    }
    
    function carregaColaboradores($paraformalidade_id){
        $.post(BASE_URL+'public/escolha/carregaColaboradores/',{ id:  $paraformalidade_id},function(data){
               var colaboradores = data.colaboradores;
               var count = 0;
                for (i in colaboradores) {
                    if (colaboradores.hasOwnProperty(i)) {
                        count++;
                    }
                }
                var pessoas = '';
                for(var a=0; a< count; a++){
                    pessoas+='<dd>'+colaboradores[a].nome+'</dd>';
                }
                $('#paraPessoas').html(pessoas);
            });
    }
    
    function carregaSentidos($paraformalidade_id){
        $.post(BASE_URL+'public/escolha/carregaSentidos/',{ id:  $paraformalidade_id},function(data){
               var sentidos = data.sentidos;
               var count = 0;
                for (i in sentidos) {
                    if (sentidos.hasOwnProperty(i)) {
                        count++;
                    }
                }
                var sentidoss = '';
                for(var a=0; a< count; a++){
                    sentidoss+='<dd>'+sentidos[a].descricao+'</dd>';
                }
                $('#paraSentidos').html(sentidoss);
            });
    }
    
    function carregaClimas($paraformalidade_id){
        $.post(BASE_URL+'public/escolha/carregaClimas/',{ id:  $paraformalidade_id},function(data){
               var climas = data.climas;
               var count = 0;
                for (i in climas) {
                    if (climas.hasOwnProperty(i)) {
                        count++;
                    }
                }
                var climass = '';
                for(var a=0; a< count; a++){
                    climass+='<dd>'+climas[a].descricao+'</dd>';
                }
                $('#clima').html(climass);
            });
    }
    
    function carregaInstalacoes($paraformalidade_id){
        $.post(BASE_URL+'public/escolha/carregaInstalacoes/',{ id:  $paraformalidade_id},function(data){
               var instalacoes = data.instalacoes;
               var count = 0;
                for (i in instalacoes) {
                    if (instalacoes.hasOwnProperty(i)) {
                        count++;
                    }
                }
                var instalacoess = '';
                for(var a=0; a< count; a++){
                    instalacoess+='<dd>'+instalacoes[a].descricao+'</dd>';
                }
                $('#instalacoes').html(instalacoess);
            });
    }
    
    function carregaParaformPaginar($cena_id){
        $.post(BASE_URL+'public/escolha/carregarParaformalides/',{ id:  $cena_id},function(data){
               paraformalidadesListadas = data.paraformalidades;
            });
    }
    function mudarParaformalidade($id){
        paraformalidadeVingenteId = $id;
        $('#paraDescricao').text(paraformalidadesListadas[$id].para_descricao);
        $('#atividadeRegistrada').text(paraformalidadesListadas[$id].atividade_registrada);
        $('#equipamentoMobilidade').text(paraformalidadesListadas[$id].equipamento_mobilidade);
        $('#espacoLocalizacao').text(paraformalidadesListadas[$id].espaco_localizacao);
        $('#turnoOcorrencia').text(paraformalidadesListadas[$id].turno_ocorrencia);
        $('#dt_cadastro').text(paraformalidadesListadas[$id].dt_cadastro);
        carregarSrcDeImagem(BASE_URL+'archives/'+paraformalidadesListadas[$id].nome_gerado);
        carregaColaboradores(paraformalidadesListadas[$id].id)
        carregaSentidos(paraformalidadesListadas[$id].id);
        carregaClimas(paraformalidadesListadas[$id].id);
        carregaInstalacoes(paraformalidadesListadas[$id].id);
        descricao = paraformalidadesListadas[$id].para_descricao;
        imagem = BASE_URL+'archives/'+paraformalidadesListadas[$id].nome_gerado;
        mudarComments();
    }
    
    function contribuir(){
        $('#informacoesGerais').hide('blind');
        $('#contribuir').show('blind');
    }
    
    function outrosdados(){
        $('#informacoesGerais').hide('blind');
        $('#outrosDados').show('blind');
    }
    function comentar(){
        $('#informacoesGerais').hide('blind');
        $('#comentar').show('blind');
    }
    function compartilhar(){
        $('#informacoesGerais').hide('blind');
        $('#compartilhar').show('blind');
    }
    function fechar(){
        $('#conteudo').hide('drop');
    }
    function sobreGrupoAtividade(){
        $('#informacoesGerais').hide('blind');
        $('#sobre').show('blind');
    }
    
    function voltar(){
        $('#sobre').hide('blind');
        $('#compartilhar').hide('blind');
        $('#outrosDados').hide('blind')
        $('#contribuir').hide('blind');
        $('#comentar').hide('blind');
        $('#informacoesGerais').show('blind')
    }
    
    function colaborar(){
        location.href = '<?=BASE_URL?>public/colaborar/contribuirParaformalidade/'+paraformalidadeVingenteId;
    }
    function twitter(){
        $var = descricao;
        $local = BASE_URL+'public/escolha/exibir/'+$('#txtGrupoAtividadeId').val()+'?cena='+cenaId;
        $var = $var.substring(0,20);
        $var = 'Paraformal - '+$var+' '+$local;
        $var = 'http://twitter.com/?status='+$var;
        newwindow=window.open($var,'atHome','height=400,width=400');
	if (window.focus) {newwindow.focus()}
	return false;
    }
    
    function facebookBrag() {
       FB.ui({ 
         method: 'feed',
         link: $local = BASE_URL+'public/escolha/exibir/'+$('#txtGrupoAtividadeId').val()+'?cena='+cenaId,
         picture: imagem,
         name: descricao,
         caption: descricao,
         description: strip_tags($('#paraDescricao').val())
       }, callback);
    }
    
    function callback(response){
        console.log(response)
    }
    
    $('#map').css('width',$(document).width());
    $('#map').css('height',$(document).height()-106);
    $('#footer').css('background-color','#c5c5c5');
    $('#footer').css('background-image','none');
    $('#footer').css('border','none');
    
    function mudarComments(){
        $link = BASE_URL+'public/escolha/exibir/'+$('#txtGrupoAtividadeId').val()+'?cena='+cenaId;
        document.getElementById('comments').innerHTML='<div class="fb-comments" data-href="'+$link+'" data-num-posts="10" data-width="375px"></div>'; 
        FB.XFBML.parse(document.getElementById('comments'));
    }
    
    function strip_tags(html){

            //PROCESS STRING
            if(arguments.length < 3) {
                html=html.replace(/<\/?(?!\!)[^>]*>/gi, '');
            } else {
                var allowed = arguments[1];
                var specified = eval("["+arguments[2]+"]");
                if(allowed){
                    var regex='</?(?!(' + specified.join('|') + '))\b[^>]*>';
                    html=html.replace(new RegExp(regex, 'gi'), '');
                } else{
                    var regex='</?(' + specified.join('|') + ')\b[^>]*>';
                    html=html.replace(new RegExp(regex, 'gi'), '');
                }
            }

            //CHANGE NAME TO CLEAN JUST BECAUSE 
            var clean_string = html;

            //RETURN THE CLEAN STRING
            return clean_string;
         }
</script>
<script type="text/javascript" DEFER="DEFER">
         
    <?
        
        if(@$_GET['cena'] != ''){
            $post = $_GET['cena'];
            if(is_numeric($post)){
                echo 'var cena_recebida = '.$post.';';
            }
        }
    ?>
    
</script>