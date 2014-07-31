<div id="welcome_back" class="row">
    <img src="<?= IMG . '/welcome_back.png' ?>" style="height: auto; width: auto;" >
</div>
<div class="row">
    <?
    if (!empty($cidade_id)) {
        $img = 'welcome_select.png';
    } else {
        $img = 'welcome_choose.png';
    }
    ?>
    <img id="welcome_img" src="<?= IMG . "/$img" ?>" style="height: auto; width: auto;">
</div>
<div class="row">
    <p>
    <div class="btn-toolbar">
        <div class="btn-group">
            <button class="btn btn-success dropdown-toggle" data-toggle="dropdown">Cidades <span class="caret"></span></button>
            <ul class="dropdown-menu">
                <?
                foreach (@$cidades_atividades as $cidade) {
                    echo '<li><a onClick="selectCity('. +$cidade['id'] .')">' . $cidade['descricao'] . '</a></li>';
                }
                ?> 
            </ul>
        </div>
        <button type="button" onclick="showDiscovery()" class="btn btn-default pull-right">Discovery</button>
    </div>
</p> 
</div>
<script>
function selectCity($value){
    
    ga('send', 'event', 'Principal', 'click', 'Go_Cidade', $value);
    
    $('#welcome_back').hide();
    $('#welcom_back_cidade').hide();
    $("#welcome_img").attr("src", IMG+'/welcome.png');
    painelSelecionado = 2;
    clearTags();
    $.ajaxSetup({
        cache:false
    });
    $.ajax({
            url : BASE_URL+'public/cidade/carregarParaformalidesToDiscovery/',
            dataType : "json",
            data:{ grupo_atividade:$value},
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
    $('#menu_geral').hide();
    $('#menu_menu').hide();
    $('#menu_cidade').show('drop');
}

</script>