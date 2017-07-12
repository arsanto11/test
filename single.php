<?php
//single
error_reporting(0);
@ini_set('display_errors', 0);
date_default_timezone_set('Asia/Jakarta');
	if (isset($_SERVER['HTTP_IF_MODIFIED_SINCE'])){
		header('HTTP/1.1 304 Not Modified');
        die();
	} 
header('Cache-control: public, max-age=622080000');
header('Expires: '.gmdate(DATE_RFC1123,time()+622080000));
header('Last-Modified: '.gmdate(DATE_RFC1123,time()));
header('Vary: Accept');
header('Accept-Encoding: gzip, deflate');

if(!isset($_GET['id']) || !isset($_GET['token']) || !isset($_GET['title'])){ header("Location: /"); exit(); }
if(empty($_GET['id']) || empty($_GET['token']) || empty($_GET['title'])){ header("Location: /"); exit(); }

include "func.php";
	if(!ismainreferer()){
		header("location: ".gotoaliexpress($_GET['id']));
		exit();
	}
if(string2key($_GET['id']) != $_GET['token']){
	header("Location: /"); exit();
}

$resultdata= endpoint_single($_GET['id']);
//print_r($resultdata);exit;

	if(!$resultdata){
		header("Location: /"); exit();
	}
	
$Coninnal= $_SERVER['REQUEST_URI'];	
$productimage= $resultdata['image'][0];	
?>

<!DOCTYPE html>
<html>
<head>


<meta charset="utf-8">
<meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no">
<meta property="og:site_name" itemprop="name" content="<?php echo $_SERVER['HTTP_HOST'];?>" />
<meta itemprop="url" content="http://<?php echo $_SERVER['HTTP_HOST'];?><?php echo $Coninnal;?>" />
<title><?php echo $resultdata['title'].' '.$_GET['id'];?></title>
<meta property="og:title" content="<?php echo $resultdata['title'].' '.$_GET['id'];?>" />
<meta property="og:type" content="product" />
<meta property="og:url" content="http://<?php echo $_SERVER['HTTP_HOST'];?><?php echo $Coninnal;?>" />
<meta property="og:description" content="<?php echo $_GET['id'].' '.$resultdata['title'].' Price '.$resultdata['pricereal'];?>" />
<meta property="og:image" content="<?php echo $productimage;?>"/>
<link rel="shortcut icon" href="/favicon.ico" type="image/x-icon">
<link rel="icon" href="/favicon.ico" type="image/x-icon">
<meta name="description" content="<?php echo $_GET['id'].' '.$resultdata['title'].' Price '.$resultdata['pricereal'];?>" />
<link rel="canonical" href="<?php echo $Coninnal;?>" />

