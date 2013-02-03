<?php
/**
 * @package academico
 * @subpackage cadastrosauxiliares
 */
	class PessoaProcedenciasModel extends Model {

		function __construct(){
			parent::__construct();
		}

		function getPessoaProcedenciasCombo() {
			$this->db->select('id, descricao', false);
			$this->db->orderby('id', 'asc');
			return $this->db->get('paraformal.pessoa_procedencias')->result_array();
		}

	}