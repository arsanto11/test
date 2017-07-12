<?php
include "config.php";

function gotoaliexpress($productid){
	$url= 'http://www.aliexpress.com/item/-/'.$productid.'.html';
	return "http://s.click.aliexpress.com/deep_link.htm?dl_target_url=".urlencode($url)."&aff_short_key=".ALIEXPRESS_AFFILIATE_KEY;
}

function isbot(){
	if(!isset($_SERVER['HTTP_USER_AGENT'])){ return false; }
	if(empty($_SERVER['HTTP_USER_AGENT'])){ return false; }
return preg_match('/(google|googlebot|bing|msn|yahoo|sulrp)/i', $_SERVER['HTTP_USER_AGENT']);
}

function ismainreferer(){
	if(isbot()){ return true; }
	if(!isset($_SERVER['HTTP_REFERER'])){ return false; }
	if(empty($_SERVER['HTTP_REFERER'])){ return false; }
$arrpars= parse_url($_SERVER['HTTP_REFERER'], PHP_URL_HOST);
	if($arrpars == $_SERVER['SERVER_NAME']){ return true; }
	return false;
}


function safe_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}


function endpoint_search($query,$pages=1){
$page= ($pages-1)*20;	
	$uri= 'https://m.aliexpress.com/search/mainsearch/asy/GetMainSearchDataJson.do?keyword='.urlencode($query).'&start='.$page.'&freeShipping=false&ignoreSPU=true';
	$uri .= '&pageSize=5&isBigSale=false&categoryId=';	
	$filecached= dirname(__FILE__)."/temporary-cache/".sha1($uri).".tmp";
if(file_exists($filecached)){
	return unserialize(file_get_contents($filecached));
}
	
$data= IS_CURL($uri, false);
$arr= json_decode($data,1); //return $arr;
	if(!isset($arr['items'])){ return false; }
$ass= $arr['items'];

		if(isset($ass[20])){
			unset($ass[20]);
		}

		foreach($ass as $gth){
			if(isset($gth['evaluation']['evarageStar'])){
				$kk['evarageStar']= $gth['evaluation']['evarageStar'];
			}
			if(isset($gth['imgUrl'])){
				$kk['imgUrl']= $gth['imgUrl'];
			}
				if(isset($gth['marketingPrice'])){
			if(isset($gth['marketingPrice']['appPrice']['price']['value'])){
				$kk['price_currency']= $gth['marketingPrice']['appPrice']['price']['currency'];
				$kk['price_value']= $gth['marketingPrice']['appPrice']['price']['value'];
			}else{
				$kk['price_currency']= $gth['marketingPrice']['pcPrice']['price']['currency'];
				$kk['price_value']= $gth['marketingPrice']['pcPrice']['price']['value'];
			}
				}else{
				$kk['price_currency']= "";
				$kk['price_value']= "";
				}
			
			if(isset($gth['productId'])){
				$kk['productId']= $gth['productId'];
			}
			if(isset($gth['subject'])){
				$kk['subject']= $gth['subject'];
			}
			if(isset($gth['trade']['tradeCount'])){
				$kk['tradeCount']= $gth['trade']['tradeCount'];
			}				
			$itemsdata[]=$kk;
		}
$bng= $bnga= $totnum= $hashnext= "";		


if(isset($arr['extResult']['refine']['category']['categorys']) && !empty($arr['extResult']['refine']['category']['categorys'])){
		$ftgh= $arr['extResult']['refine']['category']['categorys'];
			foreach($ftgh as $jkla){
				$nnsa= $jkla['id'];
				$nnda= $jkla['name'];
				$bnga[]= array("catid"=>$nnsa, "catname"=>$nnda);
			}
}

if(isset($arr['extResult']['refine']['base']['totalNum']) && !empty($arr['extResult']['refine']['base']['totalNum'])){
	$totnum=$arr['extResult']['refine']['base']['totalNum'];
}
if(isset($arr['extResult']['refine']['base']['hasNext']) && !empty($arr['extResult']['refine']['base']['hasNext'])){
	if($arr['extResult']['refine']['base']['hasNext']){
		$hashnext=$arr['extResult']['refine']['base']['hasNext'];
	}
}	


$thefulldata= array(
"result"=>$totnum,
"nextpage"=>$hashnext,
"brotherCategories"=>$bng,
"subCategories"=>$bnga,
"ContentData"=>$itemsdata
);

	if(file_put_contents($filecached, serialize($thefulldata))){ $rt= "ok"; }
		
	return $thefulldata;
}


