<?php

$fahima_hashtags = "#Travelblogger
#wearetravelgirls
#Darlingescapes
#dametraveler
#foodblogger
#foodbloggers
#foodblog
#atxblogger
#atxfoodblogs
#fashionblogger
#beautyblogger
#lifestyleblogger
#lifestyleblog
#blogger
#bloggerlife
#blogpost
#blogging
#bloggerstyle
#instablogger
#instabloggers
#blog
#yycblogger
#Canadianblogger
#Vancouverblogger
#yvrblogger
#dallasblogger";

$fahima_hashtags = explode('#', $fahima_hashtags);
unset($fahima_hashtags[0]);
foreach ($fahima_hashtags as $key => $value) {
    $fahima_hashtags[$key] = trim($value);
}

if(isset($_GET['limit']))
    $limit = $_GET['limit'];
else
    $limit = 5000;

$sql = "SELECT id,fullName,url,email,instagram_unique_id,followers,externalUrl,hashtag,location FROM `mails_scrap_2` where hashtag in ('canada_location','losangelesblogger','montrealblogger','sfblogger','sanfranciscoblogger','sfblogger','washingtonblogger','bostonblogger','seattleblogger','phillyblogger','sandiegoblogger','detroitblogger','atlantablogger','dallasblogger','phoenixblogger','calgaryblogger','denverblogger','Pittsburghblogger','bloglovin','dcblogger','dslr','labeautyblogger','lafashionblogger','lastyleblogger','thebloggerunion','liketoknowit','sitsblogging','bloggerbabes','giftguide','malestyle','bloggerswanted','blogilates','blogto','bloggerdiaries','bloggervibes','bloggingtips','londonblogger','londonbloggers','ukblogger','ukbloggers','britishblogger','britishbloggers','muanyc','nycfitness','fitnessblogger','foodbloggerlife','torontofashion','nycfashion','londonfashion','birminghamblogger','bristolbloggers','glasgowblogger','glasgowbloggers','manchesterblogger','edinburghbloggers','liverpoolbloggers','leedsbloggers','leedsblogger','cardiffblogger','newcastleblogger','oxfordblogger','nottinghamblogger','southamptonblogger','englishblogger','britishstyle','irishblogger','irishbloggers','dublinblogger','belfastblogger','irishblog','ukblog','ukfoodblogger','ukfitnessblogger','ukfitnessblog,','ukyoga','vscoireland','vscouk','vscocanada','vscousa'
) and email not like '%na_%' and mediaCount > 20 and followers > 100 and conner != -1
ORDER BY `mails_scrap_2`.`followers`  DESC limit $limit
";

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

$result = $conn->query($sql);


$date = date("Y/m/d");
// $filename = 'instagram-data-influencer-conner';
$filename = 'instagram-data-fahima-'.$date;
$file_ending = "xls";
// header info for browser
header("Content-Type: application/xls");    
header("Content-Disposition: attachment; filename=$filename.xls");  
header("Pragma: no-cache"); 
header("Expires: 0");
/*******Start of Formatting for Excel*******/   
//define separator (defines columns in excel & tabs in word)
$sep = "\t"; //tabbed character
//start of printing column names as names of MySQL fields
 while ($fieldinfo=mysqli_fetch_field($result))
    {
    	echo $fieldinfo->name. "\t";
    }
print("\n");    
//end of printing column names  
//start while loop to get data
$ids = array();
    while($row = mysqli_fetch_row($result))
    {
        $schema_insert = "";
        $ids[] = $row[0];
        for($j=0; $j<mysqli_num_fields($result);$j++)
        {   

            if(!isset($row[$j]))
                $schema_insert .= "NULL".$sep;
            elseif ($row[$j] != ""){
                if($j == 1)
                {
                    $value = clean($row[$j]);
                }
                elseif($j == 7)
                {
                    // if(in_array($row[$j], $fahima_hashtags))
                        $value =  utf8_decode($row[$j]);
                    // else
                        // $value =  utf8_decode($fahima_hashtags[array_rand($fahima_hashtags)]); 
                }
                else
                {
                    $value =  utf8_decode($row[$j]);
                }
                $schema_insert .= "$value".$sep;
            }
            else
                $schema_insert .= "".$sep;
        }
        $schema_insert = str_replace($sep."$", "", $schema_insert);
        $schema_insert = preg_replace("/\r\n|\n\r|\n|\r/", " ", $schema_insert);
        $schema_insert .= "\t";
        print(trim($schema_insert));
        print "\n";
    }  

    if(isset($_GET['mark']))
    markEnteries($ids);
    exit();



    function clean($string) {
   $string = str_replace(' ', '-', $string); // Replaces all spaces with hyphens.

   return preg_replace('/[^A-Za-z0-9\-]/', '', $string); // Removes special chars.
}

    function printme($x)
    {
        echo '<pre>'.print_r($x,true).'</pre>';
    } 


    function markEnteries($ids)
    {   

        if($_GET['mark'] != 'true')
            exit();


        $date = date("Y/m/d");
        $ids = implode("','",$ids);
        file_put_contents("entries_".rand().".txt",$ids);


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

        $sql = "update mails_scrap_2 set conner = -1 where id in ('$ids')";



        $conn = mysqli_connect($servername, $username, $password, $dbname);
        // Check connection
        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }

        $result = $conn->query($sql);

        
    }
?>
