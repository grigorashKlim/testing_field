<?php

class ErrorLogger
{
    public $error_name=2;
    public $error_message='';

    public function addError($error)
    {
        $this->error_message.=$error."</br>";
    }

    public function displayError()
    {
       print_r($this->error_message)  ;
    }
}
/*<?php
$error_log=New ErrorLogger();
$error_log->addError('все пропало');
$error_log->addError('мы все умрем');
$error_log->addError('бегите,глупцы');
$error_log->displayError();
*/?>