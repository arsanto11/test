<?php
//index.php
error_reporting(0);
@ini_set('display_errors', 0);
date_default_timezone_set('Asia/Jakarta');

$pages=1; $CATEGORY_NAME= "Untitle";$ifcatname=false; $pagesname="";

if(isset($_GET['page']) && !empty($_GET['page']) && is_numeric($_GET['page']) && isset($_GET['token']) && !empty($_GET['token']) && strlen($_GET['token']) == 5){
	if($_GET['page'] >= 2){
		$pages= $_GET['page'];
		$pagesname= " Pages ".$pages;
			$pageto_token= substr(md5("keyku".$pages),0,5);
				if($pageto_token != $_GET['token']){
					header("Location: /"); exit();
				}
	}
}



include "func.php";

	if(isset($_GET['pagetype']) && isset($_GET['cid']) && isset($_GET['cit']) && isset($_GET['cnm']) && !empty($_GET['pagetype']) && !empty($_GET['cid']) && !empty($_GET['cit']) && !empty($_GET['cnm'])){
		$cid_token= substr(md5("keyku".$_GET['cid']),0,5);
			if($cid_token != $_GET['cit']){
				header("Location: /"); exit();
			}else{
	if (isset($_SERVER['HTTP_IF_MODIFIED_SINCE'])){
		header('HTTP/1.1 304 Not Modified');
        die();
	} 
header('Cache-control: public, max-age=622080000');
header('Expires: '.gmdate(DATE_RFC1123,time()+622080000));
header('Last-Modified: '.gmdate(DATE_RFC1123,time()));
header('Vary: Accept');
header('Accept-Encoding: gzip, deflate');
				
				$current_cat= $_GET['cid'];
				$CATEGORY_NAME= $_GET['cnm'];
				$ifcatname= true;
			}
	}else{
$alcat= ali_category();
shuffle($alcat);
$current_cat= $alcat[0];
	}
$cat_token= substr(md5("keyku".$current_cat),0,5);	
$html_scr= endpoint_cats($current_cat, $pages);



	if(!$ifcatname){
$CATEGORY_NAME= ali_category($current_cat,true);
	}


if(!isset($html_scr['ContentData']) || empty($html_scr['ContentData'])){
	header("Location: /"); exit();
}

$contentdata= $html_scr['ContentData'];

$nextpage= $pages+1;
$nexttoken= substr(md5("keyku".$nextpage),0,5);
$CATEGORY_NAMES= str_replace("/", "%2F", $CATEGORY_NAME);

$morecats="";
if(!empty($html_scr['subCategories'])){
	$morecats= $html_scr['subCategories'];
}elseif(!empty($html_scr['brotherCategories'])){
	$morecats= $html_scr['brotherCategories'];
}

	if($ifcatname){
$pagestitle= "Shopping Online ".$CATEGORY_NAME." Category".$pagesname;
$metadesc= "Recommended ".$CATEGORY_NAME.", Browse Through Our Directory of ".$CATEGORY_NAME.$pagesname.", ".joincategory($morecats).", Worldwide Shipping!";
	}else{
$pagestitle= "Flash Deals Homepage";
$metadesc= "Automotive, Phones, Accessories, Computers, Electronics, Fashion, Beauty, Health, Home, Garden, Toys , Sports, Weddings, Events.";
	}
