<?php

echo '
<link href="/css/flickr.css" rel="stylesheet" type="text/css">';

$q = $_SERVER['QUERY_STRING'];
$api_key = "9f8ccbee182fb5f0253e6bb152f56254"; // replace with your API key
$user = "Indiana University Northwest";
$nsid = "94040921@N07";

$photoset_id = $_GET['photoset_id'];
$title = $_GET['title'];
$descriptions = $_GET['descriptions'];
$picture_size = $_GET['picture_size'];

// Get photos from the gallery, convert json response to valid json string, then decode to PHP object
$url = "http://api.flickr.com/services/rest/?method=flickr.photosets.getPhotos&api_key=$api_key&photoset_id=$photoset_id&format=json&nojsoncallback=1";
$json = file_get_contents($url);
$response = json_decode( ltrim(rtrim(str_replace( "jsonFlickrApi",  "", $json), ')'),'('));

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
        $description = $photo->description;
        
        //150 x 150
        $imagePathLargeSquare = 'http://farm'.$farmId.'.staticflickr.com/'.$serverId.'/'.$id.'_'.$secret.'_q.jpg';
        //100 x 100
        $imagePathThumbnail = 'http://farm'.$farmId.'.staticflickr.com/'.$serverId.'/'.$id.'_'.$secret.'_t.jpg';
        //320 on longest side
        $imagePathSmall = 'http://farm'.$farmId.'.staticflickr.com/'.$serverId.'/'.$id.'_'.$secret.'_n.jpg';
        //500 on longest side
        $imagePathStandard = 'http://farm'.$farmId.'.staticflickr.com/'.$serverId.'/'.$id.'_'.$secret.'.jpg';
        //800 on longest side
        $imagePathMedium = 'http://farm'.$farmId.'.staticflickr.com/'.$serverId.'/'.$id.'_'.$secret.'_c.jpg';
        
        
        // API call to get info for each photo, clean up the response, and define the description variable
        
        $info_url = "http://api.flickr.com/services/rest/?method=flickr.photos.getInfo&api_key=$api_key&photo_id=$id&format=json&nojsoncallback=1";
        $info_json = file_get_contents($info_url);
        $info_response = json_decode( ltrim(rtrim(str_replace( "jsonFlickrApi",  "", $info_json), ')'),'('));
        $description = $info_response->photo->description->_content;
        
        if($descriptions == 'Yes') {
    if ($picture_size == 'Large_Square') {
        
        $image = '
    <a " href="'.$imagePathStandard.'" target="_blank">';
        $image.= '
        <img src="'.$imagePathLargeSquare.'" alt="'.$title.'">';
        $image.= '
        </a>';
        
        echo "
        <div class=\"flickr-block-large-square\">
            <div class=\"flickr-image\">
            $image
          </div>
            <div class=\"flickr-description\">
                <p>" . $description . "</p>
            </div>
        </div>";
    }
    elseif ($picture_size == 'Thumbnail'){
        
        $image = '
        <a " href="'.$imagePathStandard.'" target="_blank">';
        $image.= '
            <img src="'.$imagePathThumbnail.'" alt="'.$title.'">';
        $image.= '
            </a>';
        
        echo "
            <div class=\"flickr-block-thumbnail\">
                <div class=\"flickr-image\">
            $image
          </div>
                <div class=\"flickr-description\">
                    <p>" . $description . "</p>
                </div>
            </div>";
    }
    elseif ($picture_size == 'Small'){
        
        $image = '
            <a " href="'.$imagePathStandard.'" target="_blank">';
        $image.= '
                <img src="'.$imagePathSmall.'" alt="'.$title.'">';
        $image.= '
                </a>';
        
        echo "
                <div class=\"flickr-block-small\">
                    <div class=\"flickr-image\">
            $image
          </div>
                    <div class=\"flickr-description\">
                        <p>" . $description . "</p>
                    </div>
                </div>";
    }
    elseif ($picture_size == 'Medium'){
        
        $image = '
                <a " href="'.$imagePathStandard.'" target="_blank">';
        $image.= '
                    <img src="'.$imagePathStandard.'" alt="'.$title.'">';
        $image.= '
                    </a>';
        
        echo "
                    <div class=\"flickr-block-medium\">
                        <div class=\"flickr-image\">
            $image
          </div>
                        <div class=\"flickr-description\">
                            <p>" . $description . "</p>
                        </div>
                    </div>";
    }
    elseif ($picture_size == 'Large'){
        
        $image = '
                    <a " href="'.$imagePathStandard.'" target="_blank">';
        $image.= '
                        <img src="'.$imagePathMedium.'" alt="'.$title.'">';
        $image.= '
                        </a>';
        
        echo "
                        <div class=\"flickr-block-large\">
                            <div class=\"flickr-image\">
            $image
          </div>
                            <div class=\"flickr-description\">
                                <p>" . $description . "</p>
                            </div>
                        </div>";
    }    
    else {
        echo "ERROR1";
    }

}

if($descriptions == 'No') {
    if ($picture_size == 'Large_Square') {
        
        $image = '
                        <a " href="'.$imagePathStandard.'" target="_blank">';
        $image.= '
                            <img src="'.$imagePathLargeSquare.'" alt="'.$title.'">';
        $image.= '
                            </a>';
        
        echo "
                            <div class=\"flickr-block-large-square\">
                                <div class=\"flickr-image\">
            $image
          </div>
                            </div>";
    }
    elseif ($picture_size == 'Thumbnail'){
        
        $image = '
                            <a " href="'.$imagePathStandard.'" target="_blank">';
        $image.= '
                                <img src="'.$imagePathThumbnail.'" alt="'.$title.'">';
        $image.= '
                                </a>';
        
        echo "
                                <div class=\"flickr-block\">
                                    <div class=\"flickr-image\">
            $image
          </div>
                                </div>";
    }
    elseif ($picture_size == 'Small'){
        
        $image = '
                                <a " href="'.$imagePathStandard.'" target="_blank">';
        $image.= '
                                    <img src="'.$imagePathSmall.'" alt="'.$title.'">';
        $image.= '
                                    </a>';
        
        echo "
                                    <div class=\"flickr-block-small\">
                                        <div class=\"flickr-image\">
            $image
          </div>
                                    </div>";
    }
    elseif ($picture_size == 'Medium'){
        
        $image = '
                                    <a " href="'.$imagePathStandard.'" target="_blank">';
        $image.= '
                                        <img src="'.$imagePathStandard.'" alt="'.$title.'">';
        $image.= '
                                        </a>';
        
        echo "
                                        <div class=\"flickr-block-medium\">
                                            <div class=\"flickr-image\">
            $image
          </div>
                                        </div>";
    }
    elseif ($picture_size == 'Large'){
        
        $image = '
                                        <a " href="'.$imagePathStandard.'" target="_blank">';
        $image.= '
                                            <img src="'.$imagePathMedium.'" alt="'.$title.'">';
        $image.= '
                                            </a>';
        
        echo "
                                            <div class=\"flickr-block-large\">
                                                <div class=\"flickr-image\">
            $image
          </div>
                                            </div>";
    }    
    else {
        echo "ERROR2";
    }

}
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