<?php

require_once ('path.inc');
require_once ('get_host_info.inc');
require_once ('rabbitMQLib.inc');

function phpErrorThrow($errorLev, $errorMsg, $errorFile, $errorLine, $errorContext)
{
        $eClient = new rabbitMQClient("testRabbitMQ.ini","errorServer");
        $request3= array();
        $eDate = time();
        $msg = " [$errorLev]".$errorMsg.$errorFile.$errorLine.$errorContext;
        $request3['type']= "error";
        $request3['date'] = $eDate;
        $request3['msg'] =$msg;
        $eClient->send_request($request3);
}

error_reporting(E_ALL);
ini_set("display_errors",0);
set_error_handler("phpErrorThrow");

