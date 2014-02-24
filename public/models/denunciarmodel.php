<?php
/**
 * @package academico
 * @subpackage cadastrosauxiliares
 */
class DenunciarModel extends Model {

    function __construct(){
            parent::__construct();
    }

    function inserirDenuncia($parametros){
        $this->db->trans_start();
            $this->db->set('remote_addr',$_SERVER['REMOTE_ADDR']);
            $this->db->set('denuncia', $parametros['txtDescricao']);
            $this->db->set('pessoa_nome', $parametros['txtNome']);
            $this->db->set('pessoa_email', $parametros['txtEmail']);
            $this->db->set('revisor_id','0');
            $this->db->set('link', $parametros['txtEmail']);
            $this->db->set('dt_cadastro', 'NOW()', false);
            $this->db->insert('paraformal.denuncias');
        $this->db->trans_complete();
        if($this->db->trans_status() === FALSE){
                $this->validate->addError('txtCodigo', lang('registroNaoGravado'));
                return false;
        }
        return true;
    }
    function alterar($denuncia){
        $this->db->trans_start();
        if( $denuncia['cmbRevisado'] == 'S'){
            $this->db->set('revisor_id', getUsuarioSession()->pessoa_id);	
        }else{
            $this->db->set('revisor_id', '0');	
        }
        $this->db->where('id', $denuncia['txtDenunciaId']);
        $this->db->update('paraformal.denuncias');
        $this->db->trans_complete();
        
        
        

        if($this->db->trans_status() === FALSE){
                $this->validate->addError('txtDenunciaId', lang('registroNaoGravado'));
                return false;
        }

        $this->ajax->addAjaxData('denuncia', $this->getDenuncia($denuncia['txtDenunciaId']));
        return true;
    }

    
    function listaDenuncias($parametros){
        $this->db->select('id, pessoa_nome, pessoa_email, denuncia, link, to_char(dt_cadastro, \'dd/mm/yyyy hh24:mi:ss\') as dt_cadastro, case when revisor_id = 0 then \'Não Revisado\' else \'Revisado\' end as foirevisado', false);
        $this->db->from('paraformal.denuncias');
        if(@$parametros['descricao'] != '')
            $this->db->like('upper(denuncia)', strtoupper(@$parametros['descricao']));
        $this->db->sendToGrid();
    }
    
    function getNumeroDeDenunciasNaoSolucionados(){
        $this->db->select('*');
        $this->db->from('paraformal.denuncias');
        $this->db->where('revisor_id','0');
        return $this->db->get()->num_rows();
    }
    
    function getDenuncia($corpoNumeroId){
            $this->db->select('id, pessoa_nome, pessoa_email, denuncia, link, to_char(dt_cadastro, \'dd/mm/yyyy hh24:mi:ss\') as dt_cadastro, case when revisor_id = 0 then \'N\' else \'S\' end as revisado',false);
            $this->db->where('id', $corpoNumeroId);
            return $this->db->get('paraformal.denuncias')->row();
    }
    

}