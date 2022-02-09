<?php
/*
define('OP_FALSE',        '00');
define('OP_RETURN',       '6a');
define('OP_2DUP',         '6e');
define('OP_DUP',          '76');
define('OP_EQUALVERIFY',  '88');
define('OP_HASH160',      'a9');
define('OP_CHECKSIG',     'ac');
 */
//include "/var/www/auth.php";
//

global $chain;

$op = array();
$op['png']= "09696d6167652f706e670662696e617279";
$op['jpeg']="0a696d6167652f6a7065670662696e617279";
$op['jpg']= "0a696d6167652f6a7065670662696e617279";
$op['mp3']= "09617564696f2f6d70330662696e617279";
$op['mp4']= "09696d6167652f6d70340662696e617279";
//$eth = "0xaE0953974011737b5397D5B619305c83D98B9377";


//$sizes = ["4c"=>"4","4d"=>"5","4e"=>"7","4f"=>"33"];

$str = "";

function printer($array,$style = "")
{
	if($style === ""){
	echo "<pre>";
	print_r($array);
	echo "</pre>";
	}
	if($style === "json_encode")
		echo json_encode($array);
	if($style === "json")
	{
		$all = count($array);
		$array2 = array();
		foreach($array as $count => $element)
		{
			$array2[$count]["txid"]=$element;
		}
		foreach($array2 as $index => $element){

			print_r($element);
		}
		// echo json_encode($array2);
		}

}
/*
function linker($url,$desc) {
	return "<a href=$url target='$desc'>$desc</a>";
}

function raw($txfile) {
	return linker("$txfile","[raw]");
}

function grt($txid) {
	return linker("src/getrawtransaction.php?txid=$txid","[grt]");
}
 */

function hex2str($hex) {
	$str = "";
    for($i=0;$i<strlen($hex);$i+=2)
       $str .= chr(hexdec(substr($hex,$i,2)));

    return $str;
}

function str2hex($string){
    $hex='';
    for ($i=0; $i < strlen($string); $i++){
        $hex .= dechex(ord($string[$i]));
    }
    return $hex;
}
/*
function get_tiny_url($url)
{

        $ch = curl_init();
        $timeout = 5;
        curl_setopt($ch,CURLOPT_URL,'http://tinyurl.com/api-create.php?url='.$url);
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
        curl_setopt($ch,CURLOPT_CONNECTTIMEOUT,$timeout);
        $data = curl_exec($ch);
        curl_close($ch);
        return $data;
}
 */
function str_lreplace($search, $replace, $subject)
{
    $pos = strrpos($subject, $search);

    if($pos !== false)
    {
        $subject = substr_replace($subject, $replace, $pos, strlen($search));
    }

    return $subject;
}
/*
function unspendable($first,$rest="") 
{
	return `python3 /opt/alp/QmZEF7LGBicfaNgtoJyT2uo11YX7L6SYdKMYA1tAMH6pfc $first "$rest"`;
}


function get_size_($string,$add=0) {

//      echo "$string<br>";
        $size = 0;
        $new_size = "";
        $op_return = strpos($string,"006a");
        $size_class = $string[$op_return+4] . $string[$op_return+5];
        echo "xxxxxx $size_class xxxxxx";
        return $size_class;

}

function history_query_api( $chain )
{
$history = curl_init();

curl_setopt($history, CURLOPT_URL, 'https://secretbeachsolutions.com/api/list.php?chain=' . $chain);
curl_setopt($history, CURLOPT_RETURNTRANSFER, 1);

$result = curl_exec($history);
if (curl_errno($history)) {
    echo 'Error:' . curl_error($history);
}

curl_close($history);

$display = json_decode($result);

foreach($display as $val)
    foreach($val as $id => $name)
	echo "<br>$id $name";

}

function retrieve_payload_api( $chain )
{
$history = curl_init();

curl_setopt($history, CURLOPT_URL, 'https://secretbeachsolutions.com/api/list.php?chain=' . $chain);
curl_setopt($history, CURLOPT_RETURNTRANSFER, 1);

$result = curl_exec($history);
if (curl_errno($history)) {
    echo 'Error:' . curl_error($history);
}

curl_close($history);

$display = json_decode($result);

foreach($display as $val)
	foreach($val as $id => $name)
	{
		list($blockheight,$hash,$vout,$op_return_pos) = explode("-",$id);
		$dir = "/var/www/html/$chain/" . substr($blockheight,0,-3);
		mkdir($dir);
		$target = "$dir/$id";
		echo "<br>$dir/$id";
		file_put_contents($target,$payload);
	}

}
 */

