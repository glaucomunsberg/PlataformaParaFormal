<?php
/**
 * @package academico
 * @subpackage cadastrosauxiliares
 */
class Cidade extends Controller {
		
    function __construct(){
        parent::__construct();
        $this->load->model('../../gerenciador/models/ProgramaModel', 'programaModel');
        $this->load->model('CidadeModel', 'cidadeModel');
    }

    function index(){
        $data['path_bread'] = $this->programaModel->pathBread($_SERVER['REQUEST_URI']);
        $data['estado'] = $this->cidadeModel->getEstadosCombo();
        $this->load->view('cidadeFiltroView', $data);
    }

    function listaCidades(){
        $this->cidadeModel->getCidades($_GET);
    }

    function novo(){
        $data['path_bread'] = $this->programaModel->pathBread($_SERVER['REQUEST_URI']).' / Novo';			
        $data['estados'] = $this->cidadeModel->getEstadosCombo();
        $this->load->view('cidadeView', $data);
    }

    function editar($cidadeID){
        $data['cidade'] = $this->cidadeModel->getCidadeById($cidadeID);
        $data['estados'] = $this->cidadeModel->getEstadosCombo();
        $data['path_bread'] = $this->programaModel->pathBread($_SERVER['REQUEST_URI']) . " / Editar / " . @$data['cidade']->nome;
        $this->load->view('cidadeView', $data);
    }
		
    function salvar(){
        if(empty($_POST['txtCidadeId'])){
             $ret = $this->cidadeModel->inserir($_POST);
        }else{
             $ret = $this->cidadeModel->alterar($_POST);
        }
        
        if ($ret !== FALSE) {
            $this->ajax->addAjaxData('cidade', $ret);
            $this->ajax->ajaxMessage('success', lang('registroGravado'));
        } else {
           if (!$this->cidadeModel->validate->existsErrors()) {
                $this->cidadeModel->validate->addError("txtNome", lang('registroNaoGravado'));
            }
            $this->ajax->addAjaxData('error', $this->cidadeModel->validate->getError());
        }

        $this->ajax->returnAjax();
    }
}	