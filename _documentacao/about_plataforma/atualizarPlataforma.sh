#!/bin/bash
echo "----------------------------------------"
echo "Programa de atualização da plataforma..."
cd /var/www/PlataformaDoParaformal
clear
echo "----------------------------------------"
echo "Atualizando com gitHub..."
git pull origin master
echo "----------------------------------------"
echo "Finalizado! Enter para finalizar"
read nada
