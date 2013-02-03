<?php
/**
 * @package academico
 * @subpackage cadastrosauxiliares
 */
	class QuantidadesRegistradaModel extends Model {

		function __construct(){
			parent::__construct();
		}

		function getQuantidadessRegistradasCombo() {
			$this->db->select('id, descricao', false);
			$this->db->orderby('id', 'asc');
			return $this->db->get('paraformal.quantidadess_registradas')->result_array();
		}

		function inserir($locais){
			$this->db->trans_start();
			$this->db->set('descricao', $locais['txtDescricao']);
			$this->db->set('dt_cadastro', 'NOW()', false);
			$this->db->insert('paraformal.quantidadess_registradas');
			$this->db->trans_complete();
			if($this->db->trans_status() === FALSE){
				$this->validate->addError('txtCodigo', lang('registroNaoGravado'));
				return false;
			}

			$this->ajax->addAjaxData('quantidadess_registradas', $this->getQuantidadesRegistrada($this->db->insert_id('paraformal.quantidadess_registradas', 'id')));
			return true;
		}

		function alterar($locais){

			$this->db->trans_start();
			$this->db->set('descricao', $locais['txtDescricao']);		
			$this->db->where('id', $locais['txtQuantidadesRegistradaId']);
			$this->db->update('paraformal.quantidadess_registradas');
			$this->db->trans_complete();

			if($this->db->trans_status() === FALSE){
				$this->validate->addError('txtCodigo', lang('registroNaoGravado'));
				return false;
			}

			$this->ajax->addAjaxData('tipos_registros_quantidadess', $this->getQuantidadesRegistrada($locais['txtQuantidadesRegistradaId']));
			return true;
		}

		function excluir($id){
			
			$this->db->trans_start();
				$aQuantidadessRegistradas = explode(',', $id);
				$aExcluirQuantidadessRegistradas = array();
				for($i = 0; $i < count($aQuantidadessRegistradas); $i++)
					if($aQuantidadessRegistradas[$i] != 'undefined')
						array_push($aExcluirQuantidadessRegistradas, $aQuantidadessRegistradas[$i]);

				$this->db->where_in('id', $aExcluirQuantidadessRegistradas);
				$this->db->delete('paraformal.quantidadess_registradas');

			$this->db->trans_complete();

			if($this->db->trans_status() === FALSE)					
				return false;

			return true;
		}

		function getQuantidadesRegistrada($QuantidadesRegistradaId){
			$this->db->where('id', $QuantidadesRegistradaId);
			return $this->db->get('paraformal.quantidadess_registradas')->row();
		}
		
		function getQuantidadessRegistradas($parametros){
			$this->db->select('id, descricao, to_char(dt_cadastro, \'dd/mm/yyyy hh24:mi:ss\') as dt_cadastro', false);
                        $this->db->from('paraformal.quantidadess_registradas');
                        if(@$parametros['descricao'] != '')
                            $this->db->like('upper(descricao)', strtoupper(@$parametros['descricao']));
                        $this->db->sendToGrid();
		}

		function validaQuantidadesRegistrada($local){
			$this->validate->setData($local);			
				
			$this->validate->validateField('txtLocalId', array('required'), lang('QuantidadessRegistradasDescricaoDeveSerInformado'));
			return $this->validate->existsErrors();
		}

	}