<?php

class EquipesGruposAtividadesModel extends Model {
    
    function inserir($pessoaId,$grupoAtividadeId,$coordenador) {
        $existem = $this->existe($pessoaId,$grupoAtividadeId);
        
        if($existem){
            $this->validate->addError('txtColaboradorId', lang('registroNaoGravado'));
            return false;
        }
            
	$this->db->trans_start();
        $this->db->set('pessoa_id', $pessoaId);
        $this->db->set('grupo_atividade_id', $grupoAtividadeId);
        $this->db->set('coordenador', $coordenador);
	$this->db->insert('paraformal.equipe_grupos_atividade');
	$this->db->trans_complete();
	if($this->db->trans_status() === FALSE){
            $this->validate->addError('txtColaboradorId', lang('registroNaoGravado'));
            return false;
	}

        $this->ajax->addAjaxData('pessoa', $this->getColaboradorEquipe($this->db->insert_id('paraformal.equipe_grupos_atividade', 'id')));
	return true;
    }

    function alterar($colaborador){
	$this->db->trans_start();
	$this->db->set('nome', $colaborador['txtColaboradorNome']);
        $this->db->set('email', $colaborador['txtColaboradorEmail']);
        $this->db->set('sexo', $colaborador['cmbColaboradorSexo']);
	$this->db->where('id', $colaborador['txtColaboradorId']);
	$this->db->update('pessoas');
	$this->db->trans_complete();
	if($this->db->trans_status() === FALSE){
            $this->validate->addError('txtColaboradorNomeId', lang('registroNaoGravado'));
	return false;
	}
	$this->ajax->addAjaxData('colaborador', $this->getColaborador($colaborador['txtColaboradorId']));
        return true;
    }
    
    function getColaboradorEquipe($id){
        $this->db->select('p.id as pessoa_id, egp.id, p.nome, egp.coordenador',false);
        $this->db->join('pessoas as p','p.id = egp.pessoa_id');
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
        $this->db->select('equi.id, p.id as pessoa_id, p.nome, equi.coordenador, to_char(p.dt_cadastro, \'dd/mm/yyyy hh24:mi:ss\') as dt_cadastro', false);
        $this->db->from('paraformal.equipe_grupos_atividade as equi');
        $this->db->join('pessoas as p', 'p.id = equi.pessoa_id');
        if(@$parametros['txtGrupoAtividadeId'] != '' )
            $this->db->where('equi.grupo_atividade_id', @$parametros['txtGrupoAtividadeId']);
        $this->db->sendToGrid();
    }
    
    function existe($pessoa_id,$grupo_atividade_id){
        $this->db->where('pessoa_id',$pessoa_id);
        $this->db->where('grupo_atividade_id',$grupo_atividade_id);
        $query = $this->db->get('paraformal.equipe_grupos_atividade');
        if ($query->num_rows == 1) { 
            return true;
        }else{
            return false;
        }
    }

}
