<?php
$dateTime = $_POST['data'];
$soapUrl = "https://www.cbr.ru/DailyInfoWebServ/DailyInfo.asmx?WSDL";
$xml_post_string = '<?xml version="1.0" encoding="utf-8"?>
    <soap12:Envelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
                     xmlns:xsd="http://www.w3.org/2001/XMLSchema" 
                    xmlns:soap12="http://www.w3.org/2003/05/soap-envelope">
        <soap12:Body>
          <GetCursOnDate xmlns="http://web.cbr.ru/">
                <On_date>'.$dateTime.'</On_date>
         </GetCursOnDate>
        </soap12:Body>
    </soap12:Envelope>';


$headers = array(
    "POST /DailyInfoWebServ/DailyInfo.asmx HTTP/1.1",
    "Host: www.cbr.ru",
    "Content-Type: application/soap+xml; charset=utf-8",
    "Content-Length:".strlen($xml_post_string));

$url = $soapUrl;

// PHP cURL  for https connection with auth
 $ch = curl_init();
 curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 1);
 curl_setopt($ch, CURLOPT_URL, $url);
 curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
 curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
 curl_setopt($ch, CURLOPT_TIMEOUT, 10);
 curl_setopt($ch, CURLOPT_POST, true);
 curl_setopt($ch, CURLOPT_POSTFIELDS, $xml_post_string); // the SOAP request
 curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
//
//converting
 $response = curl_exec($ch); curl_close($ch);
// converting
 $response1 = str_replace("<soap:Body>","",$response);      
 $response2 = str_replace("</soap:Body>","",$response1); 
//var_dump ($response2); 
// convertingc to XML
$response3=str_replace('diffgr:','',$response2);
 $parser =simplexml_load_string($response3);
 if (!$parser) {
         echo "Error download XML\n";
             foreach(libxml_get_errors() as $error) {
                         echo "\t", $error->message;
                             }
 }
 //echo"<pre>";
 //var_dump($parser);
 //echo"<pre>";
 // user $parser to get your data out of XML response and to display it.
    //print_r($parser);
     $valutes = $parser->GetCursOnDateResponse->GetCursOnDateResult->diffgram->ValuteData->ValuteCursOnDate;
 //var_dump($valutes);
 include("valutes.html");
