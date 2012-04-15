#!/bin/bash

#	Você queria executar e não estar vendo esse código?!
#	  Então abra seu terminal e digite
#
# 		$ sudo chmod +x creator.sh
#		$ sudo ./creator
#
#	Você queria mesmo ver o código?!
#	  Bem-vindo ao código criado para automatizar o processo do GitHub
#		Olhe e modifique ao seu gosto!


#--- Identificadores

version="0.9"         	#Versão do GitHub Creator
lido=1                	#Verifica se já foi lido o nome do usuário e do projeto
exec="Y"         	    #Garante que haverá a execução do programa mesmo existindo o automatico.
autoself="1"	        #Esse identificador identifica se é o Creator ou Automatico
user="glaucomunsberg"                   #Descomentado no Automatico.sh para conter o nome do usuário do Github
project="plataformaParaFormal"			    #Desbloqueado no Automatico.sh para conter o nome do projeto do Github

#---------------------------------------------------------------------------------------------
#---------------------------------------- Funções --------------------------------------------

function cabeca()
{
	# Função que printa o cabeçalho
	
	if [ $autoself -eq 1 ]; then
		echo "---------------------------------------------------------"
		echo "             GitHub Creator - Automatico                 "
		echo "---------------------------------------------------------"
	else
		echo "---------------------------------------------------------"
		echo "             GitHub Creator - Executador                 "
		echo "---------------------------------------------------------"
	fi
}

function criar_automatico()
{
	# Função responsável pela configuração e criação do automatico.sh
	#     segundo as configurações pré-colidas na função criar_projeto()
	
	clear
	cabeca
	echo "- Você  está  prestes a  cria um  automático para o seu -"
	echo "-    projeto.                                           -"
	echo "-    Você tem certeza disso? Y/N                        -"
	read enter
	if [ $enter = "Y" -o $enter = "y" ]; then
		clear
		criacao_projeto
		clear
		cabeca
		echo "- As configurações básicas  foram feitas,  agora  vamos -"
		echo "-    criar seu automatico.sh                            -"
		echo "-    |-0%                                        |      -"
		#Troca o valor para informar que autoself é o automatico
		sed "s/autoself=\"0\"/autoself=\"1\"/g" "creator.sh" > "temp1.sh"
		echo "-    |------------%25                            |      -"
		#coloca o valor do projeto no identificador
		sed "s/project="C-C"/project=\"$project\"/g" "temp1.sh" > "temp2.sh"
		echo "-    |--------------------%50                    |      -"
		#Coloca o valor do usuário no indentifador
		sed "s/user="glaucomunsberg"/user=\"$user\"/g" "temp2.sh" > "temp3.sh"
		echo "-    |--------------------------------%75        |      -"
		#Troca o valor de lido para que o automatico.sh não leia novo nome de projeto
		sed "s/lido=1/lido=1/g" "temp3.sh" > "temp4.sh"
		echo "-    |-------------------------------------%90   |      -"
		
		if [ $criarpasta = "Y" -o $criarpasta = "y" ]; then
			cp temp4.sh ${project}/automatico.sh
			sudo chmod +x ${project}/automatico.sh
			rm temp*
			echo "-    |-------------------------------------------| %100 -"
			sleep 1
			if [ -f ${project}/automatico.sh ]; then
				echo "- Automatico.sh foi criado com sucesso!                 -"
			else
				echo "- ATENÇÃO!                                              -"
				echo "- Automatico.sh não foi criado por algum erro           -"
			fi
			
		else
			cp temp4.sh automatico.sh
			sudo chmod +x automatico.sh
			rm temp*
			echo "-    |-------------------------------------------| %100 -"
			sleep 1
			if [ -f "automatico.sh" ]; then
				cabeca
				echo "- Automatico.sh foi criado com sucesso!                 -"
			else
				cabeca
				echo "- ATENÇÃO!                                              -"
				echo "- Automatico.sh não foi criado por algum erro           -"
			fi
		fi
		
		echo "- Deseja sair? Y/N                                      -"
		leu=false
		while [ $leu = false ]; do
			read nada
			if [ -n "$nada" ];then
				leu=true
			fi
		done
		if [ $nada = "Y" -o $nada = "y" ]; then
			sair
		fi
	fi
	
	
}

function executar()
{
	
	# Função deficada apenas a executar funções basicas
	#	do github sem necessariamente a criação de um
	#	automatico.sh
	
	#Verifica se o nome do usuário e do projeto já foram
	#     lido, sendo lido passa direto para as funções.
	#	caso contrário vai ler os valores
					
	if [ $lido = "0" ]; then
		leitura
	fi
	clear
	cabeca
	echo "- No executar não é feita nenhuma configuração.         -"
	echo "-   portando  para que funcione é preciso que o  gitHub -"
	echo "-   já esteja previamente funcionando neste local.      -"
	echo "-                                                       -" 
	echo "- 1.Push                                                -"
	echo "- 2.Pull                                                -"
	echo "- 0.Sair                                                -"
	read commit
	if [ $commit -eq 1 ]; then
		git_push
	elif [ $commit -eq 2 ]; then
		git_pull
	else
		echo "- Retornando...                                         -"
	fi
		
}

