<div id='geral'>
    <div id='cenaNome'>
        <strong>Cena </strong>Descricao da cena
    </div>
    <div class="thumbnail" style="border: none!important;width: 100%" >
        <a href="#imagemCompleta" role="button" class="btn" data-toggle="modal">
            <img id='imageVisualizador' src="http://placehold.it/260x180" style="height: auto; width: auto;">
        </a>
        <div class="caption" style='margin-top: -40px'>
            <p>
            <div class="pagination pagination-centered" style='margin-top: -5px'>
                <ul id='paginas'>
                </ul>  
            </div>
            <div id="informacoesGerais">
                <p >
                <dl class="dl-horizontal" id='descricao' style='margin-top: -15px' >
                    <dt><?= lang('escolhaColaborador') ?></dt>
                    <div id='paraPessoas'></div>
                    <dt><?= lang('escolhaDescricao') ?></dt>
                    <dd ><div id='paraDescricao'></div></dd>
                    <dt><?= lang('escolhaAtividadeRegistrada') ?></dt>
                    <dd><div id='atividadeRegistrada'></div></dd>
                    <dt><?= lang('escolhaMobilidade') ?></dt>
                    <dd><div id='equipamentoMobilidade'></div></dd>
                    <dt><?= lang('escolhaSentido') ?></dt>
                    <div id='paraSentidos'></div>
                    <dt><?= lang('escolhaEspaco') ?></dt>
                    <dd><div id='espacoLocalizacao'></div></dd>
                    <dt><?= lang('escolhaCapturado') ?></dt>
                    <dd><div id='paraData'></div></dd>
                    <dt><?= lang('escolhaPeriodo') ?></dt>
                    <dd><div id='turnoOcorrencia'></div></dd>
                </dl>
                <div class="btn-group">
                    <button class="btn btn-primary" OnClick="comentar()"><?= lang('escolhaComentar') ?></button>
                    <button class="btn btn-primary dropdown-toggle" data-toggle="dropdown"><span class="caret"></span></button>
                    <ul class="dropdown-menu">
                        <li><a href="#" OnClick="compartilhar()"><?= lang('escolhaCompartilhar') ?></a></li>
                        <li><a href="#" OnClick="outrosdados()"><?= lang('escolhaVerOutrosDados') ?></a></li>
                        <li><a href="#" OnClick="sobreGrupoAtividade()"><?= lang('escolhaSobreGrupoAtividade') ?></a></li>

                        <li class="divider"></li>
                        <li><a OnClick="contribuir()"><?= lang('escolhaAtualizarDados') ?></a></li>
                    </ul>
                    <button class="btn" style='margin-left: 3px' OnClick="fechar()"><?= lang('escolhaFechar') ?></button>
                </div>
                </p>
            </div>
            <div id='comentar' style='display: none'>
                <div id="comments"></div>
                <button class="btn" href="#" OnClick="voltar()"><?= lang('escolhaVoltar') ?></button>
            </div>
            <div id='outrosDados' style='display: none'>
                <p >
                <dl class="dl-horizontal" id='descricao' style='margin-top: -15px' >
                    <dt><?= lang('escolhaInstalacoes') ?></dt>
                    <div id=instalacoes></div>
                    <dt><?= lang('escolhaClima') ?></dt>
                    <div id='clima'></div>
                    <dt><?= lang('escolhaDtCadastro') ?></dt>
                    <dd><div id='dt_cadastro'></div></dd>

                </dl>

                </p>
                <button class="btn" href="#" OnClick="voltar()"><?= lang('escolhaVoltar') ?></button>
            </div>
            <div id='sobre' style='display: none'>
                <p >
                <div id="sobreGrupo" style="text-align: justify">
                </div>
                </p>
                <button class="btn" href="#" OnClick="voltar()"><?= lang('escolhaVoltar') ?></button>
            </div>
            <div id='compartilhar' style='display: none'>
                <p >
                <p>
                    <button class="btn btn-primary" OnClick="facebookBrag()"><?= lang('escolhaFacebook') ?></button> <button class="btn btn-warning" OnClick="twitter()"><?= lang('escolhaTwitter') ?></button>
                </p>

                </p>
                <button class="btn" OnClick="voltar()" href="#"><?= lang('escolhaVoltar') ?></button>
            </div>

            <div id='contribuir' style='display: none'>
                <p>
                    <span class="label label-info"><?= lang('escolhaQuerAjudar') ?></span>
                    <?= lang('escolhaQuerAjudarMensagem') ?>
                </p>
                <button class="btn btn-primary" href="#" OnClick="colaborar()"><?= lang('paraformalidadesContribuir') ?></button><button class="btn"  style='margin-left: 3px'href="#" OnClick="voltar()"><?= lang('paraformalidadesContribuirOutraHora') ?></button>
            </div>
        </div>
    </div>
</div>
<div id='share' style='display: none' class='row'>
</div>