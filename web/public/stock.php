<?php

// Copuright (c) 2014, Tolga Kilicli                   
// Simple Slack Integration example for slash commands 

$input = file_get_contents('php://input');
$lines = explode("&", $input);
$security_token = "YOUR_TOKEN";
$token = "";
$command = "";
$text = "";
$channel_name = "";
$user_name = "";
$response="";

// php version of .Net's string.Contains()
// $word: What you're looking for in $str
// $str: string

function contains ($word, $str){
	if (strpos($str, $word) !== false) 
    	return true;
	else 
		return false;
}

// Generate response to be sent to Slack
// $ticker: code of the stock

function generate_response($ticker){
	$stock_json = file_get_contents('https://query.yahooapis.com/v1/public/yql?q=select%20*%20from%20yahoo.finance.quote%20where%20symbol%20in%20(%22'.$ticker.'%22)&format=json&diagnostics=true&env=store%3A%2F%2Fdatatables.org%2Falltableswithkeys&callback=');
	$stock = json_decode($stock_json);

	$symbol = $stock->query->results->quote->symbol;
	$price = $stock->query->results->quote->LastTradePriceOnly;
	$change = $stock->query->results->quote->Change;
	$name = $stock->query->results->quote->Name;
		
	if (isset($change)) {
		$str = "*<http://www.bing.com/search?q=".$symbol."|".$name.">*: $". $price." _(change ".$change.")_\r\n";
		return $str;
	} else 
		return "";
}

// parse incoming data sent from Slack
foreach ($lines as $line) {
	$keyvalue=explode("=", $line);
	$key=$keyvalue[0];
	$value=$keyvalue[1];
	switch ($key){
		case "token": $token = $value; break;
		case "command": $command = urldecode($value); break;
		case "text": $text = trim(urldecode($value));  break;
		case "channel_name": $channel_name=$value; break;
		case "user_name": $user_name=$value; break;
	}
}

// incoming data needs to be validated wit token and only responsd to command /stock
if (($token == $security_token) &&
	($command == "/stock")) {
	$tickers = preg_split("/[\s,]+/", $text); // preg_split is used to split/tokenize parameters with " " or ","
	foreach ($tickers as $ticker) 
		$response = $response.generate_response($ticker);
	
	echo $response;
}

?>
