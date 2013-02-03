<?php
/**
 * @package academico
 * @subpackage cadastrosauxiliares
 */
	class EquipamentoMobilidades extends Controller {
		
		function __construct(){
			parent::__construct();
			$this->load->model('../../gerenciador/models/ProgramaModel', 'programaModel');
			$this->load->model('cadastrosBasicos/EquipamentoMobilidadesModel', 'equipamentoMobilidadesModel');
		}
		
		function index(){
			$data['path_bread'] = $this->programaModel->pathBread($_SERVER['REQUEST_URI']);
			$this->load->view('cadastrosBasicos/equipamentoMobilidadesFiltroView', $data);
		}
		
		function listaEquipamentoMobilidades(){
			$this->equipamentoMobilidadesModel->getEquipamentoMobilidades($_GET);
		}
		
		function novo(){
			$data['path_bread'] = $this->programaModel->pathBread($_SERVER['REQUEST_URI']).' / Novo';			
			$this->load->view('cadastrosBasicos/equipamentoMobilidadesView', $data);
		}

		function editar($equipamentoPorteId){
			$data['equipamento_mobilidades'] = $this->equipamentoMobilidadesModel->getEquipamentoPorte($equipamentoPorteId);
			$data['path_bread'] = $this->programaModel->pathBread($_SERVER['REQUEST_URI']).' / Editar / '.@$data['equipamento_Mobilidades']->descricao;
			$this->load->view('cadastrosBasicos/equipamentoMobilidadesView', $data);
		}
		
		function excluir(){
			$isSUccess = $this->equipamentoMobilidadesModel->excluir($_POST['id']);

			if($isSUccess)
				$this->ajax->addAjaxData('success', true);
			else
				$this->ajax->addAjaxData('success', false);

			$this->ajax->returnAjax();
		}
		
		function salvar(){
	        if (empty($_POST['txtEquipamentoMobilidadesId'])) {
                        $ret = $this->equipamentoMobilidadesModel->inserir($_POST);
                    } else {
                        $ret = $this->equipamentoMobilidadesModel->alterar($_POST);
                    }
                    if ($ret !== FALSE) {
                        $this->ajax->addAjaxData('equipamento_mobilidades', $ret);
                        $this->ajax->ajaxMessage('success', lang('registroGravado'));
                    } else {
                        if (!$this->equipamentoMobilidadesModel->validate->existsErrors()) {
                            $this->equipamentoMobilidadesModel->validate->addError("txtEquipamentoMobilidadesId", lang('registroNaoGravado'));
                        }
                        $this->ajax->addAjaxData('error', $this->equipamentoMobilidadesModel->validate->getError());
                    }
                    $this->ajax->returnAjax();
		}
		
	}	