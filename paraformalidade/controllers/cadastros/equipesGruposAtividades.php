<?php
/**
 * @package academico
 * @subpackage cadastrosauxiliares
 */
	class EquipesGruposAtividades extends Controller {
		
		function __construct(){
			parent::__construct();
			$this->load->model('../../gerenciador/models/ProgramaModel', 'programaModel');
			$this->load->model('cadastros/GruposAtividadesModel', 'gruposAtividadesModel');
                        $this->load->model('cadastros/EquipesGruposAtividadesModel', 'equipeGruposAtividadesModel');
                        $this->load->model('cadastros/ParticipacoesEquipemodel', 'participacoesEquipeModel');
                        $this->load->model('../../gerenciador/models/CidadeModel', 'cidadeModel');
                        $this->load->model('../../gerenciador/models/PessoaModel', 'pessoaModel');
		}
		
		function index(){
			$data['path_bread'] = $this->programaModel->pathBread($_SERVER['REQUEST_URI']);
			$this->load->view('cadastros/equipeGruposAtividadesFiltroView', $data);
		}
		
		function listaGruposAtividades(){
			$this->gruposAtividadesModel->getGruposAtividades($_GET);
		}
                
                function listaEquipe(){
                        $this->equipeGruposAtividadesModel->getEquipe($_GET);
                }

                function inserir(){
                    print json_decode($this->equipeGruposAtividadesModel->inserir($_GET['pessoa_id'],$_GET['grupo_atividade_id'], $_GET['tipo_participacao']));
                }
		function editar($grupoAtividadeID){
			$data['grupo_atividade'] = $this->gruposAtividadesModel->getGrupoAtividade($grupoAtividadeID);
                        $data['tipo_participacao'] = $this->participacoesEquipeModel->getParticipacoesEquipeCombo($grupoAtividadeID);
			$data['path_bread'] = $this->programaModel->pathBread($_SERVER['REQUEST_URI']).' / Editar / '.@$data['grupo_atividade']->descricao;
			$this->load->view('cadastros/equipeGruposAtividadesView', $data);
		}
		
                function excluir(){
			$isSUccess = $this->equipeGruposAtividadesModel->excluir($_POST['id']);

			if($isSUccess)
				$this->ajax->addAjaxData('success', true);
			else
				$this->ajax->addAjaxData('success', false);

			$this->ajax->returnAjax();
		}
                
                function buscarPessoa(){
                    $this->ajax->addAjaxCombo(
                            $this->pessoaModel->getPessoaByNome($_GET['q'])
                    );
                    $this->ajax->returnAjax();
                }
                
		
	}	