function ledger_query( $ch, $cmd, $id, $data="" ) {

curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_POST, 1);

if($data == "")
{     
	//	curl_setopt($ch, CURLOPT_POSTFIELDS,'{"jsonrpc":"1.0","id":"'. $id . '","method":"' . $cmd . '" }');
	$toeval = '{"jsonrpc":"1.0","id":"'. $id . '","method":"' . $cmd . '" }';
//	printer(json_decode($toeval));
	curl_setopt($ch, CURLOPT_POSTFIELDS, $toeval);
}
else
{       
	$toeval = '{"jsonrpc": "1.0", "id":"' . $id . '", "method":"' . $cmd . '" , "params": [' . $data . ']  }';
//        printer(json_decode($toeval));
        curl_setopt($ch, CURLOPT_POSTFIELDS, $toeval);
}

if( ! $result = curl_exec($ch))
    {
        throw new Exception(curl_error($ch));
}
//echo $result;
return json_decode($result);
}
/*
function decode_raw_transaction( $ch,&$data) {

	echo "decode_raw_transaction\n";
	echo "$data\n";
}
 */
function find_size( $ch,$vin,&$data )
{
        // This returns the length of the OP_RETURN size component
        // for a set of data. Find the length of your final combined
        // dataset and then remove this number of characters 
        //
        $data2 = " $vin ,  { \"data\":\"$data\" } ";
	$created = ledger_query($ch,"createrawtransaction","find_size crt",$data2);
//	printer($created);
        unset($data2);
        $temp = $created->result;
        unset($created);
        $decoded = ledger_query($ch,"decoderawtransaction","find_size decode","\"$temp\"" );
	unset($temp);
	$value = substr($decoded->result->vout[0]->scriptPubKey->hex,4);

//	printer($decoded);
		
	if(strlen($data) < 12)
		$match = $data;
	else
	{
		$match = substr($data,0,12);

	}

	$exploded = explode($match,$value);
	return $exploded[0];

}

function add_size( $ch,$vin,&$data )
{
	// This returns a segment with its size added to the beginning
	//
	//
	$data2 = " $vin ,  { \"data\":\"$data\" } ";
	$created = ledger_query($ch,"createrawtransaction","add_size create",$data2);
	unset($data2);
	$temp = $created->result;
	unset($created);
	$decoded = ledger_query($ch,"decoderawtransaction","add_size decode","\"$temp\"" );
	unset($temp);
	return substr($decoded->result->vout[0]->scriptPubKey->hex,4);

}

