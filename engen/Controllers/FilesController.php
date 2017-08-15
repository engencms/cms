<?php namespace Engen\Controllers;

class FilesController extends BaseController
{
    public function __construct()
    {
        $this->addBreadCrumb([
            'Files' => $this->router->getRoute('engen.files'),
        ]);
    }


    /**
     * Show files
     *
     * @return string
     */
    public function showFiles()
    {
        return $this->views->render("admin::files/list");
    }


    /**
     * Delete a file
     *
     * @return JsonEntity
     */
    public function deleteFile()
    {
        $response = $this->makeJsonEntity();

        $file  = $this->request->post('ref');
        $token = $this->request->post('token');

        if (!$this->csrf->validateToken($token, 'delete-file')) {
            return $response->setError('Invalid call. Update your page and try again.');
        }

        if (is_null($file) || $file == '') {
            return $response->setError('No files were selected');
        }

        $deleteCount = 0;

        if (is_array($file)) {
            foreach ($file as $f) {
                $result = $this->files->deleteFile($f);
                if ($result === true) {
                    $deleteCount++;
                }
            }
        } else {
            $result = $this->files->deleteFile($file);
            if ($result === true) {
                $deleteCount++;
            }
        }

        if (true !== $result) {
            return $response->setError($result);
        } else {
            $files = $deleteCount . ' ' . ($deleteCount == 1 ? 'file' : 'files');
            $this->session->setFlash('success', "Successfuly deleted {$files}");
        }

        return $response;
    }


    /**
     * Upload files
     *
     * @return JsonEntity
     */
    public function upload()
    {
        $response = $this->makeJsonEntity();
        $files    = $this->request->files('uploads');

        if (!$files) {
            return $response->setError('No files selected');
        }

        $count  = 0;
        $errors = [];
        foreach ($files as $file) {
            $msg = $this->files->upload($file);
            if ($msg !== true) {
                $errors[] = $file->getClientOriginalName() . " could not be uploaded. Reason: {$msg}";
            }
            $count++;
        }

        if ($count == count($errors)) {
            return $response->setErrors($errors);
        }

        if ($errors) {
            $this->session->setFlash('error', $errors);
        }

        $this->session->setFlash('success', 'Files uploaded!');


        return $response;
    }
}
