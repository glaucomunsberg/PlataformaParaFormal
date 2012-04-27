<?php

class ConfiguracaoModel extends Model {

    function salvarDadosGerais($dados_gerais, $usuarioId) {
        /* $this->db->trans_begin();
          $this->db->set('avatar_id', $dados_gerais['avatarId']);
          $this->db->where('id', $usuarioId);
          $this->db->update('usuarios');
          $this->db->trans_complete(); */

        if ($this->db->trans_status() === FALSE) {
            return false;
        }
        return true;
    }

    function salvarSenha($senha, $usuarioId) {
        $retErro = $this->validaNovaSenha($senha, $usuarioId);
        if ($retErro) {
            return false;
        }
        $this->db->set('senha', $this->encrypt->sha1(trim($senha['txtSenhaNova'])));
        $this->db->where('id', $usuarioId);
        $this->db->update('usuarios');

        return true;
    }

    function salvarTema($tema, $usuarioId) {
        $this->db->set('tema', $tema);
        $this->db->where('id', $usuarioId);
        $this->db->update('usuarios');
    }

    function validaUsuarioSenhaAtual($senha, $usuarioId) {
        $this->db->where('senha', $this->encrypt->sha1(trim($senha['txtSenhaAtual'])));
        $this->db->where('id', $usuarioId);
        $usuario = $this->db->get('usuarios')->row();
        if (@$usuario->id == '') {
            return false;
        } else {
            return true;
        }
    }

    function validaNovaSenha($senha, $usuarioId) {
        $this->validate->setData($senha);
        $this->validate->validateField('txtSenhaAtual', array('required'), lang('configuracaoSenhaAtualDeveSerInformada'));
        $this->validate->validateField('txtSenhaNova', array('required'), lang('configuracaoSenhaNovaDeveSerInformada'));
        $this->validate->validateField('txtConfirmaSenha', array('required'), lang('configuracaoCofirmacaoSenhaDeveSerInformada'));

        if ($senha['txtSenhaNova'] != $senha['txtConfirmaSenha']) {
            $this->validate->addError('txtConfirmaSenha', lang('configuracaoCofirmacaoSenhaDiferenteSenhaNova'));
        }
        if ($senha['txtSenhaAtual'] != '') {
            if (!$this->validaUsuarioSenhaAtual($senha, $usuarioId)) {
                $this->validate->addError('txtSenhaAtual', lang('configuracaoSenhaAtualNaoConfere'));
            }
        }
        return $this->validate->existsErrors();
    }

}
