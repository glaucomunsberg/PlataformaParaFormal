<?=$this->load->view("../../static/_views/headerPublicView");?>
<input type="hidden" name="enderecoBaseImagem" id="enderecoBaseImagem" value="<?=BASE_URL;?>" />
<div id="conteudo" class='conteudo'>ASAHUISHA

    <div id="conteudoParaformalidadeINFO " class="conteudoParaformalidadeINFO ">
         <img id="imagem_visualizacao">
    </div>
    <div id="conteudofacebookComentario " class="conteudofacebookComentario">
        
    </div>
    <div id="compartilhar " class="compartilhar escolhaConteudo">

        <img id="facebook" alt="Smiley face" class='compartilharIconfacebook'/>
        <img id="twitter"alt="Smiley face" class='compartilharIconTwitter'/>
        <img id="Email" alt="Smiley face" class='compartilharIconEmail'/>
    </div>

</div> 


<?=form_MapForParaformal('marcador', @$grupo_atividade->geocode_origem_lat, @$grupo_atividade->geocode_origem_lng, @$paraformalidadesToMaps, 'map', true, false)?>

<?=$this->load->view("../../static/_views/footerPublicView");?>
<script> 
    $('#conteudo').hide();
    function getIdFromMaps($id){
       $.post(BASE_URL+'public/escolha/exibirParaformalidade/'+$id,{id:  $id},function(data){
                var paraformal = data.paraformalidade;
                //document.getElementById('txtParaformalidadeId').value = paraformal.id;
               // document.getElementById('txtLatParaformalidade').value = paraformal.geocode_lat;
                //document.getElementById('txtLngParaformalidade').value = paraformal.geocode_lng;
                //$("#conteudoParaformalidadeINFO").html(paraformal.descricao);
                $('#conteudo').show();
                $('#conteudo').html('<div id="conteudoParaformalidadeINFO " class="conteudoParaformalidadeINFO"> <img id="imagem_visualizacao" ><br>'+paraformal.descricao+ "<br><br>Por: "+paraformal.nome  +"<br>Data: "+paraformal.dt_ocorrencia+'</div><div id="conteudofacebookComentario " class="conteudofacebookComentario"></div>    <div id="compartilhar " class="compartilhar escolhaConteudo"><img alt="Smiley face" class=\'compartilharIconfacebook\' /><img alt="Smiley face" class=\'compartilharIconTwitter\'/><img alt="Smiley face" class=\'compartilharIconEmail\'/></div>');   
                //txtParaformalidadeId.val(data.paraformalidade.paraformalidade_id);
               // cmbTipoRegistroAtividade.setValueCombo(data.paraformalidade.tipo_registro_atividade_id);
                //cmbTipoLocal.setValueCombo(data.paraformalidade.tipo_local_id);
                //cmbTipoCondicaoAmbiental.setValueCombo(data.paraformalidade.tipo_condicao_ambiental_id);
                //cmbTipoElementoSituacao.setValueCombo(data.paraformalidade.tipo_elemento_situacao_id);
                //cmbTipoPonte.setValueCombo(data.paraformalidade.tipo_ponte_id);

                //txtColaboradorId.val(data.paraformalidade.colaborador_id);
                //searchtxtColaboradorId.val(paraformal.nome);
                //$('#chkParaformalidadeAtivo').attr('checked', (data.paraformalidade.esta_ativo == 'S' ? true : false));
                carregarSrcDeImagem(document.getElementById('enderecoBaseImagem').value +'archives/resized_640x480/'+paraformal.nome_gerado);
                //form_MapWithMarker_setPosicao($('#txtLatParaformalidade').val(),$('#txtLngParaformalidade').val());
            });
    }
    function carregarSrcDeImagem(urlImagem){
                var imagemThu = document.getElementById("imagem_visualizacao");
                    imagemThu.style.height = '236px';
                    imagemThu.style.width = '350px';
                    imagemThu.src = urlImagem;
        }
    
    
</script>