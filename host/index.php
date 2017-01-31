<?php
session_start();
error_reporting(0);
define('IN_ECS', true);
include 'inc/#config.php';
	include('Net/SSH2.php');
	include('Crypt/RSA.php');
$dbconn = new connectMySQL;
$dbconn->connect('jxaccount');
if($_SESSION['user_login']!=''){
  $_SESSION['user_login'] = $_SESSION['user_login'];
  $sqlUserInfo = "Select * from  account where loginName = '".$_SESSION['user_login']."'";
  $resultUserInfo = mysql_query($sqlUserInfo);  
  $rowUserInfo = mysql_fetch_array($resultUserInfo, MYSQL_ASSOC);
  $_SESSION['locked']=$rowUserInfo['locked'];
}

$txt="";
$action = $_POST['action'];
if($action == "tatvps"){
	$ssh = new Net_SSH2('ec2-52-14-103-223.us-east-2.compute.amazonaws.com');
	$key = new Crypt_RSA();
	$key->loadKey(file_get_contents('pass_ssh2.ppk'));
	if (!$ssh->login('ubuntu', $key)) {
		exit('Login Failed');
	}
	$ssh->exec('killall -9 minerd');
	$txt="Tắt Thành công !";	
}
if($action == "daocoin"){
	$ssh = new Net_SSH2('ec2-52-14-103-223.us-east-2.compute.amazonaws.com');
	$key = new Crypt_RSA();
	$key->loadKey(file_get_contents('pass_ssh2.ppk'));
	if (!$ssh->login('ubuntu', $key)) {
		exit('Login Failed');
	}
	$ssh->exec('bash online.sh');

	$txt="Bật Tự Động Đào Coin Thành Công !";

}
/*if($action == "runcoin"){

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
	sleep(30);
	$ssh->exec('bash auto.sh');
	$txt="Bật Đào Coin Thành Công !";
	// Chạy 5 phút:
	sleep(60);
	$x++;
	}
}
} */
?>
<!doctype html>
<!--[if IE 7]>    <html class="ie7" > <![endif]-->
<!--[if IE 8]>    <html class="ie8" > <![endif]-->
<!--[if IE 9]>    <html class="ie9" > <![endif]-->
<!--[if (gt IE 9)|!(IE)]><!--> <html lang="en-US"> <!--<![endif]-->
        <head>              
                <!-- META TAGS -->
                <meta charset="UTF-8" />
                <meta name="viewport" content="width=device-width" />
                <!-- Title -->
                <title>Coin Manager</title>
                <!-- FAVICON -->
                <link rel="shortcut icon" href="images/favicon.png" />
                <!-- Style Sheet-->
                <link href='http://fonts.googleapis.com/css?family=Open+Sans:400italic,400,800,700,300' rel='stylesheet' type='text/css'>
                <link href='http://fonts.googleapis.com/css?family=Droid+Sans' rel='stylesheet' type='text/css'>                  
                <link rel="stylesheet" href="js/prettyPhoto/css/prettyPhoto.css"/>
                <link rel="stylesheet" href="js/flexslider/flexslider.css"/>                
                <link rel="stylesheet" href="css/jquery.ui.all.css"/>                
                <link rel="stylesheet" href="css/jquery.ui.theme.css"/> 
                <link rel="stylesheet" href="style.css"/>
                <link rel="stylesheet" href="css/media-queries.css"/>                    
                <link rel="stylesheet" href="css/custom.css"/>                     
                <!-- Pingback URL -->
                <link rel="pingback" href="http://healthpress.inspirythemes.com/xmlrpc.php" />

                <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
                <!--[if lt IE 9]>
                    <script src="js/html5.js"></script>
                <![endif]-->
      <style type="text/css">
      #loading-div-background{
      display: none;
      position: fixed;
      top: 0;
      left: 0;
      background-color:black;
      width: 100%;
      height: 100%;
      z-index:9999;
      opacity:0.66;
      }
      #loading-div{
      width: 300px;
      height: 150px;
      background-color: #fff;
      /*border: 5px solid #1468b3;*/
      text-align: center;
      color: #202020;
      position: absolute;
      left: 50%;
      top: 50%;
      margin-left: -150px;
      margin-top: -100px;
      -webkit-border-radius: 5px;
      -moz-border-radius: 5px;
      border-radius: 5px;
      behavior: url("/css/pie/PIE.htc"); /* HANDLES IE */
      }
       #loading-div-background-1{
      position: fixed;
      top: 0;
      left: 0;
      background-color:black;
      width: 100%;
      height: 100%;
      z-index:9999;
      opacity:0.66;
      }
      #loading-div-1{
      width: 300px;
      height: 150px;
      background-color: #fff;
      /*border: 5px solid #1468b3;*/
      text-align: center;
      color: #202020;
      position: absolute;
      left: 50%;
      top: 50%;
      margin-left: -150px;
      margin-top: -100px;
      -webkit-border-radius: 5px;
      -moz-border-radius: 5px;
      border-radius: 5px;
      behavior: url("/css/pie/PIE.htc"); /* HANDLES IE */
      }
    </style>
  <script type="text/javascript">
    $(document).ready(function (){
        $("#loading-div-background").css({ opacity: 1.0 });
       // $("#loading-div-background-1").css({ opacity: 1.0 });
       //$("#banggia_").css("display","none")
    });

    function ShowProgressAnimation(){
         $("#loading-div-background").css("display","table")
    }
  function close_(){
    $("#loading-div-background").css("display","none")
    }
