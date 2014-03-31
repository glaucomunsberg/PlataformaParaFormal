<?=$this->load->view("../../static/_views/headerPublicView");?>
<?=form_hidden('txtCenaId', ''); ?>
<?=form_hidden('txtGrupoAtividadeId', @$grupo_atividade->id); ?>
<input type="hidden" name="enderecoBaseImagem" id="enderecoBaseImagem" value="<?=BASE_URL;?>" />
<div id="fb-root"></div>
<div id="imagemCompleta" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h3 id="myModalLabel">Imagem</h3>
    </div>
    <div id="myModelBody" class="modal-body" style="max-height:none !important">
        <img id="imagemFull" src="http://placehold.it/260x180">
    </div>
</div>
<div class="row-fluid">
    <div id="painelLateral" class="span3" >
        <div id="menu_geral" style="padding-left: 30px;margin-top: 20px">
            <?=$this->load->view('painelGeralView')?>
        </div>
        <div id="menu_conteudo" style='margin-left: 5px;margin-top: 20px;display: none;'>
            <?=$this->load->view('painelConteudoView')?>
        </div>
        <div id="menu_discovery" style="margin-left: 5px;margin-top: 20px;display: none;">
            <?=$this->load->view("painelDiscoveryView")?>
        </div>
        <div id="menu_cidade" style="padding-left: 30px;margin-top: 20px;display: none">
            <?=$this->load->view("painelCidadeView")?>
        </div>
        </br>
    </div>
    <div class="span9" id="span_map">
        <?=form_MapForParaformal('marcador', @$grupo_atividade->geocode_origem_latitude, @$grupo_atividade->geocode_origem_longitude, @$paraformalidadesToMaps, 'map', true, false,3)?>
    </div>
</div>

