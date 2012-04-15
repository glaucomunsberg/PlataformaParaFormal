<?php

class LogTabelaModel extends Model {

	function __construct(){
		parent::__construct();
	}

	function getTabelas($parametros){
		$this->db->select('count(*) as total_tabelas', false);
		$this->db->where('table_schema', 'public');
		$this->db->where('table_type', 'BASE TABLE');
		$this->db->like('upper(table_name)', @$parametros['tabela']);
		$total = $this->db->get('information_schema.tables')->row();

		$paramsJqGrid = $this->ajax->setStartLimitJqGrid($parametros, $total->total_tabelas);

		$this->db->select('concat_ws(\'chr9\', table_schema, table_name) as id, table_schema, table_name', false);
		$this->db->where('table_schema', 'public');
		$this->db->where('table_type', 'BASE TABLE');
		$this->db->like('upper(table_name)', @$parametros['tabela']);
		$this->db->order_by($paramsJqGrid->sortField, $paramsJqGrid->sortDirection);
		$this->db->limit($paramsJqGrid->limit, $paramsJqGrid->start);
		$result = $this->db->get('information_schema.tables');

		$paramsJqGrid->rows = $result->result();
		return $paramsJqGrid;
	}

	function getColunas($parametros, $esquema, $tabela){
		$this->db->select('column_name as id, ordinal_position, column_name, data_type, column_default', false);
		$this->db->where('table_schema', $esquema);
		$this->db->where('table_name', $tabela);
		$this->db->order_by('ordinal_position', 'asc');
		$result = $this->db->get('information_schema.columns');

		$paramsJqGrid = $this->ajax->setStartLimitJqGrid($parametros, $result->num_rows());
		$paramsJqGrid->rows = $result->result();
		return $paramsJqGrid;
	}
	
	function salvarLogTabela($logTabela){
		$this->db->trans_start();
			$sql = 'delete 
					  from log_fields_structures
					 where id in (select lfs.id
							  from log_fields_structures as lfs
							  join log_tables_structures as lts
								on lts.id = lfs.log_table_structure_id
							  where lts.table_name = \''.$logTabela['txtTabela'].'\')';
			$this->db->query($sql);

			$this->db->where('table_name', $logTabela['txtTabela']);
			$this->db->delete('log_tables_structures');
			
			$sql = 'drop trigger if exists trigger_log_'.$logTabela['txtTabela'].' on '.$logTabela['txtTabela'];
			$this->db->query($sql);
			
			if($logTabela['txtColunas'] != ''){
				$fields = explode(',', $logTabela['txtColunas']);
				$this->db->set('table_name', $logTabela['txtTabela']);
				$this->db->insert('log_tables_structures');
				
				$logTableStructureId = $this->db->insert_id();
				
				for($i = 0; $i < count($fields); $i++){
					$this->db->set('log_table_structure_id', $logTableStructureId);
					$this->db->set('field_name', $fields[$i]);
					$this->db->insert('log_fields_structures');
				}

				$sql = 'create trigger trigger_log_'.$logTabela['txtTabela'].' after insert or update or delete on '.$logTabela['txtTabela'].' for each row execute procedure fnc_trigger_log()';
				$this->db->query($sql);
			}
			
		$this->db->trans_complete();

		if($this->db->trans_status() === FALSE)			
			return false;
		
		return true;
	}

	function getColunasLogTabela($tabela){
		$this->db->select('lfs.field_name', false);
		$this->db->from('log_fields_structures as lfs');
		$this->db->join('log_tables_structures as lts', 'lts.id = lfs.log_table_structure_id');
		$this->db->where('lts.table_name', $tabela);
		return $this->db->get()->result();
	}
	
	function getLogTabela($parametros, $esquema, $tabela){
		$this->db->select('count(*) as total_log', false);
		$this->db->from('log_tables as lt');
		$this->db->join('log_fields as lf', 'lt.id = lf.log_table_id');
		$this->db->where('lt.table_name', $tabela);
		if(@$parametros['searchField'] != '')
			$this->db->like('upper(cast('.$parametros['searchField'].' as text))', strtoupper(@$parametros['searchString']));

		$total = $this->db->get()->row();

		$paramsJqGrid = $this->ajax->setStartLimitJqGrid($parametros, $total->total_log);

		$this->db->select('lt.id, lt.table_id as id_tabela, flg_action as acao, lf.field_name as campo, lf.old_value as valor_antigo,
							lf.new_value as valor_novo, date_format(dt_register, \'%d/%m/%Y hh24:mi:ss\') as dt_registro', false);
		$this->db->from('log_tables as lt');
		$this->db->join('log_fields as lf', 'lt.id = lf.log_table_id');
		$this->db->where('lt.table_name', $tabela);
		if(@$parametros['searchField'] != '')
			$this->db->like('upper(cast('.$parametros['searchField'].' as text))', strtoupper(@$parametros['searchString']));

		$this->db->order_by($paramsJqGrid->sortField, $paramsJqGrid->sortDirection);
		$this->db->limit($paramsJqGrid->limit, $paramsJqGrid->start);
		$result = $this->db->get();

		$paramsJqGrid->rows = $result->result();
		return $paramsJqGrid;
	}

}