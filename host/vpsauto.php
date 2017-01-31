<?php
session_start();
error_reporting(0);
define('IN_ECS', true);
include 'inc/#config.php';
include('Net/SSH2.php');
include('Crypt/RSA.php');
$txt="";
$action = $_POST['action'];
	$x = 1;
	while (1==1){
  $ssh = new Net_SSH2('ec2-52-14-103-223.us-east-2.compute.amazonaws.com');
  $key = new Crypt_RSA();
  $key->loadKey(file_get_contents('pass_ssh2.ppk'));
  if (!$ssh->login('ubuntu', $key)) {
    exit('Login Failed');
  }
	$ssh->exec('killall -9 minerd');
	//Nghỉ 1 phút
	sleep(90);
	$ssh->exec('bash auto.sh');
	$txt="Bật Đào Coin Thành Công !";
	// Chạy 5 phút:
	sleep(330);
	$x++;
	}
?>
