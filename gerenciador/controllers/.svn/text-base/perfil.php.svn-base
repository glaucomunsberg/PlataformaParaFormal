<?php

class Perfil extends Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('ProgramaModel', 'programaModel');
        $this->load->model('PerfilModel', 'perfilModel');
    }

    function index() {
        $data['path_bread'] = $this->programaModel->pathBread($_SERVER['REQUEST_URI']);
        $this->load->view('perfilFiltroView', $data);
    }

    function salvar() {
        if ($_POST['txtCodigo'] == '') {
            $ret = $this->perfilModel->incluirPerfil($_POST);
        } else {
            $ret = $this->perfilModel->alterarPerfil($_POST);
        }
        if ($ret) {
            $this->ajax->ajaxMessage('success', lang('registroGravado'));
        } else {
            $this->ajax->addAjaxData('error', $this->perfilModel->validate->getError());
        }
        $this->ajax->returnAjax();
    }

    function excluir() {
        $isSucess = $this->perfilModel->excluirPerfil($_POST['perfis']);

        if ($isSucess) {
            $this->ajax->addAjaxData('success', 'true');
        } else {
            $this->ajax->addAjaxData('success', 'false');
        }
        $this->ajax->returnAjax();
    }

    function salvarProgramaPai() {
        if ($_POST['txtIdProgramaPerfilPai'] == '') {
            $ret = $this->perfilModel->incluirProgramaPai($_POST, 0);
        } else {
            $ret = $this->perfilModel->alterarProgramaPai($_POST);
        }
        if ($ret) {
            $this->ajax->ajaxMessage('success', lang('registroGravado'));
        } else {
            $this->ajax->addAjaxData('error', $this->grupoModel->validate->getError());
        }
        $this->ajax->returnAjax();
    }

    function salvarPrograma() {
        if ($_POST['txtIdProgramaPerfil'] == '') {
            $ret = $this->perfilModel->incluirPrograma($_POST, $_POST['txtIdPerfil'], $_POST['txtIdProgramaPai']);
        } else {
            $ret = $this->perfilModel->alterarPrograma($_POST, $_POST['txtIdPerfil'], $_POST['txtIdProgramaPai']);
        }
        if ($ret) {
            $this->ajax->ajaxMessage('success', lang('registroGravado'));
        } else {
            $this->ajax->addAjaxData('error', $this->perfilModel->validate->getError());
        }
        $this->ajax->returnAjax();
    }

    function alterarProgramasPai($perfil_id) {
        $isSucess = $this->perfilModel->alterarProgramas($perfil_id, 0, $_POST['ids'], $_POST['idProgramas']);

        if ($isSucess) {
            $this->ajax->addAjaxData('sucess', 'true');
        } else {
            $this->ajax->addAjaxData('sucess', 'false');
        }
        $this->ajax->returnAjax();
    }

    function alterarProgramas($perfil_id, $programa_pai_id) {
        $isSucess = $this->perfilModel->alterarProgramas($perfil_id, $programa_pai_id, $_POST['ids'], $_POST['idProgramas']);

        if ($isSucess) {
            $this->ajax->addAjaxData('sucess', 'true');
        } else {
            $this->ajax->addAjaxData('sucess', 'false');
        }
        $this->ajax->returnAjax();
    }

    function excluirProgramaPai($perfil_programa_id, $programa_id, $perfil_id) {
        $isSucess = $this->perfilModel->excluirProgramaPai($perfil_programa_id, $programa_id, $perfil_id);

        if ($isSucess) {
            $this->ajax->addAjaxData('sucess', 'true');
        } else {
            $this->ajax->addAjaxData('sucess', 'false');
        }
        $this->ajax->returnAjax();
    }

    function excluirPrograma($perfil_programa_id, $programa_id) {
        $isSucess = $this->perfilModel->excluirPrograma($perfil_programa_id, $programa_id);

        if ($isSucess) {
            $this->ajax->addAjaxData('sucess', 'true');
        } else {
            $this->ajax->addAjaxData('sucess', 'false');
        }
        $this->ajax->returnAjax();
    }

    function listaPerfis() {
        $this->perfilModel->getPerfis($_GET);
    }

    function novo() {
        $data['path_bread'] = $this->programaModel->pathBread($_SERVER['REQUEST_URI']) . ' / Novo';
        $data['programas'] = $this->programaModel->getProgramasCombo();
        $this->load->view('perfilView', $data);
    }

    function editar($perfil_id) {
        $data['perfil'] = $this->perfilModel->getPerfil($perfil_id);
        $data['path_bread'] = $this->programaModel->pathBread($_SERVER['REQUEST_URI']) . ' / Editar / ' . $data['perfil']->nome_perfil;
        $data['programas'] = $this->programaModel->getProgramasCombo();
        $this->load->view('perfilView', $data);
    }

    function buscarProgramaPai() {
        $this->ajax->addAjaxData('programaPai', $this->perfilModel->getPerfilPrograma($_POST['id']));
        $this->ajax->returnAjax();
    }

    function buscarPrograma() {
        $this->ajax->addAjaxData('programa', $this->perfilModel->getPerfilPrograma($_POST['id']));
        $this->ajax->returnAjax();
    }

    function listaProgramasPai() {
        $this->ajax->returnJqGrid($this->perfilModel->getPerfilProgramas($_GET, 0));
    }

    function listaProgramas() {
        $this->ajax->returnJqGrid($this->perfilModel->getPerfilProgramas($_GET, $_GET['programa_pai']));
    }

}
