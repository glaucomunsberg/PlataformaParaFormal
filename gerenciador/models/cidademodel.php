<?php

	class CidadeModel extends Model{
		
		function __construct(){
			parent::__construct();		
		}
		
		function getCidadesCombo(){
			$this->db->select('id, nome_cidade');
			$this->db->where('flg_clima_tempo', 'S');
			$this->db->order_by('nome_cidade', 'asc');
			return $this->db->get('cidades')->result_array();
		}
		
	}

?>
