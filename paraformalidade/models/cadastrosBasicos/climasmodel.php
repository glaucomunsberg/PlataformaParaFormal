<?php
/**
 * @package academico
 * @subpackage cadastrosauxiliares
 */
	class ClimasModel extends Model {

		function __construct(){
			parent::__construct();
		}

		function getClimasCombo() {
			$this->db->select('id, descricao', false);
			$this->db->orderby('id', 'asc');
			return $this->db->get('paraformal.climas')->result_array();
		}

	}