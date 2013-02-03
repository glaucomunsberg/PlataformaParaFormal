<?php
/**
 * @package academico
 * @subpackage cadastrosauxiliares
 */
	class GaleriaDaParaformalidade extends Controller {
		
		function __construct(){
			parent::__construct();
			$this->load->model('../../gerenciador/models/ProgramaModel', 'programaModel');
                        $this->load->model('cadastros/GruposAtividadesModel','grupoAtividadeModel');
                        $this->load->model('cadastros/ParaformalidadeModel', 'paraformalidadeModel');
                        $this->load->model('../../gerenciador/models/CidadeModel', 'cidadeModel');
		}
		
		function index(){
			$data['path_bread'] = $this->programaModel->pathBread($_SERVER['REQUEST_URI']);
			$this->load->view('cadastros/galeriaDoParaformalFiltroView', $data);
		}
		
		function listaGruposAtividades(){
			$this->grupoAtividadeModel->getGruposAtividades($_GET);
		}
		

		function verGaleria($grupoAtividadeID){
			$data['grupo_atividade'] = $this->grupoAtividadeModel->getGrupoAtividade($grupoAtividadeID);
                        $data['cmbImagens'] = $this->paraformalidadeModel->getImageCombo($grupoAtividadeID);
                        $data['cidade'] = $this->cidadeModel->getCidadeById( $data['grupo_atividade']->cidade_id );
			$data['path_bread'] = $this->programaModel->pathBread($_SERVER['REQUEST_URI']).' / Galeria / '.@$data['cidade']->nome;
			$this->load->view('cadastros/galeriaDoParaformalView', $data);
		}
                
                function buscarCidade(){
                    $this->ajax->addAjaxCombo(
                            $this->cidadeModel->getCidadeByNome($_GET['q'])
                    );
                    $this->ajax->returnAjax();
                }
                
		
	}	