function decode_bitcom_b( $txid,$height,&$final )
{

	global $chain;

                        echo "BITCOM-B";
                        $target = $final[3];
			if(isset($final[4]))
			{ 
				 echo "<br>" . $final[4];
					$render=render_type($final[4]); 
					echo "<hr>render=$render<hr>";
			}

                       if(isset($final[5]))
                                {
                                        $adv2=hex2str($final[5]);
                                        echo "<hr>adv2=$adv2<hr>";
                        }

                       if(isset($final[6]))
                                {
                                        $name=hex2str($final[6]);
                                        echo "<hr>name=$name<hr>";
                        }


                if($render == NULL ) {
                        // Try to discover type
                 echo "<br>";
                 $filetype=`file /var/www/html/$chain/$txid `;
                 $temp = explode(":",$filetype);
           //      printer($temp);
                 $type="'" . rtrim($temp[1]) . "'";
                 echo $type;
                 if(substr($temp[2],0,4) == "MPEG")$render = "audio";
                 if($type == ' ISO Media, MP4 v2 [ISO 14496-14]')$render = "mp4";
//               if($type == ' Audio file with ID3 version 2.4.0, contains')$render = "audio";
                }

                      $outfile = "/var/www/html/" . $chain . "/$height-$txid";
                        file_put_contents($outfile,hex2str($final[3]));
                        $outfile = "../" . substr($outfile,14);
			//      echo "<br><img src=$outfile>";
			//
			//
			
               if($render === "image")
                        echo "<img src=/$outfile>";

               if($render === "audio")
                        echo "<br><a href=$outfile>Click here to listen to audio file...</a>";






                }  

function render_type($advtype) {

	                     switch (hex2str($advtype)) {
                                case "image/png":
                                return "image";
                                break;
                                case "image/jpeg":
                                return "image";
                                break;
                                case "image/mp3":
                                return "audio";
                                case "audio/mp3":
                                return "audio";
                                break;
                                case "image/mp4":
                                return "av";
				break;
			     } 

			     return NULL;


}

function decode_metanet( $txid,$height,&$final )
{

               {
                        echo "<hr>Maybe metanet 1635018093";
                        foreach($final as $id=>$field)
                        {
                                if($id == 7)continue;
                                if(strlen($field) < 10000)
                                        echo "<br>" . hex2str($field);
                                else
                                        echo "<br>very long field";
                        }
                       $outfile = "/var/www/html/" . $chain . "/$height-$txid";
                        file_put_contents($outfile,hex2str($final[7]));
                        $outfile = "../" . substr($outfile,14);
                        echo "<br><img src=$outfile>";

                }



}


global $file;
global $name;
global $ftype;
global $type;
global $fee;
global $grt; 
global $satoshi;
global $version;
global $message;

global $ipfs;

//$version = "src3";
//$grt = "$version/getrawtransaction.php";

if(isset($argv[1])) { $chain = $argv[1]; $format = "text"; }
if(isset($argv[2])) { $txid = $argv[2]; $format = "text"; }
if(isset($argv[3])) { $address = $argv[3]; } 


if(isset($_GET['file'])) { $file = $_GET['file']; $format = "html"; }
else
	if(isset($argv[2]))
	      $file = $argv[2];
if(isset($_GET['txid'])) { $txid = $_GET['txid']; $format = "html"; }
if(isset($_GET['fee'])) { $fee = $_GET['fee']; $format = "html"; }
if(isset($_GET['chain'])) { $chain = $_GET['chain']; }

if(isset($_REQUEST['satoshi'])) { $satoshi = $_REQUEST['satoshi']; }
if(isset($_REQUEST['message'])) { $message = $_REQUEST['message']; }
if(isset($_REQUEST['range'])) { $range = $_REQUEST['range']; }
if(isset($_GET['code'])) { $code = $_GET['code']; $format = "html"; }
if(isset($_GET['ipfs'])) { $ipfs = $_GET['ipfs']; }

if(isset($file))
list($name,$ftype) = explode(".",$file);

//$type = $enc_type[strtolower($ftype)];

if(isset($argv[2])) { $string = $argv[2]; $format = "text"; }
if(isset($_GET['string'])) { $string = $_GET['string']; $format = "html"; }

if(isset($argv[3])) { $body = $argv[3]; $format = "text"; }
if(isset($_GET['body'])) { $body = $_GET['body']; $format = "html"; }

$char_count = "";

curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_POST, 1);

//$eval_begin = '{ "jsonrpc":"1.0" , "id":"mempool" , "method":"';
//$eval_single_end = '" }';
//$eval_double_end = ' }';


$headers = array();
$headers[] = 'Content-Type: text/plain;';
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

