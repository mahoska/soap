<?php
$client = new 
    SoapClient("https://www.cbr.ru/dailyinfowebserv/dailyinfo.asmx?wsdl");
try{
    date_default_timezone_set('Europe/Kiev');
    $param["On_date"]= date("Y-m-d");
    $res = $client->GetCursOnDate($param)->GetCursOnDateResult->any;
    $data = new SimpleXMLElement($res);
    $valutes = $data->ValuteData->ValuteCursOnDate;

    include("valutes.html");
}catch(SoapFault $exception){
    echo $exception;
}