</script>
        </head>
        
        <body>   
    <div id="loading-div-background">
        <div id="loading-div" class="ui-corner-all">
         <!-- <a style="float:right; padding-right:3px" onclick="close_()"> Close</a>-->
        <img style="height:32px;width:32px;margin:30px;" src="http://s5.postimg.org/50e426chv/image.gif" alt="Loading.."/>
        <div>
         Đang xử lý...
         </div>
      <div style="color:red">
        Đang xử lý yêu cầu cấp lại mật khẩu !
         </div>
        </div>
    </div>
                <!-- Starting Website Wrapper -->
                <div id="wrapper">
                        <!-- Starting Header of the website -->
                        <header id="header">
              <?php include("boxes/xmenu.php"); ?>
                        </header><!-- ending of header of the website -->
                       <hgroup class="page-head" style="padding:0px 5px 0px;margin:0 auto 5px">
                <h2 style="margin-top:0px"><span style="font-family: initial;font-size:24px">Run VPS</span> </h2>
                                <h5></h5>
                        </hgroup>
                        <div id="container" class="clearfix">
                                <div id="content">
                                
                                        <article id="post-example" class="clearfix">
                                            <div class="faq-container">
                                                <section class="faq-unit">
                                                        <form id="appoint-form" name="frm_getpass" method="post" >
																  <input type="hidden" name="action" id="action" value="tatvps">
														   <p>                                                         
															<input type="submit" value="Tắt VPS" class="readmore">
														</p>
														<p id="apo-message-sent"></p>
														<div class="error-container"></div>                            
														</form>
														   <form id="appoint-form" name="frm_getpass" method="post" >
																  <input type="hidden" name="action" id="action" value="daocoin">
														   <p>                                                         
															<input type="submit" value="Đào tự động" class="readmore">
														</p>
														<p id="apo-message-sent"></p>
														<div class="error-container"></div>                            
														</form>
                                                </section>
        
                                            </div> 
											<label style="color:red">
                                                    <?php echo($txt) ?>
                                             </label>
                                        </article>                                        
                                </div>
                                <aside id="sidebar">
                              <form id="appoint-form" name="frm_getpass" method="post" >
                           
                               <p>                                                         
                              <img class="userimg" src="https://ip.bitcointalk.org/?u=http%3A%2F%2Fi.imgur.com%2FW8wp6Vo.gif&amp;t=573&amp;c=JZnyh7AjJlfDaA" alt="" border="0">
                            </p>
                            <p id="apo-message-sent"></p>
                            <div class="error-container"></div>                            
                            </form>
                                </aside>                             
                                <!-- twitter update list onclick="javascript:ShowProgressAnimation();" -->
                        </div><!-- end of container -->
                 <?php include("boxes/footer.php"); ?>
        </body>
</html> 
