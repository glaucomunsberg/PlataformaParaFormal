<?php

class EquipesGruposAtividadesModel extends Model {
    
    function inserir($pessoaId,$grupoAtividadeId,$tipo_colaboracao) {
       
	$this->db->trans_start();
            $this->db->set('pessoa_id', $pessoaId);
            $this->db->set('grupo_atividade_id', $grupoAtividadeId);
            $this->db->set('participacao_equipe_id', $tipo_colaboracao);
            $this->db->insert('paraformal.equipe_grupos_atividade');
	$this->db->trans_complete();
	if($this->db->trans_status() === FALSE){
            $this->validate->addError('txtColaboradorId', lang('registroNaoGravado'));
            return false;
	}

        $this->ajax->addAjaxData('pessoa', $this->getColaboradorEquipe($this->db->insert_id('paraformal.equipe_grupos_atividade', 'id')));
	return true;
    }
    
    function getColaboradorEquipe($id){
        $this->db->select('p.id as pessoa_id, egp.id, p.nome, pe.descricao',false);
        $this->db->join('pessoas as p','p.id = egp.pessoa_id');
         $this->db->join('paraformal.participacoes_equipe as pe','egp.participacao_equipe_id = pe.id');
        $this->db->where('p.id',$id);
        return $this->db->get('paraformal.equipe_grupos_atividade as egp')->row();
    }
    
    function excluir($id) {
	$this->db->trans_start();
	$aNotasTipos = explode(',', $id);
	$aExcluirNotasTipos = array();
	for($i = 0; $i < count($aNotasTipos); $i++)
            if($aNotasTipos[$i] != 'undefined')
                array_push($aExcluirNotasTipos, $aNotasTipos[$i]);
	$this->db->where_in('id', $aExcluirNotasTipos);
	$this->db->delete('paraformal.equipe_grupos_atividade');
	$this->db->trans_complete();
        if($this->db->trans_status() === FALSE)					
            return false;
	return true;
    }

    function getEquipe($parametros) {
        $this->db->select('equi.id, p.id as pessoa_id, p.nome, pe.descricao, to_char(p.dt_cadastro, \'dd/mm/yyyy hh24:mi:ss\') as dt_cadastro', false);
        $this->db->from('paraformal.equipe_grupos_atividade as equi');
        $this->db->join('pessoas as p', 'p.id = equi.pessoa_id');
        $this->db->join('paraformal.participacoes_equipe as pe','equi.participacao_equipe_id = pe.id');
        if( @$parametros['txtGrupoAtividadeId'] != '' )
            $this->db->where('equi.grupo_atividade_id', @$parametros['txtGrupoAtividadeId']);
        $this->db->sendToGrid();
    }

}
