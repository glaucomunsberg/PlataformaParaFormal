<?=$this->load->view("../../static/_views/headerPublicView");?>
<div id='container' class='container'>
    <div class="row">
        <div class='span12'>
           
                
            <div class="hero-unit">
                <h1>Colaborador,</h1>
                <p>Atualmente a plataforma está sendo alimentada apenas pela equipe do Cidade+Contemporaneidade. Mas estamos trabalhando para que também possa nos ajudar! 
                    Em breve estará disponível aqui para que você insira e/ou atualize uma paraformalidade. Legal neh?! </p>
                <p><a class="btn btn-primary btn-large">Fique de Olho</a></p>
            </div>
            <p><span class="label label-info">Não achou sua cidade?</span> Atualmente contamos com as cidades onde foram realizados capturas pelo grupo. Mas em breve, será possível você também adicionar ;)</p>
        </div>
    </div>
</div>
<?=$this->load->view("../../static/_views/footerPublicView");?>
<script>
    $('#container').css('height',$(document).height()-106);
    $('#footer').css('background-color','#c5c5c5');
    $('#footer').css('background-image','none');
    $('#footer').css('border','none');
</script>