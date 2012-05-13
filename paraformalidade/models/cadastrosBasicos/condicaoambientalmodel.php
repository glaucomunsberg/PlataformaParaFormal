<?php
/**
 * @package academico
 * @subpackage cadastrosauxiliares
 */
	class CondicaoAmbientalModel extends Model {

		function __construct(){
			parent::__construct();
		}

		function getCondicaoAmbientalCombo() {
			$this->db->select('id, descricao', false);
			$this->db->orderby('id', 'asc');
			return $this->db->get('tipos_condicoes_ambientais')->result_array();
		}

		function inserir($condicaoAmbiental){
			$this->db->trans_start();
			$this->db->set('descricao', $condicaoAmbiental['txtDescricao']);
			$this->db->set('dt_cadastro', 'NOW()', false);
			$this->db->insert('tipos_condicoes_ambientais');
			$this->db->trans_complete();
			if($this->db->trans_status() === FALSE){
				$this->validate->addError('txtCodigo', lang('registroNaoGravado'));
				return false;
			}

			$this->ajax->addAjaxData('condicao_ambiental', $this->getCondicaoAmbiental($this->db->insert_id('tipos_condicoes_ambientais', 'id')));
			return true;
		}

		function alterar($condicaoAmbiental){

			$this->db->trans_start();
			$this->db->set('descricao', $condicaoAmbiental['txtDescricao']);		
			$this->db->where('id', $condicaoAmbiental['txtCondicaoAmbientalId']);
			$this->db->update('tipos_condicoes_ambientais');
			$this->db->trans_complete();

			if($this->db->trans_status() === FALSE){
				$this->validate->addError('txtCodigo', lang('registroNaoGravado'));
				return false;
			}

			$this->ajax->addAjaxData('condicao_ambiental', $this->getCondicaoAmbiental($condicaoAmbiental['txtCondicaoAmbientalId']));
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
				$this->db->delete('tipos_condicoes_ambientais');

			$this->db->trans_complete();

			if($this->db->trans_status() === FALSE)					
				return false;

			return true;
		}

		function getCondicaoAmbiental($CondicaoAmbientalId){
			$this->db->where('id', $CondicaoAmbientalId);
			return $this->db->get('tipos_condicoes_ambientais')->row();
		}
		
		function getCondicoesAmbientais($parametros){
			$this->db->select('count(*) as quantidade');
			$this->db->like('upper(descricao)', strtoupper(@$parametros['descricao']));
			$total = $this->db->get('tipos_condicoes_ambientais')->row();

			$paramsJqGrid = $this->ajax->setStartLimitJqGrid($parametros, $total->quantidade);

			$this->db->select('id, descricao, to_char(dt_cadastro, \'dd/mm/yyyy hh24:mi:ss\') as dt_cadastro', false);
			$this->db->like('upper(descricao)', strtoupper(@$parametros['descricao']));
			$this->db->order_by($paramsJqGrid->sortField, $paramsJqGrid->sortDirection);
			$result = $this->db->get('tipos_condicoes_ambientais', $paramsJqGrid->limit, $paramsJqGrid->start);

			$paramsJqGrid->rows = $result->result();
			return $paramsJqGrid;
		}

		function validaCondicaoAmbiental($condicaoAmbiental){
			$this->validate->setData($condicaoAmbiental);			
				
			$this->validate->validateField('txtCondicaoAmbientalId', array('required'), lang('condicoesAmbientaisDescricaoDeveSerInformado'));
			return $this->validate->existsErrors();
		}

	}