function endpoint_single($productid){
	$filecached= dirname(__FILE__)."/temporary-cache/".sha1($productid).".tmp";
if(file_exists($filecached)){
	return unserialize(file_get_contents($filecached));
}
$urljson= 'https://m.aliexpress.com/ajaxapi/product/ajax_detail.do?productId='.$productid;
	$json= IS_CURL($urljson,false);
	$arr= json_decode($json,1);
	if($arr['errorCode'] != 200){ return false; }

$hturl= 'https://www.aliexpress.com/item/-/'.$productid.'.html';	
$htmls= WEB_CURL($hturl, false);
	preg_match_all('~/category/([0-9]+)/([^>]+)>\K.*(?=</a>)~Uis', $htmls, $hasilcat);
	preg_match_all('~<ul class="product-property-list util-clearfix">\K.*(?=</ul>)~Uis', $htmls, $hasilspec);
	preg_match_all('~window.runParams.categoryId="\K.*(?=")~Uis', $htmls, $hasilcatreal);
	preg_match_all('~window.runParams.companyId="\K.*(?=")~Uis', $htmls, $hasilcompanyreal);
	//return $hasilcompanyreal;
	

$seosearch= WEB_CURL('https://www.aliexpress.com/seo/detailCrosslinkAjax.htm?productId='.$productid, false);
	preg_match_all('~<a([^>]+)>\K.*(?=</a>)~Uis', $seosearch, $hasilseo);

		if(!empty($hasilcatreal[0]) && !empty($hasilcompanyreal[0])){
$relatedproduct= WEB_CURL('https://www.aliexpress.com/product/recommend.htm?productId='.$productid.'&sceneId=2056&categoryId='.$hasilcatreal[0][0].'&companyId='.$hasilcompanyreal[0][0], false);
$relarr= json_decode($relatedproduct,1);
			if(isset($relarr[0]['recommendDTOList'])){
				if(!empty($relarr[0]['recommendDTOList'])){
					$data['related']=$relarr[0]['recommendDTOList'];
				}
			}
		}
	
for($i=0; $i < count($hasilcat); $i++){
	$data['category'][$i]['catname']= $hasilcat[0][$i];
	$data['category'][$i]['catid']= $hasilcat[1][$i];
	
}	
if(isset($hasilspec[0][0]) && !empty($hasilspec[0][0])){
	$data['specifics']= $hasilspec[0][0];
}
if(isset($hasilseo[0][0]) && !empty($hasilseo[0][0])){
	unset($hasilseo[0][0]);
		foreach($hasilseo[0] as $ertk){
			$dgshd[]= trim(str_replace('Wholesale', '', $ertk));
		}
	$data['seosearch']= array_unique($dgshd);
}

$data['id']= $productid;	
$data['title']= $arr['mobileProductDetailResult']['subject'];
$data['image']= $arr['mobileProductDetailResult']['productImageUrl'];
$data['sellerid']= $arr['mobileProductDetailResult']['sellerId'];
$data['sellername']= $arr['mobileProductDetailResult']['sellerBasicInfo']['storeName'];
$data['rating']= $arr['mobileProductDetailResult']['ratings'];
$data['pricereal']= $arr['mobileProductDetailResult']['priceOption'][0]['maxAmountPerPiece']['formatedAmount'];
$data['packageinfo']= $arr['mobileProductDetailResult']['packageInfo'];
	if(file_put_contents($filecached, serialize($data))){ $rt= "ok"; }
return $data;
}

