<?php
ob_start("ob_gzhandler");
include_once($_SERVER['DOCUMENT_ROOT'].'/inc/_content.php');
$meta_title = "We are the top BBQ cleaning and repair service for Toronto and Ottawa".' - '.$company["name"] ;
include_once($_SERVER['DOCUMENT_ROOT'].'/inc/_header.php');
?>
<!-- HERO -->
<div class="dropshadow">
	<div class="hero big-lookup curve-out-bottom">
		<video id="background-video" autoplay loop muted poster="/img/van.jpg">
		<source src="/video/intro-360p.mp4" type="video/mp4">
		<source src="/intro-1080p.mp4" media="(min-width: 768px)">
		</video>
		<?php
		include_once($_SERVER['DOCUMENT_ROOT'].'/inc/_postalcodelookup.php');
		?>
	</div>
</div>
<?php include_once($_SERVER['DOCUMENT_ROOT'].'/inc/_ourservices.php'); ?>


<?php 
$municipalities = $territoryData;
include_once($_SERVER['DOCUMENT_ROOT'].'/inc/_municipality.php');
 ?>
<?php 
include_once($_SERVER['DOCUMENT_ROOT'].'/inc/_reviews.php');
?>
<?php
// include_once($_SERVER['DOCUMENT_ROOT'].'/inc/_pills.php');
?>
<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/inc/_footer.php');
?>