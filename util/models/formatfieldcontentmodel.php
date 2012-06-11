<?php

class FormatFieldContentModel extends Model {

    /**
     * @name removeCharacteres
     * Função utilizada para a remoção de vários caracteres de uma string;
     *
     */
    function removeCharacteres($string, $removes) {
        $newString = '';
        foreach ($removes as $remove) {
            $newString += str_replace($remove, '', $string);
        }
        return $newString;
    }

}
