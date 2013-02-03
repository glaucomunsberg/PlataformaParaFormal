<?php
/**
 * @package academico
 * @subpackage cadastrosauxiliares
 */
	class CondicoesAmbientalModel extends Model {

		function __construct(){
			parent::__construct();
		}

		function getCondicoesAmbientalCombo() {
			$this->db->select('id, descricao', false);
			$this->db->orderby('id', 'asc');
			return $this->db->get('paraformal.condicoes_ambientais')->result_array();
		}

		function inserir($condicoesAmbiental){
			$this->db->trans_start();
			$this->db->set('descricao', $condicoesAmbiental['txtDescricao']);
			$this->db->set('dt_cadastro', 'NOW()', false);
			$this->db->insert('paraformal.condicoes_ambientais');
			$this->db->trans_complete();
			if($this->db->trans_status() === FALSE){
				$this->validate->addError('txtCodigo', lang('registroNaoGravado'));
				return false;
			}

			$this->ajax->addAjaxData('condicoes_ambiental', $this->getCondicoesAmbiental($this->db->insert_id('paraformal.condicoes_ambientais', 'id')));
			return true;
		}

		function alterar($condicoesAmbiental){

			$this->db->trans_start();
			$this->db->set('descricao', $condicoesAmbiental['txtDescricao']);		
			$this->db->where('id', $condicoesAmbiental['txtCondicaoAmbientalId']);
			$this->db->update('paraformal.condicoes_ambientais');
			$this->db->trans_complete();

			if($this->db->trans_status() === FALSE){
				$this->validate->addError('txtCodigo', lang('registroNaoGravado'));
				return false;
			}

			$this->ajax->addAjaxData('condicoes_ambiental', $this->getCondicoesAmbiental($condicoesAmbiental['txtCondicaoAmbientalId']));
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
				$this->db->delete('paraformal.condicoes_ambientais');

			$this->db->trans_complete();

			if($this->db->trans_status() === FALSE)					
				return false;

			return true;
		}

		function getCondicoesAmbiental($CondicaoAmbientalId){
			$this->db->where('id', $CondicaoAmbientalId);
			return $this->db->get('paraformal.condicoes_ambientais')->row();
		}
		
		function getCondicoesAmbientais($parametros){
			$this->db->select('id, descricao, to_char(dt_cadastro, \'dd/mm/yyyy hh24:mi:ss\') as dt_cadastro', false);
			$this->db->from('paraformal.condicoes_ambientais');
                        if(@$parametros['descricao'] != '')
                            $this->db->like('upper(descricao)', strtoupper(@$parametros['descricao']));
                        $this->db->sendToGrid();

		}

		function validaCondicoesAmbiental($condicoesAmbiental){
			$this->validate->setData($condicoesAmbiental);			
				
			$this->validate->validateField('txtCondicaoAmbientalId', array('required'), lang('condicoesAmbientaisDescricaoDeveSerInformado'));
			return $this->validate->existsErrors();
		}

	}