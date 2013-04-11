<?php

class Colaborar extends Controller{
    function __construct(){
        parent::__construct();
        $this->load->model('../../paraformalidade/models/cadastros/paraformalidadeModel', 'paraformalidadeModel');
    }
    
    function index(){
        $this->load->view('colaborarFiltroView');
    }
    
    function novaParaformalidade(){
        $this->load->view('contribuir/novaParaformalidadeView');
    }
    
    function contribuirParaformalidade($idParaformalidade){
        //$data['paraformalidade'] = $this->paraformalidadeModel->getParaformalidadeComDados($idParaformalidade);
        $data['data'] = '';
        $this->load->view('colaborar/contribuirParaformalidadeView',$data);
    }
    
}