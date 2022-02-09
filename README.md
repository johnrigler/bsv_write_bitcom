This system allows you to write large arbitrary data files into the bitcoin.sv production or testnet ledgers. You will need to be running your own version of Satoshi Vision. To build this, I used:


https://github.com/bitcoin-sv/bitcoin-sv

I built on a Digital Oceans Droplet using the latest version of Ubuntu.

In order to keep older block files (and thus the entire ledger), I added s3fs buckets
and accessed those blk??????.dat files via a symbolic link.

The API must be running and accessible on port 8332 (1882 for testnet). All of these files can be dropped into a PHP-enabled Apache directory except the auth.php file should be put elsewhere so that it can be read online. I put mine in /var/www and link my lib.php file to it appropriately.


I will try to get this into a docker image so that it is easier to test out.

How to use:

From the index.php page, you should be able to upload a file from your computer. It will load it into staging and send it on its way with no further questions:

https://github.com/johnrigler/bsv_write_bitcom/blob/main/staging/smiley.png
smiley.png-rw-r--r-- 1 www-data www-data 1768 Feb 8 23:59 ../staging/smiley.png

Array
(
    [0] => 0
    [1] => OP_RETURN
    [2] => 31394878696756345179427633744870515663554551797131707a5a56646f417574
    [3] => --- potentially long data field removed ---
    [4] => 696d6167652f706e67
    [5] => 62696e617279
    [6] => 736d696c65792e706e67
)
stdClass Object
(
    [result] => 8b3fcd90a484d48a05417c4e2d56bbaa6bc76075122bc49f18a643a332979756
    [error] => 
    [id] => send
)


https://test.whatsonchain.com/tx/8b3fcd90a484d48a05417c4e2d56bbaa6bc76075122bc49f18a643a332979756