function about()
{
	# Função que trás informações a respeito do projeto
	
	clear
	cabeca
	echo "- GitHub Creator  é  um programa  para que  você  possa -"
	echo "-    automatizar  tarefas  rotineiras do GitHub no  seu -"
	echo "-    terminal. Possibilitando a  execução apenas  ou  a -"
	echo "-    criação deu um automatico.sh para fazer isso.      -"
	echo "-                                                       -"
	echo "- O projeto pode ser baixado no seguinte link           -"
	echo "-     Http://github.com/glaucomunsberg/Automatico       -"
	echo "- Versão:                                               -"
	echo "-     $version	                                        -"
	echo "- Criado por:                                           -"
	echo "-     Glauco Roberto Munsberg dos Santos                -"
	echo "---------------------------------------------------------"
	read nada
}

function sair()
{
	# Função que simplifica o processo de saida
	
	clear
	cabeca
	echo "- Saindo...                                             -"
	echo "---------------------------------------------------------"
	sleep 1;
	clear;
	exit;
}

function leitura()
{
	certo=false
	while [ $certo = false ]; do
		clear
		cabeca
		#ler o USER
		echo "- 2) Qual é o seu usuário do GitHub?                    -"
		leu=false
		certo=false
		
		while [ $leu = false ]; do
			read user
			if [ -n "$user" ];then
				leu=true
			fi
		done
		
		#ler o PROJECT
		lido=1
		echo "- 3) Qual é o nome do projeto no GitHub?                -"
		leu=false
		
		while [ $leu = false ]; do
			read project
			if [ -n "$project" ];then
				leu=true
			fi
		done
		
		clear
		cabeca
		if [ $autoself -eq 1 ]; then
			echo "- Ok.  Confira  os  dados,  pois  o  automatico.sh será -"
			echo "-    criado com os seguintes dados:                     -"
		else
			echo "- OK. Confira os dados para continuar:                  -"
		fi
		echo "-                                                       -"
		echo "-    USER    = $user"
		echo "-    PROJETO = $project"
		echo "-                                                       -"
		echo "- Os dados estão corretos?! Y/N                         -"
		read tudo
		
		if [ $tudo = "Y" -o $tudo = "y" ]; then
			certo=true
		fi
	done
	lido=1
}
function criacao_projeto()
{
	#Faz a leitura do nome do usuário e o nome do projeto
	#   que será utilizado pelo arquivo, bem como o as dependências
	#	do mesmo. Possibilita a criação de uma pasta para conter o
	#   projeto e configura a pasta segundo o projeto que será descarregado
	
	clear
	cabeca
	echo "- Ok.  Porém  é preciso de algumas informações:         -"
	echo "-    1) Seu projeto já teve algum commit? Y/N           -"
	read existe
	
	if [ $existe = "Y" -o $existe = "y" ]; then
		clear
		cabeça

		echo "- Ok.  Vamos  criar  TUDO, ou  seja, configuraremos seu -"
		echo "-    projeto, criaremos seu automatico  e seu  primeiro -"
		echo "-    commit. Mas antes disso vamos trazer seus arquivos -"
	else
		clear
		cabeca
		echo "- Ok.  Vamos  criar  TUDO, ou  seja, configuraremos seu -"
		echo "-    projeto, criaremos seu automatico  e seu  primeiro -"
		echo "-    commit.                                            -"
	fi
	
	#Verifica se o nome do usuário e do projeto já foram
	#     lido, sendo lido passa direto para as funções.
	#	caso contrário vai ler os valores
					
	if [ $lido = "0" ]; then
		leitura
	fi
	
	clear
	cabeca
	echo "- 4) Deseja criar uma pasta para os arquivos? Y/N.      -"
	read criarpasta
	
	if [ $criarpasta = "Y" -o $criarpasta = "y" ]; then

		echo "- Criada a pasta e configurando...                      -"
		mkdir ${project}
		cd ${project}/
	else
		echo "- Configurando...                                       -"
	fi
	
	if [ $existe = "N" -o $existe = "n" ]; then
		sudo git init
		touch README
		sudo git add README
		sudo git commit -m 'Conf. pelo GitHub Creator $version'
		sudo git remote add origin git@github.com:${user}/${project}.git
		sudo git push -u origin master
	else
		sudo git init
		sudo git remote add origin git@github.com:${user}/${project}.git
		sudo git pull git@github.com:${user}/${project}.git master
		if [ -f "README" ]; then
			sudo chmod 777 README
			gedit README
		else
			echo "- Não foi detectado o README utilizado no gitHub.       -"
			echo "- Deseja criar um para ser usado?!  Y/N                 -"
			read nada
			if [ $nada = "Y" -o $nada = "y" ]; then
				touch README
				gedit README
			fi
			git add *.*
			sudo git push -u origin master
		fi
	fi
	
	if [ $criarpasta = "Y" -o $criarpasta = "y" ]; then
		cd ../
	fi
	
	echo "---------------------------------------------------------"
	read nada
}

