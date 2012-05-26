<?=$this->load->view("../../static/_views/headerLoginView");?>
<div style="margin: 5px;">
		<div style="float: right; padding: 10px 0; left: 420px; right: 0; position: absolute;">										
			 <ul style="list-style-type: none;">
			 	<li>			 		
			 		<h1>Plataforma do Paraformal - Portal de Gerenciamento de Para-Formalidades</h1>
			 		<ul style="padding-left: 0px;">
			 			<li style="list-style-type: none;">						 		
					 		<p style="margin: 5px; font-size: 14px; text-align: justify; text-indent: 20px;">					 			
					 			Seja bem-vindo ao portal de gerenciamento de paraformalidades, venha fazer parte você também do Paraformal
							</p>					 			
							<p style="margin: 5px; font-size: 14px; text-align: justify; text-indent: 20px;">
								A Plataforma do Paraformal se destina cadastrar e gerenciar as paraformalidades registradas através de eventos com a comunidade. Possibilitando uma comunicação com o público e permitindo que uma equipe se integre com a comunidade 
							</p>
							<p style="margin: 5px; font-size: 14px; text-align: justify; text-indent: 20px;">
								Deseja saber mais sobre o Portal?!
							</p>
							<p style="margin: 5px; font-size: 14px; text-align: justify; text-indent: 20px;">
								Conheça o Projeto da Plataforma do Parformal: <a href="http://glaucomunsberg.github.com/C-C/" target="_blank">Plataforma Source</a>
							</p>
                                                        <p style="margin: 5px; font-size: 14px; text-align: justify; text-indent: 20px;">
								Conheça a Equipe Idealizadora do projeto : <a href="http://www.wix.com/contemporaneidade/faurb#!__quem-somos" target="_blank">Cidade+Contemporaneidade</a>
							</p>
                                                        
                                                        
					 	</li>						 	
			 		</ul>				 		
			 	</li>
			 	<li>
			 		<h2><?=lang("sigla")?></h2>
			 		<ul>
			 			<li>
					 		<h2>O projeto</h2>
					 		<p style="margin: 5px; font-size: 14px; text-align: justify">O Grupo procura articular-se em torno da abordagem multidisciplinar de questões teóricas e empíricas relacionadas à sociedade contemporânea, em especial na relação entre a arquitetura e cidade, habitando para isso as fronteiras da filosofia, das artes e da educação, a fim de criar ações projetuais e perceptos para uma estética urbana atual.</p>
					 	</li>
					 	<li>
					 		<h2>O que é Para-formal?!</h2>
					 		<p style="margin: 5px; font-size: 14px; text-align: justify">O “para-formal” habita o “entre” a “formalidade” e a “informalidade” existente nos territórios da cidade. <a href="http://media.wix.com/ugd/e30259_1c9cf98a4a9aff99db5073edabbc4529.pdf?dn=OS%2BLUGARES%2BDO%2BPARA-FORMAL-CNPQsemor%C3%83%C2%A7amento.pdf" target="_blank">Veja mais</a></p>
					 	</li>
			 		</ul>
			 	</li>				 	
			 </ul>
			<?=new_line();?>
			<div style="height: 200px; float: left;"><!--class="description-cobalto" --></div>
		</div>
	<div style="margin: 5px;">
		<div style="float: left; padding: 2px 2px 0px 2px; margin: 30px; width: 360px;">
			<?=begin_TabPanel();?>
				<?=begin_Tab(lang('acessoSistema'));?>
					<?=begin_form('autenticacao/login/entrar', 'formLogin');?>
						<?=form_label('lblEmail', lang('login'), 60);?>
						<?=form_textField('txtEmail', '', 240);?>
						<?=new_line();?>
						<?=form_label('lblSenha', lang('usuarioSenha'), 60);?>
						<?=form_textField('txtSenha', '', 240, '', '', array('type' => 'password'));?>
						<?=new_line();?>
						<input id="btnEntrar" name="btnEntrar" type="submit" value="<?=lang('entrar');?>" style="margin-bottom: 0px;"/>
					<?=end_form();?>
				<?=end_Tab();?>
			<?=end_TabPanel();?>
			<span style="float: right;"><!-- Versão do manager aqui --></span>
		</div>
	</div>

<script type="text/javascript">
    function init(){
        $("#btnEntrar").bind('click', entrar);
        $('#txtEmail').focus();
    }

    function entrar(){
        $("#btnEntrar").blur();
        formLogin_submit();
    }

    function formLogin_callback(data){
        if (data.error != undefined) {
            messageErrorBox(data.error.message, data.error.field);
        } else {
            if (data.success != undefined) {
                location.href = BASE_URL+'dashboard';
            }
        }
    }

</script>

<?=$this->load->view("../../static/_views/footerLoginView");?>