function fixslug($str){
	$str= preg_replace('/([^a-z0-9-_]+|-+)/i', '-', $str);
	$str= trim($str);
	return $str;
}

function joincategory($arr){
	if(empty($arr)){ return false; }
foreach($arr as $items){
$data[]= $items['catname'];
}
	return implode(", ", $data);
}

function breadcrumbsgen($arr=""){
	if(empty($arr)){ return false; }
	$data[]= '<a href="/">Home</a>';
foreach($arr as $items){
	$cnm= str_replace("/", "%2F", $items['catname']);
	$data[]= '<a href="/category?cid='.$items['catid'].'&cit='.string2key($items['catid']).'&cnm='.urlencode($cnm).'">'.$items['catname'].'</a>';
}	
	return implode(' &raquo; ', $data);
}


function string2key($str){
	return substr(md5("keyku".$str),0,5);
}

function endpoint_cats($catsid,$pages=1){
$page= ($pages-1)*20;	
	$uri= 'https://m.aliexpress.com/search/mainsearch/asy/GetMainSearchDataJson.do?keyword=&start='.$page.'&freeShipping=false&ignoreSPU=true';
	$uri .= '&pageSize=5&isBigSale=false&categoryId='.$catsid;	
	$filecached= dirname(__FILE__)."/temporary-cache/".sha1($uri).".tmp";
if(file_exists($filecached)){
	return unserialize(file_get_contents($filecached));
}
	
$data= IS_CURL($uri, false);
$arr= json_decode($data,1); //return $arr;
	if(!isset($arr['items'])){ return false; }
$ass= $arr['items'];

		if(isset($ass[20])){
			unset($ass[20]);
		}

		foreach($ass as $gth){
			if(isset($gth['evaluation']['evarageStar'])){
				$kk['evarageStar']= $gth['evaluation']['evarageStar'];
			}
			if(isset($gth['imgUrl'])){
				$kk['imgUrl']= $gth['imgUrl'];
			}
				if(isset($gth['marketingPrice'])){
			if(isset($gth['marketingPrice']['appPrice']['price']['value'])){
				$kk['price_currency']= $gth['marketingPrice']['appPrice']['price']['currency'];
				$kk['price_value']= $gth['marketingPrice']['appPrice']['price']['value'];
			}else{
				$kk['price_currency']= $gth['marketingPrice']['pcPrice']['price']['currency'];
				$kk['price_value']= $gth['marketingPrice']['pcPrice']['price']['value'];
			}
				}else{
				$kk['price_currency']= "";
				$kk['price_value']= "";
				}
			
			if(isset($gth['productId'])){
				$kk['productId']= $gth['productId'];
			}
			if(isset($gth['subject'])){
				$kk['subject']= $gth['subject'];
			}
			if(isset($gth['trade']['tradeCount'])){
				$kk['tradeCount']= $gth['trade']['tradeCount'];
			}				
			$itemsdata[]=$kk;
		}
$bng= $bnga= $totnum= $hashnext= "";		
if(isset($arr['extResult']['refine']['category']['selectedCategory']['brotherCategories']) && !empty($arr['extResult']['refine']['category']['selectedCategory']['brotherCategories'])){
		$ftgh= $arr['extResult']['refine']['category']['selectedCategory']['brotherCategories'];
			foreach($ftgh as $jkl){
				$nns= $jkl['id'];
				$nnd= $jkl['name'];
				$bng[]= array("catid"=>$nns, "catname"=>$nnd);
			}
}

if(isset($arr['extResult']['refine']['category']['selectedCategory']['subCategories']) && !empty($arr['extResult']['refine']['category']['selectedCategory']['subCategories'])){
		$ftgh= $arr['extResult']['refine']['category']['selectedCategory']['subCategories'];
			foreach($ftgh as $jkla){
				$nnsa= $jkla['id'];
				$nnda= $jkla['name'];
				$bnga[]= array("catid"=>$nnsa, "catname"=>$nnda);
			}
}

if(isset($arr['extResult']['refine']['base']['totalNum']) && !empty($arr['extResult']['refine']['base']['totalNum'])){
	$totnum=$arr['extResult']['refine']['base']['totalNum'];
}
if(isset($arr['extResult']['refine']['base']['hasNext']) && !empty($arr['extResult']['refine']['base']['hasNext'])){
	if($arr['extResult']['refine']['base']['hasNext'] >= 1){
		$hashnext=$arr['extResult']['refine']['base']['hasNext'];
	}
}	


$thefulldata= array(
"result"=>$totnum,
"nextpage"=>$hashnext,
"brotherCategories"=>$bng,
"subCategories"=>$bnga,
"ContentData"=>$itemsdata
);

	if(file_put_contents($filecached, serialize($thefulldata))){ $rt= "ok"; }
		
	return $thefulldata;
}



