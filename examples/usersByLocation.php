<?php

set_time_limit(0);
date_default_timezone_set('UTC');
error_reporting(E_ALL);
ini_set('display_errors', 1);

require __DIR__.'/../vendor/autoload.php';

/////// CONFIG ///////
$username = 'instadev89.1';
$password = 'Password1';
$debug = true;
$truncatedDebug = false;
//////////////////////

/////// MEDIA ////////
$photoFilename = 'trial.jpg';
$captionText = 'Test';
//////////////////////

$ig = new \InstagramAPI\Instagram($debug, $truncatedDebug);

// try {
//     $ig->setUser($username, $password);
//     $ig->login();
// } catch (\Exception $e) {
//     echo 'Something went wrong: '.$e->getMessage()."\n";
//     exit(0);
// }

try {
    //$ig->uploadTimelinePhoto($photoFilename, ['caption' => $captionText]);
    // $result = $ig->getHashtagFeed('photography');
    // $result = $ig->getLocationFeed(213069300);
    // getUsernameId($username)
    // getMediaLikers($mediaId)
    // likeComment($commentId)
    // getMediaInfo($mediaId)
    // getTimelineFeed($maxId = null)
    // getUserFollowings($userId,$maxId = null)
    // getUserFollowers($userId,$maxId = null)
    //setProxy($value)
    
   	// $hashtag = getMyHashtag();

	// $logged_in = false;


	$username = getMyUser();
	$password = 'Password1';

	$ig->setUser($username, $password);
    $ig->login();

    
	
	//GET ALL RELATED LOCATIONS
    $locations = $ig->searchFBLocation('australia');

    foreach ($locations->fullResponse->items as $location) 
    {

    	$location_name = $location->location->name;
    	$location_id = $location->location->pk;



    	//GET THIS LOCATION FEED
    	$result = $ig->getLocationFeed($location_id);

    	foreach ($result->items as $item) {
    		

    		$proxy = getMyProxy();
			$ig->setProxy(array('CURLOPT_PROXY'=>$proxy['proxy'],'CURLOPT_PROXYPORT'=>$proxy['port']));

			// printme($item);
			// exit();
			$username = getMyUser();
			$password = 'Password1';
			$ig->logout();
			$ig->setUser($username, $password);
		    $ig->login();

    		$user_id = $item->user->pk;
    		$user = $ig->getUserInfoById($user_id);


    		$user_data = array();
	        $user_data['username'] = $user->user->username;
	        $user_data['url'] = 'https://www.instagram.com/'.$user->user->username.'/';
	        $user_data['followers'] = $user->user->follower_count;
	        $user_data['hashtag']       = 'australia';
	        $user_data['externalUrl']       = $user->user->external_url;
	        $user_data['instagram_unique_id']       = $user->user->pk;
	        $user_data['fullName']       = $user->user->full_name;
	        $user_data['profilePicUrl']       = $user->user->hd_profile_pic_versions[0]->url;
	        $user_data['biography']       = $user->user->biography;
	        $user_data['followsCount']       = $user->user->following_count;
	        $user_data['mediaCount']       = $user->user->media_count;


	        if($user->user->public_email)
	        {
				$mails = array();
				$mails[] = $user->user->public_email;
				saveMails($mails,$user_data);
			}
			else
			{
				saveMails(getMails($user->user->biography),$user_data);
			}
    		
    	}
    	

    }
    
} catch (\Exception $e) {
    echo 'Something went wrong: '.$e->getMessage()."\n";
}



function getMyHashtag()
{
	 $hashtags = "losangelesblogger
montrealblogger
sfblogger
sanfranciscoblogger
sfblogger
washingtonblogger
bostonblogger
seattleblogger
phillyblogger
sandiegoblogger
detroitblogger
atlantablogger
dallasblogger
phoenixblogger
calgaryblogger
denverblogger
Pittsburghblogger
bloglovin
dcblogger
dslr
labeautyblogger
lafashionblogger
lastyleblogger
thebloggerunion
liketoknowit
sitsblogging
bloggerbabes
giftguide
malestyle
bloggerswanted
blogilates
blogto
bloggerdiaries
bloggervibes
bloggingtips
londonblogger
londonbloggers
ukblogger
ukbloggers
britishblogger
britishbloggers
muanyc
nycfitness
fitnessblogger
foodbloggerlife
torontofashion
nycfashion
londonfashion
birminghamblogger
bristolbloggers
glasgowblogger
glasgowbloggers
manchesterblogger
edinburghbloggers
liverpoolbloggers
leedsbloggers
leedsblogger
cardiffblogger
newcastleblogger
oxfordblogger
nottinghamblogger
southamptonblogger
englishblogger
britishstyle
irishblogger
irishbloggers
dublinblogger
belfastblogger
irishblog
ukblog
ukfoodblogger
ukfitnessblogger
ukfitnessblog
ukyoga
vscoireland
vscouk
vscocanada
vscousa
";

	$hashtags = explode(PHP_EOL, $hashtags);
	unset($hashtags[78]);


	$hashtag_index = file_get_contents('hashtag.txt');
	$hashtag_index = intval($hashtag_index);

	$hashtag = $hashtags[$hashtag_index];

	if($hashtag_index >= count($hashtags)-1)
		$new_index = 0;
	else
		$new_index = $hashtag_index+1;

	file_put_contents('hashtag.txt', $new_index);

	return $hashtag;
}



