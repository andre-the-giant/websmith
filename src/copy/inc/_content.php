<?php
// WEBSITE GLOBAL PARAMETERS
$company = array(
  "name" => "WebSmith",
  "description" => "My own personal project kickstart    kit",
  "url" => "https://github.com/andre-the-giant/websmith",
  "address_street1" => "address",
  "address_city" => "Toronto",
  "address_province" => "ON",
  "address_postalcode" => "P0S 7A1",
  "address_country" => "Canada",
  "telephone" => "(416)416-4166",
  "telephone_short" => "+14164164166",
  "hoursAvailable" => "Mo, Tu, We, Th, Fr, Sat 09:00-17:00",
  "hoursAvailable_footer" => "Mon to Sat - 9AM to 5PM",
  "social_image_url" => "https://avatars.githubusercontent.com/u/20052172",
  "social_image_width" => "612",
  "social_image_height" => "612",
  "logo" => "",
  "image" => "",
  "email" => "andrecollin.toronto@gmail.com",
  "facebook_link" => "http://facebook.com/yoooo",
  "instagram_link" => "https://www.instagram.com/may_the_forks",
  "youtube_link" => "http://youtube.com/yooooo",
  "linkedin_link" => "",
  "theme_color" => "#f08300",
  'google-site-verification',''
);

// SERVICES CONTENT 
$services = array(
    'SERVICE1' => array(
        'title' => 'Service name',
        'h1' => "Service main title",
        'description' => "Service description",
        'image' => 'service-big-image.jpg',
        'pill' => 'service-thumbnail.jpg',
        'slug' => 'service-unique-slug1'
    ),
    'SERVICE2' => array(
        'title' => 'Service name',
        'h1' => "Service main title",
        'description' => "Service description",
        'image' => 'service-big-image.png',
        'pill' => 'service-thumbnail.jpg',
        'slug' => 'service-unique-slug2'
    ),
    'SERVICE3' => array(
        'title' => 'Service name',
        'h1' => "Service main title",
        'description' => "Service description",
        'image' => 'service-big-image.jpg',
        'pill' => 'service-thumbnail.jpg',
        'slug' => 'service-unique-slug3'
    )
);

//********* UTILITY FUNCTION */

function getServiceBySlug($slug) {
    global $services;
    foreach ($services as $id => $service) {
        if (isset($service['slug']) && $slug === $service['slug']) {
            $service['id']=$id;
            return $service;
        }
    }
    return null;
}
function generateSocialMediaLinks($socialNetworks) {
    global $company;
    $output = '';
    foreach ($socialNetworks as $network) {
        $key = $network . '_link';
        
        if (isset($company[$key]) && !empty($company[$key])) {
            $output .= '<li><a href="' . $company[$key] . '"><img src="/svg/' . $network . '.svg" alt="' . $company['name'].' on '. $network . '"></a></li>';
        }
    }

    return $output;
}
?>