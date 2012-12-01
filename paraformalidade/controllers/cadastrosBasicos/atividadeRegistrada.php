<?php
/**
 * @package academico
 * @subpackage cadastrosauxiliares
 */
	class AtividadeRegistrada extends Controller {
		
		function __construct(){
			parent::__construct();
			$this->load->model('../../gerenciador/models/ProgramaModel', 'programaModel');
			$this->load->model('cadastrosBasicos/AtividadeRegistradaModel', 'atividadeRegistradaModel');
		}
		
		function index(){
			$data['path_bread'] = $this->programaModel->pathBread($_SERVER['REQUEST_URI']);
			$this->load->view('cadastrosBasicos/atividadeRegistradaFiltroView', $data);
		}
		
		function listaAtividadesRegistradas(){
			$this->atividadeRegistradaModel->getAtividadesRegistradas($_GET);
		}
		
		function novo(){
			$data['path_bread'] = $this->programaModel->pathBread($_SERVER['REQUEST_URI']).' / Novo';			
			$this->load->view('cadastrosBasicos/atividadeRegistradaView', $data);
		}

		function editar($AtividadeRegistradaId){
			$data['atividades_registradas'] = $this->atividadeRegistradaModel->getAtividadeRegistrada($AtividadeRegistradaId);
			$data['path_bread'] = $this->programaModel->pathBread($_SERVER['REQUEST_URI']).' / Editar / '.@$data['atividades_registradas']->descricao;
			$this->load->view('cadastrosBasicos/atividadeRegistradaView', $data);
		}
		
		function excluir(){
			$isSUccess = $this->atividadeRegistradaModel->excluir($_POST['id']);

			if($isSUccess)
				$this->ajax->addAjaxData('success', true);
			else
				$this->ajax->addAjaxData('success', false);

			$this->ajax->returnAjax();
		}
		
		function salvar(){
	        if (empty($_POST['txtAtividadeRegistradaId'])) {
                        $ret = $this->atividadeRegistradaModel->inserir($_POST);
                    } else {
                        $ret = $this->atividadeRegistradaModel->alterar($_POST);
                    }
                    if ($ret !== FALSE) {
                        $this->ajax->addAjaxData('atividades_registradas', $ret);
                        $this->ajax->ajaxMessage('success', lang('registroGravado'));
                    } else {
                        if (!$this->atividadeRegistradaModel->validate->existsErrors()) {
                            $this->atividadeRegistradaModel->validate->addError("txtAtividadeRegistradaId", lang('registroNaoGravado'));
                        }
                        $this->ajax->addAjaxData('error', $this->atividadeRegistradaModel->validate->getError());
                    }
                    $this->ajax->returnAjax();
		}
		
	}	