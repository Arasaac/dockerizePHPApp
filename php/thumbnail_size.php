<?php 
$ls='';

if (isset($_SESSION["selected_text_size"])) {
	$ls=''.$_SESSION["selected_text_size"].'';
} else { 
	$ls==0.9;
}

if ($ls=='0.6') {
	$img_size=20;
	$video_width=80;
	$video_height=95;
	$img_big_size=250;
	$img_little_size=150;
} elseif ($ls=='0.7') {
	$img_size=30;
	$video_width=90;
	$video_height=105;
	$img_big_size=250;
	$img_little_size=150;
} elseif ($ls=='0.8') {
	$img_size=40;
	$video_width=100;
	$video_height=115;
	$img_big_size=300;
	$img_little_size=170;
} elseif ($ls=='0.9') {
	$img_size=50;
	$video_width=110;
	$video_height=125;
	$img_big_size=300;
	$img_little_size=200;
} elseif ($ls=='1') {
	$img_size=70;
	$video_width=130;
	$video_height=145;
	$img_big_size=350;
	$img_little_size=200;
} elseif ($ls==1.1) {
	$img_size=90;
	$video_width=150;
	$video_height=165;
	$img_big_size=350;
	$img_little_size=200;
} elseif ($ls=='1.2') {
	$img_size=110;
	$video_width=170;
	$video_height=185;
	$img_big_size=350;
	$img_little_size=200;
} elseif ($ls=='1.3') {
	$img_size=130;
	$video_width=190;
	$video_height=205;
	$img_big_size=400;
	$img_little_size=200;
} elseif ($ls=='1.4') {
	$img_size=150;
	$video_width=210;
	$video_height=225;
	$img_big_size=400;
	$img_little_size=250;
} elseif ($ls=='1.5') {
	$img_size=170;
	$video_width=230;
	$video_height=245;
	$img_big_size=400;
	$img_little_size=250;
} elseif ($ls=='1.6') {
	$img_size=190;
	$video_width=250;
	$video_height=265;
	$img_big_size=450;
	$img_little_size=250;
} else {
	$img_size=50;
	$video_width=110;
	$video_height=125;
	$img_big_size=300;
	$img_little_size=200;
}
?>