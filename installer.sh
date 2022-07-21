#!/bin/bash
phpMailerVersion="6.6.3"
[ ! -d www/Lib ] && mkdir www/Lib

function helpFunc() {
    echo "Usage : $0 <option>

Option :
-h or --help ................................. Show help
phpMailer .................................... Install phpMailer"
    exit 0
}

function installPhpMailer() {
    wget https://github.com/PHPMailer/PHPMailer/archive/refs/tags/v${phpMailerVersion}.tar.gz
    tar xfvz v${phpMailerVersion}.tar.gz -C www/Lib/
    rm v${phpMailerVersion}.tar.gz
    mv www/Lib/PHPMailer-${phpMailerVersion} www/Lib/PHPMailer
}

[ $# -lt 1 ] && echo "Need parameter (use --help)" && exit 1

for i in $(seq 1 $#); do
    case $1 in
        -h | --help)
            helpFunc;;
        phpMailer)
            installPhpMailer
            exit 0;;
        "")
            ;;
        *)
            echo "Unknown parameter \"$1\""
            exit 1
    esac
    shift
done