function getMyUser()
{
	$users = array();
	// $users[]= 'instadev89.1';
	// $users[]= 'instadev89.2';
	// $users[]= 'instadev89.3';
	$users[]= 'instadev89.4';
	$users[]= 'instadev89.5';
	$users[]= 'instadev89.6';
	$users[]= 'instadev89.7';
	$users[]= 'instadev89.8';
	$users[]= 'instadev89.9';


	$user_index = file_get_contents('user.txt');
	$user_index = intval($user_index);

	$user = $users[$user_index];

	if($user_index >= count($users)-1)
		$new_index = 0;
	else
		$new_index = $user_index+1;

	file_put_contents('user.txt', $new_index);

	

	return $user;



}

function getMyProxy()
{
	$proxyies = array();
	$proxyies[] = '50.31.8.17:3128';
	$proxyies[] = '89.32.69.91:3128';
	$proxyies[] = '89.32.69.87:3128';
	$proxyies[] = '89.32.69.2:3128';
	$proxyies[] = '89.32.69.206:3128';
	$proxyies[] = '50.31.8.149:3128';
	$proxyies[] = '192.126.159.29:3128';
	$proxyies[] = '192.126.159.203:3128';
	$proxyies[] = '50.31.8.21:3128';
	$proxyies[] = '50.31.8.56:3128';

	//NEW 50 PROXIES
	$proxyies[] = '170.130.62.4:3128';
	$proxyies[] = '206.214.93.65:3128';
	$proxyies[] = '192.126.159.228:3128';
	$proxyies[] = '104.140.210.122:3128';
	$proxyies[] = '206.214.93.250:3128';
	$proxyies[] = '104.140.209.88:3128';
	$proxyies[] = '104.140.210.136:3128';
	$proxyies[] = '206.214.93.46:3128';
	$proxyies[] = '170.130.62.200:3128';
	$proxyies[] = '192.126.159.212:3128';
	$proxyies[] = '104.140.210.98:3128';
	$proxyies[] = '173.234.249.239:3128';
	$proxyies[] = '104.140.209.33:3128';
	$proxyies[] = '104.140.209.62:3128';
	$proxyies[] = '173.234.249.16:3128';
	$proxyies[] = '192.126.157.3:3128';
	$proxyies[] = '104.140.210.161:3128';
	$proxyies[] = '170.130.62.145:3128';
	$proxyies[] = '192.126.159.118:3128';
	$proxyies[] = '192.126.159.246:3128';
	$proxyies[] = '170.130.62.40:3128';
	$proxyies[] = '206.214.93.166:3128';
	$proxyies[] = '206.214.93.69:3128';
	$proxyies[] = '206.214.93.139:3128';
	$proxyies[] = '192.126.157.207:3128';
	$proxyies[] = '192.126.159.45:3128';
	$proxyies[] = '170.130.62.212:3128';
	$proxyies[] = '94.229.71.61:3128';
	$proxyies[] = '192.126.159.253:3128';
	$proxyies[] = '104.140.210.65:3128';
	$proxyies[] = '192.126.157.139:3128';
	$proxyies[] = '94.229.71.67:3128';
	$proxyies[] = '170.130.62.216:3128';
	$proxyies[] = '104.140.210.85:3128';
	$proxyies[] = '192.126.159.200:3128';
	$proxyies[] = '192.126.159.146:3128';
	$proxyies[] = '206.214.93.34:3128';
	$proxyies[] = '94.229.71.28:3128';
	$proxyies[] = '192.126.157.63:3128';
	$proxyies[] = '192.126.157.39:3128';
	$proxyies[] = '192.126.157.124:3128';
	$proxyies[] = '206.214.93.247:3128';
	$proxyies[] = '104.140.209.177:3128';
	$proxyies[] = '192.126.157.8:3128';
	$proxyies[] = '104.140.209.192:3128';
	$proxyies[] = '94.229.71.14:3128';
	$proxyies[] = '94.229.71.42:3128';
	$proxyies[] = '94.229.71.108:3128';
	$proxyies[] = '104.140.209.173:3128';
	$proxyies[] = '192.126.157.47:3128';


	$proxy_index = file_get_contents('proxy.txt');
	$proxy_index = intval($proxy_index);

	$proxy = $proxyies[$proxy_index];
	$proxy = explode(":",$proxy);

	$output = array();
	$output['proxy'] = $proxy['0'];
	$output['port'] = $proxy['1'];

	if($proxy_index >= count($proxyies)-1)
		$new_index = 0;
	else
		$new_index = $proxy_index+1;

	file_put_contents('proxy.txt', $new_index);

	return $output;
}

