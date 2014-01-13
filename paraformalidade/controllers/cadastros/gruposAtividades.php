<?php
/**
 * @package academico
 * @subpackage cadastrosauxiliares
 */
	class GruposAtividades extends Controller {
		
		function __construct(){
			parent::__construct();
			$this->load->model('../../gerenciador/models/ProgramaModel', 'programaModel');
			$this->load->model('cadastros/GruposAtividadesModel', 'gruposAtividadesModel');
                        $this->load->model('../../gerenciador/models/CidadeModel', 'cidadeModel');
		}
		
		function index(){
			$data['path_bread'] = $this->programaModel->pathBread($_SERVER['REQUEST_URI']);
			$this->load->view('cadastros/gruposAtividadesFiltroView', $data);
		}
		
		function listaGruposAtividades(){
			$this->gruposAtividadesModel->getGruposAtividades($_GET);
		}
		
		function novo(){
			$data['path_bread'] = $this->programaModel->pathBread($_SERVER['REQUEST_URI']).' / Novo';
			$this->load->view('cadastros/gruposAtividadesView', $data);
		}

		function editar($grupoAtividadeID){
			$data['grupo_atividade'] = $this->gruposAtividadesModel->getGrupoAtividade($grupoAtividadeID);
                        $data['grupo_atividade_cidade'] = $this->cidadeModel->getCidadeById( $data['grupo_atividade']->cidade_id );
			$data['path_bread'] = $this->programaModel->pathBread($_SERVER['REQUEST_URI']).' / Editar / '.@$data['grupo_atividade']->descricao;
			$this->load->view('cadastros/gruposAtividadesView', $data);
		}
		
		function excluir(){
			$isSUccess = $this->gruposAtividadesModel->excluir($_POST['id']);

			if($isSUccess)
				$this->ajax->addAjaxData('success', true);
			else
				$this->ajax->addAjaxData('success', false);

			$this->ajax->returnAjax();
		}
		
		function salvar(){
	        if (empty($_POST['txtGrupoAtividadeId'])) {
                        $ret = $this->gruposAtividadesModel->inserir($_POST);
                    } else {
                        $ret = $this->gruposAtividadesModel->alterar($_POST);
                    }
                    if ($ret !== FALSE) {
                        $this->ajax->ajaxMessage('success', lang('registroGravado'));
                    } else {
                        if (!$this->gruposAtividadesModel->validate->existsErrors()) {
                            $this->gruposAtividadesModel->validate->addError("txtGrupoAtividadeId", lang('registroNaoGravado'));
                        }
                        $this->ajax->addAjaxData('error', $this->gruposAtividadesModel->validate->getError());
                    }
                    
                    $this->ajax->returnAjax();
		}
                
                function buscarCidade(){
                    $this->ajax->addAjaxCombo(
                            $this->cidadeModel->getCidadeByNome($_GET['q'])
                    );
                    $this->ajax->returnAjax();
                }
                
                public function loadAbaGeral($grupoAtividadeID = NULL) {
                    $this->load->model('programasModel');

                    $data = array();
                    if (!empty($grupoAtividadeID)) {
                        $data['projeto'] = $this->projetoModel->getProjetoDadosGerais($projetoId);
                    }
                    $data['cmbResponsavel'] = array (array ("S", lang('equipeGrupoAtividadeSim')), array ("N", lang('equipeGrupoAtividadeNao')));
                    $data['grupo_atividade'] = $this->gruposAtividadesModel->getGrupoAtividade($grupoAtividadeID);
                    $data['path_bread'] = $this->programaModel->pathBread($_SERVER['REQUEST_URI']).' / Editar / '.@$data['grupo_atividade']->descricao;
                    $this->load->view('cadastros/equipeGrupoAtividadeView', $data);
                }
		
	}	