<!DOCTYPE html>
<html lang="en-CA">
<head>
	<meta charset="utf-8">
	<title><?php echo $meta_title?$meta_title:$company["name"]; ?></title>
	<meta property="og:type" content="website" />
	<meta property="og:locale" content="en_CA" />
	<meta property="og:title" content="<?php echo $meta_title?$meta_title:$company["name"]; ?>"/>
	<meta property="og:site_name" content="<?=$company["name"]?>" />
	<meta property="og:description" content="<?=$company["description"]?>"/>
	<meta property="og:image" content="<?=$company["social_image_url"]?>"/>
	<meta property="og:image:type" content="image/jpeg" />
	<meta property="og:image:width" content="<?=$company["social_image_width"]?>" />
	<meta property="og:image:height" content="<?=$company["social_image_height"]?>" />
	<?php 
		$protocol = "https://";
		if (!empty($_SERVER['HTTP_HOST'])) {
			$host = $_SERVER['HTTP_HOST'];
		} elseif (!empty($_SERVER['SERVER_NAME'])) {
			$host = $_SERVER['SERVER_NAME'];
		} else {
			$host = $_SERVER['SERVER_ADDR'];
		}
		$request_uri = $_SERVER['REQUEST_URI'];
		$current_url = htmlspecialchars($protocol . $host . $request_uri, ENT_QUOTES, 'UTF-8');
	?>
	<meta property="og:url" content="<?= $current_url ?>" />
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta name="description" content="<?=$company["description"]?>">
	<link rel="apple-touch-icon" sizes="152x152" href="/favicon/apple-touch-icon.png">
	<link rel="icon" type="image/png" sizes="32x32" href="/favicon/favicon-32x32.png">
	<link rel="icon" type="image/png" sizes="16x16" href="/favicon/favicon-16x16.png">
	<link rel="manifest" href="/favicon/site.webmanifest">
	<link rel="shortcut icon" href="/favicon/favicon.ico">
	<meta name="msapplication-TileColor" content="<?=$company["theme_color"]?>">
	<meta name="msapplication-config" content="/favicon/browserconfig.xml">
	<meta name="theme-color" content="<?=$company["theme_color"]?>">
	<?php 
	// embed CSS in the header
	$cssFile = $_SERVER['DOCUMENT_ROOT'].'/css/'.(isset($css)?$css:'main').'.min.css';
	if (is_file($cssFile)){
		$cssContent=file_get_contents($cssFile);
		echo '<style>'.$cssContent.'</style>';
	}
	?>
	<?php if($company["google-site-verification"]){
		echo '<meta name="google-site-verification" content="'.$company["google-site-verification"].'" />';
	}
	?>

	<meta name="twitter:title" content="<?=$meta_title?>" />
	<meta name="twitter:image"
		content="<?=$company["social_image_url"]?>" />
	<meta name="twitter:url" content="<?=$company["url"]?>" />
	<meta name="twitter:card" content="summary" />
	<meta name="twitter:description"
		content="<?=$company["description"]?>" />
	<meta name="description" content="<?=$company["description"]?>" />
	<script type="application/ld+json">
	{
		"@context": "http://schema.org/",
		"@type": "Organization",
		"name": "<?=$company["name"]?>",
		"url": "<?=$company["url"]?>",
		"logo": "<?=$company["logo"]?>",
		"image": "<?=$company["image"]?>",
		"description": "<?=$company["description"]?>",
		"address": {
		"@type": "PostalAddress",
		"streetAddress": "<?=$company["address_street1"]?>",
		"addressLocality": "<?=$company["address_city"]?>",
		"addressRegion": "<?=$company["address_province"]?>",
		"postalCode": "<?=$company["address_postalcode"]?>",
		"addressCountry": "<?=$company["address_country"]?>"
		},
		"contactPoint": {
		"@type": "ContactPoint",
		"telephone": "<?=$company["telephone"]?>",
		"contactType":"customer support",
		"hoursAvailable": "<?=$company["hoursAvailable"]?>"
		}
	}
	</script>
</head>
<body>
	<header>
		<div class="header">
		<?php 
		if($company["logo"] && !empty($company["logo"])){
			echo '<div class="logo"><a href="/" class="logo-link"><img src="'.$company["logo"].'" alt="'.$company["name"].'"></a></div>';
		}
		?>
			<div class="tagline"><a href="tel:<?=$company['telephone_short']?>" class="button">CALL US <?=$company['telephone']?></a></div>
			<nav class="navigation navDesktop"><ul>
				<li>
					<a href="/services/bbq-cleaning">Services</a>
					<ul>
						<?php 
						foreach ($services as $service) {
							$title = $service['title'];
							$slug = $service['slug'];
							echo '<li><a href="/services/' . $slug . '">' . $title . '</a></li>';
						}
						?>
					</ul>
				</li>
			</ul></nav>
			<!-- <label class="navMobile">
				<input type="checkbox">
				<span class="menu"> <span class="hamburger"></span> </span>
				<ul>
				<li> <a href="#">Home</a> </li>
				<li> <a href="#">About</a> </li>
				<li> <a href="#">Contact</a> </li>
				</ul>
			</label> -->
		</div>
	</header>
	<main>
    <h1 class="sr-only"><?=$meta_title?></h1>