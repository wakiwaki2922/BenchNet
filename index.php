<?
////////////////////////////////////////
///// APP SETTINGS ///////////////////////////////////
////////////////////////////////////////





$language = "EN"; // available in "EN", "IT", "ES", "DE", "RU", "FR"
$progress_bar = "2"; // ["1"=simple text on right top corner]  ["2"=progress bar in middle with percentage]  ["3"=simple progress bar in middle]
$folder = "speed12/"; //leave empty if used in root
$cookie_position = "bottom"; // set position of cookie agreement. Set "top" or "bottom"

$upload_server = "google.com"; // set server to check upload speed
$ping_server = "google.com"; // set server to check ping
$file = "file.NEF"; // file name which we are loading. We recommend to dont change
$download_server_file = "http://".$_SERVER['HTTP_HOST']."/".$folder.$file;
//echo $download_server_file;

////////////////////////////////////////
///// GEOIP SERVICE SETTINGS ///////////////////////////////////
////////////////////////////////////////

$use_geoip_service = "1"; // If you want to disable this service, just set "0". Used free version limited on 2500 queries per day
$api_key = "5b9d4d13b0a29d88083dcbbd38c1829c39207ab2"; // db-ip.com service api key. Obtain your key on https://db-ip.com/api/free by inserting your e-mail adress

////////////////////////////////////////
///// DO NOT TOUCH ///////////////////////////////////
////////////////////////////////////////

//file with all php functions
include_once "functions.php";
include_once "languages/".$language.".php";

if($use_geoip_service == "1"){
include_once "dbip-client.class.php";
}
?>

<html lang="<?=lang_hotkey;?>">
<head>
<title><?=app_name;?> 1.2 # CodeCanyon</title>
<meta name="viewport" content="width=device-width; initial-scale=1.0" />
<link href="css/loading.css?<?=date("s")?>" rel="stylesheet">
<link href="css/bootstrap.min.css" rel="stylesheet">
<link href="css/bootstrap-theme.min.css" rel="stylesheet">
<link href="css/pace<?=$progress_bar?>.css?<?=date("s")?>" rel="stylesheet">

<? if(isset($_POST['start'])){ ?>
<!-- START progress bar when we hit button -->
<script src="js/pace.min.js"></script>
<? } ?>

<!--[if lt IE 9]>
<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
<![endif]-->

</head>
<body>
<?
//functions when START button clicked
if(isset($_POST['start'])){
$speed = speed();
$upload = upload();
$ping = ping("www.".$ping_server, 80, 10);
}else{
$speed = "0";
$upload = "0";
$ping = "0";	  
}
?>
	  
<div class="container text-center">

<? if(isset($_POST['start'])){ ?>
<!-- START CONTENT WHEN START BUTTON POSTED -->
<div class="row heading-speed">
	
	<div class="col-md-4"><div class="inner"><span class="glyphicon glyphicon-arrow-down" aria-hidden="true"></span><strong><?=$speed; ?> Mbps</strong><br />Download speed</div></div>
	<div class="col-md-4"><div class="inner"><span class="glyphicon glyphicon-arrow-up" aria-hidden="true"></span><strong><?=$upload; ?> Mbps</strong><br />Upload speed</div></div>
	<div class="col-md-4"><div class="inner"><span class="glyphicon glyphicon-repeat" aria-hidden="true"></span><strong><?=$ping; ?> ms</strong><br />Ping</div></div>
</div>

<div class="row chart-row">
<div class="col-lg-3 col-md-2 col-sm-2 hidden-xs"></div>
<div class="col-lg-6 col-md-8 col-sm-8 col-xs-12"><div id="chart_div" style="margin:0px auto;"></div></div>
<div class="col-lg-3 col-md-2 col-sm-2 hidden-xs"></div>
</div>


<div class="row stats">
	
	<div class="col-md-4">
	  <?
	  if($use_geoip_service == "1"){
	  //DB-IP get info about your IP address
	  $dbip = new DBIP_Client($api_key);
	  $geo_info = $dbip->Get_Address_Info($_SERVER['REMOTE_ADDR']);
	  ?>
	  <table class="table table-striped">
	     <tr><th><?=ip_address;?></th><td><?=$geo_info->address;?></td></tr>
	     <tr><th><?=country_code;?></th><td><span class="flag-icon flag-icon-<?=strtolower($geo_info->country);?>"></span><?=$geo_info->country;?></td></tr>
	     <tr><th><?=state;?></th><td><?=$geo_info->stateprov;?></td></tr>     
	     <tr><th><?=city;?></th><td><?=transliterateString($geo_info->city);?></td></tr>	     
	     
	  </table>
	  <?
	  }else{
	  ?>
	  <!-- DB-IP service not allowed by our settings, lets print IP adress :) -->
	  <p class="text-muted text-center">
	  <strong><?=ip_address;?></strong> <?=$_SERVER['REMOTE_ADDR'];?>	  
	  </p>
	  <? } ?>
	</div>
	
	<div class="col-md-4">
	  

	  
	</div>
	
	<div class="col-md-4">
	  <table class="table table-striped">
	     <tr><th><?=download_mp3?></th><td><?=download_time($speed, "MP3");?>s</td></tr>
	     <tr><th><?=download_cd?></th><td><?=download_time($speed, "CD");?>s</td></tr>
		 <tr><th><?=download_dvd?></th><td><?=download_time($speed, "DVD");?>s</td></tr>
	  </table>
	  <a href="http://<?=$_SERVER['HTTP_HOST']?>/<?=$folder?>" class="btn btn-success"><span class="glyphicon glyphicon-refresh" aria-hidden="true"></span> <?=repeat;?></a><br />
	</div>
	
</div>

<!-- END CONTENT WHEN START BUTTON POSTED -->
<? }else{ ?>
<!-- START BUTTON CONTENT -->

<div class="row heading-start">
	
	<div class="col-md-12">
	  <form action="" method="post">
			<input type="hidden" name="start" value="1" />
			<button class="btn btn-lg btn-success" type="submit"><span class="glyphicon glyphicon-globe" aria-hidden="true"></span> <?=begin_test?></button>
	  </form>
	</div>
	
</div>

<!-- END BUTTON CONTENT -->
<? } ?>

</div>

<!-- START JQuery -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>



<!-- START Google gauge charts -->
<script type="text/javascript" src="https://www.google.com/jsapi?autoload={'modules':[{'name':'visualization','version':'1','packages':['gauge']}]}"></script>
<script type="text/javascript">
       google.setOnLoadCallback(drawChart);
      
	  
	  
	  function drawChart() {

        var data = google.visualization.arrayToDataTable([
          ['Label', 'Value'],
          ['<?=download?>', 0],
          ['<?=upload?>', 0],
          ['<?=ping?>', 0]
        ]);

        var options = {
          width: '100%', height: '100%',
		  minorTicks: 5
		  
        };

        var chart = new google.visualization.Gauge(document.getElementById('chart_div'));
        chart.draw(data, options);
		//window.onresize = function(){chart.draw(data, options);};
		
		setInterval(function() {
          data.setValue(0, 1, <?=$speed;?>);
          chart.draw(data, options);
        }, 1000);
        setInterval(function() {
          data.setValue(1, 1, <?=$upload;?>);
          chart.draw(data, options);
        }, 1100);
        setInterval(function() {
          data.setValue(2, 1, <?=$ping;?>);
          chart.draw(data, options);
        }, 1200);
        
      }
</script>
<!-- END Google gauge charts -->

</body>
</html>