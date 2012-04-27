<?php

class Upload extends Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('UploadModel', 'uploadModel');
        $this->load->model('../../gerenciador/models/PessoaModel', 'pessoaModel');
    }

    function index() {
        $this->load->view('upload/uploadChoiceFileView');
    }

    function choiceFile($objectId, $objectName, $methodReturn, $allowed_types) {
        $data['objectId'] = $objectId;
        $data['objectName'] = $objectName;
        $data['methodReturn'] = $methodReturn;
        $data['allowed_types'] = $allowed_types;
        $this->load->view('upload/uploadChoiceFileView', $data);
    }

    function progress($progress_key) {
        $status = apc_fetch('upload_' . $progress_key);
        $this->ajax->addAjaxData('statusUpload', $status);
        $this->ajax->returnAjax();
    }

    function enviarArquivo() {
        $path = array_reverse(explode('/', $_SERVER['DOCUMENT_ROOT']));
        $pathArchive = $_SERVER['DOCUMENT_ROOT'] . ($path[1] != 'cobalto' ? '/cobalto' : '');

        $status = apc_fetch('upload_' . $_POST['APC_UPLOAD_PROGRESS']);
        $config['upload_path'] = '../archives/';
        if ($_POST['paramUploadAllowedTypes'] != '') {
            $config['allowed_types'] = $_POST['paramUploadAllowedTypes'];
        }
        $config['max_size'] = '500000';
        $config['max_width'] = '0';
        $config['max_height'] = '0';
        $config['encrypt_name'] = TRUE;
        $config['remove_spaces'] = TRUE;
        $this->load->library('upload', $config);

        $mongo = new Mongo('mongodb://' . $this->config->item('mongo_host'));
        $db = $mongo->selectDB($this->config->item('mongo_db'));
        $gridFS = $db->getGridFS();

        if (!$files = $this->upload->do_upload()) {
            $this->ajax->addAjaxData('success', false);
            $this->ajax->ajaxMessage('error', $this->upload->display_errors('', ''));
        } else {
            $totalArquivos = count($_FILES);
            $uploads = array();
            $this->load->library('image_lib');
            for ($i = 0; $i < $totalArquivos; $i++) {
                $upload = $this->uploadModel->inserir($this->upload->data());
                if (substr($upload->tipo, 0, 5) == 'image') {

                    $config['image_library'] = 'gd2';
                    $config['source_image'] = '../archives/' . $upload->nome_gerado;
                    $config['new_image'] = '../archives/thumbs_48x48/';
                    $config['create_thumb'] = TRUE;
                    $config['thumb_marker'] = '';
                    $config['maintain_ratio'] = TRUE;
                    $config['width'] = 48;
                    $config['height'] = 48;

                    $this->image_lib->initialize($config);
                    $this->image_lib->resize();

                    $storedfile = $gridFS->storeFile($pathArchive . 'archives/thumbs_48x48/' . $upload->nome_gerado, array('filename' => $upload->nome_gerado,
                        'filename_original' => $upload->nome_original,
                        'type' => $upload->tipo,
                        'thumb' => '48x48'));

                    unlink($pathArchive . 'archives/thumbs_48x48/' . $upload->nome_gerado);

                    $config['image_library'] = 'gd2';
                    $config['source_image'] = '../archives/' . $upload->nome_gerado;
                    $config['new_image'] = '../archives/thumbs_80x80/';
                    $config['create_thumb'] = TRUE;
                    $config['thumb_marker'] = '';
                    $config['maintain_ratio'] = TRUE;
                    $config['width'] = 80;
                    $config['height'] = 80;

                    $this->image_lib->initialize($config);
                    $this->image_lib->resize();

                    $storedfile = $gridFS->storeFile($pathArchive . 'archives/thumbs_80x80/' . $upload->nome_gerado, array('filename' => $upload->nome_gerado,
                        'filename_original' => $upload->nome_original,
                        'type' => $upload->tipo,
                        'thumb' => '80x80'));

                    unlink($pathArchive . 'archives/thumbs_80x80/' . $upload->nome_gerado);

                    $configResized['image_library'] = 'gd2';
                    $configResized['source_image'] = '../archives/' . $upload->nome_gerado;
                    $configResized['new_image'] = '../archives/resized_640x480/';
                    $configResized['create_thumb'] = TRUE;
                    $configResized['thumb_marker'] = '';
                    $configResized['maintain_ratio'] = TRUE;
                    $configResized['width'] = 640;
                    $configResized['height'] = 480;

                    $this->image_lib->initialize($configResized);
                    $this->image_lib->resize();

                    $storedfile = $gridFS->storeFile($pathArchive . 'archives/resized_640x480/' . $upload->nome_gerado, array('filename' => $upload->nome_gerado,
                        'filename_original' => $upload->nome_original,
                        'type' => $upload->tipo,
                        'thumb' => '640x480'));

                    unlink($_SERVER["DOCUMENT_ROOT"] . '/cobalto/archives/resized_640x480/' . $upload->nome_gerado);

                    $this->image_lib->clear();
                }
                array_push($uploads, $upload);
            }

            $storedfile = $gridFS->storeFile($pathArchive . 'archives/' . $upload->nome_gerado, array('filename' => $upload->nome_gerado,
                'filename_original' => $upload->nome_original,
                'type' => $upload->tipo,
                'no_thumb' => true));

            unlink($pathArchive . 'archives/' . $upload->nome_gerado);

            $status['done'] = 1;
            $this->ajax->addAjaxData('success', true);
            $this->ajax->addAjaxData('uploads', $uploads);
        }

        $this->ajax->addAjaxData('statusUpload', $status);
        $this->ajax->returnAjax();
    }

    function enviarImagemWebCam() {
        $path = array_reverse(explode('/', $_SERVER['DOCUMENT_ROOT']));
        $pathArchive = $_SERVER['DOCUMENT_ROOT'] . ($path[1] != 'cobalto' ? '/cobalto' : '');

        $config['max_size'] = '500000';
        $config['max_width'] = '0';
        $config['max_height'] = '0';
        $config['encrypt_name'] = TRUE;
        $config['remove_spaces'] = TRUE;

        $this->load->library('upload', $config);
        $this->load->library('image_lib');

        $mongo = new Mongo('mongodb://' . $this->config->item('mongo_host'));
        $db = $mongo->selectDB($this->config->item('mongo_db'));
        $gridFS = $db->getGridFS();

        $input = file_get_contents('php://input');
        $folder = '../archives/';
        $filename = md5($_SERVER['REMOTE_ADDR'] . rand()) . '.jpg';

        $original = $folder . $filename;
        $result = file_put_contents($original, $input);

        $image = array('file_name' => $filename, 'orig_name' => $filename, 'file_size' => round(filesize($original) / 1024, 2), 'file_type' => 'image/jpeg');

        $upload = $this->uploadModel->inserir($image);

        $config['image_library'] = 'gd2';
        $config['source_image'] = '../archives/' . $upload->nome_gerado;
        $config['new_image'] = '../archives/crop_3x4/';
        $config['width'] = 354;
        $config['x_axis'] = '100';
        $config['y_axis'] = '0';

        $this->image_lib->initialize($config);
        $this->image_lib->crop();

        $storedfile = $gridFS->storeFile($pathArchive . 'archives/crop_3x4/' . $upload->nome_gerado, array('filename' => $upload->nome_gerado,
            'filename_original' => $upload->nome_original,
            'type' => $upload->tipo,
            'thumb' => '3x4'));

        unlink($pathArchive . 'archives/crop_3x4/' . $upload->nome_gerado);

        $config['image_library'] = 'gd2';
        $config['source_image'] = '../archives/' . $upload->nome_gerado;
        $config['new_image'] = '../archives/thumbs_48x48/';
        $config['create_thumb'] = TRUE;
        $config['thumb_marker'] = '';
        $config['maintain_ratio'] = TRUE;
        $config['width'] = 48;
        $config['height'] = 48;

        $this->image_lib->initialize($config);
        $this->image_lib->resize();

        $storedfile = $gridFS->storeFile($pathArchive . 'archives/thumbs_48x48/' . $upload->nome_gerado, array('filename' => $upload->nome_gerado,
            'filename_original' => $upload->nome_original,
            'type' => $upload->tipo,
            'thumb' => '48x48'));

        unlink($pathArchive . 'archives/thumbs_48x48/' . $upload->nome_gerado);

        $config['image_library'] = 'gd2';
        $config['source_image'] = '../archives/' . $upload->nome_gerado;
        $config['new_image'] = '../archives/thumbs_80x80/';
        $config['create_thumb'] = TRUE;
        $config['thumb_marker'] = '';
        $config['maintain_ratio'] = TRUE;
        $config['width'] = 80;
        $config['height'] = 80;

        $this->image_lib->initialize($config);
        $this->image_lib->resize();

        $storedfile = $gridFS->storeFile($pathArchive . 'archives/thumbs_80x80/' . $upload->nome_gerado, array('filename' => $upload->nome_gerado,
            'filename_original' => $upload->nome_original,
            'type' => $upload->tipo,
            'thumb' => '80x80'));

        unlink($pathArchive . 'archives/thumbs_80x80/' . $upload->nome_gerado);

        $config['image_library'] = 'gd2';
        $config['source_image'] = '../archives/' . $upload->nome_gerado;
        $config['new_image'] = '../archives/thumbs_256x309/';
        $config['create_thumb'] = TRUE;
        $config['thumb_marker'] = '';
        $config['maintain_ratio'] = TRUE;
        $config['width'] = 256;
        $config['height'] = 309;

        $this->image_lib->initialize($config);
        $this->image_lib->resize();

        $storedfile = $gridFS->storeFile($pathArchive . 'archives/thumbs_256x309/' . $upload->nome_gerado, array('filename' => $upload->nome_gerado,
            'filename_original' => $upload->nome_original,
            'type' => $upload->tipo,
            'thumb' => '256x309'));

        unlink($pathArchive . 'archives/thumbs_256x309/' . $upload->nome_gerado);

        $config['image_library'] = 'gd2';
        $config['source_image'] = '../archives/' . $upload->nome_gerado;
        $config['new_image'] = '../archives/thumbs_354x472/';
        $config['create_thumb'] = TRUE;
        $config['thumb_marker'] = '';
        $config['maintain_ratio'] = TRUE;
        $config['width'] = 354;
        $config['height'] = 472;

        $this->image_lib->initialize($config);
        $this->image_lib->resize();

        $storedfile = $gridFS->storeFile($pathArchive . 'archives/thumbs_354x472/' . $upload->nome_gerado, array('filename' => $upload->nome_gerado,
            'filename_original' => $upload->nome_original,
            'type' => $upload->tipo,
            'thumb' => '354x472'));

        unlink($pathArchive . 'archives/thumbs_354x472/' . $upload->nome_gerado);

        $configResized['image_library'] = 'gd2';
        $configResized['source_image'] = '../archives/' . $upload->nome_gerado;
        $configResized['new_image'] = '../archives/resized_640x480/';
        $configResized['create_thumb'] = TRUE;
        $configResized['thumb_marker'] = '';
        $configResized['maintain_ratio'] = TRUE;
        $configResized['width'] = 640;
        $configResized['height'] = 480;

        $this->image_lib->initialize($configResized);
        $this->image_lib->resize();

        $storedfile = $gridFS->storeFile($pathArchive . 'archives/resized_640x480/' . $upload->nome_gerado, array('filename' => $upload->nome_gerado,
            'filename_original' => $upload->nome_original,
            'type' => $upload->tipo,
            'thumb' => '640x480'));

        unlink($pathArchive . 'archives/resized_640x480/' . $upload->nome_gerado);

        $this->image_lib->clear();

        $storedfile = $gridFS->storeFile($pathArchive . 'archives/' . $upload->nome_gerado, array('filename' => $upload->nome_gerado,
            'filename_original' => $upload->nome_original,
            'type' => $upload->tipo,
            'no_thumb' => true));

        unlink($pathArchive . 'archives/' . $upload->nome_gerado);

        $this->ajax->addAjaxData('upload', $upload);
        $this->ajax->addAjaxData('success', true);
        $this->ajax->returnAjax();
    }

}