function ali_category($current='',$status=false){
	$allidcat= array(100003109,200003482,200001648,200000775,200000785,200000724,200118010,200000773,200001092,200000782,100003141,200000781,200000777,200000783,200215341,200215336,100003070,100003084,200000707,200000662,200118008,200000668,100003086,200000708,200000599,200000701,200000692,200000673,100003088,200003491,509,200005298,200084017,200126001,200130003,380230,200086021,5090301,200003132,7,200216687,200216607,200216586,200216561,200216551,200215304,200215461,200215462,200002319,200002342,200214206,200002318,100005063,702,70803003,200002320,200004720,717,712,200002321,200002361,44,200216582,200216648,200118003,200216623,200003200,200215272,200216589,200216592,200216598,200010196,200005280,200002394,200002395,200002397,200004414,200002398,200002396,1509,200000109,200000139,100006749,200000097,200132001,200154003,200000161,200188001,15,200002086,3710,405,200154001,100002992,100004814,200003136,100006206,125,200215281,1524,200010063,200010057,152401,152405,200066014,152404,200068019,3803,152409,322,100001606,100001615,200002124,200216407,200002161,200002155,200216391,200002136,200002164,200002253,1501,200000567,200000528,100003199,100003186,200002101,32212,100001118,200003594,200003592,100002964,200003595,200000774,200166001,18,200214332,200005276,200214370,200094001,200005059,200005102,100005433,200003570,200005101,100005444,100005259,100005322,100005460,100005471,100005383,100005663,200005143,200005156,100005479,100005599,200001095,200001115,100005575,66,200002489,200002547,660103,200002496,3306,200002458,660302,200003045,200074001,200003551,200002444,200002454,3305,1513,200002569,1511,200214006,200214036,200214047,200214043,361120,200000084,200214074,26,200002639,200003225,100001626,100001625,100001623,2621,200002633,100001663,100001622,100001629,200003226,200002636,100003235,100003269,100005792,100005791,200001520,100005624,200001553,100005790,200001554,100003270,100005823,200001556,200000875,200001270,200001271,100003240,200003410,200001355,200001096,34,200000191,200000369,200216017,200004619,200004620,200000408,3015,200214451,39,200214033,1504,150402,390501,150401,200003575,390503,200003009,39050508,39050501,200003210,200002283,200216091,530,1503,150303,150304,100001203,150302,150301,200216366,100001146,3712,150306,3708,502,4001,150412,4003,504,150407,4002,515,4004,4099,4005,21,100003836,2202,211111,200003198,100003819,211106,100003804,200003197,200003238,100003745,100003809,2115,200003196,212002,100005094,13,1420,6,30,100006479,200215252,42,5,200003230,2,200114002,200216447,289,200002418,238,200216453,200216448,200002419,200216454,100006182,200215432,200215419,3030,200003251,3009,3012,3019,3011,3007);
		if(!$status){ return $allidcat; }
	$aliexpress_cat= array(100003109 => "Women's Clothing & Accessories",200003482 => "Dresses",200001648 => "Blouses & Shirts",200000775 => "Jackets & Coats",200000785 => "Tops & Tees",200000724 => "Accessories",200118010 => "Bottoms",200000773 => "Intimates",200001092 => "Jumpsuits",200000782 => "Suits & Sets",100003141 => "Hoodies & Sweatshirts",200000781 => "Socks & Hosiery",200000777 => "Sleep & Lounge",200000783 => "Sweaters",200215341 => "Rompers",200215336 => "Bodysuits",100003070 => "Men's Clothing & Accessories",100003084 => "Hoodies & Sweatshirts",200000707 => "Tops & Tees",200000662 => "Jackets & Coats",200118008 => "Pants",200000668 => "Shirts",100003086 => "Jeans",200000708 => "Underwear",200000599 => "Accessories",200000701 => "Sweaters",200000692 => "Suits & Blazers",200000673 => "Sleep & Lounge",100003088 => "Shorts",200003491 => "Socks",509 => "Phones & Telecommunications",200005298 => "Mobile Phone LCDs",200084017 => "Mobile Phone Accessories",200126001 => "Communication Equipments",200130003 => "Mobile Phone Touch Panel",380230 => "Phone Bags & Cases",200086021 => "Mobile Phone Parts",5090301 => "Mobile Phones",200003132 => "Power Bank",7 => "Computer & Office",200216687 => "Desktop",200216607 => "Tablet",200216586 => "Internal Storage",200216561 => "Cables & Connectors",200216551 => "Gaming Laptops",200215304 => "Memory Cards & SSD",200215461 => "DIY Gaming PC",200215462 => "Bluetooth Receiver/Wireless Adapter",200002319 => "Computer Components",200002342 => "Computer Peripherals",200214206 => "Demo Board",200002318 => "Desktops & Servers",100005063 => "Laptop Accessories",702 => "Laptops",70803003 => "Mini PCs",200002320 => "Networking",200004720 => "Office Electronics",717 => "Other Computer Products",712 => "Software",200002321 => "Storage Devices",200002361 => "Tablet Accessories",44 => "Consumer Electronics",200216582 => "Camcorders",200216648 => "Sports & Action Video Cameras",200118003 => "Camera Drones & Accessories",200216623 => "Earphones & Headphones",200003200 => "Digital Cables",200215272 => "VR/AR Devices",200216589 => "Digital Cameras",200216592 => "360 Video Cameras",200002321 => "Storage Devices",200216598 => "Home Electronic Accessories",200010196 => "Smart Electronics",200005280 => "Electronic Cigarettes",200002394 => "Accessories & Parts",200002395 => "Camera & Photo",200002397 => "Home Audio & Video",200004414 => "Other Consumer Electronics",200002398 => "Portable Audio & Video",200002396 => "Video Games",1509 => "Jewelry & Accessories",200000109 => "Necklaces & Pendants",200000139 => "Earrings",100006749 => "Rings",200000097 => "Bracelets & Bangles",200132001 => "Jewelry Sets & More",200154003 => "Beads & Jewelry Making",200000161 => "Wedding & Engagement Jewelry",200188001 => "Fine Jewelry",15 => "Home & Garden",200002086 => "Kitchen,Dining & Bar",3710 => "Home Decor",405 => "Home Textile",200154001 => "Arts,Crafts & Sewing",100002992 => "Festive & Party Supplies",100004814 => "Bathroom Products",200003136 => "Housekeeping & Organization",100006206 => "Pet Products",125 => "Garden Supplies",200215281 => "Household Merchandises",1524 => "Luggage & Bags",200010063 => "Women's Bags",200010057 => "Men's Bags",152401 => "Backpacks",152405 => "Wallets",200066014 => "Kids & Baby's Bags",152404 => "Luggage & Travel Bags",200068019 => "Functional Bags",3803 => "Coin Purses & Holders",152409 => "Bag Parts & Accessories",322 => "Shoes",100001606 => "Women's Shoes",100001615 => "Men's Shoes",200002124 => "Shoe Accessories",200216407 => "Women's Boots",200002161 => "Women's Pumps",200002155 => "Women's Flats",200216391 => "Men's Boots",200002136 => "Men's Casual Shoes",200002164 => "Women's Vulcanize Shoes",200002253 => "Men's Vulcanize Shoes",1501 => "Mother & Kids",200000567 => "Baby Girls Clothing",200000528 => "Baby Boys Clothing",100003199 => "Girls Clothing",100003186 => "Boys Clothing",200002101 => "Baby Shoes",32212 => "Children's Shoes",100001118 => "Baby Care",200003594 => "Activity & Gear",200003592 => "Safety",100002964 => "Baby Bedding",200003595 => "Feeding",200000774 => "Maternity",200166001 => "Family Matching Outfits",18 => "Sports & Entertainment",200214332 => "Sports Bags",200005276 => "Sneakers",200214370 => "Sport Accessories",200094001 => "Team Sports",200005059 => "Racquet Sports",200005102 => "Bowling",100005433 => "Camping & Hiking",200003570 => "Cycling",200005101 => "Entertainment",100005444 => "Fishing",100005259 => "Fitness & Body Building",100005322 => "Golf",100005460 => "Horse Racing",100005471 => "Hunting",100005383 => "Musical Instruments",100005663 => "Other Sports & Entertainment Products",200005143 => "Roller,Skate board &Scooters",200005156 => "Running",100005479 => "Shooting",100005599 => "Skiing & Snowboarding",200001095 => "Sports Clothing",200001115 => "Swimming",100005575 => "Water Sports",66 => "Beauty & Health",200002489 => "Hair Extensions & Wigs",200002547 => "Nails & Tools",660103 => "Makeup",200002496 => "Health Care",3306 => "Skin Care",200002458 => "Hair Care & Styling",660302 => "Shaving & Hair Removal",200003045 => "Sex Products",200074001 => "Beauty Essentials",200003551 => "Tattoo & Body Art",200002444 => "Bath & Shower",200002454 => "Fragrances & Deodorants",3305 => "Oral Hygiene",1513 => "Sanitary Paper",200002569 => "Tools & Accessories",1511 => "Watches",200214006 => "Men's Watches",200214036 => "Women's Watches",200214047 => "Lover's Watches",200214043 => "Children's Watches",361120 => "Pocket & Fob Watches",200000084 => "Watch Accessories",200214074 => "Women's Bracelet Watches",26 => "Toys & Hobbies",200002639 => "Remote Control Toys",200003225 => "Dolls & Stuffed Toys",100001626 => "Classic Toys",100001625 => "Learning & Education",100001623 => "Outdoor Fun & Sports",2621 => "Action & Toy Figures",200002633 => "Models & Building Toy",100001663 => "Diecasts & Toy Vehicles",100001622 => "Baby Toys",100001629 => "Electronic Toys",200003226 => "Puzzles & Magic Cubes",200002636 => "Novelty & Gag Toys",100003235 => "Weddings & Events",100003269 => "Wedding Dresses",100005792 => "Evening Dresses",100005791 => "Prom Dresses",200001520 => "Wedding Party Dress",100005624 => "Wedding Accessories",200001553 => "Celebrity-Inspired Dresses",100005790 => "Cocktail Dresses",200001554 => "Homecoming Dresses",100003270 => "Bridesmaid Dresses",100005823 => "Mother of the Bride Dresses",200001556 => "Quinceanera Dresses",200000875 => "Novelty & Special Use",200001270 => "Costumes & Accessories",200001271 => "Exotic Apparel",100003240 => "Stage & Dance Wear",200003410 => "Traditional Chinese Clothing",200001355 => "Work Wear & Uniforms",200001096 => "World Apparel",34 => "Automobiles & Motorcycles",200000191 => "Auto Replacement Parts",200000369 => "Car Electronics",200216017 => "Tools, Maintenance & Care",200004619 => "Interior Accessories",200004620 => "Exterior Accessories",200000408 => "Motorcycle Accessories & Parts",3015 => "Roadway Safety",200214451 => "Other Vehicle Parts & Accessories",39 => "Lights & Lighting",200214033 => "Lamps & Shades",1504 => "Ceiling Lights & Fans",150402 => "Light Bulbs",390501 => "LED Lighting",150401 => "Outdoor Lighting",200003575 => "LED Lamps",390503 => "Portable Lighting",200003009 => "Commercial Lighting",39050508 => "Night Lights",39050501 => "Book Lights",200003210 => "Professional Lighting",200002283 => "Novelty Lighting",200216091 => "Holiday Lighting",530 => "Lighting Accessories",1503 => "Furniture",150303 => "Home Furniture",150304 => "Office Furniture",100001203 => "Children Furniture",150302 => "Outdoor Furniture",150301 => "Commercial Furniture",200216366 => "Caf&eacute; Furniture",100001146 => "Bar Furniture",3712 => "Furniture Accessories",150306 => "Furniture Hardware",3708 => "Furniture Parts",502 => "Electronic Components & Supplies",4001 => "Active Components",150412 => "EL Products",4003 => "Electronic Accessories & Supplies",504 => "Electronic Data Systems",150407 => "Electronic Signs",4002 => "Electronics Production Machinery",515 => "Electronics Stocks",4004 => "Optoelectronic Displays",4099 => "Other Electronic Components",4005 => "Passive Components",21 => "Office & School Supplies",100003836 => "Adhesives & Tapes",200004720 => "Office Electronics",2202 => "Books",150304 => "Office Furniture",211111 => "Painting Supplies",200003198 => "Calendars, Planners & Cards",100003819 => "Cutting Supplies",211106 => "Desk Accessories & Organizer",100003804 => "Filing Products",200003197 => "Labels, Indexes & Stamps",200003238 => "Mail & Shipping Supplies",100003745 => "Notebooks & Writing Pads",100003809 => "Office Binding Supplies",2115 => "Other Office & School Supplies",200003196 => "Pens, Pencils & Writing Supplies",212002 => "Presentation Boards",100005094 => "School & Educational Supplies",13 => "Home Improvement",39 => "Lights & Lighting",1420 => "Tools",6 => "Home Appliances",30 => "Security & Protection",100006479 => "Bathroom Fixtures",200215252 => "Kitchen Fixtures",42 => "Hardware",5 => "Electrical Equipment & Supplies",200003230 => "Building Supplies",2 => "Food",200114002 => "Medlar",200216447 => "Canned Food",289 => "Coffee",200002418 => "Dried Fruit",238 => "Grain Products",200216453 => "Honey",200216448 => "Jam",200002419 => "Nut & Kernel",200216454 => "Oils",100006182 => "Tea",30 => "Security & Protection",200215432 => "Security Alarm",200215419 => "Door Intercom",3030 => "Access Control",200003251 => "Emergency Kits",3009 => "Fire Protection",3012 => "Safes",3019 => "Self Defense Supplies",3011 => "Video Surveillance",3007 => "Workplace Safety Supplies");
		if(empty($current)){
			return $aliexpress_cat;
		}
	if(isset($aliexpress_cat[$current])){
		return $aliexpress_cat[$current];
	}else{
		return false;
	}	
			return $aliexpress_cat;
}