<?=$this->load->view("../../static/_views/footerPublicView");?>
<script> 
    var paraformalidadesListadas;
    var paraformalidadeVingenteId;
    var descricao;
    var cenaId;
    var imagem;
    var painelSelecionado = 1; //1-discovery 2-city 3-geral
    
    function getIdFromMaps($id){
       var para_id = $id;
       $.post(BASE_URL+'public/cidade/exibirCena/',{ id:  para_id},function(data){
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
               carregarSrcDeImagem(BASE_URL+'archives/resized_640x480/'+paraformal.nome_gerado);
               carregaColaboradores(paraformal.para_id);
               carregaSentidos(paraformal.para_id);
               carregaParaformPaginar(paraformal.id);
               carregaClimas(paraformal.para_id);
               carregaInstalacoes(paraformal.para_id);
               descricao = paraformal.cena_descricao;
               image = BASE_URL+'archives/resized_640x480/'+paraformal.nome_gerado;
               mudarComments();
            });
            $('#menu_geral').hide();
            $('#menu_discovery').hide();
            $('#menu_cidade').hide();
            $('#menu_conteudo').show('drop');
    }
    
    function carregarSrcDeImagem(urlImagem){
        var painelLateral = document.getElementById("painelLateral"); 
        var imagemThu = document.getElementById("imageVisualizador");
        imagemThu.style.height = 'auto';
        imagemThu.style.width = 'auto';
        imagemThu.src = urlImagem;
        $('#myModalLabel').text("Imagem");
        $('#myModelBody').text("");
        $("#imagemFull").attr("src", urlImagem);
    }
    
    function carregaColaboradores($paraformalidade_id){
        $.post(BASE_URL+'public/cidade/carregaColaboradores/',{ id:  $paraformalidade_id},function(data){
               var colaboradores = data.colaboradores;
               var count = 0;
                for (i in colaboradores) {
                    if (colaboradores.hasOwnProperty(i)) {
                        count++;
                    }
                }
                var pessoas = '';
                for( var a=0; a< count; a++){
                    pessoas+='<dd>'+colaboradores[a].nome+'</dd>';
                }
                $('#paraPessoas').html(pessoas);
            });
    }
    
    function carregaSentidos($paraformalidade_id){
        $.post(BASE_URL+'public/cidade/carregaSentidos/',{ id:  $paraformalidade_id},function(data){
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
        $.post(BASE_URL+'public/cidade/carregaClimas/',{ id:  $paraformalidade_id},function(data){
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
        $.post(BASE_URL+'public/cidade/carregaInstalacoes/',{ id:  $paraformalidade_id},function(data){
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
        $.post(BASE_URL+'public/cidade/carregarParaformalides/',{ id:  $cena_id},function(data){
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
        carregarSrcDeImagem(BASE_URL+'archives/resized_640x480/'+paraformalidadesListadas[$id].nome_gerado);
        carregaColaboradores(paraformalidadesListadas[$id].id)
        carregaSentidos(paraformalidadesListadas[$id].id);
        carregaClimas(paraformalidadesListadas[$id].id);
        carregaInstalacoes(paraformalidadesListadas[$id].id);
        descricao = paraformalidadesListadas[$id].para_descricao;
        imagem = BASE_URL+'archives/resized_640x480/'+paraformalidadesListadas[$id].nome_gerado;
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
        $('#menu_conteudo').hide();
        if(painelSelecionado == 1){
            $('#menu_discovery').show('drop');
        }
        if(painelSelecionado == 2){
            $('#menu_cidade').show('drop');
        }
        if(painelSelecionado == 3){
            $('#menu_geral').show('drop');
        }
        
    }
    function back_geral(){
        painelSelecionado = 3;
        $('#menu_discovery').hide();
        $('#menu_cidade').hide();
        $('#menu_geral').show('drop');
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
        $local = BASE_URL+'public/cidade/exibir/'+$('#txtGrupoAtividadeId').val()+'?cena='+cenaId;
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
         link: $local = BASE_URL+'public/cidade/exibir/'+$('#txtGrupoAtividadeId').val()+'?cena='+cenaId,
         picture: imagem,
         name: descricao,
         caption: descricao,
         description: strip_tags($('#paraDescricao').val())
       }, callback);
    }
    
    function callback(response){
        console.log(response);
    }
    
    $('#map').css('min-height',$(document).height()-106);
    $('#footer').css('background-color','#c5c5c5');
    $('#footer').css('background-image','none');
    $('#footer').css('border','none');
    
    function mudarComments(){
        $link = BASE_URL+'public/cidade/exibir/?cena='+cenaId;
        document.getElementById('comments').innerHTML='<div class="fb-comments" data-href="'+$link+'" data-num-posts="10"></div>'; 
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
         
         function showDiscovery(){
             
             painelSelecionado = 1;
             $('#menu_geral').hide();
             $('#menu_discovery').show('drop');
             $('#welcome_back').hide();
             $('#welcom_back_cidade').hide();
             $("#welcome_img").attr("src", IMG+'/welcome.png');
             map.setZoom(4);
             map.setCenter(new google.maps.LatLng(-16.37, -49.26));
         }
    <?
        if(@$_GET['cena'] != ''){
            $post = $_GET['cena'];
            if(is_numeric($post)){
               ?>
                $.realy(
                        $.ajaxSetup({
                            cache:false
                        });
                        $.ajax({
                            url : BASE_URL+'public/cidade/carregarParaformalidesToDiscovery/',
                            dataType : "json",
                            data:{ cena:<?=$post?>},
                            success : function(data){
                                var locations = data;
                                setAllMap(null);
                                var latCenter =0;
                                var lngCenter =0;
                                for(i=0; i < locations.length ; i++){
                                      latCenter=latCenter+parseInt(locations[i][0]);
                                      lngCenter=lngCenter+parseInt(locations[i][1]);
                                      marker = new google.maps.Marker({
                                        position: new google.maps.LatLng(locations[i][0], locations[i][1]),
                                        map: map
                                      });
                                      google.maps.event.addListener(marker, 'click', (function(marker, i) {
                                        return function() {
                                            getIdFromMaps(locations[i][2]);
                                        }
                                      })(marker, i));
                                    allMarkers.push(marker);
                                }
                                console.log(latCenter/locations.length);
                                console.log(lngCenter/locations.length);
                                map.setCenter(new google.maps.LatLng(latCenter/locations.length, lngCenter/locations.length));
                            },
                            error: function(xhr, ajaxOptions, thrownError){
                                $('#myModalLabel').text("Error");
                                $('#imagemFull').attr('src',null);
                                $('#myModelBody').text("Ooops! Um erro no servidor aconteceu, tente novamente mais tarde");
                                $("#imagemCompleta").modal('show');
                            }
                        });
                        );
               <?
            }
        }
    ?>
</script>