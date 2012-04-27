<?php

class LogTabelaModel extends Model {

    function getTabelas($parametros) {
        $this->db->select('\'chr9\'||table_schema||table_name as id, table_schema, table_name', false);
        $this->db->from('information_schema.tables');
        $this->db->where('table_schema', 'public');
        $this->db->where('table_type', 'BASE TABLE');
        $this->db->like('upper(table_name)', @$parametros['tabela']);
        $this->db->sendToGrid();
    }

    function getColunas($parametros, $esquema, $tabela) {
        $this->db->select('column_name as id, ordinal_position, column_name, data_type, column_default', false);
        $this->db->from('information_schema.columns');
        $this->db->where('table_schema', $esquema);
        $this->db->where('table_name', $tabela);
        $this->db->sendToGrid();
    }

    function salvarLogTabela($logTabela) {
        $this->db->trans_start();
        $sql = 'delete
            from log_fields_structures
			where id in (select lfs.id
                from log_fields_structures as lfs
				join log_tables_structures as lts
				on lts.id = lfs.log_table_structure_id
				where lts.table_name = \'' . $logTabela['txtTabela'] . '\')';
        $this->db->query($sql);

        $this->db->where('table_name', $logTabela['txtTabela']);
        $this->db->delete('log_tables_structures');

        $sql = 'drop trigger if exists trigger_log_' . $logTabela['txtTabela'] . ' on ' . $logTabela['txtTabela'];
        $this->db->query($sql);

        if ($logTabela['txtColunas'] != '') {
            $fields = explode(',', $logTabela['txtColunas']);
            $this->db->set('table_name', $logTabela['txtTabela']);
            $this->db->insert('log_tables_structures');

            $logTableStructureId = $this->db->insert_id();

            for ($i = 0; $i < count($fields); $i++) {
                $this->db->set('log_table_structure_id', $logTableStructureId);
                $this->db->set('field_name', $fields[$i]);
                $this->db->insert('log_fields_structures');
            }

            $sql = 'create trigger trigger_log_' . $logTabela['txtTabela'] . ' after insert or update or delete on ' . $logTabela['txtTabela'] . ' for each row execute procedure fnc_trigger_log()';
            $this->db->query($sql);
        }

        $this->db->trans_complete();

        return $this->db->trans_status();
    }

    function getColunasLogTabela($tabela) {
        $this->db->select('lfs.field_name', false);
        $this->db->from('log_fields_structures as lfs');
        $this->db->join('log_tables_structures as lts', 'lts.id = lfs.log_table_structure_id');
        $this->db->where('lts.table_name', $tabela);
        return $this->db->get()->result();
    }

    function getLogTabela($parametros, $esquema, $tabela) {
        $this->db->select('lt.id, lt.table_id as id_tabela, flg_action as acao, lf.field_name as campo, lf.old_value as valor_antigo, lf.new_value as valor_novo, dt_register dt_registro', false);
        $this->db->from('log_tables as lt');
        $this->db->join('log_fields as lf', 'lt.id = lf.log_table_id');
        $this->db->where('lt.table_name', $tabela);
        if (@$parametros['searchField'] != '') {
            $this->db->like('upper(cast(' . $parametros['searchField'] . ' as text))', strtoupper(@$parametros['searchString']));
        }
        $this->db->sendToGrid();
    }

}
