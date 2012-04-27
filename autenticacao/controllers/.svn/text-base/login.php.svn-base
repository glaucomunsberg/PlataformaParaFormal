<?php

/**
 * Classe responsavel pelo login no sistema cobalto-php
 * @package autenticacao
 * @subpackage login
 */
class Login extends Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('LoginModel', 'loginModel');
        $this->load->model('../../gerenciador/models/UsuarioModel', 'usuarioModel');
        $this->load->model('../../gerenciador/models/ParametroModel', 'parametroModel');
    }

    /**
     * Direciona para a tela login caso o usuário não esteja logado
     */
    function index() {
        if (@$_COOKIE['92c29c1ac4d85b45639f741599c24cd7'] != '') {
            redirect('dashboard');
        } else {
            $this->load->view('loginView');
        }
    }

    /**
     * Efetua o login no sistema
     */
    function entrar() {
        if ($this->loginModel->validaUsuario($_POST)) {
            $usuario_id = getUsuarioSession()->id;
            $this->session->set_userdata('menu', $this->usuarioModel->getMenuByUsuarioId($usuario_id));
            setcookie('navigationtree', '', time() - 3600, PATH_COOKIE);
            setcookie('showMenu', '', time() - 3600, PATH_COOKIE);
            $this->ajax->ajaxMessage('success', lang('registroGravado'));
            $this->ajax->returnAjax();
        } else {
            $this->ajax->addAjaxData('error', $this->loginModel->validate->getError());
            $this->ajax->returnAjax();
        }
    }

    /**
     * Efetua o logout no sistema
     */
    function sair() {
        $this->session->sess_destroy();
        setcookie('92c29c1ac4d85b45639f741599c24cd7', '', time() - 3600, PATH_COOKIE);
        setcookie('navigationtree', '', time() - 3600, PATH_COOKIE);
        setcookie('showMenu', '', time() - 3600, PATH_COOKIE);
        setcookie('tema', '', time() - 3600, PATH_COOKIE);
        setcookie('avatar', '', time() - 3600, PATH_COOKIE);
        setcookie('redirect', '', time() - 3600, PATH_COOKIE);
        redirect('autenticacao/login');
    }

    /**
     * Antes de cada chamada AJAX, verifique se o usuário esta devidamente autenticado no sistema
     * @todo Este método deve ser implementado na bibliteca javascript do sistema
     */
    function validaAutenticacaoAjax() {
        if (@$_COOKIE['92c29c1ac4d85b45639f741599c24cd7'] == '') {
            $this->ajax->ajaxMessage('logged', false);
        } else {
            $this->ajax->ajaxMessage('logged', true);
        }
        return $this->ajax->returnAjax();
    }

    /**
     * Este método era usado em uma versão antiga do sistema
     * @deprecated 13/02/2012
     */
    function semPermissao() {
        if ($this->uri->segment(3) == 'perfil') {
            $data['mensagem'] = 'Você não tem permissão para acessar este grupo';
        } else {
            $data['mensagem'] = lang('semPermissaoAcessarMetodo');
        }
        $this->load->view('login/semPermissaoView', $data);
    }

}
