<?php

class GrupoAcesso extends Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('ProgramaModel', 'programaModel');
        $this->load->model('EmpresaModel', 'empresaModel');
        $this->load->model('GrupoAcessoModel', 'grupoAcessoModel');
        $this->load->model('PermissaoModel', 'permissaoModel');
    }

    function index() {
        $data['path_bread'] = $this->programaModel->pathBread($_SERVER['REQUEST_URI']);
        $this->load->view('grupoAcessoFiltroView', $data);
    }

    function listaGrupos() {
        $this->grupoAcessoModel->getGruposAcessos($_GET);
    }

    function novo() {
        $data['path_bread'] = $this->programaModel->pathBread($_SERVER['REQUEST_URI']) . ' / Novo';
        $data['empresas'] = $this->empresaModel->getEmpresasCombo();
        $this->load->view('grupoAcessoView', $data);
    }

    function editar($grupoAcessoId) {
        $data['grupoAcesso'] = $this->grupoAcessoModel->getGrupoAcesso($grupoAcessoId);
        $data['path_bread'] = $this->programaModel->pathBread($_SERVER['REQUEST_URI']) . ' / Editar / ' . $data['grupoAcesso']->nome;
        $data['empresas'] = $this->empresaModel->getEmpresasCombo();
        $data['permissao_aplicativos'] = $this->grupoAcessoModel->getMenuPermissoesByGrupoAcessoId($data['grupoAcesso']->id);
        $this->load->view('grupoAcessoView', $data);
    }

    function salvarGrupoAcesso() {
        if ($_POST['txtGrupoAcessoId'] == '') {
            $ret = $this->grupoAcessoModel->incluir($_POST);
        } else {
            $ret = $this->grupoAcessoModel->alterar($_POST);
        }
        if ($ret) {
            $this->ajax->ajaxMessage('success', lang('registroGravado'));
        } else {
            $this->ajax->addAjaxData('error', $this->grupoAcessoModel->validate->getError());
        }
        $this->ajax->returnAjax();
    }

    function listaEmpresas() {
        $this->ajax->returnJqGrid($this->grupoAcessoModel->getEmpresasGrupoAcesso($_GET));
    }

    function salvarGrupoAcessoEmpresa() {
        $ret = $this->grupoAcessoModel->salvarGrupoAcessoEmpresa($_POST);

        if ($ret) {
            $this->ajax->ajaxMessage('success', lang('registroGravado'));
        } else {
            $this->ajax->addAjaxData('error', $this->grupoAcessoModel->validate->getError());
        }
        $this->ajax->returnAjax();
    }

    function excluirEmpresa() {
        $isSucess = $this->grupoAcessoModel->excluirGrupoAcessoEmpresa($_POST['grupoAcessoId'], $_POST['empresaId']);

        if ($isSucess) {
            $this->ajax->addAjaxData('success', 'true');
        } else {
            $this->ajax->addAjaxData('success', 'false');
        }
        $this->ajax->returnAjax();
    }

    function listaPerfisGrupoAcesso() {
        $this->ajax->AddAjaxData('grupoAcessoPerfis', $this->grupoAcessoModel->getPerfisGrupoAcesso($_POST['grupoAcessoId'], $_POST['empresaId']));
        $this->ajax->returnAjax();
    }

    function salvarPerfis() {
        $ret = $this->grupoAcessoModel->salvarPerfis($_POST);

        if ($ret) {
            $this->ajax->addAjaxData('success', 'true');
        } else {
            $this->ajax->addAjaxData('success', 'false');
        }
        $this->ajax->returnAjax();
    }

    function salvarGrupoAcessoPrograma() {
        $ret = $this->grupoAcessoModel->salvarGrupoAcessoPrograma($_POST);

        if ($ret) {
            $this->ajax->ajaxMessage('success', lang('registroGravado'));
        } else {
            $this->ajax->addAjaxData('error', $this->grupoAcessoModel->validate->getError());
        }
        $this->ajax->returnAjax();
    }

    function permissoes($programa) {
        $aPrograma = explode('-', $programa);
        $data['programaId'] = $aPrograma[0];
        $data['grupoAcessoId'] = $aPrograma[2];
        $this->load->view('grupoAcessoPermissoesView', $data);
    }

    function listaMetodosGrid($programaId) {
        $programa = $this->programaModel->getPrograma($programaId);
        $this->permissaoModel->getMetodosGrid($_GET, $programa->link);
    }

    function listaMetodosGrupoAcesso() {
        $this->ajax->AddAjaxData('grupoAcessoPermissoes', $this->grupoAcessoModel->getPermissoesGrupoAcesso($_POST['grupoAcessoId'], $_POST['programaId']));
        $this->ajax->returnAjax();
    }

    function salvarPermissoes() {
        $ret = $this->grupoAcessoModel->salvarPermissoes($_POST);

        if ($ret) {
            $this->ajax->addAjaxData('success', 'true');
        } else {
            $this->ajax->addAjaxData('success', 'false');
        }
        $this->ajax->returnAjax();
    }

}
