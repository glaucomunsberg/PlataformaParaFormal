<?php

class UploadModel extends Model {

    function inserir($arquivo) {
        $this->db->set('nome_gerado', $arquivo['file_name']);
        $this->db->set('nome_original', $arquivo['orig_name']);
        $this->db->set('tamanho', $arquivo['file_size']);
        $this->db->set('tipo', $arquivo['file_type']);
        $this->db->set('dt_cadastro', 'NOW()', false);
        $this->db->insert('uploads');
        return $this->getUpload($this->db->insert_id());
    }

    function getUpload($id) {
        $this->db->where('id', $id);
        return $this->db->get('uploads')->row();
    }

}
