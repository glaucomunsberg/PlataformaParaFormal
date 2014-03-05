<div class="row">
    <img id="welcom_back_cidade" src="<?= IMG . '/welcome_back.png' ?>" style="height: auto; width: auto;" >
</div>
<div class="row">
    <img src="<?= IMG . "/welcome_select.png" ?>" style="height: auto; width: auto;">
</div>
<div class="row">
    <p>
    <div class="btn-toolbar pull-right">
        <button type="button" onclick="back_geral()" class="btn btn-default" style="margin-right: 5px">Início</button>
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
        
    </div>
</p> 
</div>