<?php

namespace common\services;


use PhpOffice\PhpWord\Exception\CopyFileException;
use PhpOffice\PhpWord\Exception\CreateTemporaryFileException;
use PhpOffice\PhpWord\TemplateProcessor;
use Yii;

class DocumentService
{
    private $file_title;
    private $document;
    private $template_title;
    private [] $fields;


    /**
     * @throws CopyFileException
     * @throws CreateTemporaryFileException
     */
    public function __construct($file_title, $template_name, [] $fields)
    {
        $this->file_title = $file_title . 'docx';
        $this->document = new TemplateProcessor(Yii::getAlias('@templates') . "/$template_name");
    }

    public function setFields($fields )
    {
        foreach ($fields as $field) {
            $this->document->setValue('FIO', '8888888888' );
        }
    }

    public function save()
    {
        $this->document->saveAs($this->file_title);
    }

    public function creat3e()
    {}
}