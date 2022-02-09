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

</body>
</html>
