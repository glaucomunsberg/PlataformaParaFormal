<?php
/**
 * @package academico
 * @subpackage cadastrosauxiliares
 */
	class CorpoNumerosModel extends Model {

		function __construct(){
			parent::__construct();
		}

		function getCorpoNumerosCombo() {
			$this->db->select('id, descricao', false);
			$this->db->orderby('id', 'asc');
			return $this->db->get('paraformal.corpo_numeros')->result_array();
		}

		function inserir($corpoNumero){
			$this->db->trans_start();
			$this->db->set('descricao', $corpoNumero['txtDescricao']);
			$this->db->set('dt_cadastro', 'NOW()', false);
			$this->db->insert('paraformal.corpo_numeros');
			$this->db->trans_complete();
			if($this->db->trans_status() === FALSE){
				$this->validate->addError('txtCodigo', lang('registroNaoGravado'));
				return false;
			}

			$this->ajax->addAjaxData('corpo_numeros', $this->getCorpoNumero($this->db->insert_id('paraformal.corpo_numeros', 'id')));
			return true;
		}

		function alterar($corpoNumeros){

			$this->db->trans_start();
			$this->db->set('descricao', $corpoNumeros['txtDescricao']);		
			$this->db->where('id', $corpoNumeros['txtCorpoNumerosId']);
			$this->db->update('paraformal.corpo_numeros');
			$this->db->trans_complete();

			if($this->db->trans_status() === FALSE){
				$this->validate->addError('txtCodigo', lang('registroNaoGravado'));
				return false;
			}

			$this->ajax->addAjaxData('corpo_numeros', $this->getCorpoNumero($corpoNumeros['txtCorpoNumerosId']));
			return true;
		}

		function excluir($id){
			
			$this->db->trans_start();
				$aLocais = explode(',', $id);
				$aExcluirLocais = array();
				for($i = 0; $i < count($aLocais); $i++)
					if($aLocais[$i] != 'undefined')
						array_push($aExcluirLocais, $aLocais[$i]);

				$this->db->where_in('id', $aExcluirLocais);
				$this->db->delete('paraformal.corpo_numeros');

			$this->db->trans_complete();

			if($this->db->trans_status() === FALSE)					
				return false;

			return true;
		}

		function getCorpoNumero($corpoNumeroId){
			$this->db->where('id', $corpoNumeroId);
			return $this->db->get('paraformal.corpo_numeros')->row();
		}
		
		function getCorpoNumeros($parametros){
			$this->db->select('id, descricao, to_char(dt_cadastro, \'dd/mm/yyyy hh24:mi:ss\') as dt_cadastro', false);
                        $this->db->from('paraformal.corpo_numeros');
                        if(@$parametros['descricao'] != '')
                            $this->db->like('upper(descricao)', strtoupper(@$parametros['descricao']));
                        $this->db->sendToGrid();
		}

		function validaPonte($ponte){
			$this->validate->setData($ponte);				
			$this->validate->validateField('txtCorpoNumerosId', array('required'), lang('ponteDescricaoDeveSerInformado'));
			return $this->validate->existsErrors();
		}

	}