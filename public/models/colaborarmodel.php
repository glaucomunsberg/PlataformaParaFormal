<?php

/**
 * @package academico
 * @subpackage cadastrosauxiliares
 */
class ColaborarModel extends Model {

    function __construct() {
        parent::__construct();
    }

    function inserir($parametros) {
        $this->db->trans_start();
        $this->db->set('remote_addr', $_SERVER['REMOTE_ADDR']);
        $this->db->set('paraformalidade_id', $parametros['txtParaformaliadeId']);
        $this->db->set('descricao', $parametros['txtDescricao']);
        $this->db->set('pessoa_nome', $parametros['txtNome']);
        $this->db->set('pessoa_email', $parametros['txtEmail']);
        $this->db->set('revisor_id', '0');
        if (@$parametros['txtGeoLatitude'] != '')
            $this->db->set('geo_latitude', $parametros['txtGeoLatitude']);
        if (@$parametros['txtGeoLongitude'] != '')
            $this->db->set('geo_longitude', $parametros['txtGeoLongitude']);
        if (@$parametros['txtImagemId'] != '')
            $this->db->set('upload_id', $parametros['txtImagemId']);
        $this->db->set('dt_cadastro', 'NOW()', false);
        $this->db->insert('paraformal.correcao_paraformalidades');
        $this->db->trans_complete();
        if ($this->db->trans_status() === FALSE) {
            $this->validate->addError('txtCodigo', lang('registroNaoGravado'));
            return false;
        }
        return true;
    }
    
    function listaColaboracoes($parametros){
        $this->db->select('cp.id, cp.paraformalidade_id,ga.descricao as grupo_atividade, c.descricao, case when revisor_id = 0 then \'Não Revisado\' else \'Revisado\' end as estaativo, to_char(cp.dt_cadastro, \'dd/mm/yyyy hh24:mi:ss\') as dt_cadastro', false);
        $this->db->from('paraformal.correcao_paraformalidades as cp');
        $this->db->join('paraformal.paraformalidades as p','p.id = cp.paraformalidade_id');
        $this->db->join('paraformal.cenas as c','c.id = p.cena_id');
        $this->db->join('paraformal.grupos_atividades as ga','ga.id = c.grupo_atividade_id');
        $this->db->join('cidades as cit','cit.id = ga.cidade_id');
        if(@$parametros['descricao'] != '')
            $this->db->like('upper(ga.descricao)', strtoupper(@$parametros['descricao']));
        $this->db->sendToGrid();
    }
    
    function getColaboracao($atualizacaoId){
            $this->db->select('cp.upload_id, up.nome_gerado, cp.id, cp.pessoa_email, cp.pessoa_nome, cp.descricao, cp.geo_latitude, cp.geo_longitude, cp.revisor_id, cp.paraformalidade_id');
            $this->db->join('public.uploads as up','up.id = cp.upload_id','left');
            $this->db->where('cp.id ', $atualizacaoId);
            return $this->db->get('paraformal.correcao_paraformalidades as cp')->row();
    }
    
    function getNumeroDeColaboracoesNaoProcessadas(){
        $this->db->select('*');
        $this->db->from('paraformal.correcao_paraformalidades');
        $this->db->where('revisor_id','0');
        return $this->db->get()->num_rows();
    }
    
    function excluir($id) {

        $this->db->trans_start();
        $aLocais = explode(',', $id);
        $aExcluirLocais = array();
        for ($i = 0; $i < count($aLocais); $i++)
            if ($aLocais[$i] != 'undefined')
                array_push($aExcluirLocais, $aLocais[$i]);

        $this->db->where_in('id', $aExcluirLocais);
        $this->db->delete('paraformal.correcao_paraformalidades');

        $this->db->trans_complete();

        if ($this->db->trans_status() === FALSE)
            return false;

        return true;
    }

}