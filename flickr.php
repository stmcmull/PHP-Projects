<?php

$q = $_SERVER['QUERY_STRING'];
$api_key = "9f8ccbee182fb5f0253e6bb152f56254"; // replace with your API key
$user = "Indiana University Northwest";
$nsid = "94040921@N07";

$photoset_id = $_GET['photoset_id'];
$title = $_GET['title'];

// Get photos from the gallery
$url = "http://api.flickr.com/services/rest/?method=flickr.photosets.getPhotos&api_key=$api_key&photoset_id=$photoset_id&format=json&nojsoncallback=1";
 
// read in API response
$json = file_get_contents($url);
 
// a little string clean up to convert jsonp response to a valid json string, then decode to a PHP object
$response = json_decode( ltrim(rtrim(str_replace( "jsonFlickrApi",  "", $json), ')'),'('));

$set_title = $response->photoset->title;

echo "
<div>
    <h2>$title</h2>
</div>";


if($response->stat == 'ok')
{
    $photos = $response->photoset->photo;
    if(count($photos) > 0)
    {      
    foreach($photos as $photo)
    {
        $farmId = $photo->farm;
		$serverId = $photo->server;
        $id = $photo->id;
        $secret = $photo->secret;
        $title = $photo->title;
        $imagePathThumbnail = 'http://farm'.$farmId.'.staticflickr.com/'.$serverId.'/'.$id.'_'.$secret.'_q.jpg';
        $imagePathLarge = 'http://farm'.$farmId.'.staticflickr.com/'.$serverId.'/'.$id.'_'.$secret.'.jpg';
        $image = '

<a " href="'.$imagePathLarge.'" target="_blank">';
        $image.= '
    
    <img src="'.$imagePathThumbnail.'" alt="'.$title.'">';
        $image.= '
    
    </a>';
        echo $image;
    }
    }
    else
    {
        echo 'No Results';
    }
}
else
{
    echo '
    
    <strong>Error : </strong>'.$response->message;
}


?>