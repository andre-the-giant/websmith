<?php
// Test if $serviceValue exists in any of the 'slug' values
// make sure there are pages created in /services/ with filename being `_service-slug.php`
// if file not created, will default to service description
ob_start("ob_gzhandler");
include_once($_SERVER['DOCUMENT_ROOT'].'/inc/_content.php');
$service = $_GET['service'];
$slugs = array_column($services, 'slug');
if (!in_array($service, $slugs)) {
    header("Location: /");
    exit; 
}

$serviceDetails = getServiceBySlug($service);
$meta_title = ''.$serviceDetails['title'].'  - '.$company["name"] ;
$css = 'services-page';
include($_SERVER['DOCUMENT_ROOT'].'/inc/_header.php');
?>
 <h1><span><?php
    echo $serviceDetails['h1'];
    ?></span>
</h1>

<div class="services-description">
    <nav>
        <ul>
            <?php
            foreach ($services as $service) {
                $title = $service['title'];
                $slug = $service['slug'];
                $pill = $service['pill'];
                echo '<li>';
                echo $title==$serviceDetails['title']? '<img src="/img/'.$pill.'" alt=""> '. $title . '':'<img src="/img/'.$pill.'" alt=""> <a href="/services/' . $slug . '">' . $title . '</a>';
                echo '</li>';
            }
            ?>
        </ul>
    </nav>
    <div class="service-description">
        <h2><?=$serviceDetails['title']?></h2>
        <?php
        if(is_file('_'.$serviceDetails['slug'].'.php')){
            include_once('_'.$serviceDetails['slug'].'.php');
        }
        else {
            echo $serviceDetails['description'];
        }
        ?>
    </div>
</div>

<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/inc/_footer.php');
?>