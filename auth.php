<?php 

/*  Move this file to /var/www/auth.php */ 
/*  Set the correct encryption keys. */
/*  I will try to find the tool I used */
/* to create the key            */

/* For this to work, you have to have a local copy of the bitcoin.sv ledger running */


global $chain;

if(strcmp($chain,"bitcoin.sv-testnet") == 0)
{
	curl_setopt($ch, CURLOPT_USERPWD, 'bitcoinsv' . ':' . 'Add_Encrypted_Prod_Key_Here_zzzzzzzzzzzzzzz='); 
	curl_setopt($ch, CURLOPT_URL, 'http://127.0.0.1:18332/');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_POST, 1);

}

if($chain == "bitcoin.sv")
{
        curl_setopt($ch, CURLOPT_USERPWD, 'bitcoinsv' . ':' . 'Add_Encrypted_Dev_Key_Here_zzzzzzzzzzzzzzzz='); 
        curl_setopt($ch, CURLOPT_URL, 'http://127.0.0.1:8332/');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);

}

?>