<meta name="robots" content="FOLLOW,NOARCHIVE,NOODP,NOYDIR,NOTRANSLATE"/>
<style>
*,body{font-family:Arial,Helvetica Neue,Helvetica,sans-serif;padding:0;margin:0;line-height:22px}*,*::after,*::before{box-sizing:border-box}a,input,select{text-decoration:none;outline:0;color:#000}select:-moz-focusring{color:transparent;text-shadow:0 0 0 #000}select{-webkit-appearance:none;-moz-appearance:none;-ms-appearance:none;-o-appearance:none;appearance:none;text-indent:1px;text-overflow:'';background:#f2f2f2}select::-ms-expand{display:none}.wrap,.h-wrap{max-width:980px;margin:auto}.wrap{padding-bottom:20px}.h-wrap{padding:10px 0}.fluid{padding-right:15px;padding-left:15px;margin-right:auto;margin-left:auto}.main-header{width:100%;background:#2e88d0}.mc-header{max-width:980px;margin:auto}.omjonilogo{float:left;width:212px;height:70px;background:url(http://i.imgur.com/tstUpap.png) no-repeat 0 center}.mc-link{float:right;width:40px;height:40px;margin-top:15px;border-radius:5px;background:#fff no-repeat center}.cheader{width:100%;background:#eee;border-bottom:1px solid #ddd}.header{max-width:980px}.sheader{max-width:980px;padding:4px 0;font-size:12px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;-o-text-overflow:ellipsis}.bborder{border-bottom:1px dotted #ccc}.product-info,.product-related,.share-info{max-width:980px;margin-top:12px}.product-related{height:40px;background:url(../images/232134510.gif) no-repeat center}.share-info{float:left;margin-top:20px}.share-info .shtext,.share-info .smicons{float:left}.share-info .shtext{white-space:nowrap;margin-right:6px;font-size:14px;font-weight:700;color:#888}.share-info .smicons{width:48px;height:48px;margin:0 5px;border-radius:4px;box-shadow:0 0 4px #ddd}.share-info .tw{background:url(../images/a29cf8bdd321.png) no-repeat 0 0}.share-info .fb{background:url(../images/a29cf8bdd321.png) no-repeat -48px 0}.share-info .gp{background:url(../images/a29cf8bdd321.png) no-repeat -96px 0}.product-title{max-width:980px;padding:8px 0 5px;font-weight:700;font-size:18px;color:#2e88d0;border-bottom:1px dotted #ccc}.product-content{max-width:980px;padding:8px 0 5px;font-size:16px;word-wrap:break-word;line-height:24px}.product-content ul{padding-left:16px;list-style:outside}.product-content ul li{line-height:24px;word-wrap:break-word}.product-content table{width:100%;border-collapse:collapse;padding:0;margin:0;border:0;font-size:13px}.product-content table tr th{width:25%;padding:8px;padding-left:0;text-align:left;vertical-align:top;border-bottom:1px dotted #ccc;word-wrap:break-word;color:#666}.product-content table tr td{padding:8px;padding-right:0;border-bottom:1px dotted #ccc;word-wrap:break-word}.sheader a{color:#2e88d0}.sheader a:hover{color:#ff5c00;text-decoration:underline}.m-select{float:left;width:25%;height:40px;border:0;padding:10px 30px 10px 4px;border-radius:3px 0 0 3px;border:1px solid #ccc;background:#f2f2f2 url(../images/1454584.png) no-repeat right center}.m-select option{padding:2px 0;text-indent:5px}.m-input{float:left;width:90%;height:40px;border:0;padding:8px;border-top:1px solid #ccc;border-bottom:1px solid #ccc}.m-submit,.f-submit{float:left;width:10%;height:40px;background:#2e88d0;padding:7px 4px;font-weight:700;color:#fff;border-radius:0 3px 3px 0;border:1px solid #2e88d0;cursor:pointer}.f-submit{float:right;width:auto;height:38px;border-radius:3px;padding:6px 26px}.c-slct{font-weight:400}.sc-slct{padding-left:5px}.itemLists{margin-bottom:10px;margin-left:-2.5%}.items{position:relative;float:left;margin:1.25% 0 1.25% 2.5%;background:#f5f5f5;box-shadow:0 0 4px #ddd;border:1px solid #ccc;font-size:100%;border-radius:3px}.empty-result{margin:10px 0 10px 2.5%;padding:40px 0;font-size:16px;text-align:center;background:#f2f2f2;border-radius:4px}.cItems{width:100%;padding-left:5px;padding-right:5px}.pImg{position:relative;vertical-align:middle;background:#fff;border-radius:3px 3px 0 0;border-bottom:1px solid #ccc;width:100%;height:161px}.pImg a{top:0;left:0;position:absolute;width:100%;height:100%}.pImg img{margin:auto;position:absolute;top:0;left:0;bottom:0;right:0;max-width:100%;max-height:160px}.m-title{font-size:16px;word-wrap:break-word;text-shadow:1px 1px 1px #fff;overflow:hidden;height:44px;margin-bottom:5px}.m-price{position:relative;font-size:18px;text-align:center;color:#ff5c00;padding:5px 0 15px;cursor:default}.m-price .m-discount{position:absolute;font-size:12px;padding:3px 6px;line-height:12px;margin-left:6px;background:#ff5c00;color:#fff;border-radius:2px 2px 10px 10px}.m-price .m-oriprice{margin:auto;top:24px;left:0;bottom:0;right:0;position:absolute;font-size:12px;text-decoration:line-through;color:#aaa}.m-title a{display:block;width:100%;color:#2e88d0;word-wrap:break-word;padding-top:5px;text-align:center;line-height:19px}.m-title a:hover{color:#ff5c00}.m-info{padding:4px 0;border-top:1px dotted #ccc;margin-top:5px;cursor:default}.m-seller,.m-shop{color:#fff;padding:2px 4px;font-weight:700;font-size:11px;border-radius:3px}.m-seller{float:left;max-width:60%;background:#2e88d0;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;-o-text-overflow:ellipsis}.m-seller:hover{background:#ddd;color:#2e88d0}.m-shop{float:right;background:#ff5c00}.title,.lists,.slists{max-width:980px;padding:12px 0;border-top:1px dotted #ccc;border-bottom:1px dotted #ccc;font-size:20px}.box-message{max-width:980px;border-top:1px dotted #ccc}.message{max-width:980px;padding:8px 8px;margin:4px 0;font-size:14px;text-align:center;font-weight:700;background:#fef5c1;border:1px solid #dece90}.m-rdr{max-width:980px;min-height:250px;margin:30px 0 10px}.cm-rrdr{float:right;width:38.3%}.cm-lrdr{float:left;width:60%}.rdr-text{font-size:14px;text-align:center;color:#777}.rdr-m-pgrb{position:relative;margin-top:8px;width:100%;height:26px;background:#f2f2f2;box-shadow:1px 2px 2px #ccc inset;border-radius:6px;overflow:hidden}.rdr-pgrb{position:absolute;width:0;top:0;left:0;height:26px;box-shadow:1px 2px 2px #ccc;background:#f2f2f2 url(../images/prgbar.gif) repeat-x 0 0}.rdr-notes{margin-top:8px;font-size:14px;text-align:justify;line-height:18px}.lists{padding:12px 0 6px}.catLnk,.mainLnk{width:100%;padding:6px 0;border-bottom:1px dotted #ccc}.mainLnk{width:auto;margin:6px 0 0 2.5%}.catUL{list-style:none;padding:8px 0 6px}.catUL li{padding:2px 0}.catLnk a,.mainLnk a{color:#2e88d0;font-size:18px}.catLnk a:hover,.mainLnk:hover a{color:#ff5c00}.catUL a{display:block;font-size:13px;font-weight:700;background:#f2f2f2;padding:6px 0 6px 8px;border:1px solid #ccc;width:100%;border-radius:20px 0 20px 0}.catUL a:hover{color:#2e88d0}.slists{border-top:0;padding:6px 0}.s-lists{position:relative;height:38px;border:1px solid #ccc;border-radius:3px;background:#f2f2f2}.ls-label{position:absolute;width:90px;height:36px;top:0;left:0;text-align:left;padding:7px;background:#fff;border-radius:3px 0 0 3px;white-space:nowrap;font-size:13px}.mid-list{margin-left:8px}.ls-left{float:left}.ls-right{float:right}.s-select,.s-input{border:0;padding-left:90px}.s-input{width:329.5px}.ls-select{width:100%;height:36px;border:0;padding:7px 28px 7px 7px;border-left:1px solid #ccc;border-radius:0 3px 3px 0;font-size:13px;background:#f2f2f2 url(../images/1454584.png) no-repeat right center}.ls-input{float:left;width:119.6px;border:0;padding:7px 13px;border-left:1px solid #ccc;border-radius:0 3px 3px 0;font-size:13px;background:#f2f2f2}.ls-select option{padding:2px 0;text-indent:7px}.ls-hide{display:none}.m-gallery,.gallery{float:left;position:relative;top:0;left:0}.m-gallery{margin-top:15px}.gallery{width:100%;border-radius:3px;box-shadow:0 1px 5px #ccc;border:1px solid #ccc;font-size:100%;overflow:hidden;height:395px}.galleryImg{position:relative;vertical-align:middle;background:#fff;border-bottom:1px solid #ccc;border-radius:4px;width:100%;height:395px}.galleryImg img{margin:auto;position:absolute;top:0;left:0;bottom:0;right:0;max-width:100%;max-height:394px}.m-thumbnail{float:left;width:100%;margin-top:10px;overflow:hidden;max-height:70px}.p-thumbnail{float:left;position:relative;vertical-align:middle;background:#fff;border-bottom:1px solid #ccc;width:70px;height:70px;box-shadow:0 0 4px #ddd;margin:0 2px;border:1px solid #ccc;border-radius:3px;cursor:pointer}.thumbnail{margin:auto;position:absolute;top:0;left:0;bottom:0;right:0;max-width:64px;max-height:64px}.info-nogrid,.info-grid{width:100%;padding-bottom:12px}.info-grid{padding:4px 0 10px;border-bottom:1px dotted #ccc;line-height:14px}.font-price{font-size:30px;color:#ff5c00}.font-price span{display:block;font-size:12px;color:#999;padding-top:10px}.font-oriprice{padding:7px 0 10px;font-size:18px;color:#aaa}.font-oriprice span.linethrough{text-decoration:line-through}.font-oriprice span.disc{padding:10px 15px;margin-left:10px;background:#ff5c00;color:#fff;font-weight:700;font-size:12px;font-weight:700;border-radius:6px}.font-seller{font-size:18px;color:#999}.font-seller div.prwr{float:left;width:100%}.font-seller span.powr{display:block;padding-bottom:4px;font-size:12px;font-weight:700;color:#aaa}.font-seller span.g-seller,.font-seller span.g-shop{float:left;padding:4px 8px;font-size:12px;font-weight:700;color:#fff;border-radius:3px}.font-seller span.g-seller{background:#2e88d0}.font-seller span.g-shop{margin-top:6px;background:#ff5c00}.font-updated{font-size:16px;font-weight:700;color:#999}.font-updated span{display:block;padding-bottom:4px;font-size:12px;color:#aaa}.font-ketoko{display:block;width:100%;padding:8px;background:#287dc1;font-size:14px;font-weight:700;border:1px solid #2c5678;border-radius:2px;color:#fff;text-align:center;margin-top:12px}.box-similar{width:100%;text-align:center}.font-similar{padding:10px 16px;background:#287dc1;font-size:14px;font-weight:700;border:1px solid #2c5678;border-radius:2px;color:#fff;text-align:center}.font-ketoko:hover,.font-similar:hover{background:#eee;color:#2c5678}.p-thumbnail:hover{border:1px solid #2e88d0}.info{position:relative;float:right;margin-top:18px;font-size:100%;border-radius:3px}.page-info-left{float:left;width:25%;border:1px solid #ccc;margin-top:15px;border-radius:3px;background:#f5f5f5}.page-info-left a:last-child{border:0}.page-info-right{float:right;width:70%;margin-top:10px}.page-info-main{min-height:247px;border:1px solid #ccc;padding:5px 12px 12px;margin-left:-7.3%;background:#fff;font-size:13px;text-align:justify;border-radius:3px}.page-info-main .page-title{border-bottom:1px dotted #ccc;font-size:16px;padding-bottom:5px;margin-bottom:5px}.page-info-main ul{padding-left:12px;list-style:square outside none}.page-info-left a,.page-info-main a{color:#2e88d0}.page-info-left a{display:block;font-size:12px;padding:8px 12px;border-bottom:1px dotted #ccc}.page-info-left a:hover,.page-info-main a:hover{text-decoration:underline;color:#ff5c00}.pagination{border-top:1px dotted #ccc;text-align:center;margin-left:2.5%}.time-paging{padding-top:5px;text-align:center;font-size:14px;color:#aaa}.paging{display:inline-block;list-style:none;margin:5px 0}.paging li{display:inline}.paging li a,.paging li div,.paging li .selected{position:relative;float:left;padding:6px 12px;margin-left:-1px;line-height:1.42857;color:#337ab7;font-size:14px;font-weight:700;text-decoration:none;background-color:#fff;border:1px solid #ddd}.paging li .selected{background:#337ab7;color:#fff}.paging li a.prev,.paging li div.prev-disabled,.paging li a.next,.paging li div.next-disabled{width:34px;height:34px}.paging li a.prev,.paging li div.prev-disabled{border-radius:5px 0 0 5px}.paging li a.prev{background:url(../images/arrow.png) no-repeat -3px -3px}.paging li div.prev-disabled{background:url(../images/arrow.png) no-repeat -3px -41px}.paging li a.next,.paging li div.next-disabled{border-radius:0 5px 5px 0}.paging li a.next{background:url(../images/arrow.png) no-repeat -41px -3px}.paging li div.next-disabled{background:url(../images/arrow.png) no-repeat -41px -41px}.paging li a:hover{background:#eee}.paging li a.prev:hover{background:#eee url(../images/arrow.png) no-repeat -3px -3px}.paging li a.next:hover{background:#eee url(../images/arrow.png) no-repeat -41px -3px}.m-footer{width:100%}.p-footer{background:#f5f5f5;border-top:1px solid #ccc;border-bottom:1px solid #ccc}.footer{max-width:980px;margin:auto}.foot-desc,.foot-copyright{font-size:11px;padding:8px 0;line-height:12px;color:#777}.foot-copyright{font-size:12px;padding:0 0 10px;color:#333}.foot-copyright span{color:#2e88d0}.foot-links{float:left;width:70%}.foot-sm,.foot-psm{float:right}.foot-psm{width:175px;height:28px}.foot-sm{margin:9px 0}.foot-follow{float:right;font-size:12px;font-weight:700;color:#777;margin:3px 5px 3px 0;white-space:nowrap}.foot-icon{float:right;width:28px;height:28px;margin-left:5px}.ftw{background:url(https://i0.wp.com/image.prntscr.com/image/e32997b2247845ec989b0e3626930204.png) no-repeat 0 0}.ffb{background:url(https://i0.wp.com/image.prntscr.com/image/e32997b2247845ec989b0e3626930204.png) no-repeat 0 -28px}.fgp{background:url(https://i0.wp.com/image.prntscr.com/image/e32997b2247845ec989b0e3626930204.png) no-repeat 0 -56px}.ftw:hover{background:url(https://i0.wp.com/image.prntscr.com/image/e32997b2247845ec989b0e3626930204.png) no-repeat -28px 0}.ffb:hover{background:url(https://i0.wp.com/image.prntscr.com/image/e32997b2247845ec989b0e3626930204.png) no-repeat -28px -28px}.fgp:hover{background:url(https://i0.wp.com/image.prntscr.com/image/e32997b2247845ec989b0e3626930204.png) no-repeat -28px -56px}.foot-links a{display:inline-block;padding:12px 0;font-size:12px;color:#2e88d0}.foot-links a:hover{color:#ff5c00;text-decoration:underline}.foot-links span{position:relative;display:inline-block;width:2px;height:16px;margin:0 6px;top:3px;border-left:1px solid #ccc;border-right:1px solid #fff}.adsPages{margin-top:12px;overflow:hidden}.fit-in{}.adsItems{clear:both;margin-left:2.5%;overflow:hidden}.clear{clear:both}@media only screen and (min-width:200px) and (max-width:767px){.itemLists,.mainLnk{margin:0}.items{width:48%;margin:8px 2px 2.5%}.m-gallery,.share-info,.info,.cm-lrdr,.cm-rrdr{width:100%}.cm-lrdr{margin-top:10px}.m-select,.m-input,.m-submit,.f-submit{width:100%}.s-input{width:100%}.ls-input{width:50%}.m-select,.m-input{border:1px solid #ccc}.m-select{border-radius:3px;margin-bottom:7px}.m-input{border-radius:3px;margin-bottom:7px}.m-submit{border-radius:3px}.box-similar{margin-top:6px}.font-similar{padding:8px 10px;display:block;width:100%}.page-info-left,.page-info-right,.foot-links,.foot-sm{width:100%}.pagination{margin:0}.page-info-left{margin-top:10px}.page-info-main{margin-left:0}.foot-psm{float:none;margin:auto}.foot-links a{width:100%;padding:4px 0;text-align:center;border-bottom:1px dotted #ccc}.foot-links span{display:none}.s-lists{width:100%}.mid-list{margin-left:0;margin-top:6px}.fit-in{margin-left:-15px;margin-right:-15px;width:auto}}@media only screen and (min-width:768px) and (max-width:1023px){.wrap,.h-wrap,.mc-header,.footer{max-width:768px}.items{width:47.5%}.m-gallery,.share-info,.cm-lrdr{width:56.5%}.info,.cm-rrdr{width:41.5%}.m-select{width:30%}.m-input{width:60%}.catUL{-webkit-columns:2;-moz-columns:2;columns:2}}@media only screen and (min-width:1024px){.items{width:22.5%}.m-gallery,.share-info{width:60%}.info{width:38.4%}.catUL{-webkit-columns:3;-moz-columns:3;columns:3}}
.amp-thesahe { width:100%; margin-top: 10px; }
html{overflow-x:hidden!important}body,html{height:auto!important}body{margin:0!important;-webkit-text-size-adjust:100%;-moz-text-size-adjust:100%;-ms-text-size-adjust:100%;text-size-adjust:100%}html.i-amphtml-singledoc.i-amphtml-embedded{-ms-touch-action:pan-y;touch-action:pan-y}html.i-amphtml-ios-embed{position:static}#i-amphtml-wrapper,html.i-amphtml-ios-embed{overflow-y:auto!important;-webkit-overflow-scrolling:touch!important}#i-amphtml-wrapper{overflow-x:hidden!important;position:absolute!important;top:0!important;left:0!important;right:0!important;bottom:0!important;margin:0!important;display:block!important}#i-amphtml-wrapper>body{position:relative!important;border-top:1px solid transparent!important}.i-amphtml-make-body-block body{display:block!important}.i-amphtml-element{display:inline-block}.i-amphtml-layout-fixed{display:inline-block;position:relative}.i-amphtml-layout-container,.i-amphtml-layout-fixed-height,.i-amphtml-layout-responsive{display:block;position:relative}.i-amphtml-layout-fill{display:block;overflow:hidden!important;position:absolute;top:0;left:0;bottom:0;right:0}.i-amphtml-layout-flex-item{display:block;position:relative;-webkit-box-flex:1;-webkit-flex:1 1 auto;-ms-flex:1 1 auto;flex:1 1 auto}.i-amphtml-layout-size-defined{overflow:hidden!important}i-amphtml-sizer{display:block!important}.-amp-fill-content,.i-amphtml-fill-content{display:block;width:1px;min-width:100%;height:1px;min-height:100%;margin:auto}.i-amphtml-layout-size-defined .-amp-fill-content,.i-amphtml-layout-size-defined .i-amphtml-fill-content{position:absolute;top:0;left:0;bottom:0;right:0}.-amp-replaced-content,.-amp-screen-reader,.i-amphtml-replaced-content{padding:0!important;border:none!important}.-amp-screen-reader{position:fixed!important;top:0px!important;left:0px!important;width:2px!important;height:2px!important;opacity:0!important;overflow:hidden!important;margin:0!important;display:block!important;visibility:visible!important}.i-amphtml-unresolved{position:relative;overflow:hidden!important}.i-amphtml-notbuilt{position:relative;overflow:hidden!important;color:transparent!important}.i-amphtml-notbuilt>*{display:none}.-amp-ghost{visibility:hidden!important}.i-amphtml-element>[placeholder]{display:block}.i-amphtml-element>[placeholder].amp-hidden,.i-amphtml-element>[placeholder].hidden{visibility:hidden}.i-amphtml-element:not(.amp-notsupported)>[fallback]{display:none}.i-amphtml-layout-size-defined>[fallback],.i-amphtml-layout-size-defined>[placeholder]{position:absolute!important;top:0!important;left:0!important;right:0!important;bottom:0!important;z-index:1!important}.i-amphtml-notbuilt>[placeholder]{display:block!important}.i-amphtml-hidden-by-media-query{display:none}.i-amphtml-element-error{background:red!important;color:#fff!important;position:relative!important}.i-amphtml-element-error:before{content:attr(error-message)}i-amp-scroll-container{position:absolute;top:0;left:0;right:0;bottom:0;display:block}i-amp-scroll-container.amp-active{overflow:auto}.i-amphtml-loading-container{display:block!important;z-index:1}.i-amphtml-notbuilt>.i-amphtml-loading-container{display:block!important}.i-amphtml-loading-container.amp-hidden{visibility:hidden}.i-amphtml-loader-line{position:absolute;top:0;left:0;right:0;height:1px;overflow:hidden!important;background-color:hsla(0,0%,59%,.2);display:block}.i-amphtml-loader-moving-line{display:block;position:absolute;width:100%;height:100%!important;background-color:#979797;z-index:2}@-webkit-keyframes i-amphtml-loader-line-moving{0%{-webkit-transform:translateX(-100%);transform:translateX(-100%)}to{-webkit-transform:translateX(100%);transform:translateX(100%)}}@keyframes i-amphtml-loader-line-moving{0%{-webkit-transform:translateX(-100%);transform:translateX(-100%)}to{-webkit-transform:translateX(100%);transform:translateX(100%)}}.i-amphtml-loader-line.amp-active .i-amphtml-loader-moving-line{-webkit-animation:i-amphtml-loader-line-moving 2s ease infinite;animation:i-amphtml-loader-line-moving 2s ease infinite}.i-amphtml-loader{position:absolute;display:block;height:10px;top:50%;left:50%;-webkit-transform:translateX(-50%) translateY(-50%);transform:translateX(-50%) translateY(-50%);-webkit-transform-origin:50% 50%;transform-origin:50% 50%;white-space:nowrap}.i-amphtml-loader.amp-active .i-amphtml-loader-dot{-webkit-animation:i-amphtml-loader-dots 2s infinite;animation:i-amphtml-loader-dots 2s infinite}.i-amphtml-loader-dot{position:relative;display:inline-block;height:10px;width:10px;margin:2px;border-radius:100%;background-color:rgba(0,0,0,.3);box-shadow:2px 2px 2px 1px rgba(0,0,0,.2);will-change:transform}.i-amphtml-loader .i-amphtml-loader-dot:first-child{-webkit-animation-delay:0s;animation-delay:0s}.i-amphtml-loader .i-amphtml-loader-dot:nth-child(2){-webkit-animation-delay:.1s;animation-delay:.1s}.i-amphtml-loader .i-amphtml-loader-dot:nth-child(3){-webkit-animation-delay:.2s;animation-delay:.2s}@-webkit-keyframes i-amphtml-loader-dots{0%,to{-webkit-transform:scale(.7);transform:scale(.7);background-color:rgba(0,0,0,.3)}50%{-webkit-transform:scale(.8);transform:scale(.8);background-color:rgba(0,0,0,.5)}}@keyframes i-amphtml-loader-dots{0%,to{-webkit-transform:scale(.7);transform:scale(.7);background-color:rgba(0,0,0,.3)}50%{-webkit-transform:scale(.8);transform:scale(.8);background-color:rgba(0,0,0,.5)}}.i-amphtml-element>[overflow]{cursor:pointer;z-index:2;visibility:hidden}.i-amphtml-element>[overflow].amp-visible{visibility:visible}template{display:none!important}.amp-border-box,.amp-border-box *,.amp-border-box :after,.amp-border-box :before{box-sizing:border-box}amp-pixel{display:none!important}amp-instagram{padding:48px 8px!important;background-color:#fff}amp-analytics{position:fixed!important;top:0!important;width:1px!important;height:1px!important;overflow:hidden!important;visibility:hidden}amp-iframe iframe{box-sizing:border-box!important}[amp-access][amp-access-hide],amp-experiment,amp-live-list>[update],amp-share-tracking,form [submit-error],form [submit-success]{display:none}amp-fresh{visibility:hidden}.amp-video-eq{-webkit-box-align:end;-webkit-align-items:flex-end;-ms-flex-align:end;align-items:flex-end;bottom:7px;display:-webkit-box;display:-webkit-flex;display:-ms-flexbox;display:flex;height:12px;opacity:0.8;overflow:hidden;position:absolute;right:7px;width:20px}.amp-video-eq .amp-video-eq-col{-webkit-box-flex:1;-webkit-flex:1;-ms-flex:1;flex:1;height:100%;margin-right:1px;position:relative}.amp-video-eq .amp-video-eq-col div{-webkit-animation-name:amp-video-eq-animation;animation-name:amp-video-eq-animation;-webkit-animation-timing-function:linear;animation-timing-function:linear;-webkit-animation-iteration-count:infinite;animation-iteration-count:infinite;-webkit-animation-direction:alternate;animation-direction:alternate;background-color:#fafafa;height:100%;position:absolute;width:100%;will-change:transform;-webkit-animation-play-state:paused;animation-play-state:paused}.amp-video-eq[unpausable] .amp-video-eq-col div{-webkit-animation-name:none;animation-name:none}.amp-video-eq[unpausable].amp-video-eq-play .amp-video-eq-col div{-webkit-animation-name:amp-video-eq-animation;animation-name:amp-video-eq-animation}.amp-video-eq.amp-video-eq-play .amp-video-eq-col div{-webkit-animation-play-state:running;animation-play-state:running}.amp-video-eq-1-1{-webkit-animation-duration:0.3s;animation-duration:0.3s}.amp-video-eq-1-1,.amp-video-eq-1-2{-webkit-transform:translateY(60%);transform:translateY(60%)}.amp-video-eq-1-2{-webkit-animation-duration:0.45s;animation-duration:0.45s}.amp-video-eq-2-1{-webkit-animation-duration:0.5s;animation-duration:0.5s}.amp-video-eq-2-1,.amp-video-eq-2-2{-webkit-transform:translateY(30%);transform:translateY(30%)}.amp-video-eq-2-2{-webkit-animation-duration:0.4s;animation-duration:0.4s}.amp-video-eq-3-1{-webkit-animation-duration:0.3s;animation-duration:0.3s}.amp-video-eq-3-1,.amp-video-eq-3-2{-webkit-transform:translateY(70%);transform:translateY(70%)}.amp-video-eq-3-2{-webkit-animation-duration:0.35s;animation-duration:0.35s}.amp-video-eq-4-1{-webkit-animation-duration:0.4s;animation-duration:0.4s}.amp-video-eq-4-1,.amp-video-eq-4-2{-webkit-transform:translateY(50%);transform:translateY(50%)}.amp-video-eq-4-2{-webkit-animation-duration:0.25s;animation-duration:0.25s}@-webkit-keyframes amp-video-eq-animation{0%{-webkit-transform:translateY(100%);transform:translateY(100%)}to{-webkit-transform:translateY(0);transform:translateY(0)}}@keyframes amp-video-eq-animation{0%{-webkit-transform:translateY(100%);transform:translateY(100%)}to{-webkit-transform:translateY(0);transform:translateY(0)}}
.amp-social-share-facebook {background-image: url('data:image/svg+xml;charset=utf8,%3Csvg%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20viewBox%3D%220%200%20512%20512%22%3E%3Cpath%20fill%3D%22%23ffffff%22%20d%3D%22M211.9%20197.4h-36.7v59.9h36.7V433.1h70.5V256.5h49.2l5.2-59.1h-54.4c0%200%200-22.1%200-33.7%200-13.9%202.8-19.5%2016.3-19.5%2010.9%200%2038.2%200%2038.2%200V82.9c0%200-40.2%200-48.8%200%20-52.5%200-76.1%2023.1-76.1%2067.3C211.9%20188.8%20211.9%20197.4%20211.9%20197.4z%22%3E%3C%2Fpath%3E%3C%2Fsvg%3E');}
.amp-social-share-pinterest {background-image: url('data:image/svg+xml;charset=utf8,%3Csvg%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20viewBox%3D%220%200%20512%20512%22%3E%3Cpath%20fill%3D%22%23ffffff%22%20d%3D%22M266.6%2076.5c-100.2%200-150.7%2071.8-150.7%20131.7%200%2036.3%2013.7%2068.5%2043.2%2080.6%204.8%202%209.2%200.1%2010.6-5.3%201-3.7%203.3-13%204.3-16.9%201.4-5.3%200.9-7.1-3-11.8%20-8.5-10-13.9-23-13.9-41.3%200-53.3%2039.9-101%20103.8-101%2056.6%200%2087.7%2034.6%2087.7%2080.8%200%2060.8-26.9%20112.1-66.8%20112.1%20-22.1%200-38.6-18.2-33.3-40.6%206.3-26.7%2018.6-55.5%2018.6-74.8%200-17.3-9.3-31.7-28.4-31.7%20-22.5%200-40.7%2023.3-40.7%2054.6%200%2019.9%206.7%2033.4%206.7%2033.4s-23.1%2097.8-27.1%20114.9c-8.1%2034.1-1.2%2075.9-0.6%2080.1%200.3%202.5%203.6%203.1%205%201.2%202.1-2.7%2028.9-35.9%2038.1-69%202.6-9.4%2014.8-58%2014.8-58%207.3%2014%2028.7%2026.3%2051.5%2026.3%2067.8%200%20113.8-61.8%20113.8-144.5C400.1%20134.7%20347.1%2076.5%20266.6%2076.5z%22%2F%3E%3C%2Fsvg%3E');}
.amp-social-share-linkedin {background-image: url('data:image/svg+xml;charset=utf8,%3Csvg%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20viewBox%3D%220%200%20512%20512%22%3E%3Cpath%20fill%3D%22%23ffffff%22%20d%3D%22M186.4%20142.4c0%2019-15.3%2034.5-34.2%2034.5%20-18.9%200-34.2-15.4-34.2-34.5%200-19%2015.3-34.5%2034.2-34.5C171.1%20107.9%20186.4%20123.4%20186.4%20142.4zM181.4%20201.3h-57.8V388.1h57.8V201.3zM273.8%20201.3h-55.4V388.1h55.4c0%200%200-69.3%200-98%200-26.3%2012.1-41.9%2035.2-41.9%2021.3%200%2031.5%2015%2031.5%2041.9%200%2026.9%200%2098%200%2098h57.5c0%200%200-68.2%200-118.3%200-50-28.3-74.2-68-74.2%20-39.6%200-56.3%2030.9-56.3%2030.9v-25.2H273.8z%22%2F%3E%3C%2Fsvg%3E');}
.amp-social-share-gplus {background-image: url('data:image/svg+xml;charset=utf8,%3Csvg%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20viewBox%3D%220%200%20512%20512%22%3E%3Cpath%20fill%3D%22%23ffffff%22%20d%3D%22M179.7%20237.6L179.7%20284.2%20256.7%20284.2C253.6%20304.2%20233.4%20342.9%20179.7%20342.9%20133.4%20342.9%2095.6%20304.4%2095.6%20257%2095.6%20209.6%20133.4%20171.1%20179.7%20171.1%20206.1%20171.1%20223.7%20182.4%20233.8%20192.1L270.6%20156.6C247%20134.4%20216.4%20121%20179.7%20121%20104.7%20121%2044%20181.8%2044%20257%2044%20332.2%20104.7%20393%20179.7%20393%20258%20393%20310%20337.8%20310%20260.1%20310%20251.2%20309%20244.4%20307.9%20237.6L179.7%20237.6%20179.7%20237.6ZM468%20236.7L429.3%20236.7%20429.3%20198%20390.7%20198%20390.7%20236.7%20352%20236.7%20352%20275.3%20390.7%20275.3%20390.7%20314%20429.3%20314%20429.3%20275.3%20468%20275.3%22%2F%3E%3C%2Fsvg%3E');}
.amp-social-share-email {background-image: url('data:image/svg+xml;charset=utf8,%3Csvg%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20viewBox%3D%220%200%20512%20512%22%3E%3Cpath%20fill%3D%22%23ffffff%22%20d%3D%22M101.3%20141.6v228.9h0.3%20308.4%200.8V141.6H101.3zM375.7%20167.8l-119.7%2091.5%20-119.6-91.5H375.7zM127.6%20194.1l64.1%2049.1%20-64.1%2064.1V194.1zM127.8%20344.2l84.9-84.9%2043.2%2033.1%2043-32.9%2084.7%2084.7L127.8%20344.2%20127.8%20344.2zM384.4%20307.8l-64.4-64.4%2064.4-49.3V307.8z%22%2F%3E%3C%2Fsvg%3E');}
.amp-social-share-twitter {background-image: url('data:image/svg+xml;charset=utf8,%3Csvg%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20viewBox%3D%22-49%20141%20512%20512%22%3E%3Cpath%20fill%3D%22%23ffffff%22%20d%3D%22M432.9%2C256.9c-16.6%2C7.4-34.5%2C12.4-53.2%2C14.6c19.2-11.5%2C33.8-29.7%2C40.8-51.3c-17.9%2C10.6-37.8%2C18.4-58.9%2C22.5%20c-16.9-18-41-29.2-67.7-29.2c-51.2%2C0-92.7%2C41.5-92.7%2C92.7c0%2C7.2%2C0.8%2C14.3%2C2.4%2C21.1c-77-3.9-145.3-40.8-191.1-96.9%20C4.6%2C244%2C0%2C259.9%2C0%2C276.9C0%2C309%2C16.4%2C337.4%2C41.3%2C354c-15.2-0.4-29.5-4.7-42-11.6c0%2C0.4%2C0%2C0.8%2C0%2C1.1c0%2C44.9%2C31.9%2C82.4%2C74.4%2C90.9%20c-7.8%2C2.1-16%2C3.3-24.4%2C3.3c-6%2C0-11.7-0.6-17.5-1.7c11.8%2C36.8%2C46.1%2C63.6%2C86.6%2C64.4c-31.8%2C24.9-71.7%2C39.7-115.2%2C39.7%20c-7.5%2C0-14.8-0.4-22.2-1.3c41.1%2C26.4%2C89.8%2C41.7%2C142.2%2C41.7c170.5%2C0%2C263.8-141.3%2C263.8-263.8c0-4.1-0.1-8-0.3-12%20C404.8%2C291.8%2C420.5%2C275.5%2C432.9%2C256.9z%22%2F%3E%3C%2Fsvg%3E');}
.amp-social-share-tumblr {background-image: url('data:image/svg+xml;charset=utf8,%3Csvg%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20viewBox%3D%220%200%20512%20512%22%3E%3Cpath%20fill%3D%22%23ffffff%22%20d%3D%22M210.8%2080.3c-2.3%2018.3-6.4%2033.4-12.4%2045.2%20-6%2011.9-13.9%2022-23.9%2030.5%20-9.9%208.5-21.8%2014.9-35.7%2019.5v50.6h38.9v124.5c0%2016.2%201.7%2028.6%205.1%2037.1%203.4%208.5%209.5%2016.6%2018.3%2024.2%208.8%207.6%2019.4%2013.4%2031.9%2017.5%2012.5%204.1%2026.8%206.1%2043%206.1%2014.3%200%2027.6-1.4%2039.9-4.3%2012.3-2.9%2026-7.9%2041.2-15v-55.9c-17.8%2011.7-35.7%2017.5-53.7%2017.5%20-10.1%200-19.1-2.4-27-7.1%20-5.9-3.5-10-8.2-12.2-14%20-2.2-5.8-3.3-19.1-3.3-39.7v-91.1H345.5v-55.8h-84.4v-90H210.8z%22%2F%3E%3C%2Fsvg%3E');}
.amp-social-share-whatsapp {background-image: url('data:image/svg+xml,%3Csvg%20width%3D%22419%22%20height%3D%22421%22%20viewBox%3D%220%200%20419%20421%22%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20xmlns%3Axlink%3D%22http%3A%2F%2Fwww.w3.org%2F1999%2Fxlink%22%3E%3Ctitle%3Elogo%3C%2Ftitle%3E%3Cdefs%3E%3Cpath%20d%3D%22M299.558%20247.553c-5.111-2.558-30.242-14.925-34.928-16.633-4.685-1.706-8.092-2.557-11.5%202.559-3.408%205.117-13.204%2016.634-16.186%2020.046-2.98%203.41-5.963%203.84-11.074%201.279-5.112-2.559-21.582-7.956-41.106-25.375-15.195-13.556-25.455-30.296-28.436-35.414-2.982-5.118-.318-7.885%202.24-10.434%202.3-2.291%205.113-5.971%207.668-8.957%202.557-2.984%203.408-5.118%205.112-8.528%201.704-3.413.852-6.397-.426-8.956-1.278-2.558-11.5-27.723-15.76-37.96-4.15-9.968-8.363-8.618-11.501-8.776-2.978-.148-6.39-.18-9.796-.18-3.408%200-8.946%201.28-13.632%206.397-4.685%205.118-17.89%2017.487-17.89%2042.649%200%2025.165%2018.316%2049.473%2020.872%2052.885%202.556%203.413%2036.044%2055.05%2087.321%2077.193%2012.195%205.269%2021.716%208.414%2029.14%2010.77%2012.245%203.891%2023.388%203.342%2032.195%202.025%209.821-1.466%2030.243-12.366%2034.503-24.307%204.259-11.944%204.259-22.18%202.98-24.311-1.276-2.133-4.684-3.412-9.796-5.972m-93.266%20127.364h-.069c-30.511-.012-60.436-8.21-86.542-23.705l-6.21-3.685-64.353%2016.884%2017.177-62.753-4.043-6.435c-17.02-27.075-26.01-58.368-25.997-90.501.038-93.761%2076.315-170.043%20170.104-170.043%2045.416.015%2088.107%2017.727%20120.212%2049.872%2032.102%2032.143%2049.77%2074.87%2049.753%20120.308-.038%2093.77-76.314%20170.058-170.032%20170.058M351.003%2060.126C312.38%2021.452%20261.016.145%20206.29.122%2093.532.122%201.76%2091.901%201.715%20204.71c-.015%2036.06%209.405%2071.257%2027.307%20102.286L0%20413.02l108.447-28.452c29.88%2016.3%2063.523%2024.892%2097.761%2024.903h.084c112.747%200%20204.527-91.787%20204.573-204.597.02-54.67-21.239-106.074-59.862-144.747%22%20id%3D%22b%22%2F%3E%3Cfilter%20x%3D%22-50%25%22%20y%3D%22-50%25%22%20width%3D%22200%25%22%20height%3D%22200%25%22%20filterUnits%3D%22objectBoundingBox%22%20id%3D%22a%22%3E%3CfeMorphology%20radius%3D%221%22%20operator%3D%22dilate%22%20in%3D%22SourceAlpha%22%20result%3D%22shadowSpreadOuter1%22%2F%3E%3CfeOffset%20in%3D%22shadowSpreadOuter1%22%20result%3D%22shadowOffsetOuter1%22%2F%3E%3CfeColorMatrix%20values%3D%220%200%200%200%200%200%200%200%200%200%200%200%200%200%200%200%200%200%200.04%200%22%20in%3D%22shadowOffsetOuter1%22%2F%3E%3C%2Ffilter%3E%3C%2Fdefs%3E%3Cg%20fill%3D%22none%22%20fill-rule%3D%22evenodd%22%3E%3Cpath%20d%3D%22M117.472%20352.386l6.209%203.685c26.106%2015.494%2056.031%2023.693%2086.542%2023.704h.07c93.717%200%20169.993-76.288%20170.032-170.058.017-45.438-17.653-88.165-49.755-120.308-32.103-32.145-74.795-49.856-120.21-49.872-93.79%200-170.068%2076.282-170.105%20170.043-.013%2032.133%208.976%2063.427%2025.997%2090.501l4.043%206.435-17.177%2062.753%2064.354-16.883z%22%20fill%3D%22%2325D366%22%2F%3E%3Cg%20transform%3D%22translate(4%204.858)%22%3E%3Cuse%20fill%3D%22%23000%22%20filter%3D%22url(%23a)%22%20xlink%3Ahref%3D%22%23b%22%2F%3E%3Cuse%20fill%3D%22%23FFF%22%20xlink%3Ahref%3D%22%23b%22%2F%3E%3C%2Fg%3E%3C%2Fg%3E%3C%2Fsvg%3E');}
amp-social-share{background-repeat:no-repeat;background-position:center;background-size:contain;text-decoration:none;cursor:pointer;position:relative}.amp-social-share-twitter{background-color:#55acee}.amp-social-share-facebook{background-color:#3b5998}.amp-social-share-pinterest{background-color:#bd081c}.amp-social-share-linkedin{background-color:#0077b5}.amp-social-share-gplus{background-color:#dc4e41}.amp-social-share-tumblr{background-color:#3c5a77}.amp-social-share-email{background-color:#000}.amp-social-share-whatsapp{background-color:#25d366}

.b-lazy {background:url(http://i0.wp.com/image.prntscr.com/image/1a0fe394a4154d33855197554a00a409.gif);background-repeat:no-repeat;background-position:center;}
</style>
</head>
<body itemscope itemtype="http://schema.org/Recipe">
      <meta content="<?php echo $productimage;?>" itemprop="image" />
      <meta content="<?php echo $_GET['id'].' '.$resultdata['title'].' Price '.$resultdata['pricereal'];?>" itemprop="description" />
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

<!-- start content -->
<div class="wrap">
	<div class="fluid">
        <div class="sheader">
<?php
if(isset($resultdata['category']) && !empty($resultdata['category'])){
	echo breadcrumbsgen($resultdata['category']).' &raquo; '.$resultdata['title'];
}else{
	echo '<a href="/">Home</a> &raquo; '.$resultdata['title'];
}
?>
</div>
<h1 class="title" itemprop="name"><?php echo $resultdata['title'];?></h1>

        <div class="m-gallery">
            <div class="gallery">
                <div class="galleryImg">
                    <img id="main-img" class="b-lazy b-loaded  i-amphtml-fill-content -amp-fill-content i-amphtml-replaced-content -amp-replaced-content" src="<?php echo $productimage;?>" alt="<?php echo $resultdata['title'];?>" layout="responsive" width="750" height="750"/>
                </div>
            </div>
                        <div class="clear"></div>
        </div>
        <div class="info">
            <div class="info-grid font-price"><?php echo $resultdata['pricereal'];?></div>
                        <div class="info-grid font-seller">
            	<span class="powr" itemprop="ingredients">On sale &amp; posted by :</span>
                <div class="prwr">
<span class="g-seller" itemprop="author"><?php echo $resultdata['sellername'];?></span>
                </div>
                <div class="prwr">
                	<span class="g-shop" itemprop="ingredients"><?php echo $resultdata['sellerid'];?></span>
                </div>
                <div class="clear"></div>
            </div>
            <div class="info-grid font-updated">
            	<span>Start Sale :</span> <?php echo date('c');?> </div>
            <span class="font-ketoko" itemprop="ingredients" href="tel:+00"><?php echo $_GET['id'];?></span>
<div class="amp-thesahe">
<amp-social-share type="facebook" onclick="sharesocial('facebook'); return false;"  width="55" height="30" class="i-amphtml-element i-amphtml-layout-fixed i-amphtml-layout-size-defined amp-social-share-facebook i-amphtml-layout" style="width: 55px; height: 30px;" role="link"></amp-social-share>
<amp-social-share type="twitter" onclick="sharesocial('twitter'); return false;" width="55" height="30" class="i-amphtml-element i-amphtml-layout-fixed i-amphtml-layout-size-defined amp-social-share-twitter i-amphtml-layout" style="width: 55px; height: 30px;" role="link"></amp-social-share>
<amp-social-share type="gplus" onclick="sharesocial('googleplus'); return false;" width="55" height="30" class="i-amphtml-element i-amphtml-layout-fixed i-amphtml-layout-size-defined amp-social-share-gplus i-amphtml-layout" style="width: 55px; height: 30px;" role="link"></amp-social-share>
<amp-social-share type="pinterest" onclick="sharesocial('pinterest'); return false;" width="55" height="30" class="i-amphtml-element i-amphtml-layout-fixed i-amphtml-layout-size-defined amp-social-share-pinterest i-amphtml-layout" style="width: 55px; height: 30px;" role="link"></amp-social-share>
<amp-social-share type="whatsapp" onclick="sharesocial('whatsapp'); return false;" width="55" height="30" class="i-amphtml-element i-amphtml-layout-fixed i-amphtml-layout-size-defined amp-social-share-whatsapp i-amphtml-layout" style="width: 55px; height: 30px;" role="link"></amp-social-share>
<amp-social-share type="email" onclick="sharesocial('email'); return false;" width="55" height="30" class="i-amphtml-element i-amphtml-layout-fixed i-amphtml-layout-size-defined amp-social-share-email i-amphtml-layout" style="width: 55px; height: 30px;" role="link"></amp-social-share>
</div>		
        </div>
        <div class="clear"></div>	
<div class="product-info"><div class="product-title">Product Info</div><div class="product-content" itemprop="recipeInstructions" id="prod_deskripsi"><?php echo $resultdata['specifics'];?></div></div>

<div class="product-info"><div class="product-title">Product Related Search</div><div class="product-content" itemprop="recipeInstructions" id="prod_deskripsi">


  <span itemprop="aggregateRating" itemscope itemtype="http://schema.org/AggregateRating">
    Average rating: <span itemprop="ratingValue"><?php echo(mt_rand(4,5));
?></span>, based on
    <span itemprop="ratingCount"><?php echo(mt_rand(100,10000));
?></span> reviews
  </span>
  
<?php 
if(isset($resultdata['seosearch'])){
	if(!empty($resultdata['seosearch'])){
foreach($resultdata['seosearch'] as $thit){
	//$ftr[]= '<a href="/search/'.fixslug($thit).'.html">'.$thit.'</a>';
	$ftr[]= $thit;
}
	echo implode(' , ', $ftr);
	}
}	
?>
</div></div>

<div class="product-info"> <div class="product-title">Related Products</div> <div class="product-content"> <div class="itemLists">
			
<?php
if(isset($resultdata['related'])){
	if(!empty($resultdata['related'])){
		foreach($resultdata['related'] as $wejkl){
		$pttf= 	$wejkl['fullName'];
		$ptts= 	$wejkl['simpleName'];
		$pimgs= $wejkl['imagePath'];
		$pprice= $wejkl['localPrice'];
		$pprodid= $wejkl['productId'];
		$ptoken= string2key($pprodid);
		$psold= $wejkl['saleProductTotal'];
		$ppaths= trim(preg_replace('/((.*)item\/|\/(.*))/i', '', $wejkl['productDetailURL']));
$ppermalink= '/items/'.$pprodid.'_'.$ptoken.'/'.$ppaths.'.html';
		
			echo '<div class="items">
            	<div class="pImg">
                    <a href="'.$ppermalink.'" title="'.$pttf.'">
<img class="b-lazy i-amphtml-fill-content -amp-fill-content i-amphtml-replaced-content -amp-replaced-content" data-src="'.$pimgs.'" width="140" height="140" alt="'.$pttf.'" title="'.$pttf.'"/>
                	</a>
                </div>
            	<div class="cItems">
                	<h4 class="m-title">
                    	<a href="'.$ppermalink.'" title="'.$pttf.'">'.$ptts.'</a>
                    </h4>
                    <h3 class="m-price">'.$pprice.'</h3>
                    <div class="m-info">
                    	<div class="m-seller">'.$psold.' orders</div>
                    	<div class="m-shop"><a href="'.$ppermalink.'" rel="bookmark">Details Product</a></div>
                        <div class="clear"></div>
                    </div>
                </div>
            </div>';
		}
	}
}
?>						
			<div class="clear"></div></div></div></div>	


			</div>
</div>

<!-- ends content -->

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
        	Search results are displayed by <a href="https://www.google.com/webmasters/sitemaps/ping?sitemap=http://<?php echo $_SERVER['SERVER_NAME'];?>/sitemap.php" target="_blank"><?php echo $_SERVER['SERVER_NAME'];?></a> is as a reference. By using <?php echo $_SERVER['SERVER_NAME'];?> services, you agree to comply with this regulation.
            </div>
            <div class="foot-copyright">
        	Copyright &copy; <span><?php echo $_SERVER['SERVER_NAME'];?></span> 2016
        	</div>
        </div>
    </div>
</div>
<script>
function sharesocial(source){var thetitles=document.title;var social='';if(source == 'googleplus'){social = 'https://plus.google.com/share?url=';}if(source == 'facebook'){social = 'https://www.facebook.com/dialog/share?app_id=254325784911610&href=';}if(source == 'twitter'){social = 'https://twitter.com/intent/tweet?text='+thetitles+'&url=';}if(source == 'pinterest'){social = 'https://pinterest.com/pin/create/button/?url=';}if(source == 'whatsapp'){social = 'whatsapp://send?text='+thetitles+' - ';}if(source == 'email'){social = 'mailto:?subject='+thetitles+'&body=';}var strWindowFeatures = "location=yes";var URL = social+location.href;var win = window.open(URL, "_blank", strWindowFeatures);return false;}
(function(p,m){"function"===typeof define&&define.amd?define(m):"object"===typeof exports?module.exports=m():p.Blazy=m()})(this,function(){function p(b){var c=b._util;c.elements=B(b.options.selector);c.count=c.elements.length;c.destroyed&&(c.destroyed=!1,b.options.container&&k(b.options.container,function(a){n(a,"scroll",c.validateT)}),n(window,"resize",c.save_viewportOffsetT),n(window,"resize",c.validateT),n(window,"scroll",c.validateT));m(b)}function m(b){for(var c=b._util,a=0;a<c.count;a++){var d=c.elements[a],f=d.getBoundingClientRect();if(f.right>=e.left&&f.bottom>=e.top&&f.left<=e.right&&f.top<=e.bottom||q(d,b.options.successClass))b.load(d),c.elements.splice(a,1),c.count--,a--}0===c.count&&b.destroy()}function x(b,c,a){if(!q(b,a.successClass)&&(c||a.loadInvisible||0<b.offsetWidth&&0<b.offsetHeight))if(c=b.getAttribute(r)||b.getAttribute(a.src)){c=c.split(a.separator);var d=c[y&&1<c.length?1:0],f="img"===b.nodeName.toLowerCase();if(f||void 0===b.src){var l=new Image,u=function(){a.error&&a.error(b,"invalid");t(b,a.errorClass);g(l,"error",u);g(l,"load",h)},h=function(){if(f){b.src=d;v(b,"srcset",a.srcset);var c=b.parentNode;c&&"picture"===c.nodeName.toLowerCase()&&k(c.getElementsByTagName("source"),function(b){v(b,"srcset",a.srcset)})}else b.style.backgroundImage='url("'+d+'")';w(b,a);g(l,"load",h);g(l,"error",u)};n(l,"error",u);n(l,"load",h);l.src=d}else b.src=d,w(b,a)}else"video"===b.nodeName.toLowerCase()?(k(b.getElementsByTagName("source"),function(b){v(b,"src",a.src)}),b.load(),w(b,a)):(a.error&&a.error(b,"missing"),t(b,a.errorClass))}function w(b,c){t(b,c.successClass);c.success&&c.success(b);b.removeAttribute(c.src);k(c.breakpoints,function(a){b.removeAttribute(a.src)})}function v(b,c,a){var d=b.getAttribute(a);d&&(b[c]=d,b.removeAttribute(a))}function q(b,c){return-1!==(" "+b.className+" ").indexOf(" "+c+" ")}function t(b,c){q(b,c)||(b.className+=" "+c)}function B(b){var c=[];b=document.querySelectorAll(b);for(var a=b.length;a--;c.unshift(b[a]));return c}function z(b){e.bottom=(window.innerHeight||document.documentElement.clientHeight)+b;e.right=(window.innerWidth||document.documentElement.clientWidth)+b}function n(b,c,a){b.attachEvent?b.attachEvent&&b.attachEvent("on"+c,a):b.addEventListener(c,a,!1)}function g(b,c,a){b.detachEvent?b.detachEvent&&b.detachEvent("on"+c,a):b.removeEventListener(c,a,!1)}function k(b,c){if(b&&c)for(var a=b.length,d=0;d<a&&!1!==c(b[d],d);d++);}function A(b,c,a){var d=0;return function(){var f=+new Date;f-d<c||(d=f,b.apply(a,arguments))}}var r,e,y;return function(b){if(!document.querySelectorAll){var c=document.createStyleSheet();document.querySelectorAll=function(a,b,d,h,e){e=document.all;b=[];a=a.replace(/\[for\b/gi,"[htmlFor").split(",");for(d=a.length;d--;){c.addRule(a[d],"k:v");for(h=e.length;h--;)e[h].currentStyle.k&&b.push(e[h]);c.removeRule(0)}return b}}var a=this,d=a._util={};d.elements=[];d.destroyed=!0;a.options=b||{};a.options.error=a.options.error||!1;a.options.offset=a.options.offset||100;a.options.success=a.options.success||!1;a.options.selector=a.options.selector||".b-lazy";a.options.separator=a.options.separator||"|";a.options.container=a.options.container?document.querySelectorAll(a.options.container):!1;a.options.errorClass=a.options.errorClass||"b-error";a.options.breakpoints=a.options.breakpoints||!1;a.options.loadInvisible=a.options.loadInvisible||!1;a.options.successClass=a.options.successClass||"b-loaded";a.options.validateDelay=a.options.validateDelay||25;a.options.save_viewportOffsetDelay=a.options.save_viewportOffsetDelay||50;a.options.srcset=a.options.srcset||"data-srcset";a.options.src=r=a.options.src||"data-src";y=1<window.devicePixelRatio;e={};e.top=0-a.options.offset;e.left=0-a.options.offset;a.revalidate=function(){p(this)};a.load=function(a,b){var c=this.options;void 0===a.length?x(a,b,c):k(a,function(a){x(a,b,c)})};a.destroy=function(){var a=this._util;this.options.container&&k(this.options.container,function(b){g(b,"scroll",a.validateT)});g(window,"scroll",a.validateT);g(window,"resize",a.validateT);g(window,"resize",a.save_viewportOffsetT);a.count=0;a.elements.length=0;a.destroyed=!0};d.validateT=A(function(){m(a)},a.options.validateDelay,a);d.save_viewportOffsetT=A(function(){z(a.options.offset)},a.options.save_viewportOffsetDelay,a);z(a.options.offset);k(a.options.breakpoints,function(a){if(a.width>=window.screen.width)return r=a.src,!1});setTimeout(function(){p(a)})}});
var bLazy=new Blazy({error:function(a,b){a.src="http://i.imgur.com/zyClULV.jpg"}});
</script>

<!-- Go to www.addthis.com/dashboard to customize your tools -->
<script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-58f910cdf9228e95"></script>


</body>
</html>