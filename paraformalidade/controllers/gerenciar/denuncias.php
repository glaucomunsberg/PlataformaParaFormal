<?php
/**
 * @package academico
 * @subpackage cadastrosauxiliares
 */
class Denuncias extends Controller {
    
    function __construct(){
        parent::__construct();
        $this->load->model('../../gerenciador/models/ProgramaModel', 'programaModel');
        $this->load->model('../../public/models/DenunciarModel', 'denunciarModel');
    }

    function listaDenuncias(){
        $this->denunciarModel->listaDenuncias($_GET);
    }
    
    function index(){
        $data['path_bread'] = $this->programaModel->pathBread($_SERVER['REQUEST_URI']);
        $this->load->view('gerenciar/denunciasFiltroView', $data);
    }
    
    function editar($denunciaId){
        $data['denuncia'] = $this->denunciarModel->getDenuncia($denunciaId);
        $data['revisado'] = array(array('S','Sim'),array('N','Não'));
        $data['path_bread'] = $this->programaModel->pathBread($_SERVER['REQUEST_URI']).' / Editar / '.@$data['denuncia']->pessoa_nome;
        $this->load->view('gerenciar/denunciasView', $data);
    }

    function salvar(){
        $ret = $this->denunciarModel->alterar($_POST);
        if ($ret !== FALSE) {
            $this->ajax->addAjaxData('denuncia', $ret);
            $this->ajax->ajaxMessage('success', lang('registroGravado'));
        } else {
            if (!$this->cenasModel->validate->existsErrors()) {
                $this->cenasModel->validate->addError("txtDenunciaId", lang('registroNaoGravado'));
            }
            $this->ajax->addAjaxData('error', $this->denunciarModel->validate->getError());
        }

        $this->ajax->returnAjax();
    }
}	