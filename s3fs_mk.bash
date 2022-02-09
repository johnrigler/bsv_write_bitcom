    s3fs bitcoin-sv /root/s3 -o passwd_file=${HOME}/.passwd-s3fs -o url=https://nyc3.digitaloceanspaces.com/ -o use_path_request_style;
    s3fs bitcoin-sv-a /root/s3a -o passwd_file=${HOME}/.passwd-s3fs -o url=https://nyc3.digitaloceanspaces.com/ -o use_path_request_style;
    s3fs bitcoin-sv-b /root/s3b -o passwd_file=${HOME}/.passwd-s3fs -o url=https://nyc3.digitaloceanspaces.com/ -o use_path_request_style
