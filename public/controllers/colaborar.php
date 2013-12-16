<?php

class Colaborar extends Controller{
    function __construct(){
        parent::__construct();
        $this->load->model('../../paraformalidade/models/cadastros/paraformalidadeModel', 'paraformalidadeModel');
        $this->load->model('../models/colaborarModel', 'colaborarModel');
        $this->load->model('../models/denunciarModel', 'denunciarModel');
    }
    
    function index(){
        $this->load->view('colaborarFiltroView');
    }
    
    function novaParaformalidade(){
        $this->load->view('contribuir/novaParaformalidadeView');
    }
    
    function contribuirParaformalidade($idParaformalidade){
        if($idParaformalidade != ''){
            $data['paraformalidade'] = $this->paraformalidadeModel->getParaformalidadeComDados($idParaformalidade);
            $this->load->view('colaborar/contribuirParaformalidadeView',$data); 
        }else{
            redirect(BASE_URL.'public/escolha');
        }
          
    }
    function colaborarComDados(){
        $this->ajax->addAjaxData('colaboracao', $this->colaborarModel->inserir($_POST) );
	$this->ajax->returnAjax();
    }
    function colaborarDenunciar(){
        $this->ajax->addAjaxData('colaboracao', $this->denunciarModel->inserirDenuncia($_POST) );
	$this->ajax->returnAjax();
    }
}