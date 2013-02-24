<?php
/**
 * @package academico
 * @subpackage cadastrosauxiliares
 */
	class CondicionantesAmbientalModel extends Model {

		function __construct(){
			parent::__construct();
		}

		function getCondicionantesAmbientalCombo() {
			$this->db->select('id, descricao', false);
			$this->db->orderby('id', 'asc');
			return $this->db->get('paraformal.condicionantes_ambientais')->result_array();
		}

		function inserir($condicionantesAmbiental){
			$this->db->trans_start();
			$this->db->set('descricao', $condicionantesAmbiental['txtDescricao']);
			$this->db->set('dt_cadastro', 'NOW()', false);
			$this->db->insert('paraformal.condicionantes_ambientais');
			$this->db->trans_complete();
			if($this->db->trans_status() === FALSE){
				$this->validate->addError('txtCodigo', lang('registroNaoGravado'));
				return false;
			}

			$this->ajax->addAjaxData('condicoes_ambiental', $this->getCondicionantesAmbiental($this->db->insert_id('paraformal.condicionantes_ambientais', 'id')));
			return true;
		}

		function alterar($condicionantesAmbiental){

			$this->db->trans_start();
			$this->db->set('descricao', $condicionantesAmbiental['txtDescricao']);		
			$this->db->where('id', $condicionantesAmbiental['txtCondicaoAmbientalId']);
			$this->db->update('paraformal.condicionantes_ambientais');
			$this->db->trans_complete();

			if($this->db->trans_status() === FALSE){
				$this->validate->addError('txtCodigo', lang('registroNaoGravado'));
				return false;
			}

			$this->ajax->addAjaxData('condicoes_ambiental', $this->getCondicionantesAmbiental($condicionantesAmbiental['txtCondicaoAmbientalId']));
			return true;
		}

		function excluir($id){
			
			$this->db->trans_start();
				$aCondicoesAmbientais = explode(',', $id);
				$aExcluirCondicoesAmbientais = array();
				for($i = 0; $i < count($aCondicoesAmbientais); $i++)
					if($aCondicoesAmbientais[$i] != 'undefined')
						array_push($aExcluirCondicoesAmbientais, $aCondicoesAmbientais[$i]);

				$this->db->where_in('id', $aExcluirCondicoesAmbientais);
				$this->db->delete('paraformal.condicionantes_ambientais');

			$this->db->trans_complete();

			if($this->db->trans_status() === FALSE)					
				return false;

			return true;
		}

		function getCondicionantesAmbiental($CondicaoAmbientalId){
			$this->db->where('id', $CondicaoAmbientalId);
			return $this->db->get('paraformal.condicionantes_ambientais')->row();
		}
		
		function getCondicoesAmbientais($parametros){
			$this->db->select('id, descricao, to_char(dt_cadastro, \'dd/mm/yyyy hh24:mi:ss\') as dt_cadastro', false);
			$this->db->from('paraformal.condicionantes_ambientais');
                        if(@$parametros['descricao'] != '')
                            $this->db->like('upper(descricao)', strtoupper(@$parametros['descricao']));
                        $this->db->sendToGrid();

		}

		function validaCondicionantesAmbiental($condicionantesAmbiental){
			$this->validate->setData($condicionantesAmbiental);			
				
			$this->validate->validateField('txtCondicaoAmbientalId', array('required'), lang('condicoesAmbientaisDescricaoDeveSerInformado'));
			return $this->validate->existsErrors();
		}

	}