<?php
$url = 'http://'.$_SERVER['HTTP_HOST'];
$contents = file_get_contents($url);
preg_match_all("<a href=\x22(.+?)\x22>", $contents, $matches);
foreach($matches[1] as $href) {
	if(!preg_match('#http://#i', $href) && $href != '#') {
		$result[] = $url.$href;
		if(preg_match('#category#i', $href)) {
		$contents = file_get_contents($url.$href);
		preg_match_all("<a href=\x22(.+?)\x22>", $contents, $matches);
		foreach($matches[1] as $href) {
			if(!preg_match('#http://#i', $href) && $href != '#') {
				$result[] = $url.$href;
			}
		}
		}
	}
}
$result = array_values(array_unique($result));
header('Content-type: application/xml');
echo '<?xml version="1.0" encoding="UTF-8" ?>';
?>

<urlset
	xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"
	xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
	xmlns:image="http://www.google.com/schemas/sitemap-image/1.1"
	xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9
	http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd">
<url>
<loc><?php echo $url ?></loc>
<changefreq>daily</changefreq>
<priority>1.0</priority>
</url>

<?php
foreach($result as $v) {
?>
<url>
<loc><?php echo xml_entities($v) ?></loc>
<lastmod><?php echo date('Y-m-d'); ?></lastmod>
<priority>0.8</priority>
</url>
<?php } ?>
</urlset>

<?php
function xml_entities($string) {
    return str_replace(
        array("&",     "<",    ">",    '"',      "'"),
        array("&amp;", "&lt;", "&gt;", "&quot;", "&apos;"), 
        $string
    );
}
function debug($var) {
	echo '<pre>';
	print_r($var);
	echo '</pre>';
}

?>