function git_push()
{
	#Função contendo o Push, utilizado no github para empurrar os arquivos
	
	clear
	cabeca
	echo "- Deseja inserir algo no README? Y/N                    -"
	read opcao;

	if [ $opcao = "Y" -o $opcao = "y" ]; then
		gedit README
	fi
	
	echo "- Carregando os arquivos...                             -"
	git add README
	git add *.*
	echo "- Insira o nome do commit:                              -"
	read nome
	git commit -m ${nome// /_};
	echo "- Commintando...                                        -"
	git push origin master
	echo "---------------------------------------------------------"
	read nada
}

function git_pull()
{
	# Função usado no git para puxar os arquivos
	
	clear;
	cabeca
	echo "- Github Pull...                                        -"
	sudo git pull git@github.com:${user}/${project}.git master
	echo "---------------------------------------------------------"
	read nada
}

function ssh_key()
{
	# Função para que se possa resetar o SSH e após fazer isso
	#     testa a conexão com o github
	clear;
	cabeca
	echo "- Resetar SSH..                                         -"
	sudo systemctl restart sshd.service
	sleep 1
	sudo ssh -T git@github.com
	echo "---------------------------------------------------------"
	read nada
}

function git_remove()
{
	# Função que deleta os arquivos escolhidos nomeados pelo usuário
	
	clear
	cabeca
	echo "- Digite os arquivos que deseja deletar:                -"
	read removendo
	sudo git rm ${removendo}
	echo "---------------------------------------------------------"
	echo "- Commit para que que se delete os arquivos             -"
	echo "---------------------------------------------------------"
	read nada
}

function git_test()
{
	# Função de teste de conexão do projeto com o GitHub
	clear;
	cabeca
	echo "---------------------------------------------------------"
	echo "- Teste de Conexão com o GitHub...                      -"
	sudo ssh -T git@github.com
	echo "---------------------------------------------------------"
	read nada
}

function git_add()
{
	# Função que adiciona os arquivos escolhidos nomeados pelo usuário
	
	clear
	cabeca
	echo "- Digite os arquivos que deseja adicionar:              -"
	read adicionar
	sudo git add ${adicionar}
	echo "---------------------------------------------------------"
	echo "- Commit para que adicione os arquivos                  -"
	echo "---------------------------------------------------------"
	read nada
}

function git_status()
{
	# Função de status do estado que se encontra os arquivo em relação
	#     ao estado do repositório segundo o último push/pull
	
	clear
	cabeca
	echo "--------------------------------------------------------"
	echo "- Git Status...                                        -"
	sudo git status
	echo "--------------------------------------------------------"
	read nada
}

function ferramentas()
{
	# Função que contém as ferramentas aninhadas para melhore ser
	#     melhor organizado o menu do automatico.sh. Trás nele a
	#     coleção de ferramentas integradas.
	
	clear
	cabeca
	echo "- 1. Git Remove                                         -"
	echo "- 2. Git Status                                         -"
	echo "- 3. Git Test                                           -"
	echo "- 4. Git Add                                            -"
	read nada
	case $nada in
		1) git_remove;;
		2) git_status;;
		3) git_test;;
		4) git_add;;
	esac
}

#---------------------------------------------------------------------------------------------
#--------------------------------------- Programa --------------------------------------------

if [ $autoself -eq 1 ]; then
	# Parte responsável pela execução do AUTOMATICO.SH
	run=true
	while [ $run = true ]; do
		
		clear
		cabeca
		echo "- 1. Push                                               -"
		echo "- 2. Pull                                               -"
		echo "- 3. Ferramentas                                        -"
		echo "- 0. Sair                                               -"
		leu=false
		while [ $leu = false ]; do
			read commit
			if [ -n "$user" ];then
				leu=true
			fi
		done
		case $commit in
			0) sair;;
			1) git_push;;
			2) git_pull;;
			3) ferramentas;;
		esac
	done
else
	# Parte responsável pela execução do CREATOR.SH
	if [ -e "automatico.sh" ]; then
		clear
		cabeca
		echo "- O automatico.sh do projeto já existe. Isso quer dizer -"
		echo "-    que o projeto já foi configurado nessa pasta.  Por -"
		echo "-    isso deve usá-lo.                                  -"
		echo "-    Deseja executar assim mesmo?! Y/N                  -"
		read exec
		
		if [ $exec != "N" -o $exec != "n" ]; then
			sair
		fi
	fi

	if [ $exec = "Y" -o $exec = "y" ]; then
		run=true
		while [ $run = true ]; do
			clear
			cabeca
			echo "- 1. Executar sem criar um automatico.sh                -"
			echo "- 2. Criar um automatico.sh para seu projeto.           -"
			echo "- 3. Sobre GitHub Creator                               -"
			echo "- 4. Sair                                               -"
			read opcao
			if [ $opcao -ge 4 ]; then
				sair
			else
				if [ $opcao -eq 3 ]; then
					about
				else
					
					#Executa o projeto apenas ou cria então o automatico.sh
					#     segundo valor de opcao
					
					if [ $opcao -eq 2 ]; then
						criar_automatico
					else
						executar
					fi
	
				fi
			fi
		done
	fi
fi