function WEB_CURL($url, $iscache=true){
		if($iscache){
	$filecached= "temporary-cache/".md5($url).".tmp";
if(file_exists($filecached)){
	return file_get_contents($filecached);
}	
		}
			$referer= "https://www.aliexpress.com/";
	$data = curl_init();
	$header[0] = "Accept: text/xml,application/xml,application/xhtml+xml,";
	$header[0] .= "text/html;q=0.9,text/plain;q=0.8,image/png,*/*;q=0.5";
	$header[] = "Cache-Control: max-age=0";
	$header[] = "Connection: keep-alive";
	$header[] = "Keep-Alive: 300";
	$header[] = "Accept-Charset: ISO-8859-1,utf-8;q=0.7,*;q=0.7";
	$header[] = "Accept-Language: en-us,en;q=0.5";
	$header[] = "Pragma: "; // browsers keep this blank.

     curl_setopt($data, CURLOPT_SSL_VERIFYHOST, FALSE);
     curl_setopt($data, CURLOPT_SSL_VERIFYPEER, FALSE);
     curl_setopt($data, CURLOPT_URL, $url);
     curl_setopt($data, CURLOPT_USERAGENT, '​Mozilla/5.0 (compatible; Googlebot/2.1; +http://www.google.com/bot.html)');
	 curl_setopt($data, CURLOPT_HTTPHEADER, $header);
	 curl_setopt($data, CURLOPT_REFERER, $referer);
	 curl_setopt($data, CURLOPT_ENCODING, 'gzip,deflate');
	 curl_setopt($data, CURLOPT_AUTOREFERER, true);
	 curl_setopt($data, CURLOPT_RETURNTRANSFER, 1);
	 curl_setopt($data, CURLOPT_CONNECTTIMEOUT, 60);
	 curl_setopt($data, CURLOPT_TIMEOUT, 60);
	 curl_setopt($data, CURLOPT_MAXREDIRS, 7);
	 curl_setopt($data, CURLOPT_FOLLOWLOCATION, true);
curl_setopt($data, CURLOPT_COOKIEJAR, dirname(__FILE__).'/devtemps/cookies.txt');
curl_setopt($data, CURLOPT_COOKIEFILE, dirname(__FILE__).'/devtemps/cookies.txt');
     $hasil = curl_exec($data);
     curl_close($data);
	 if($iscache){
if(file_put_contents($filecached, $hasil)){
	$brankas="OK";
}	 
	 }
	 return $hasil;
}


