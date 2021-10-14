<?php

namespace Modules\User\Serveices\SmsServeice;


interface smsInterface
{
public  function send ($phone  ,$message );

public  function  getBalance();
}
