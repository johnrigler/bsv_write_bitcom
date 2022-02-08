This system allows you to write large arbitrary data files into the bitcoin.sv production or testnet ledgers. You will need to be running your own version of Satoshi Vision. To build this, I used:


https://github.com/bitcoin-sv/bitcoin-sv

I built on a Digital Oceans Droplet using the latest version of Ubuntu.

In order to keep older block files (and thus the entire ledger), I added s3fs buckets
and accessed those blk??????.dat files via a symbolic link.

The API must be running and accessible on port 8332 (1882 for testnet). All of these files can be dropped into a PHP-enabled Apache directory except the auth.php file should be put elsewhere so that it can be read online. I put mine in /var/www and link my lib.php file to it appropriately.


I will try to get this into a docker image so that it is easier to test out.

How to use:

From the index.php page, you should be able to upload a file from your computer. T
