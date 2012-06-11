<?php

class Paraformalidade extends Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('../../gerenciador/models/ProgramaModel', 'programaModel');
        $this->load->model('../../gerenciador/models/CidadeModel', 'cidadeModel');
        $this->load->model('cadastros/ParaformalidadeModel', 'paraformalidadeModel');
        $this->load->model('cadastros/GrupoAtividadeModel', 'grupoAtividadeModel');
        $this->load->model('cadastrosBasicos/AtividadeRegistradaModel', 'atividadeRegistradaModel');
        $this->load->model('cadastrosBasicos/LocalModel', 'localModel');
        $this->load->model('cadastrosBasicos/CondicaoAmbientalModel', 'condicoesAmbientaisModel');
        $this->load->model('cadastrosBasicos/ElementoSituacaoModel', 'elementoSituacaoModel');
        $this->load->model('cadastrosBasicos/PonteModel', 'ponteModel');
    }
    
    function index() {
        $data['path_bread'] = $this->programaModel->pathBread($_SERVER['REQUEST_URI']);
        $this->load->view('cadastros/paraformalidadeFiltroView', $data);
    }

    function listaParaformalidades(){
        $this->paraformalidadeModel->getParaformalidades($_GET);
    }

    public function salvar() {
        if (empty($_POST['txtParaformalidadeId'])) {
            $ret = $this->paraformalidadeModel->inserir($_POST);
        } else {
            $ret = $this->paraformalidadeModel->alterar($_POST);
        }
        if ($ret !== FALSE) {
            $this->ajax->addAjaxData('paraformalidade', $ret);
            $this->ajax->ajaxMessage('success', lang('registroGravado'));
        } else {
            if (!$this->paraformalidadeModel->validate->existsErrors()) {
                $this->paraformalidadeModel->validate->addError("txtParaformalidadeId", lang('registroNaoGravado'));
            }
            $this->ajax->addAjaxData('error', $this->paraformalidadeModel->validate->getError());
        }
        $this->ajax->returnAjax();
    }
    
    function verParaformalidades($grupoAtividade) {
	$data['path_bread'] = $this->programaModel->pathBread($_SERVER['REQUEST_URI']);
        $data['grupo_atividade'] = $this->grupoAtividadeModel->getGrupoAtividade($grupoAtividade);
        $data['tipo_registros_atividades'] = $this->atividadeRegistradaModel->getAtividadesRegistradasCombo();
        $data['tipo_local'] = $this->localModel->getLocaisCombo();
        $data['tipo_condicoes_ambientais'] = $this->condicoesAmbientaisModel->getCondicaoAmbientalCombo();
        $data['tipo_elemento_situacao'] = $this->elementoSituacaoModel->getElementosSituacoesCombo();
        $data['tipo_ponte'] = $this->ponteModel->getPonteCombo();
	$this->load->view('cadastros/paraformalidadeView', @$data);
		
    }
    
    function editar($grupoAtividade){
        $data['paraformalidadeCidade'] = $this->cidadeModel->getCidadeById( $data['paraformalidade']->cidade_id );
	$data['path_bread'] = $this->programaModel->pathBread($_SERVER['REQUEST_URI']).' / Editar / '.@$data['paraformalidades']->nome;
	$this->load->view('cadastro/paraformalidadeView', $data);
    }
    
    function excluir(){
	$isSUccess = $this->paraformalidadeModel->excluir($_POST['id']);
	if($isSUccess)
		$this->ajax->addAjaxData('success', true);
	else
		$this->ajax->addAjaxData('success', false);
	$this->ajax->returnAjax();
    }
    
    function buscarCidade(){
        $this->ajax->addAjaxCombo(
                $this->cidadeModel->getCidadeByNome($_GET['q'])
        );
        $this->ajax->returnAjax();
    }
}
