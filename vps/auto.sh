#!/bin/bash
echo "Tat dao coin"
killall -9 minerd
sleep 1
cd cpuminer-multi  &&
./autogen.sh &&
CFLAGS="-march=native" ./configure &&
make &&
screen -D -m -c minerd ./minerd -a cryptonight --url=stratum+tcp://xmr.pool.minergate.com:45560 -u pikachu281@gmail.com -p x
cpulimit -e minerd -l 65