$Coninnal= $_SERVER['REQUEST_URI'];	
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no">
<meta property="og:site_name" itemprop="name" content="<?php echo $_SERVER['SERVER_NAME'];?>" />
<meta itemprop="url" content="<?php echo $Coninnal;?>" />
<title><?php echo $pagestitle;?></title>
<meta property="og:title" content="<?php echo $pagestitle;?>" />
<meta property="og:type" content="product" />
<meta property="og:url" content="<?php echo $Coninnal;?>" />
<meta property="og:description" content="<?php echo $metadesc;?>" />
<link rel="shortcut icon" href="/favicon.ico" type="image/x-icon">
<link rel="icon" href="/favicon.ico" type="image/x-icon">
<meta name="description" content="<?php echo $metadesc;?>" />
<link rel="canonical" href="<?php echo $Coninnal;?>" />
<?php
if($pages >= 2){
	echo '<meta name="robots" content="NOINDEX,FOLLOW,NOARCHIVE,NOODP,NOYDIR,NOTRANSLATE"/>';
}
?>
<style>
*,body{font-family:Arial,Helvetica Neue,Helvetica,sans-serif;padding:0;margin:0;line-height:22px}*,*::after,*::before{box-sizing:border-box}a,input,select{text-decoration:none;outline:0;color:#000}select:-moz-focusring{color:transparent;text-shadow:0 0 0 #000}select{-webkit-appearance:none;-moz-appearance:none;-ms-appearance:none;-o-appearance:none;appearance:none;text-indent:1px;text-overflow:'';background:#f2f2f2}select::-ms-expand{display:none}.wrap,.h-wrap{max-width:980px;margin:auto}.wrap{padding-bottom:20px}.h-wrap{padding:10px 0}.fluid{padding-right:15px;padding-left:15px;margin-right:auto;margin-left:auto}.main-header{width:100%;background:#2e88d0}.mc-header{max-width:980px;margin:auto}.omjonilogo{float:left;width:212px;height:70px;background:url(https://i.imgur.com/tstUpap.png) no-repeat 0 center}.mc-link{float:right;width:40px;height:40px;margin-top:15px;border-radius:5px;background:#fff no-repeat center}.cheader{width:100%;background:#eee;border-bottom:1px solid #ddd}.header{max-width:980px}.sheader{max-width:980px;padding:4px 0;font-size:12px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;-o-text-overflow:ellipsis}.bborder{border-bottom:1px dotted #ccc}.product-info,.product-related,.share-info{max-width:980px;margin-top:12px}.product-related{height:40px;background:url(../images/232134510.gif) no-repeat center}.share-info{float:left;margin-top:20px}.share-info .shtext,.share-info .smicons{float:left}.share-info .shtext{white-space:nowrap;margin-right:6px;font-size:14px;font-weight:700;color:#888}.share-info .smicons{width:48px;height:48px;margin:0 5px;border-radius:4px;box-shadow:0 0 4px #ddd}.share-info .tw{background:url(../images/a29cf8bdd321.png) no-repeat 0 0}.share-info .fb{background:url(../images/a29cf8bdd321.png) no-repeat -48px 0}.share-info .gp{background:url(../images/a29cf8bdd321.png) no-repeat -96px 0}.product-title{max-width:980px;padding:8px 0 5px;font-weight:700;font-size:18px;color:#2e88d0;border-bottom:1px dotted #ccc}.product-content{max-width:980px;padding:8px 0 5px;font-size:16px;word-wrap:break-word;line-height:24px}.product-content ul{padding-left:16px;list-style:outside}.product-content ul li{line-height:24px;word-wrap:break-word}.product-content table{width:100%;border-collapse:collapse;padding:0;margin:0;border:0;font-size:13px}.product-content table tr th{width:25%;padding:8px;padding-left:0;text-align:left;vertical-align:top;border-bottom:1px dotted #ccc;word-wrap:break-word;color:#666}.product-content table tr td{padding:8px;padding-right:0;border-bottom:1px dotted #ccc;word-wrap:break-word}.sheader a{color:#2e88d0}.sheader a:hover{color:#ff5c00;text-decoration:underline}.m-select{float:left;width:25%;height:40px;border:0;padding:10px 30px 10px 4px;border-radius:3px 0 0 3px;border:1px solid #ccc;background:#f2f2f2 url(../images/1454584.png) no-repeat right center}.m-select option{padding:2px 0;text-indent:5px}.m-input{float:left;width:90%;height:40px;border:0;padding:8px;border-top:1px solid #ccc;border-bottom:1px solid #ccc}.m-submit,.f-submit{float:left;width:10%;height:40px;background:#2e88d0;padding:7px 4px;font-weight:700;color:#fff;border-radius:0 3px 3px 0;border:1px solid #2e88d0;cursor:pointer}.f-submit{float:right;width:auto;height:38px;border-radius:3px;padding:6px 26px}.c-slct{font-weight:400}.sc-slct{padding-left:5px}.itemLists{margin-bottom:10px;margin-left:-2.5%}.items{position:relative;float:left;margin:1.25% 0 1.25% 2.5%;background:#f5f5f5;box-shadow:0 0 4px #ddd;border:1px solid #ccc;font-size:100%;border-radius:3px}.empty-result{margin:10px 0 10px 2.5%;padding:40px 0;font-size:16px;text-align:center;background:#f2f2f2;border-radius:4px}.cItems{width:100%;padding-left:5px;padding-right:5px}.pImg{position:relative;vertical-align:middle;background:#fff;border-radius:3px 3px 0 0;border-bottom:1px solid #ccc;width:100%;height:161px}.pImg a{top:0;left:0;position:absolute;width:100%;height:100%}.pImg img{margin:auto;position:absolute;top:0;left:0;bottom:0;right:0;max-width:100%;max-height:160px}.m-title{font-size:16px;word-wrap:break-word;text-shadow:1px 1px 1px #fff;overflow:hidden;height:44px;margin-bottom:5px}.m-price{position:relative;font-size:18px;text-align:center;color:#ff5c00;padding:5px 0 15px;cursor:default}.m-price .m-discount{position:absolute;font-size:12px;padding:3px 6px;line-height:12px;margin-left:6px;background:#ff5c00;color:#fff;border-radius:2px 2px 10px 10px}.m-price .m-oriprice{margin:auto;top:24px;left:0;bottom:0;right:0;position:absolute;font-size:12px;text-decoration:line-through;color:#aaa}.m-title a{display:block;width:100%;color:#2e88d0;word-wrap:break-word;padding-top:5px;text-align:center;line-height:19px}.m-title a:hover{color:#ff5c00}.m-info{padding:4px 0;border-top:1px dotted #ccc;margin-top:5px;cursor:default}.m-seller,.m-shop{color:#fff;padding:2px 4px;font-weight:700;font-size:11px;border-radius:3px}.m-seller{float:left;max-width:60%;background:#2e88d0;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;-o-text-overflow:ellipsis}.m-seller:hover{background:#ddd;color:#2e88d0}.m-shop{float:right;background:#ff5c00}.title,.lists,.slists{max-width:980px;padding:12px 0;border-top:1px dotted #ccc;border-bottom:1px dotted #ccc;font-size:20px}.box-message{max-width:980px;border-top:1px dotted #ccc}.message{max-width:980px;padding:8px 8px;margin:4px 0;font-size:14px;text-align:center;font-weight:700;background:#fef5c1;border:1px solid #dece90}.m-rdr{max-width:980px;min-height:250px;margin:30px 0 10px}.cm-rrdr{float:right;width:38.3%}.cm-lrdr{float:left;width:60%}.rdr-text{font-size:14px;text-align:center;color:#777}.rdr-m-pgrb{position:relative;margin-top:8px;width:100%;height:26px;background:#f2f2f2;box-shadow:1px 2px 2px #ccc inset;border-radius:6px;overflow:hidden}.rdr-pgrb{position:absolute;width:0;top:0;left:0;height:26px;box-shadow:1px 2px 2px #ccc;background:#f2f2f2 url(../images/prgbar.gif) repeat-x 0 0}.rdr-notes{margin-top:8px;font-size:14px;text-align:justify;line-height:18px}.lists{padding:12px 0 6px}.catLnk,.mainLnk{width:100%;padding:6px 0;border-bottom:1px dotted #ccc}.mainLnk{width:auto;margin:6px 0 0 2.5%}.catUL{list-style:none;padding:8px 0 6px}.catUL li{padding:2px 0}.catLnk a,.mainLnk a{color:#2e88d0;font-size:18px}.catLnk a:hover,.mainLnk:hover a{color:#ff5c00}.catUL a{display:block;font-size:13px;font-weight:700;background:#f2f2f2;padding:6px 0 6px 8px;border:1px solid #ccc;width:100%;border-radius:20px 0 20px 0}.catUL a:hover{color:#2e88d0}.slists{border-top:0;padding:6px 0}.s-lists{position:relative;height:38px;border:1px solid #ccc;border-radius:3px;background:#f2f2f2}.ls-label{position:absolute;width:90px;height:36px;top:0;left:0;text-align:left;padding:7px;background:#fff;border-radius:3px 0 0 3px;white-space:nowrap;font-size:13px}.mid-list{margin-left:8px}.ls-left{float:left}.ls-right{float:right}.s-select,.s-input{border:0;padding-left:90px}.s-input{width:329.5px}.ls-select{width:100%;height:36px;border:0;padding:7px 28px 7px 7px;border-left:1px solid #ccc;border-radius:0 3px 3px 0;font-size:13px;background:#f2f2f2 url(../images/1454584.png) no-repeat right center}.ls-input{float:left;width:119.6px;border:0;padding:7px 13px;border-left:1px solid #ccc;border-radius:0 3px 3px 0;font-size:13px;background:#f2f2f2}.ls-select option{padding:2px 0;text-indent:7px}.ls-hide{display:none}.m-gallery,.gallery{float:left;position:relative;top:0;left:0}.m-gallery{margin-top:15px}.gallery{width:100%;border-radius:3px;box-shadow:0 1px 5px #ccc;border:1px solid #ccc;font-size:100%;overflow:hidden;height:395px}.galleryImg{position:relative;vertical-align:middle;background:#fff;border-bottom:1px solid #ccc;border-radius:4px;width:100%;height:395px}.galleryImg img{margin:auto;position:absolute;top:0;left:0;bottom:0;right:0;max-width:100%;max-height:394px}.m-thumbnail{float:left;width:100%;margin-top:10px;overflow:hidden;max-height:70px}.p-thumbnail{float:left;position:relative;vertical-align:middle;background:#fff;border-bottom:1px solid #ccc;width:70px;height:70px;box-shadow:0 0 4px #ddd;margin:0 2px;border:1px solid #ccc;border-radius:3px;cursor:pointer}.thumbnail{margin:auto;position:absolute;top:0;left:0;bottom:0;right:0;max-width:64px;max-height:64px}.info-nogrid,.info-grid{width:100%;padding-bottom:12px}.info-grid{padding:4px 0 10px;border-bottom:1px dotted #ccc;line-height:14px}.font-price{font-size:30px;color:#ff5c00}.font-price span{display:block;font-size:12px;color:#999;padding-top:10px}.font-oriprice{padding:7px 0 10px;font-size:18px;color:#aaa}.font-oriprice span.linethrough{text-decoration:line-through}.font-oriprice span.disc{padding:10px 15px;margin-left:10px;background:#ff5c00;color:#fff;font-weight:700;font-size:12px;font-weight:700;border-radius:6px}.font-seller{font-size:18px;color:#999}.font-seller div.prwr{float:left;width:100%}.font-seller span.powr{display:block;padding-bottom:4px;font-size:12px;font-weight:700;color:#aaa}.font-seller span.g-seller,.font-seller span.g-shop{float:left;padding:4px 8px;font-size:12px;font-weight:700;color:#fff;border-radius:3px}.font-seller span.g-seller{background:#2e88d0}.font-seller span.g-shop{margin-top:6px;background:#ff5c00}.font-updated{font-size:16px;font-weight:700;color:#999}.font-updated span{display:block;padding-bottom:4px;font-size:12px;color:#aaa}.font-ketoko{display:block;width:100%;padding:8px;background:#287dc1;font-size:14px;font-weight:700;border:1px solid #2c5678;border-radius:2px;color:#fff;text-align:center;margin-top:12px}.box-similar{width:100%;text-align:center}.font-similar{padding:10px 16px;background:#287dc1;font-size:14px;font-weight:700;border:1px solid #2c5678;border-radius:2px;color:#fff;text-align:center}.font-ketoko:hover,.font-similar:hover{background:#eee;color:#2c5678}.p-thumbnail:hover{border:1px solid #2e88d0}.info{position:relative;float:right;margin-top:18px;font-size:100%;border-radius:3px}.page-info-left{float:left;width:25%;border:1px solid #ccc;margin-top:15px;border-radius:3px;background:#f5f5f5}.page-info-left a:last-child{border:0}.page-info-right{float:right;width:70%;margin-top:10px}.page-info-main{min-height:247px;border:1px solid #ccc;padding:5px 12px 12px;margin-left:-7.3%;background:#fff;font-size:13px;text-align:justify;border-radius:3px}.page-info-main .page-title{border-bottom:1px dotted #ccc;font-size:16px;padding-bottom:5px;margin-bottom:5px}.page-info-main ul{padding-left:12px;list-style:square outside none}.page-info-left a,.page-info-main a{color:#2e88d0}.page-info-left a{display:block;font-size:12px;padding:8px 12px;border-bottom:1px dotted #ccc}.page-info-left a:hover,.page-info-main a:hover{text-decoration:underline;color:#ff5c00}.pagination{border-top:1px dotted #ccc;text-align:center;margin-left:2.5%}.time-paging{padding-top:5px;text-align:center;font-size:14px;color:#aaa}.paging{display:inline-block;list-style:none;margin:5px 0}.paging li{display:inline}.paging li a,.paging li div,.paging li .selected{position:relative;float:left;padding:6px 12px;margin-left:-1px;line-height:1.42857;color:#337ab7;font-size:14px;font-weight:700;text-decoration:none;background-color:#fff;border:1px solid #ddd}.paging li .selected{background:#337ab7;color:#fff}.paging li a.prev,.paging li div.prev-disabled,.paging li a.next,.paging li div.next-disabled{width:34px;height:34px}.paging li a.prev,.paging li div.prev-disabled{border-radius:5px 0 0 5px}.paging li a.prev{background:url(../images/arrow.png) no-repeat -3px -3px}.paging li div.prev-disabled{background:url(../images/arrow.png) no-repeat -3px -41px}.paging li a.next,.paging li div.next-disabled{border-radius:0 5px 5px 0}.paging li a.next{background:url(../images/arrow.png) no-repeat -41px -3px}.paging li div.next-disabled{background:url(../images/arrow.png) no-repeat -41px -41px}.paging li a:hover{background:#eee}.paging li a.prev:hover{background:#eee url(../images/arrow.png) no-repeat -3px -3px}.paging li a.next:hover{background:#eee url(../images/arrow.png) no-repeat -41px -3px}.m-footer{width:100%}.p-footer{background:#f5f5f5;border-top:1px solid #ccc;border-bottom:1px solid #ccc}.footer{max-width:980px;margin:auto}.foot-desc,.foot-copyright{font-size:11px;padding:8px 0;line-height:12px;color:#777}.foot-copyright{font-size:12px;padding:0 0 10px;color:#333}.foot-copyright span{color:#2e88d0}.foot-links{float:left;width:70%}.foot-sm,.foot-psm{float:right}.foot-psm{width:175px;height:28px}.foot-sm{margin:9px 0}.foot-follow{float:right;font-size:12px;font-weight:700;color:#777;margin:3px 5px 3px 0;white-space:nowrap}.foot-icon{float:right;width:28px;height:28px;margin-left:5px}.ftw{background:url(https://i0.wp.com/image.prntscr.com/image/e32997b2247845ec989b0e3626930204.png) no-repeat 0 0}.ffb{background:url(https://i0.wp.com/image.prntscr.com/image/e32997b2247845ec989b0e3626930204.png) no-repeat 0 -28px}.fgp{background:url(https://i0.wp.com/image.prntscr.com/image/e32997b2247845ec989b0e3626930204.png) no-repeat 0 -56px}.ftw:hover{background:url(https://i0.wp.com/image.prntscr.com/image/e32997b2247845ec989b0e3626930204.png) no-repeat -28px 0}.ffb:hover{background:url(https://i0.wp.com/image.prntscr.com/image/e32997b2247845ec989b0e3626930204.png) no-repeat -28px -28px}.fgp:hover{background:url(https://i0.wp.com/image.prntscr.com/image/e32997b2247845ec989b0e3626930204.png) no-repeat -28px -56px}.foot-links a{display:inline-block;padding:12px 0;font-size:12px;color:#2e88d0}.foot-links a:hover{color:#ff5c00;text-decoration:underline}.foot-links span{position:relative;display:inline-block;width:2px;height:16px;margin:0 6px;top:3px;border-left:1px solid #ccc;border-right:1px solid #fff}.adsPages{margin-top:12px;overflow:hidden}.fit-in{}.adsItems{clear:both;margin-left:2.5%;overflow:hidden}.clear{clear:both}@media only screen and (min-width:200px) and (max-width:767px){.itemLists,.mainLnk{margin:0}.items{width:48%;margin:8px 2px 2.5%}.m-gallery,.share-info,.info,.cm-lrdr,.cm-rrdr{width:100%}.cm-lrdr{margin-top:10px}.m-select,.m-input,.m-submit,.f-submit{width:100%}.s-input{width:100%}.ls-input{width:50%}.m-select,.m-input{border:1px solid #ccc}.m-select{border-radius:3px;margin-bottom:7px}.m-input{border-radius:3px;margin-bottom:7px}.m-submit{border-radius:3px}.box-similar{margin-top:6px}.font-similar{padding:8px 10px;display:block;width:100%}.page-info-left,.page-info-right,.foot-links,.foot-sm{width:100%}.pagination{margin:0}.page-info-left{margin-top:10px}.page-info-main{margin-left:0}.foot-psm{float:none;margin:auto}.foot-links a{width:100%;padding:4px 0;text-align:center;border-bottom:1px dotted #ccc}.foot-links span{display:none}.s-lists{width:100%}.mid-list{margin-left:0;margin-top:6px}.fit-in{margin-left:-15px;margin-right:-15px;width:auto}}@media only screen and (min-width:768px) and (max-width:1023px){.wrap,.h-wrap,.mc-header,.footer{max-width:768px}.items{width:47.5%}.m-gallery,.share-info,.cm-lrdr{width:56.5%}.info,.cm-rrdr{width:41.5%}.m-select{width:30%}.m-input{width:60%}.catUL{-webkit-columns:2;-moz-columns:2;columns:2}}@media only screen and (min-width:1024px){.items{width:22.5%}.m-gallery,.share-info{width:60%}.info{width:38.4%}.catUL{-webkit-columns:3;-moz-columns:3;columns:3}}
html{overflow-x:hidden!important}body,html{height:auto!important}body{margin:0!important;-webkit-text-size-adjust:100%;-moz-text-size-adjust:100%;-ms-text-size-adjust:100%;text-size-adjust:100%}html.i-amphtml-singledoc.i-amphtml-embedded{-ms-touch-action:pan-y;touch-action:pan-y}html.i-amphtml-ios-embed{position:static}#i-amphtml-wrapper,html.i-amphtml-ios-embed{overflow-y:auto!important;-webkit-overflow-scrolling:touch!important}#i-amphtml-wrapper{overflow-x:hidden!important;position:absolute!important;top:0!important;left:0!important;right:0!important;bottom:0!important;margin:0!important;display:block!important}#i-amphtml-wrapper>body{position:relative!important;border-top:1px solid transparent!important}.i-amphtml-make-body-block body{display:block!important}.i-amphtml-element{display:inline-block}.i-amphtml-layout-fixed{display:inline-block;position:relative}.i-amphtml-layout-container,.i-amphtml-layout-fixed-height,.i-amphtml-layout-responsive{display:block;position:relative}.i-amphtml-layout-fill{display:block;overflow:hidden!important;position:absolute;top:0;left:0;bottom:0;right:0}.i-amphtml-layout-flex-item{display:block;position:relative;-webkit-box-flex:1;-webkit-flex:1 1 auto;-ms-flex:1 1 auto;flex:1 1 auto}.i-amphtml-layout-size-defined{overflow:hidden!important}i-amphtml-sizer{display:block!important}.-amp-fill-content,.i-amphtml-fill-content{display:block;width:1px;min-width:100%;height:1px;min-height:100%;margin:auto}.i-amphtml-layout-size-defined .-amp-fill-content,.i-amphtml-layout-size-defined .i-amphtml-fill-content{position:absolute;top:0;left:0;bottom:0;right:0}.-amp-replaced-content,.-amp-screen-reader,.i-amphtml-replaced-content{padding:0!important;border:none!important}.-amp-screen-reader{position:fixed!important;top:0px!important;left:0px!important;width:2px!important;height:2px!important;opacity:0!important;overflow:hidden!important;margin:0!important;display:block!important;visibility:visible!important}.i-amphtml-unresolved{position:relative;overflow:hidden!important}.i-amphtml-notbuilt{position:relative;overflow:hidden!important;color:transparent!important}.i-amphtml-notbuilt>*{display:none}.-amp-ghost{visibility:hidden!important}.i-amphtml-element>[placeholder]{display:block}.i-amphtml-element>[placeholder].amp-hidden,.i-amphtml-element>[placeholder].hidden{visibility:hidden}.i-amphtml-element:not(.amp-notsupported)>[fallback]{display:none}.i-amphtml-layout-size-defined>[fallback],.i-amphtml-layout-size-defined>[placeholder]{position:absolute!important;top:0!important;left:0!important;right:0!important;bottom:0!important;z-index:1!important}.i-amphtml-notbuilt>[placeholder]{display:block!important}.i-amphtml-hidden-by-media-query{display:none}.i-amphtml-element-error{background:red!important;color:#fff!important;position:relative!important}.i-amphtml-element-error:before{content:attr(error-message)}i-amp-scroll-container{position:absolute;top:0;left:0;right:0;bottom:0;display:block}i-amp-scroll-container.amp-active{overflow:auto}.i-amphtml-loading-container{display:block!important;z-index:1}.i-amphtml-notbuilt>.i-amphtml-loading-container{display:block!important}.i-amphtml-loading-container.amp-hidden{visibility:hidden}.i-amphtml-loader-line{position:absolute;top:0;left:0;right:0;height:1px;overflow:hidden!important;background-color:hsla(0,0%,59%,.2);display:block}.i-amphtml-loader-moving-line{display:block;position:absolute;width:100%;height:100%!important;background-color:#979797;z-index:2}@-webkit-keyframes i-amphtml-loader-line-moving{0%{-webkit-transform:translateX(-100%);transform:translateX(-100%)}to{-webkit-transform:translateX(100%);transform:translateX(100%)}}@keyframes i-amphtml-loader-line-moving{0%{-webkit-transform:translateX(-100%);transform:translateX(-100%)}to{-webkit-transform:translateX(100%);transform:translateX(100%)}}.i-amphtml-loader-line.amp-active .i-amphtml-loader-moving-line{-webkit-animation:i-amphtml-loader-line-moving 2s ease infinite;animation:i-amphtml-loader-line-moving 2s ease infinite}.i-amphtml-loader{position:absolute;display:block;height:10px;top:50%;left:50%;-webkit-transform:translateX(-50%) translateY(-50%);transform:translateX(-50%) translateY(-50%);-webkit-transform-origin:50% 50%;transform-origin:50% 50%;white-space:nowrap}.i-amphtml-loader.amp-active .i-amphtml-loader-dot{-webkit-animation:i-amphtml-loader-dots 2s infinite;animation:i-amphtml-loader-dots 2s infinite}.i-amphtml-loader-dot{position:relative;display:inline-block;height:10px;width:10px;margin:2px;border-radius:100%;background-color:rgba(0,0,0,.3);box-shadow:2px 2px 2px 1px rgba(0,0,0,.2);will-change:transform}.i-amphtml-loader .i-amphtml-loader-dot:first-child{-webkit-animation-delay:0s;animation-delay:0s}.i-amphtml-loader .i-amphtml-loader-dot:nth-child(2){-webkit-animation-delay:.1s;animation-delay:.1s}.i-amphtml-loader .i-amphtml-loader-dot:nth-child(3){-webkit-animation-delay:.2s;animation-delay:.2s}@-webkit-keyframes i-amphtml-loader-dots{0%,to{-webkit-transform:scale(.7);transform:scale(.7);background-color:rgba(0,0,0,.3)}50%{-webkit-transform:scale(.8);transform:scale(.8);background-color:rgba(0,0,0,.5)}}@keyframes i-amphtml-loader-dots{0%,to{-webkit-transform:scale(.7);transform:scale(.7);background-color:rgba(0,0,0,.3)}50%{-webkit-transform:scale(.8);transform:scale(.8);background-color:rgba(0,0,0,.5)}}.i-amphtml-element>[overflow]{cursor:pointer;z-index:2;visibility:hidden}.i-amphtml-element>[overflow].amp-visible{visibility:visible}template{display:none!important}.amp-border-box,.amp-border-box *,.amp-border-box :after,.amp-border-box :before{box-sizing:border-box}amp-pixel{display:none!important}amp-instagram{padding:48px 8px!important;background-color:#fff}amp-analytics{position:fixed!important;top:0!important;width:1px!important;height:1px!important;overflow:hidden!important;visibility:hidden}amp-iframe iframe{box-sizing:border-box!important}[amp-access][amp-access-hide],amp-experiment,amp-live-list>[update],amp-share-tracking,form [submit-error],form [submit-success]{display:none}amp-fresh{visibility:hidden}.amp-video-eq{-webkit-box-align:end;-webkit-align-items:flex-end;-ms-flex-align:end;align-items:flex-end;bottom:7px;display:-webkit-box;display:-webkit-flex;display:-ms-flexbox;display:flex;height:12px;opacity:0.8;overflow:hidden;position:absolute;right:7px;width:20px}.amp-video-eq .amp-video-eq-col{-webkit-box-flex:1;-webkit-flex:1;-ms-flex:1;flex:1;height:100%;margin-right:1px;position:relative}.amp-video-eq .amp-video-eq-col div{-webkit-animation-name:amp-video-eq-animation;animation-name:amp-video-eq-animation;-webkit-animation-timing-function:linear;animation-timing-function:linear;-webkit-animation-iteration-count:infinite;animation-iteration-count:infinite;-webkit-animation-direction:alternate;animation-direction:alternate;background-color:#fafafa;height:100%;position:absolute;width:100%;will-change:transform;-webkit-animation-play-state:paused;animation-play-state:paused}.amp-video-eq[unpausable] .amp-video-eq-col div{-webkit-animation-name:none;animation-name:none}.amp-video-eq[unpausable].amp-video-eq-play .amp-video-eq-col div{-webkit-animation-name:amp-video-eq-animation;animation-name:amp-video-eq-animation}.amp-video-eq.amp-video-eq-play .amp-video-eq-col div{-webkit-animation-play-state:running;animation-play-state:running}.amp-video-eq-1-1{-webkit-animation-duration:0.3s;animation-duration:0.3s}.amp-video-eq-1-1,.amp-video-eq-1-2{-webkit-transform:translateY(60%);transform:translateY(60%)}.amp-video-eq-1-2{-webkit-animation-duration:0.45s;animation-duration:0.45s}.amp-video-eq-2-1{-webkit-animation-duration:0.5s;animation-duration:0.5s}.amp-video-eq-2-1,.amp-video-eq-2-2{-webkit-transform:translateY(30%);transform:translateY(30%)}.amp-video-eq-2-2{-webkit-animation-duration:0.4s;animation-duration:0.4s}.amp-video-eq-3-1{-webkit-animation-duration:0.3s;animation-duration:0.3s}.amp-video-eq-3-1,.amp-video-eq-3-2{-webkit-transform:translateY(70%);transform:translateY(70%)}.amp-video-eq-3-2{-webkit-animation-duration:0.35s;animation-duration:0.35s}.amp-video-eq-4-1{-webkit-animation-duration:0.4s;animation-duration:0.4s}.amp-video-eq-4-1,.amp-video-eq-4-2{-webkit-transform:translateY(50%);transform:translateY(50%)}.amp-video-eq-4-2{-webkit-animation-duration:0.25s;animation-duration:0.25s}@-webkit-keyframes amp-video-eq-animation{0%{-webkit-transform:translateY(100%);transform:translateY(100%)}to{-webkit-transform:translateY(0);transform:translateY(0)}}@keyframes amp-video-eq-animation{0%{-webkit-transform:translateY(100%);transform:translateY(100%)}to{-webkit-transform:translateY(0);transform:translateY(0)}}
.b-lazy {background:url(https://i0.wp.com/image.prntscr.com/image/1a0fe394a4154d33855197554a00a409.gif);background-repeat:no-repeat;background-position:center;}
</style>
</head>
<body>
<div class="main-header">
	<div class="mc-header">
		<div class="fluid">
			<a href="/" class="omjonilogo"></a>
			<div class="clear"></div>
		</div>
	</div>
</div>
<div class="cheader">
	<div class="h-wrap">
	<div class="fluid">
    	<div class="header">
			<form action="/search" method="GET" role="form" target="_top">
				<input class="m-input" type="text" placeholder="Enter a keyword to search ..." name="product" value="" autocomplete="off" /> 
				<input class="m-submit" type="submit" value="Search" />
			</form>
            <div class="clear"></div>
        </div>
    </div>
    </div>
</div>
<div class="wrap">
	<div class="fluid">

<div class="sheader">
<?php
if(!empty($morecats)){
	echo breadcrumbsgen($morecats);
}
?>
</div>	
<h1 class="title" itemprop="name">All Product On <?php echo $CATEGORY_NAME;?> Category</h1>	
         <div class="itemLists"> 
<?php
foreach($contentdata as $tdata){
//$ttls= str_replace("/", "%2F", trim($tdata['subject']));	
$productids= $tdata['productId'];
$producttoken= string2key($productids);
$productpath= fixslug($tdata['subject']);
$isorders= "0 orders";
$isprice= "price info";
		if(!empty($tdata['tradeCount'])){
			$isorders= $tdata['tradeCount'].' orders';
		}
		if(!empty($tdata['price_currency']) && !empty($tdata['price_value'])){
			$isprice= $tdata['price_currency'].' '.$tdata['price_value'];
		}
$permalink= '/items/'.$productids.'_'.$producttoken.'/'.$productpath.'.html';
echo	'<div class="items">
            	<div class="pImg">
                    <a href="'.$permalink.'" title="'.$tdata['subject'].'">
<img class="b-lazy i-amphtml-fill-content -amp-fill-content i-amphtml-replaced-content -amp-replaced-content" data-src="'.$tdata['imgUrl'].'_200x200.jpg" width="140" height="140"/>
                	</a>
                </div>
            	<div class="cItems">
                	<h4 class="m-title">
                    	<a href="'.$permalink.'" title="'.$tdata['subject'].'">'.$tdata['subject'].'</a>
                    </h4>
                    <h3 class="m-price">'.$isprice.'</h3>
                    <div class="m-info">
                    	<div class="m-seller">'.$isorders.'</div>
                    	<div class="m-shop"><a href="'.$permalink.'" rel="bookmark">Details Product</a></div>
                        <div class="clear"></div>
                    </div>
                </div>
            </div>';
}?>		
<div class="clear"></div>					

<!-- pages -->
<div class="pagination">
				<div class="time-paging"></div>
            	<ul class="paging">
		<?php 
		if($pages >= 3){
			$prevpage= ($pages-1);
			$prevtoken= substr(md5("keyku".$prevpage),0,5);
			echo '<li><a href="/category?page='.$prevpage.'&token='.$prevtoken.'&cid='.$current_cat.'&cit='.$cat_token.'&cnm='.urlencode($CATEGORY_NAMES).'">PREV PAGE</a></li>'; 
		}
		if($html_scr['nextpage']){
			echo '<li><a href="/category?page='.$nextpage.'&token='.$nexttoken.'&cid='.$current_cat.'&cit='.$cat_token.'&cnm='.urlencode($CATEGORY_NAMES).'">NEXT PAGE</a></li>'; 
		}
		
		?>
				</ul>
            </div>
<!-- end pages -->			
					</div>
    </div>
</div>
<div class="m-footer">
	<div class="p-footer">
    	<div class="footer">
            <div class="fluid">
                <div class="foot-links">
                    <a href="/">Home</a>
                    <span></span>
                    <a href="#">Term Of Service</a>
                    <span></span>
                    <a href="#">Privasi Policy</a>
                    <span></span>
                    <a href="#">Help</a>
                    <span></span>
                    <a href="#">Contact</a>
			<span></span>
					<a href="/sitemap.html">Sitemap</a>
                </div>
				<div class="foot-sm">
					<div class="foot-psm">
						<a class="foot-icon fgp" href="#"></a>
						<a class="foot-icon ffb" href="#"></a>
						<a class="foot-icon ftw" href="#"></a>
						<div class="foot-follow">Follow Us</div>
						<div class="clear"></div>
					</div>
					<div class="clear"></div>
				</div>
				<div class="clear"></div>
            </div>
        </div>
    </div>
    <div class="footer">
    	<div class="fluid">
        	<div class="foot-desc">
        	Search results are displayed by <a href="https://www.google.com/webmasters/sitemaps/ping?sitemap=https://<?php echo $_SERVER['HTTP_HOST'];?>/sitemap.php" target="_blank"><?php echo $_SERVER['HTTP_HOST'];?></a> is as a reference.By using <?php echo $_SERVER['HTTP_HOST'];?> services, you agree to comply with this regulation.
            </div>
            <div class="foot-copyright">
        	Copyright &copy; <span><?php echo $_SERVER['HTTP_HOST'];?></span> 2016
        	</div>
        </div>
    </div>
</div>
<script>
(function(p,m){"function"===typeof define&&define.amd?define(m):"object"===typeof exports?module.exports=m():p.Blazy=m()})(this,function(){function p(b){var c=b._util;c.elements=B(b.options.selector);c.count=c.elements.length;c.destroyed&&(c.destroyed=!1,b.options.container&&k(b.options.container,function(a){n(a,"scroll",c.validateT)}),n(window,"resize",c.save_viewportOffsetT),n(window,"resize",c.validateT),n(window,"scroll",c.validateT));m(b)}function m(b){for(var c=b._util,a=0;a<c.count;a++){var d=c.elements[a],f=d.getBoundingClientRect();if(f.right>=e.left&&f.bottom>=e.top&&f.left<=e.right&&f.top<=e.bottom||q(d,b.options.successClass))b.load(d),c.elements.splice(a,1),c.count--,a--}0===c.count&&b.destroy()}function x(b,c,a){if(!q(b,a.successClass)&&(c||a.loadInvisible||0<b.offsetWidth&&0<b.offsetHeight))if(c=b.getAttribute(r)||b.getAttribute(a.src)){c=c.split(a.separator);var d=c[y&&1<c.length?1:0],f="img"===b.nodeName.toLowerCase();if(f||void 0===b.src){var l=new Image,u=function(){a.error&&a.error(b,"invalid");t(b,a.errorClass);g(l,"error",u);g(l,"load",h)},h=function(){if(f){b.src=d;v(b,"srcset",a.srcset);var c=b.parentNode;c&&"picture"===c.nodeName.toLowerCase()&&k(c.getElementsByTagName("source"),function(b){v(b,"srcset",a.srcset)})}else b.style.backgroundImage='url("'+d+'")';w(b,a);g(l,"load",h);g(l,"error",u)};n(l,"error",u);n(l,"load",h);l.src=d}else b.src=d,w(b,a)}else"video"===b.nodeName.toLowerCase()?(k(b.getElementsByTagName("source"),function(b){v(b,"src",a.src)}),b.load(),w(b,a)):(a.error&&a.error(b,"missing"),t(b,a.errorClass))}function w(b,c){t(b,c.successClass);c.success&&c.success(b);b.removeAttribute(c.src);k(c.breakpoints,function(a){b.removeAttribute(a.src)})}function v(b,c,a){var d=b.getAttribute(a);d&&(b[c]=d,b.removeAttribute(a))}function q(b,c){return-1!==(" "+b.className+" ").indexOf(" "+c+" ")}function t(b,c){q(b,c)||(b.className+=" "+c)}function B(b){var c=[];b=document.querySelectorAll(b);for(var a=b.length;a--;c.unshift(b[a]));return c}function z(b){e.bottom=(window.innerHeight||document.documentElement.clientHeight)+b;e.right=(window.innerWidth||document.documentElement.clientWidth)+b}function n(b,c,a){b.attachEvent?b.attachEvent&&b.attachEvent("on"+c,a):b.addEventListener(c,a,!1)}function g(b,c,a){b.detachEvent?b.detachEvent&&b.detachEvent("on"+c,a):b.removeEventListener(c,a,!1)}function k(b,c){if(b&&c)for(var a=b.length,d=0;d<a&&!1!==c(b[d],d);d++);}function A(b,c,a){var d=0;return function(){var f=+new Date;f-d<c||(d=f,b.apply(a,arguments))}}var r,e,y;return function(b){if(!document.querySelectorAll){var c=document.createStyleSheet();document.querySelectorAll=function(a,b,d,h,e){e=document.all;b=[];a=a.replace(/\[for\b/gi,"[htmlFor").split(",");for(d=a.length;d--;){c.addRule(a[d],"k:v");for(h=e.length;h--;)e[h].currentStyle.k&&b.push(e[h]);c.removeRule(0)}return b}}var a=this,d=a._util={};d.elements=[];d.destroyed=!0;a.options=b||{};a.options.error=a.options.error||!1;a.options.offset=a.options.offset||100;a.options.success=a.options.success||!1;a.options.selector=a.options.selector||".b-lazy";a.options.separator=a.options.separator||"|";a.options.container=a.options.container?document.querySelectorAll(a.options.container):!1;a.options.errorClass=a.options.errorClass||"b-error";a.options.breakpoints=a.options.breakpoints||!1;a.options.loadInvisible=a.options.loadInvisible||!1;a.options.successClass=a.options.successClass||"b-loaded";a.options.validateDelay=a.options.validateDelay||25;a.options.save_viewportOffsetDelay=a.options.save_viewportOffsetDelay||50;a.options.srcset=a.options.srcset||"data-srcset";a.options.src=r=a.options.src||"data-src";y=1<window.devicePixelRatio;e={};e.top=0-a.options.offset;e.left=0-a.options.offset;a.revalidate=function(){p(this)};a.load=function(a,b){var c=this.options;void 0===a.length?x(a,b,c):k(a,function(a){x(a,b,c)})};a.destroy=function(){var a=this._util;this.options.container&&k(this.options.container,function(b){g(b,"scroll",a.validateT)});g(window,"scroll",a.validateT);g(window,"resize",a.validateT);g(window,"resize",a.save_viewportOffsetT);a.count=0;a.elements.length=0;a.destroyed=!0};d.validateT=A(function(){m(a)},a.options.validateDelay,a);d.save_viewportOffsetT=A(function(){z(a.options.offset)},a.options.save_viewportOffsetDelay,a);z(a.options.offset);k(a.options.breakpoints,function(a){if(a.width>=window.screen.width)return r=a.src,!1});setTimeout(function(){p(a)})}});
var bLazy=new Blazy({error:function(a,b){a.src="https://i.imgur.com/zyClULV.jpg"}});
</script>
</body>
</html>
