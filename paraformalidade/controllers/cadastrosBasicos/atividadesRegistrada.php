<?php
/**
 * @package academico
 * @subpackage cadastrosauxiliares
 */
	class AtividadesRegistrada extends Controller {
		
		function __construct(){
			parent::__construct();
			$this->load->model('../../gerenciador/models/ProgramaModel', 'programaModel');
			$this->load->model('cadastrosBasicos/AtividadesRegistradaModel', 'atividadesRegistradaModel');
		}
		
		function index(){
			$data['path_bread'] = $this->programaModel->pathBread($_SERVER['REQUEST_URI']);
			$this->load->view('cadastrosBasicos/atividadesRegistradaFiltroView', $data);
		}
		
		function listaAtividadesRegistradas(){
			$this->atividadesRegistradaModel->getAtividadesRegistradas($_GET);
		}
		
		function novo(){
			$data['path_bread'] = $this->programaModel->pathBread($_SERVER['REQUEST_URI']).' / Novo';			
			$this->load->view('cadastrosBasicos/atividadesRegistradaView', $data);
		}

		function editar($AtividadesRegistradaId){
			$data['atividades_registradas'] = $this->atividadesRegistradaModel->getAtividadesRegistrada($AtividadesRegistradaId);
			$data['path_bread'] = $this->programaModel->pathBread($_SERVER['REQUEST_URI']).' / Editar / '.@$data['atividades_registradas']->descricao;
			$this->load->view('cadastrosBasicos/atividadesRegistradaView', $data);
		}
		
		function excluir(){
			$isSUccess = $this->atividadesRegistradaModel->excluir($_POST['id']);

			if($isSUccess)
				$this->ajax->addAjaxData('success', true);
			else
				$this->ajax->addAjaxData('success', false);

			$this->ajax->returnAjax();
		}
		
		function salvar(){
	        if (empty($_POST['txtAtividadeRegistradaId'])) {
                        $ret = $this->atividadesRegistradaModel->inserir($_POST);
                    } else {
                        $ret = $this->atividadesRegistradaModel->alterar($_POST);
                    }
                    if ($ret !== FALSE) {
                        $this->ajax->addAjaxData('atividades_registradas', $ret);
                        $this->ajax->ajaxMessage('success', lang('registroGravado'));
                    } else {
                        if (!$this->atividadesRegistradaModel->validate->existsErrors()) {
                            $this->atividadesRegistradaModel->validate->addError("txtAtividadeRegistradaId", lang('registroNaoGravado'));
                        }
                        $this->ajax->addAjaxData('error', $this->atividadesRegistradaModel->validate->getError());
                    }
                    $this->ajax->returnAjax();
		}
		
	}	