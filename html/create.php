<?php

$ch = curl_init(); 
include "lib.php";
include "/var/www/auth.php";

$unspent = ledger_query($ch,"listunspent","unspent");
//printer($unspent);

$vin['txid'] = $unspent->result[0]->txid;
$vin['vout'] = $unspent->result[0]->vout;
$vin = "[ " . json_encode($vin) . " ]";
echo $file;
$filepath = "../staging/" . $file;
echo `ls -l ../staging/$file`;

//$file = "./deadbeef";
//$filepath = $file;

function bsv_create($filepath,$funds) { 

	global $ch;
	global $vin;
	global $op;
	global $ftype;
	global $name;
	global $file;
	global $chain;

	$op_return_code_1="2231394878696756345179427633744870515663554551797131707a5a56646f417574";

	$opFtype = $op[$ftype];

//	printer($op);
//	echo "<hr>$opFtype<hr>";

$segment =  $op_return_code_1 . add_size($ch,$vin, bin2hex(file_get_contents($filepath))) . $opFtype . add_size($ch,$vin, str2hex($file));
//$segment = $op_return_code_1; 
$segment2 = substr($segment,0, strlen(find_size($ch,$vin,$segment)) * -1);

if($chain == 'bitcoin.sv') $bitcoin_address = "1FgJok3sLLbP4hmiCtURKLkARKt49W98JA";
if($chain == 'bitcoin.sv-testnet') $bitcoin_address = "mpeKUaNb7WRPoepnAGN4jNdLS7uuPrw2WU";


//$data3 = " $vin ,  { \"mpeKUaNb7WRPoepnAGN4jNdLS7uuPrw2WU\":$funds,\"data\":\"$segment2\" } ";
$data3 = " $vin ,  { \"$bitcoin_address\":$funds,\"data\":\"$segment2\" } ";

//echo "<hr>$data3<hr>";
$created = ledger_query($ch,"createrawtransaction","bsv_create crt",$data3);
 printer($created);
$exploded = explode("006a",$created->result);
return $exploded[0] . "006a" . $segment . "00000000";
}


//$deadbeef = "deadbeefcafe";
//echo find_size($ch,$vin,$deadbeef);
//exit;
$funded_ = bsv_create($filepath,"0.0001");
//echo $final;
$funded = ledger_query($ch,"fundrawtransaction","funded","\"$funded_\"");
//printer($funded);
$payment = $unspent->result[0]->amount;
$fee = $funded->result->fee;
$change = $payment - $fee;
//$fee = "0.00984174";
$changePos = $funded->result->changepos;
//echo "<hr>$payment $fee $changePos<hr>";
$noChangeFunded = bsv_create($filepath,$change);
//printer($noChangeFunded);

$frh = $noChangeFunded;
$funded2 = ledger_query($ch,"decoderawtransaction","decfund","\"$frh\"");


//printer($funded2);
$tosign = $funded2->result->hex;
$signed = ledger_query($ch,"signrawtransaction","signed","\"$tosign\"");
$tosend = $signed->result->hex;
$toshow = (explode(" ",$funded2->result->vout[1]->scriptPubKey->asm));
$toshow[3] = "--- potentially long data field removed ---";
printer($toshow);

$sent = ledger_query($ch,"sendrawtransaction","send","\"$tosend\"");

printer($sent);
$txid = $sent->result;
$next = "/src/read.php?chain=$chain&txid=$txid";
//`echo $txid >> /var/www/html/signed/bitcoinsv-testnet.txids`;
// echo "<meta http-equiv='refresh' content='0; url=$next'>";


?>
