<?php

namespace AppBundle\Service;

use AppBundle\Entity\CodeSettings;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class CodeGenerator
{
    private $validator;
    private $codeSettings;
    private $fileName = null;

    public function __construct(ValidatorInterface $validator)
    {
        $this->validator = $validator;
    }

    public function setFileName($filename) {
        $this->fileName = $filename;
    }

    public function setParameters($codeSettings) {
        $this->codeSettings = $codeSettings;
        $errors = $this->validator->validate($this->codeSettings);

        if (count($errors) > 0) {
            throw new Exception("Invalid parameters");
        }

    }

    public function generateCodes() {
        if ($this->fileName) {
            $file = fopen($this->fileName, "w");
        }
        else {
            $this->fileName = uniqid("code").'.txt';
            $file = fopen('codes/'.$this->fileName, "w");
        }

        $len = $this->codeSettings->length;
        $numberOfCodes = $this->codeSettings->numberOfCodes;
        $chars = "0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnoprstuvwxyz";
        $charsLen = strlen($chars) - 1;
        $code = "";

        for ($i = 0; $i < $numberOfCodes; ++$i) {

            for ($j = 0; $j < $len; ++$j) {
                $code .= $chars[mt_rand(0, $charsLen)];
            }

            fwrite($file, $code."\n");
            $code = "";
        }

        fclose($file);
        return $this->fileName;
    }

}