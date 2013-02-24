#!/bin/bash
cd /var/www/PlataformaDoParaformal
echo "-------------------------------------------"
echo "-Programa de atualização da plataforma... -"
echo "-Etapa 1                                  -"
echo "-Atualizando com gitHub...                -"
git reset --hard HEAD
git pull origin master
echo "-------------------------------------------"
echo "Etapa 1 finalizada! Enter para continuar  -"
read algo
clear
echo "-------------------------------------------"
echo "-Programa de atualização da plataforma... -"
echo "-Etapa 2                                  -"
echo "-Você deseja atualizar o banco de dados?! -"
echo "-OBS.: Note que isso REMOVERÁ o banco de  -"
echo "-dados atual e será substituído pelo banco-"
echo "-de dados NOVO. Note também que será feito-"
echo "-um backup do banco de dados atual. Deseja-"
echo "-continuar com a operação?! S/N           -"
read operacao
if [ $operacao != "N" ]; then
	echo "pg_dump aurora > aurora_dump_antigo.sql" | sudo su - postgres
	echo "dropdb aurora" | sudo su - postgres
	echo "createdb aurora" | sudo su - postgres
	echo "\i /var/www/PlataformaDoParaformal/_documentacao/dumps/Aurora.sql" | sudo su postgres -c "psql aurora"
	echo "Etapa 2 finalizada! Enter para continuar  -"
	read algo
	else
	echo "Etapa 2 abortada! Enter para continuar    -"
	read algo
fi
clear
echo "-------------------------------------------"
echo "-Programa de atualização da plataforma... -"
echo "-Etapa 3                                  -"
echo "-Permissão de arquivos                    -"
sudo chmod +x _documentacao/about_plataforma/tools/atualizarPlataforma.sh
echo "Etapa 3 finalizada! Enter para sair...    -"
read a
