<?php header ("content-type: text/xml");
// Make sure the above line is executed first

/*
**
** Project: Generating Google Base Data Feed with PHP
** Developed by: Jawad Shuaib (http://jawadonweb.com jawad.php@gmail.com)
**
*/

// Construct your products array here. It would be best to pull this from the database
# $products[] = array ("unique number", "product name", "product description", "link to product", "product photo path", "product price", "category of product - can be anything");
$products[] = array (rand(), "Product A", "Description A", "http://jawadonweb.com/?p=1352", "http://jawadonweb.com/wp-content/uploads/2011/03/search-engine-php-code.jpg", "$1.00", "Furniture");
$products[] = array (rand(), "Product B", "Description B", "http://jawadonweb.com/?p=1351", "http://jawadonweb.com/wp-content/uploads/2011/03/search-engine-php-code.jpg", "$2.00", "Chairs");
$products[] = array (rand(), "Product C", "Description C", "http://jawadonweb.com/?p=1350", "http://jawadonweb.com/wp-content/uploads/2011/03/search-engine-php-code.jpg", "$1.50", "Computer Accessories");
$products[] = array (rand(), "Product D", "Description D", "http://jawadonweb.com/?p=1349", "http://jawadonweb.com/wp-content/uploads/2011/03/search-engine-php-code.jpg", "$3.00", "Stationary");
$products[] = array (rand(), "Product E", "Description E", "http://jawadonweb.com/?p=1348", "http://jawadonweb.com/wp-content/uploads/2011/03/search-engine-php-code.jpg", "$0.99", "Frames");

$totalProducts = count ($products);
echo '<?xml version="1.0"?>
<rss version ="2.0" xmlns:g="http://base.google.com/ns/1.0"> 
';
?>
  <channel>
    <title>Company Name</title>
    <link>http://jawadonweb.com</link>

	<?php
    for ($i=0;$i<$totalProducts;$i++)
    {
		$serial 	 = $products[$i][0];
		$name 		 = $products[$i][1];
		$description = $products[$i][2];
		$link 		 = $products[$i][3];
		$photo 		 = $products[$i][4];
		$price 		 = $products[$i][5];
		$categoryName= $products[$i][6];		
		
		// This function generates an XML feed that is compatible with Google Data Feed
  		construct_feed_item ($serial, $name, $description, $categoryName, $link, $photo, $price);
    }
    ?>
  </channel>
<?php
echo "</rss>";
function construct_feed_item ($serial, $name, $description, $categoryName, $link, $photo, $price)
{
	$title = clean_feed ($name);
	$description = clean_feed ($description);
	$imagePath = $photo;	
	  
	echo "<item>\n";
		echo "\t<title>".$title."</title>\n";
		echo "\t<g:condition>new</g:condition>\n";		
		if ($description != NULL) {
			echo "\t<description><![CDATA[ ".strip_tags($description)." ]]></description>\n";
		}
		echo "\t<g:image_link><![CDATA[ ".$imagePath." ]]></g:image_link>\n";		
		echo "\t<link>".$link."</link>\n";		
		echo "\t<g:id>".$serial."</g:id>\n";
		echo "\t<g:mpn>".$serial."</g:mpn>\n";				
		echo "\t<g:price>".$price."</g:price>\n";						
		echo "\t<g:product_type><![CDATA[ ".$categoryName." ]]></g:product_type>\n";					
	echo "</item>\n";	
}

function clean_feed ($str)
{

	$str = str_replace (";","",$str);
	$str = str_replace ("\\","",$str);
	$str = str_replace ("'","",$str);
	$str = str_replace ("\"","",$str);		
	$str = str_replace ("&nbsp"," ",$str);		
	$str = str_replace ("&","",$str);			

	$str = preg_replace('/[\x00-\x1F\x80-\xFF]/', '', $str); 
	//$str = htmlentities ($str);
return $str;
}
?>