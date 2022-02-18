#!/bin/bash
version="6.5.3"
[ ! -d www/Lib ] && mkdir www/Lib
wget https://github.com/PHPMailer/PHPMailer/archive/refs/tags/v${version}.tar.gz
tar xfvz v${version}.tar.gz -C www/Lib/
rm v${version}.tar.gz
mv www/Lib/PHPMailer-${version} www/Lib/PHPMailer
