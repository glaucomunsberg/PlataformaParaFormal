<?php

class Configuracao extends Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('ConfiguracaoModel', 'configuracaoModel');
        $this->load->model('../../util/models/UploadModel', 'uploadModel');
    }

    function index() {
        $data['temas'] = array('blitzer', 'cupertino', 'flick', 'hot-sneaks', 'redmond', 'smoothness', 'ui-lightness', 'humanity');
        $this->load->view('configuracaoView', $data);
    }

    function salvarGeral() {
        $isSUccess = $this->configuracaoModel->salvarDadosGerais($_POST, getUsuarioSession()->id);

        if ($isSUccess) {
            //$this->ajax->addAjaxData('upload', $this->uploadModel->getUpload($_POST['avatarId']));
            $this->ajax->addAjaxData('success', true);
        } else {
            $this->ajax->addAjaxData('success', false);
        }
        $this->ajax->returnAjax();
    }

    function salvarSenha() {
        $isSUccess = $this->configuracaoModel->salvarSenha($_POST, getUsuarioSession()->id);

        if ($isSUccess) {
            $this->ajax->ajaxMessage('success', lang('configuracaoSenhaAtualAlteradaComSucesso'));
        } else {
            $this->ajax->addAjaxData('error', $this->configuracaoModel->validate->getError());
        }
        $this->ajax->returnAjax();
    }

    function salvarTema() {
        foreach ($_POST as $key => $value) {
            if ($key == 'temas') {
                setcookie("tema", $value, 0, PATH_COOKIE);
                $this->configuracaoModel->salvarTema($value, getUsuarioSession()->id);
            }
        }

        $this->ajax->ajaxMessage('success', lang('registroGravado'));
        $this->ajax->returnAjax();
    }

}
