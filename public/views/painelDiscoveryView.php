<div class="panel-group" id="accordion">
    <div class="panel panel-default">
        <div class="panel-heading">
            <h4 class="panel-title">
                <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne" >
                    <i class="icon-tags"></i> Tipos de Atividades
                </a>
            </h4>
        </div>
        <div id="collapseOne" class="panel-collapse">
            <div class="panel-body" style="margin-left:20px" >
                <div id="atividade" class="btn-group" style="white-space:normal" data-toggle="buttons-checkbox">
                    <?
                    foreach ($atividades_registrada as $arrayObject) {
                        $i = 0;
                        foreach ($arrayObject as $key => $value) {
                            switch ($i) {
                                case 0:
                                    $optionValue = $value;
                                    $i++;
                                    break;
                                case 1:
                                    $optionText = $value;
                                    break;
                                case 2:
                                    $optionGroup = $value;
                                    $i = 0;
                                    break;
                            }
                        }
                        $key = (string) $optionValue;
                        $val = (string) $optionText;
                        echo "<button id=\"$key\" type=\"button\" class=\"btn btn-small btn-primary\">$val</button>";
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
    <div class="panel panel-default">
        <div class="panel-heading">
            <h4 class="panel-title">
                <a data-toggle="collapse" data-parent="#accordion" href="#collapseTwo">
                    <i class="icon-tags"></i> Turno
                </a>
            </h4>
        </div>
        <div id="collapseTwo" class="panel-collapse collapse">
            <div class="panel-body" style="margin-left:20px">
                <div id="turno" class="btn-group" style="white-space:normal" data-toggle="buttons-checkbox">
                    <?
                    foreach ($turnos_ocorrencia as $arrayObject) {
                        $i = 0;
                        foreach ($arrayObject as $key => $value) {
                            switch ($i) {
                                case 0:
                                    $optionValue = $value;
                                    $i++;
                                    break;
                                case 1:
                                    $optionText = $value;
                                    break;
                                case 2:
                                    $optionGroup = $value;
                                    $i = 0;
                                    break;
                            }
                        }
                        $key = (string) $optionValue;
                        $val = (string) $optionText;
                        echo "<button id=\"$key\" type=\"button\" class=\"btn btn-small btn-primary\">$val</button>";
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
    <div class="panel panel-default">
        <div class="panel-heading">
            <h4 class="panel-title">
                <a data-toggle="collapse" data-parent="#accordion" href="#collapseTree">
                    <i class="icon-tags"></i> Quantidade
                </a>
            </h4>
        </div>
        <div id="collapseTree" class="panel-collapse collapse">
            <div class="panel-body" style="margin-left:20px">
                <div id="quantidade" class="btn-group" style="white-space:normal" data-toggle="buttons-checkbox">
                    <?
                    foreach ($quantidades_registrada as $arrayObject) {
                        $i = 0;
                        foreach ($arrayObject as $key => $value) {
                            switch ($i) {
                                case 0:
                                    $optionValue = $value;
                                    $i++;
                                    break;
                                case 1:
                                    $optionText = $value;
                                    break;
                                case 2:
                                    $optionGroup = $value;
                                    $i = 0;
                                    break;
                            }
                        }
                        $key = (string) $optionValue;
                        $val = (string) $optionText;
                        echo "<button id=\"$key\" type=\"button\" class=\"btn btn-small btn-primary\">$val</button>";
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
    <div class="panel panel-default">
        <div class="panel-heading">
            <h4 class="panel-title">
                <a data-toggle="collapse" data-parent="#accordion" href="#collapseFour">
                    <i class="icon-tags"></i> Localização
                </a>
            </h4>
        </div>
        <div id="collapseFour" class="panel-collapse collapse">
            <div class="panel-body" style="margin-left:20px">
                <div id="localizacao" class="btn-group" style="white-space:normal" data-toggle="buttons-checkbox">
                    <?
                    foreach ($espacos_localizacao as $arrayObject) {
                        $i = 0;
                        foreach ($arrayObject as $key => $value) {
                            switch ($i) {
                                case 0:
                                    $optionValue = $value;
                                    $i++;
                                    break;
                                case 1:
                                    $optionText = $value;
                                    break;
                                case 2:
                                    $optionGroup = $value;
                                    $i = 0;
                                    break;
                            }
                        }
                        $key = (string) $optionValue;
                        $val = (string) $optionText;
                        echo "<button id=\"$key\" type=\"button\" class=\"btn btn-small btn-primary\">$val</button>";
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
    <div class="panel panel-default">
        <div class="panel-heading">
            <h4 class="panel-title">
                <a data-toggle="collapse" data-parent="#accordion" href="#collapseFive">
                    <i class="icon-tags"></i> Corpos Posição
                </a>
            </h4>
        </div>
        <div id="collapseFive" class="panel-collapse collapse">
            <div class="panel-body" style="margin-left:20px">
                <div id="corpo_posicao" class="btn-group" style="white-space:normal" data-toggle="buttons-checkbox">
                    <?
                    foreach ($corpos_posicao as $arrayObject) {
                        $i = 0;
                        foreach ($arrayObject as $key => $value) {
                            switch ($i) {
                                case 0:
                                    $optionValue = $value;
                                    $i++;
                                    break;
                                case 1:
                                    $optionText = $value;
                                    break;
                                case 2:
                                    $optionGroup = $value;
                                    $i = 0;
                                    break;
                            }
                        }
                        $key = (string) $optionValue;
                        $val = (string) $optionText;
                        echo "<button id=\"$key\" type=\"button\" class=\"btn btn-small btn-primary\">$val</button>";
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
    <div class="panel panel-default">
        <div class="panel-heading">
            <h4 class="panel-title">
                <a data-toggle="collapse" data-parent="#accordion" href="#collapseSix">
                    <i class="icon-tags"></i> Corpos Número
                </a>
            </h4>
        </div>
        <div id="collapseSix" class="panel-collapse collapse">
            <div class="panel-body" style="margin-left:20px">
                <div id="numero_pessoas" class="btn-group" style="white-space:normal" data-toggle="buttons-checkbox">
                    <?
                    foreach ($corpos_numero as $arrayObject) {
                        $i = 0;
                        foreach ($arrayObject as $key => $value) {
                            switch ($i) {
                                case 0:
                                    $optionValue = $value;
                                    $i++;
                                    break;
                                case 1:
                                    $optionText = $value;
                                    break;
                                case 2:
                                    $optionGroup = $value;
                                    $i = 0;
                                    break;
                            }
                        }
                        $key = (string) $optionValue;
                        $val = (string) $optionText;
                        echo "<button id=\"$key\" type=\"button\" class=\"btn btn-small btn-primary\">$val</button>";
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
    <div class="panel panel-default">
        <div class="panel-heading">
            <h4 class="panel-title">
                <a data-toggle="collapse" data-parent="#accordion" href="#collapseSeven">
                    <i class="icon-tags"></i> Sentidos
                </a>
            </h4>
        </div>
        <div id="collapseSeven" class="panel-collapse collapse">
            <div class="panel-body" style="margin-left:20px">
                <div id="sentidos" class="btn-group" style="white-space:normal" data-toggle="buttons-checkbox">
                    <?
                    foreach ($sentidos as $arrayObject) {
                        $i = 0;
                        foreach ($arrayObject as $key => $value) {
                            switch ($i) {
                                case 0:
                                    $optionValue = $value;
                                    $i++;
                                    break;
                                case 1:
                                    $optionText = $value;
                                    break;
                                case 2:
                                    $optionGroup = $value;
                                    $i = 0;
                                    break;
                            }
                        }
                        $key = (string) $optionValue;
                        $val = (string) $optionText;
                        echo "<button id=\"$key\" type=\"button\" class=\"btn btn-small btn-primary\">$val</button>";
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
    <div class="panel panel-default">
        <div class="panel-heading">
            <h4 class="panel-title">
                <a data-toggle="collapse" data-parent="#accordion" href="#collapseEight">
                    <i class="icon-tags"></i> Mobilidade Equipamento
                </a>
            </h4>
        </div>
        <div id="collapseEight" class="panel-collapse collapse">
            <div class="panel-body" style="margin-left:20px">
                <div id="mobilidade_equipamento" class="btn-group" style="white-space:normal" data-toggle="buttons-checkbox">
                    <?
                    foreach ($equipamentos_mobilidade as $arrayObject) {
                        $i = 0;
                        foreach ($arrayObject as $key => $value) {
                            switch ($i) {
                                case 0:
                                    $optionValue = $value;
                                    $i++;
                                    break;
                                case 1:
                                    $optionText = $value;
                                    break;
                                case 2:
                                    $optionGroup = $value;
                                    $i = 0;
                                    break;
                            }
                        }
                        $key = (string) $optionValue;
                        $val = (string) $optionText;
                        echo "<button id=\"$key\" type=\"button\" class=\"btn btn-small btn-primary\">$val</button>";
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
    <div class="panel panel-default">
        <div class="panel-heading">
            <h4 class="panel-title">
                <a data-toggle="collapse" data-parent="#accordion" href="#collapseNine">
                    <i class="icon-tags"></i> Tamanho do Equipamento
                </a>
            </h4>
        </div>
        <div id="collapseNine" class="panel-collapse collapse">
            <div class="panel-body" style="margin-left:20px">

                <div id="tamanho_equipamento" class="btn-group" style="white-space:normal" data-toggle="buttons-checkbox">
                    <?
                    foreach ($equipamentos_porte as $arrayObject) {
                        $i = 0;
                        foreach ($arrayObject as $key => $value) {
                            switch ($i) {
                                case 0:
                                    $optionValue = $value;
                                    $i++;
                                    break;
                                case 1:
                                    $optionText = $value;
                                    break;
                                case 2:
                                    $optionGroup = $value;
                                    $i = 0;
                                    break;
                            }
                        }
                        $key = (string) $optionValue;
                        $val = (string) $optionText;
                        echo "<button id=\"$key\" type=\"button\" class=\"btn btn-small btn-primary\">$val</button>";
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
    <div class="panel panel-default">
        <div class="panel-heading">
            <h4 class="panel-title">
                <a data-toggle="collapse" data-parent="#accordion" href="#collapseTen">
                    <i class="icon-tags"></i> Instalacão do Equipamento
                </a>
            </h4>
        </div>
        <div id="collapseTen" class="panel-collapse collapse">
            <div class="panel-body" style="margin-left:20px">
                <div id="instalacao_equipamento" class="btn-group" style="white-space:normal" data-toggle="buttons-checkbox">
                    <?
                    foreach ($equipamentos_instalacao as $arrayObject) {
                        $i = 0;
                        foreach ($arrayObject as $key => $value) {
                            switch ($i) {
                                case 0:
                                    $optionValue = $value;
                                    $i++;
                                    break;
                                case 1:
                                    $optionText = $value;
                                    break;
                                case 2:
                                    $optionGroup = $value;
                                    $i = 0;
                                    break;
                            }
                        }
                        $key = (string) $optionValue;
                        $val = (string) $optionText;
                        echo "<button id=\"$key\" type=\"button\" class=\"btn btn-small btn-primary\">$val</button>";
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
    <div class="btn-group pull-right" style="margin-top:10px">
        <button class="btn" style='margin-right: 5px' OnClick="back_geral()">Início</button>
        <button type="button" OnClick="clearTags()" class="btn">Desmarcar Tags</button>
        <button id="discovery" onClick="getParaformalidades()" type="button" class="btn btn-primary" data-placement="right" data-toggle="buttons-checkbox" data-toggle="popover" title="" data-content="Selecione as características que você gostaria de ver através das tags e filtre as paraformalidades!" data-original-title="Filtrar">Filtrar</button>
    </div>
</div>
<script>
$('#discovery').popover();
var allMarkers =[];

function clearTags(){
    $('#atividade .btn.active').each(function() {
        $(this).removeClass('active');
    });
    $('#quantidade .btn.active').each(function() {
        $(this).removeClass('active');
    });
    $('#turno .btn.active').each(function() {
        $(this).removeClass('active');
    });
    $('#localizacao .btn.active').each(function() {
        $(this).removeClass('active');
    });
    $('#sentidos .btn.active').each(function() {
        $(this).removeClass('active');
    });
    $('#corpo_posicao .btn.active').each(function() {
        $(this).removeClass('active');
    });
    $('#numero_pessoas .btn.active').each(function() {
        $(this).removeClass('active');
    });
    $('#mobilidade_equipamento .btn.active').each(function() {
        $(this).removeClass('active');
    });
    $('#tamanho_equipamento .btn.active').each(function() {
        $(this).removeClass('active');
    });
    $('#tamanho_equipamento .btn.active').each(function() {
        $(this).removeClass('active');
    });
    $('#instalacao_equipamento .btn.active').each(function() {
        $(this).removeClass('active');
    });
}

function getParaformalidades(){
    var atividade = Array();
    $('#atividade .btn.active').each(function() {
        atividade.push(this.id);
    });
    console.log("atividade");console.log(atividade);
    
    var turno = Array();
    $('#turno .btn.active').each(function() {
        turno.push(this.id);
    });
    console.log("turno");
    console.log(turno);
    
    var quantidade = Array();
    $('#quantidade .btn.active').each(function() {
        quantidade.push(this.id);
    });
    console.log("quantidade");
    console.log(quantidade);
    
    var localizacao = Array();
    $('#localizacao .btn.active').each(function() {
        localizacao.push(this.id);
    });
    console.log("localizacao");
    console.log(localizacao);
    
    var corpo_posicao = Array();
    $('#corpo_posicao .btn.active').each(function() {
        corpo_posicao.push(this.id);
    });
    console.log("corpo_posicao");
    console.log(corpo_posicao);
    
    var numero_pessoas = Array();
    $('#numero_pessoas .btn.active').each(function() {
        numero_pessoas.push(this.id);
    });
    console.log("numero_pessoas");
    console.log(numero_pessoas);
    
    var sentidos = Array();
    $('#sentidos .btn.active').each(function() {
        sentidos.push(this.id);
    });
    console.log("sentidos");
    console.log(sentidos);
    
    var mobilidade_equipamento = Array();
    $('#mobilidade_equipamento .btn.active').each(function() {
        mobilidade_equipamento.push(this.id);
    });
    console.log("mobilidade_equipamento");
    console.log(mobilidade_equipamento);
    
    var tamanho_equipamento = Array();
    $('#tamanho_equipamento .btn.active').each(function() {
        tamanho_equipamento.push(this.id);
    });
    console.log("tamanho_equipamento");
    console.log(tamanho_equipamento);
    
    var instalacao_equipamento = Array();
    $('#instalacao_equipamento .btn.active').each(function() {
        instalacao_equipamento.push(this.id);
    });
    console.log("instalacao_equipamento");
    console.log(instalacao_equipamento);
    $.ajaxSetup({
        cache:false
    });
    $.ajax({
            url : BASE_URL+'public/cidade/carregarParaformalidesToDiscovery/',
            dataType : "json",
            data:{ tipo_atividade: atividade,turno:turno,quantidade:quantidade,localizacao:localizacao,corpo_posicao:corpo_posicao,corpo_numero:numero_pessoas,sentidos:sentidos,mobilidade_equipamento:mobilidade_equipamento,tamanho_equipamento:tamanho_equipamento,instalacao_equipamento:instalacao_equipamento},
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
}
function setAllMap(map) {
  for (var i = 0; i < allMarkers.length; i++) {
    allMarkers[i].setMap(map);
  }
}
</script>
<style>
.panel-title
{
    padding-bottom: 0px!important;
}
.panel-title
{
    font-size: medium !important;
}
</style>