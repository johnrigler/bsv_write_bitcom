<!DOCTYPE html PUBLIC"-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<!-- Created by: Sivaram Penumarty [skpenuma] -->

<head>

<link rel='stylesheet' href="style.css"/>

<title>PHP File Upload</title>

</head>
<body>
<?php


$ch = curl_init();
include "lib.php";
include "/var/www/auth.php";

//$unspent = ledger_query($ch,"listunspent","unspent");
//printer($unspent);


$chain = "bitcoin.sv-testnet";

if($chain == "bitcoin.sv") $other = "bitcoin.sv-testnet";
if($chain == "bitcoin.sv-testnet") $other = "bitcoin.sv";

echo "<a href=add.php?chain=$other>Switch to $other</a>";


?>

<form method="POST" action="upload.php?chain=<?= $chain ?>" enctype="multipart/form-data">
    <div class="upload-wrapper">
    <span class="file-name">Write a file into the <?= $chain ?> blockchain.</span>
      <label for="file-upload">Browse for file on your device.<input type="file" id="file-upload" name="uploadedFile"></label>
<br>
    </div>
    <input type="submit" name="uploadBtn" value="Upload" />
  </form>
<br>

<?php


history_query_api($chain);
exit;


$result = ledger_query($ch,"listunspent","unspent");
$txid = ($result->result[0]->txid);

//	$result = ledger_query($ch,"getrawtransaction","grt"," \"$txid\", 1 ");
//		printer($result);

		for($x = 0 ; $x < 80; $x++)
		{
		echo "<br><a href=read.php?chain=$chain&txid=$txid>$txid</a>";
		$result = ledger_query($ch,"getrawtransaction","grt","\"$txid\", 1");
		$last = $result->result->vin[0]->txid;

//		printer($result);
		$txid = $last;
		if($txid == "37443099b34a6e10c03bd70a5419526dc7feb459358fd54ebecaa8370209e4c6")break;
//		printer(ledger_query($ch,"getblock","block","\"$blockhash\""));
//		echo "<hr>" . $result->result->blockhash . "<hr>";
//		break;
//
		//
		}

$unspent = ledger_query($ch,"listunspent","unspent");

printer($unspent);

exit;


$status = ledger_query($ch,"getblockchaininfo","info");

printer($status);

$balance = ledger_query($ch,"getbalance","balance");
printer($balance);
echo "<hr>Balance: $balance->result<hr>";
if($chain == "bitcoin.sv-testnet")
{
	echo "<hr>Get more testnet currency: <a href=https://faucet.bitcoincloud.net/>faucet</a> mpeKUaNb7WRPoepnAGN4jNdLS7uuPrw2WU";
	echo "<hr>View testnet account remotely: <a href=https://test.whatsonchain.com/address/mpeKUaNb7WRPoepnAGN4jNdLS7uuPrw2WU>woc</a>";
}

$history = explode("\n",file_get_contents("/var/www/html/tosend/" . $chain . ".txids"));


array_pop($history);

foreach(array_reverse($history) as $txid)
{
	echo "<hr><a href=read.php?chain=$chain&txid=$txid>$txid</a>";
	echo "$txid";
}

?>

</body>
</html>
