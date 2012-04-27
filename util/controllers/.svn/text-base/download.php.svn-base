<?php

class Download extends Controller {

    function arquivo($nameFile, $thumb = '') {
        $mongo = new Mongo('mongodb://' . $this->config->item('mongo_host'));
        $db = $mongo->selectDB($this->config->item('mongo_db'));
        $gridFS = $db->getGridFS();

        if ($thumb == '') {
            $archive = $gridFS->findOne(array('filename' => $nameFile, 'no_thumb' => true));
        } else {
            $archive = $gridFS->findOne(array('filename' => $nameFile, 'thumb' => $thumb));
        }
        header('Content-type: ' . $archive->file['type']);
        echo $archive->getBytes();
    }

    function codeValidator($codeValidator) {
        $mongo = new Mongo('mongodb://' . $this->config->item('mongo_host'));
        $db = $mongo->selectDB($this->config->item('mongo_db'));
        $gridFS = $db->getGridFS();

        $archive = $gridFS->findOne(array('code_validator' => $codeValidator, 'no_thumb' => true));

        header('Content-type: ' . $archive->file['type']);
        echo $archive->getBytes();
    }

}
