<?=$this->load->view("../../static/_views/headerLoginView");?>
<link href='http://fonts.googleapis.com/css?family=Ubuntu' rel='stylesheet' type='text/css'>
<div style="margin: 5px;">
		<div style="float: right; padding: 10px 0; left: 420px; right: 0; position: absolute;">										
			 <ul style="list-style-type: none; font-family: 'Ubuntu', sans-serif;">
			 	<li>			 		
			 		<h1 >Plataforma do Para-formal - Portal de Gerenciamento de Para-Formalidades.</h1>
			 		<ul style="padding-left: 0px;">
			 			<li style="list-style-type: none;">						 		
					 		<p style="margin: 5px; font-size: 14px; text-align: justify; text-indent: 20px;">					 			
					 			Seja bem-vindo ao portal de gerenciamento de paraformalidades, venha fazer parte você também do Paraformal.
							</p>					 			
							<p style="margin: 5px; font-size: 14px; text-align: justify; text-indent: 20px;">
								A Plataforma do Paraformal se destina cadastrar e gerenciar as paraformalidades registradas através de eventos com a comunidade. Possibilitando uma comunicação com o público e permitindo que uma equipe se integre com a comunidade. 
							</p>
							<p style="margin: 5px; font-size: 14px; text-align: justify; text-indent: 20px;">
								Deseja saber mais sobre o Portal?!
							</p>
							<p style="margin: 5px; font-size: 14px; text-align: justify; text-indent: 20px; margin-left: 20px">
								Conheça o Projeto Plataforma do Parformal: <a href="<?=WIKI;?>Plataforma_Paraformal" target="_blank">Plataforma Source</a>
							</p>
                                                        <p style="margin: 5px; font-size: 14px; text-align: justify; text-indent: 20px; margin-left: 20px">
								Conheça a Equipe Idealizadora do projeto : <a href="<?=WIKI;?>Equipe" target="_blank">Cidade+Contemporaneidade</a>
							</p>
                                                        
                                                        
					 	</li>						 	
			 		</ul>				 		
			 	</li>
                                <li>
			 	<h2>Experimente como funciona</h2>
			 		<ul>
					 	<li>
					 		<p style="margin: 5px; font-size: 14px; text-align: justify"> Visite a área pública </p>
                                                        <?=form_button('btnAcessar', lang('longinAjudar'), 'areaPublica()');?>
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
					 		<p style="margin: 5px; font-size: 14px; text-align: justify">O “para-formal” habita o “entre” a “formalidade” e a “informalidade” existente nos territórios da cidade. <a href="<?=WIKI;?>" target="_blank">Veja mais</a></p>
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
                                <?=begin_Tab(lang('longinAjuda'));?>
                                                <div style="list-style-type: none; font-family: 'Ubuntu', sans-serif; margin: 5px; font-size: 12px; text-align: justify">
                                                        Visite nossa <b>WikiParaformal</b> para ter maiores informações sobre:<br>
                                                        <table style="list-style-type: none; font-family: 'Ubuntu', sans-serif; margin: 5px; font-size: 12px; text-align: justify; border:0px">
                                                                <tr>
                                                                    <td style="width: 16px; height: 16px; background-image: url(../static/_css/redmond/images/ui-icons_469bdd_256x240.png); background-position: -64px -144px;"></td>
                                                                    <td><?=lang('longinAjudarComoUsarPlataforma');?></td>
                                                                </tr>
                                                                <tr>
                                                                    <td style="width: 16px; height: 16px; background-image: url(../static/_css/redmond/images/ui-icons_469bdd_256x240.png); background-position: -64px -144px;"></td>
                                                                    <td><?=lang('longinAjudarComoColaborar');?></td>
                                                                </tr>
                                                                <tr>
                                                                    <td style="width: 16px; height: 16px; background-image: url(../static/_css/redmond/images/ui-icons_469bdd_256x240.png); background-position: -64px -144px;"></td>
                                                                    <td><?=lang('longinAjudarComoContato');?></td>
                                                                </tr>
                                                        </table>
                                                </div>
                                                <?=form_button('btnAjudar', lang('longinAjudar'), 'ajudar()');?>
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
    
    function ajudar(){
        $("#btnAjudar").blur();
        window.open ('<?=WIKI;?>');
    }
    function areaPublica(){
        $("#btnAcessar").blur();
        location.href = BASE_URL;
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
