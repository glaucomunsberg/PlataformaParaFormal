<?php
/**
 * @package academico
 * @subpackage cadastrosauxiliares
 */
class Atualizacoes extends Controller {
    
    function __construct(){
        parent::__construct();
        $this->load->model('../../gerenciador/models/ProgramaModel', 'programaModel');
        $this->load->model('../../public/models/colaborarModel', 'colaborarModel');
        $this->load->model('cadastros/ParaformalidadeModel', 'paraformalidadeModel');
    }

    function listaColaboracoes(){
        $this->colaborarModel->listaColaboracoes($_GET);
    }
    
    function index(){
        $data['path_bread'] = $this->programaModel->pathBread($_SERVER['REQUEST_URI']);
        $this->load->view('gerenciar/atualizacoesFiltroView', $data);
    }
    
    function editar($atualizacaoId){
        $data['atualizacao'] = $this->colaborarModel->getColaboracao($atualizacaoId);
        $data['paraformalidade'] = $this->paraformalidadeModel->getParaformalidadeComDados($data['atualizacao']->paraformalidade_id);
        $data['revisado'] = array(array('S','Sim'),array('N','Não'));
        $data['path_bread'] = $this->programaModel->pathBread($_SERVER['REQUEST_URI']).' / Enviado Por: '.@$data['atualizacao']->pessoa_email;
        $this->load->view('gerenciar/atualizacoesView', $data);
    }

    function salvar(){
        $ret = $this->colaborarModel->alterar($_POST);
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
    function excluir() {
        $isSUccess = $this->colaborarModel->excluir($_POST['id']);

        if ($isSUccess)
            $this->ajax->addAjaxData('success', true);
        else
            $this->ajax->addAjaxData('success', false);

        $this->ajax->returnAjax();
    }
}	