function printme($x)
{
	echo '<pre>'.print_r($x,true).'</pre>';
}



function getMails($string)
{   
    $mails = array();
    $pattern = '/[A-Za-z0-9_-]+@[A-Za-z0-9_-]+\.([A-Za-z0-9_-][A-Za-z0-9_]+)/';
    preg_match_all($pattern, $string, $matches);
    $matches = $matches[0];
    if(is_array($matches))
    {
        foreach ($matches as $match) {
            $mails[] = $match;
        }
    }

    return $mails;
}

function saveMails($data, $user_data)
{

    if(empty($data))
    {
        $data = array();
        $data[] = 'na_'.$user_data['instagram_unique_id'];
    }
    

    // $servername = "localhost";
    // $username = "root";
    // $password = "root";
    // $dbname = "insta_mails";
    $HTTP_HOST = $_SERVER['HTTP_HOST'];

    if($HTTP_HOST == 'localhost')
    {
        //Development
        $servername = "localhost";
        $username = "root";
        $password = "root";
        $dbname = "insta_mails";
    }
    else
    {
        //Production
        $servername = "localhost";
        $username = "root";
        $password = ".?R](%B=<NE,6'g";
        $dbname = "insta_mails";
    }

    // Create connection
    $conn = mysqli_connect($servername, $username, $password, $dbname);
    // Check connection
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }


    
    
        $isPrivate = 0;
        $isVerified = 0;
        $user_data['location'] = '';
        $user_data['country'] = '';
        $user_data['city'] = '';


    $sql = "select id from mails_scrap where username='".$user_data['username']."' ";
    $result = mysqli_query($conn, $sql);
    $rowcount=mysqli_num_rows($result);

    $sql = "select id from mails_scrap_2 where username='".$user_data['username']."' ";
    $result = mysqli_query($conn, $sql);
    $rowcount_1=mysqli_num_rows($result);
    if($rowcount != 1 && $rowcount_1 != 1)
    {
        foreach ($data as $mail) {
            // $sql = "INSERT INTO mails_scrap_2 (email,username,url,followers,hashtag, externalUrl, location,instagram_unique_id,fullName,profilePicUrl ,biography,followsCount,mediaCount,isPrivate,isVerified,country,city)
            //         VALUES ('".$mail."','".$user_data['username'].
            //                    "','".$user_data['url'].
            //                    "',".$user_data['followers'].",
            //                    '".$user_data['hashtag']."',
            //                    '".$user_data['externalUrl']."',
            //                    '".$user_data['location']."',
            //                    '".$user_data['instagram_unique_id']."',
            //                    '".$user_data['fullName']."',
            //                    '".$user_data['profilePicUrl']."',
            //                    '".$user_data['biography']."',
            //                    '".$user_data['followsCount']."',
            //                    '".$user_data['mediaCount']."',
            //                    '".$isPrivate."',
            //                    '".$isVerified."',
            //                    '".$user_data['country']."',
            //                    '".$user_data['city']."'


            //                 )";
        
            $sql = 'INSERT INTO mails_scrap_2 (email,username,url,followers,hashtag, externalUrl, location,instagram_unique_id,fullName,profilePicUrl ,biography,followsCount,mediaCount,isPrivate,isVerified,country,city)
                    VALUES (
                        "'.$mail.'",
                        "'.$user_data['username'].'",
                        "'.$user_data['url'].'",
                        "'.$user_data['followers'].'",
                        "'.$user_data['hashtag'].'",
                        "'.$user_data['externalUrl'].'",
                        "'.$user_data['location'].'",
                        "'.$user_data['instagram_unique_id'].'",
                        "'.$user_data['fullName'].'",
                        "'.$user_data['profilePicUrl'].'",
                        "'.$user_data['biography'].'",
                        "'.$user_data['followsCount'].'",
                        "'.$user_data['mediaCount'].'",
                        "'.$isPrivate.'",
                        "'.$isVerified.'",
                        "'.$user_data['country'].'",
                        "'.$user_data['city'].'"
                        )';


            if (mysqli_query($conn, $sql)) {
            echo "New record created successfully";
            } else {
                echo "Error: " . $sql . "<br>" . mysqli_error($conn);
            }
        }
    }

    $conn->close();
}