function IS_CURL($url, $iscache=true){
		if($iscache){
	$filecached= "temporary-cache/".md5($url).".tmp";
if(file_exists($filecached)){
	return file_get_contents($filecached);
}	
		}
			$referer= "https://m.aliexpress.com/";
	$data = curl_init();
	$header[0] = "Accept: text/xml,application/xml,application/xhtml+xml,";
	$header[0] .= "text/html;q=0.9,text/plain;q=0.8,image/png,*/*;q=0.5";
	$header[] = "Cache-Control: max-age=0";
	$header[] = "Connection: keep-alive";
	$header[] = "Keep-Alive: 300";
	$header[] = "Accept-Charset: ISO-8859-1,utf-8;q=0.7,*;q=0.7";
	$header[] = "Accept-Language: en-us,en;q=0.5";
	$header[] = "Pragma: "; // browsers keep this blank.

     curl_setopt($data, CURLOPT_SSL_VERIFYHOST, FALSE);
     curl_setopt($data, CURLOPT_SSL_VERIFYPEER, FALSE);
     curl_setopt($data, CURLOPT_URL, $url);
     curl_setopt($data, CURLOPT_USERAGENT, '​Mozilla/5.0 (Linux; Android 6.0.1; Nexus 5X Build/MMB29P) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/41.0.2272.96 Mobile Safari/537.36 (compatible; Googlebot/2.1; +http://www.google.com/bot.html)');
	 curl_setopt($data, CURLOPT_HTTPHEADER, $header);
	 curl_setopt($data, CURLOPT_REFERER, $referer);
	 curl_setopt($data, CURLOPT_ENCODING, 'gzip,deflate');
	 curl_setopt($data, CURLOPT_AUTOREFERER, true);
	 curl_setopt($data, CURLOPT_RETURNTRANSFER, 1);
	 curl_setopt($data, CURLOPT_CONNECTTIMEOUT, 60);
	 curl_setopt($data, CURLOPT_TIMEOUT, 60);
	 curl_setopt($data, CURLOPT_MAXREDIRS, 7);
	 curl_setopt($data, CURLOPT_FOLLOWLOCATION, true);
curl_setopt($data, CURLOPT_COOKIEJAR, dirname(__FILE__).'/devtemps/cookies.txt');
curl_setopt($data, CURLOPT_COOKIEFILE, dirname(__FILE__).'/devtemps/cookies.txt');
     $hasil = curl_exec($data);
     curl_close($data);
	 if($iscache){
if(file_put_contents($filecached, $hasil)){
	$brankas="OK";
}	 
	 }
	 return $hasil;
}