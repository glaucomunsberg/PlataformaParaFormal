<?php

class EnviaEmailModel extends Model {

	function __construct(){
		parent::__construct();
	}

	function enviarEmail($email, $destinatarios){
		$aDestinatarios = array();
		if(is_array($destinatarios))
			for ($i = 0; $i < count($destinatarios); $i++)
				array_push($aDestinatarios, array('email' => $destinatarios[$i], 'enviado' => false));
		else
			array_push($aDestinatarios, array('email' => $destinatarios, 'enviado' => false));

		$email['destinatarios'] = $aDestinatarios;
		$email['dt_cadastro'] = new MongoDate();
		$email['enviado'] = false;

		$lastEmail = $this->mongo_db->insert('emails', $email);

		if(PRODUCAO){
			$this->load->library('email');
			$config['protocol'] = 'smtp';
			$config['smtp_host'] = 'smtp.ufpel.edu.br';
			$config['mailtype'] = 'html';
			$this->email->initialize($config);
			
			$emails = $this->mongo_db->where(array('_id' => $lastEmail))->get('emails');

			foreach ($emails as $email) {				
				foreach ($email['destinatarios'] as $destinatario){
					if(!$destinatario['enviado']){
						$this->email->from('no-reply@ufpel.edu.br');
						$this->email->to($destinatario['email']);
						$this->email->subject($email['assunto']);
						$data['MENSAGEM_PARA_VOCE'] = 'Enviou uma mensagem pra você:';
						$data['MINISTERIO_DA_EDUCACAO'] = 'MINISTÉRIO DA EDUCAÇÃO';
						$data['FOOTER_COBALTO'] = 'cobalto - sistema integrado de gestão';
						$data['MENSAGEM'] = $email['mensagem'];
						$this->email->message($this->load->view('../../static/_views/bodyEmailView', $data, true));
						$this->email->set_alt_message(strip_tags($email['mensagem'], '<a>'));
						$this->email->send();
						$this->email->clear();

						$this->mongo_db->where(array('_id' => $lastEmail, 'destinatarios.email' => $destinatario['email']))->update('emails', array('destinatarios.$.enviado' => true));
					}
				}
				$this->mongo_db->where(array('_id' => $lastEmail))->update('emails', array('enviado' => true));
			}
		}
	}

}