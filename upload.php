<pre>
<?php

// list($currency,$address) = explode(":",$_GET[address]);
echo "<h1> /var/www/html/src/upload.php </h1>";

include "lib.php";
include "menu.php";
$target = "/var/www/html/staging";
$chain = $_GET[chain];

printer($_REQUEST);

list($url,$user) = explode("~",$_SERVER['HTTP_REFERER']);

echo "$url $user";

$user=rtrim($user,"/");
//file_put_contents("/home/$user/public_html/cache/$file",$image);

printer($_FILES);
printer($_REQUEST);

$file = str_replace(" ","_",$_FILES[uploadedFile][name]);
$file = str_lreplace(".","~",$file);
$file = str_replace(".","-",$file);
$file = str_lreplace("~",".",$file);
$image = file_get_contents($_FILES[uploadedFile][tmp_name]);
echo "$target/$file";
file_put_contents("$target/$file",$image);
list($left,$right) = explode(".",$file);
if($right === "m4a")
{

	$target = $left . ".mp3";

	echo `cd ../staging; ffmpeg -i $file $left.mp3`;
       $file = $target;

}
$next="create.php?file=$file&chain=$chain";
echo "<meta http-equiv='refresh' content='0; url=$next'>";

?>
