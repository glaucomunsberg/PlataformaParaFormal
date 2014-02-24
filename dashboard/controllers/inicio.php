<?php

class Inicio extends Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('../../gerenciador/models/UsuarioModel', 'usuarioModel');
        $this->load->model('../../public/models/DenunciarModel','denunciarModel');
        $this->load->model('../../public/models/ColaborarModel','colaborarModel');
        $this->load->model('../../paraformalidade/models/cadastros/ParaformalidadeModel','paraformalidadeModel');
    }

    function index() {
        $data['numDenuncias'] = $this->denunciarModel->getNumeroDeDenunciasNaoSolucionados();
        $data['numAtualizacoes'] = $this->colaborarModel->getNumeroDeColaboracoesNaoProcessadas();
        $data['novasParaformalidades'] = $this->paraformalidadeModel->getNumeroDeColaboracoesPublicas();
        $this->load->view('inicioView',$data);
    }

    function perfil() {
        if ($this->usuarioModel->acessaPerfil($this->uri->segment(3), getUsuarioSession()->id)) {
            $_SESSION['perfil'] = $this->uri->segment(3);
            $_SESSION['programas'] = $this->usuarioModel->getMenu($this->uri->segment(3));
            redirect('dashboard/inicio');
        } else {
            redirect('autenticacao/login/semPermissao/perfil');
        }
    }

    function empresa() {
        $_SESSION['empresa'] = $this->uri->segment(3);
        $_SESSION['perfis'] = $this->usuarioModel->getPerfisUsuario(getUsuarioSession()->id, $_SESSION['empresa']);
        $_SESSION['perfil'] = 2;
        $_SESSION['programas'] = $this->usuarioModel->getMenu(2);
        redirect('inicio');
    }

}
