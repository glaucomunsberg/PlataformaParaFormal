<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * Helper responsavel por manipular as tabs do sistema
 * @package helpers
 * @subpackage tabs
 * @author rsantos
 */

/**
 * Abre o painel onde serão incluida abas
 * @param string $name Nome do painel de abas (padrão "tab").
 * Este nome será utilizado para compor o nome (e ID) das suas abas
 * @return string
 */
function begin_TabPanel($name = 'tab') {
    $CI = & get_instance();
    $CI->tabpanel->setTabName($name);
    $tabpanel = '<div id="' . $name . '" class="tabs"><ul></ul>';
    return $tabpanel;
}

/**
 * Inicia uma aba dentro de um painel de abas
 * @param string $titulo O título (label) da aba
 * @param string $url A URL a ser carregada ao clicar na aba (padrão vazio)
 * @param boolean $navigable TRUE para navegação por hashtags na URL
 * @param string $hash Nome da aba (para navegação, use minúsculas e caracteres simples)
 * @return string 
 */
function begin_Tab($titulo, $url = '', $navigable = FALSE, $hash = FALSE) {
    $CI = & get_instance();
    $id = $CI->tabpanel->getId();
    $tabName = $CI->tabpanel->getTabName();

    if (is_bool($url)) {
        $hash = $navigable;
        $navigable = $url;
        $url = '';
    }
    if ($hash === FALSE) {
        $hash = "$tabName-$id";
    }
    if (empty($url)) {
        $url = "#$hash";
    }
    if ($navigable) {
        $url .= "\" onclick=\"if(! $(this).parent().hasClass('ui-state-disabled') ){ location.hash='$hash'; }";
    }
    $tab = "<div id=\"$hash\" class=\"ui-widget $tabName $tabName-$id $hash\">";
    $tab .= "<ul><li class=\"label$tabName\"><a href=\"$url\" title=\"$hash\">$titulo</a></li></ul>";
    return $tab;
}

/**
 * Encerra uma aba
 * @return string 
 */
function end_Tab() {
    return '<br /></div>';
}

/**
 * Encerra um painel de abas
 * @return string 
 */
function end_TabPanel() {
    return '</div>';
}

/**
 * @deprecated version - 02/12/2011
 */
function begin_TabPanelChild($name = 'tabChild') {
    $CI = & get_instance();
    $CI->tabpanel->setTabNamechild($name);
    $tabNameChild = $CI->tabpanel->getTabNameChild();
    $tabPanelChild = '<div id="' . $tabNameChild . '" class="tabs"><ul></ul>';
    return $tabPanelChild;
}

/**
 * @deprecated version - 02/12/2011
 */
function begin_TabChild($titulo, $url = '') {
    $CI = & get_instance();
    $idChild = $CI->tabpanel->getIdChild();
    $tabNameChild = $CI->tabpanel->getTabNameChild();

    $tabChild = '<div id="' . $tabNameChild . '-' . $idChild . '" class="ui-widget ' . $tabNameChild . '">';
    if ($url == '') {
        $tabChild.= '	<ul><li class="label' . $tabNameChild . '"><a href="#' . $tabNameChild . '-' . $idChild . '" title="' . $tabNameChild . '-' . $idChild . '">' . $titulo . '</a></li></ul>';
    } else {
        $tabChild.= '	<ul><li class="label' . $tabNameChild . '"><a href="' . $url . '" title="' . $tabNameChild . '-' . $idChild . '">' . $titulo . '</a></li></ul>';
    }
    return $tabChild;
}

/**
 * @deprecated version - 02/12/2011
 */
function end_TabChild() {
    return '<br /></div>';
}

/**
 * @deprecated version - 02/12/2011
 */
function end_TabPanelChild() {
    return '</div>';
}