<?php include "common/utils.php"; ?>
<?php
$goodsInfo = array();
if (isset($_GET['jy_url_app']) && $_GET['jy_url_app']) {
	//正则匹配取值
	$str = urldecode($_GET['jy_url_app']);
	$id=0;$type=0;$langCode=11;
	//webview
	$linkIndex = strpos($str,'webview');
	if($linkIndex === 0 || $linkIndex > 0){
		$strWebview=substr($str, $linkIndex+8);
		$strWebview=base64_decode(urldecode($strWebview));//echo $str;exit;
		parse_str($strWebview, $output);
		$id=$output['edtionId'];
		$type=1;
		//echo $output['edtionId']; exit;
	}

	//goods
	$linkIndex1 = strpos($str,'goods');
	if($linkIndex1 === 0 || $linkIndex1 > 0){
		$id=substr($str, $linkIndex1+6);
		$type=0;
	}

	//域名判断
	$serverSite="http://app.jollychic.com";
	if($id!==0){
		$goodsService = sendApiRequest(
			$serverSite.'/goods/getShareUrl.do'
			,json_encode(array('id' => $id,'type' => $type,'lang' =>$langCode)),
			'POST',
			array('Content-Type: text/json')
		);//echo $goodsService;exit;
		$goodsService = json_decode($goodsService,true);
		$goodsInfo['goods_img']=$goodsService['shareGoodsImgUrl'];
		if(!$goodsInfo['goods_img']){
			$goodsInfo['goods_img']=$goodsService['shareEdtionSmallImgUrl'];
		}
	}
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" id="viewport" content="width=device-width,initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0">
	<title>nimini</title>
	<link rel="icon" href="images/favicon.ico" type="image/x-icon"/>
	<meta property="og:title" content="خرید آنلاین همه دسته بندی ها در نی می نی" />
	<meta property="og:description" content="زمان آن رسیده که برنامه را نصب کرده و از قیمت ها و تخفیف های فوق العاده بهره مند شوید. بهترین برنامه برای خرید و لذت بردن از مد و فشن های روز." />
	<?php  if(isset($goodsInfo['goods_img'])){ ?>
	<meta property="og:image" content="<?php echo $goodsInfo['goods_img'];?>" />
	<?php } ?>
	<!--配合APP设置的Meta标签-->
	<?php
	$deepLinkStr=isset($_GET['jy_url_app']) ? urldecode($_GET['jy_url_app']): "nimini://home";
	//echo $deepLinkStr;exit;
	?>
	<meta property="al:android:url" content="<?php echo $deepLinkStr;?>">
	<meta property="al:android:app_store_id" content="944846798">
	<meta property="al:android:app_name" content="nimini">
	<meta property="al:android:package" content="com.jollycorp.nimini">
	<meta property="al:ios:url" content="<?php echo $deepLinkStr;?>">
	<meta property="al:ios:app_store_id" content="944846798">
	<meta property="al:ios:app_name" content="nimini">
	<meta property="al:ios:package" content="com.jollycorp.nimini">
	<style>
		html{
			height: 100%;
		}
		.wrap{
			top:50%;
			width: 100%;
			position: absolute;
			margin-top: -76px;
		}
		.logo{
			width: 190px;
			height: 32px;
			margin: 0 auto;
			overflow: hidden;
		}
		.loading{
			width: 60px;
			height: 60px;
			margin: 60px auto 0;
			overflow: hidden;
		}
	</style>
	<script src="//www.jollychic.com/cms/track/1.0.1/trackError.js"></script>
</head>
<body>
<script>
	var winWidths = (document.body) && (document.body.clientWidth) ? document.body.clientWidth : window.innerWidth;
	var defaultWidth = 750;
	var viewport = document.getElementById('viewport');
	var appScale = winWidths >= defaultWidth ? 1 :(winWidths / defaultWidth);
	viewport.content = 'width=device-width,initial-scale=' + appScale + ', minimum-scale=' + appScale + ', maximum-scale=' + appScale;
</script>
<div class="wrap">
	<div class="logo">
		<img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAL4AAAAgCAYAAACsGMKuAAAAGXRFWHRTb2Z0d2FyZQBBZG9iZSBJbWFnZVJlYWR5ccllPAAAAyZpVFh0WE1MOmNvbS5hZG9iZS54bXAAAAAAADw/eHBhY2tldCBiZWdpbj0i77u/IiBpZD0iVzVNME1wQ2VoaUh6cmVTek5UY3prYzlkIj8+IDx4OnhtcG1ldGEgeG1sbnM6eD0iYWRvYmU6bnM6bWV0YS8iIHg6eG1wdGs9IkFkb2JlIFhNUCBDb3JlIDUuNi1jMDY3IDc5LjE1Nzc0NywgMjAxNS8wMy8zMC0yMzo0MDo0MiAgICAgICAgIj4gPHJkZjpSREYgeG1sbnM6cmRmPSJodHRwOi8vd3d3LnczLm9yZy8xOTk5LzAyLzIyLXJkZi1zeW50YXgtbnMjIj4gPHJkZjpEZXNjcmlwdGlvbiByZGY6YWJvdXQ9IiIgeG1sbnM6eG1wPSJodHRwOi8vbnMuYWRvYmUuY29tL3hhcC8xLjAvIiB4bWxuczp4bXBNTT0iaHR0cDovL25zLmFkb2JlLmNvbS94YXAvMS4wL21tLyIgeG1sbnM6c3RSZWY9Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC9zVHlwZS9SZXNvdXJjZVJlZiMiIHhtcDpDcmVhdG9yVG9vbD0iQWRvYmUgUGhvdG9zaG9wIENDIDIwMTUgKFdpbmRvd3MpIiB4bXBNTTpJbnN0YW5jZUlEPSJ4bXAuaWlkOkUwREJBRDZEMDJGNjExRTdCNDVEQzc5QjcyNUI3NkY3IiB4bXBNTTpEb2N1bWVudElEPSJ4bXAuZGlkOkUwREJBRDZFMDJGNjExRTdCNDVEQzc5QjcyNUI3NkY3Ij4gPHhtcE1NOkRlcml2ZWRGcm9tIHN0UmVmOmluc3RhbmNlSUQ9InhtcC5paWQ6RTBEQkFENkIwMkY2MTFFN0I0NURDNzlCNzI1Qjc2RjciIHN0UmVmOmRvY3VtZW50SUQ9InhtcC5kaWQ6RTBEQkFENkMwMkY2MTFFN0I0NURDNzlCNzI1Qjc2RjciLz4gPC9yZGY6RGVzY3JpcHRpb24+IDwvcmRmOlJERj4gPC94OnhtcG1ldGE+IDw/eHBhY2tldCBlbmQ9InIiPz55QY0SAAALzklEQVR42uRc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" width="190" height="32" />
	</div>
	<div class="loading">
		<img src="data:image/gif;base64,R0lGODlhPAA8AKIHAP///8zMzJmZme7u7t3d3bu7u6qqqv///yH/C05FVFNDQVBFMi4wAwEAAAAh/wtYTVAgRGF0YVhNUDw/eHBhY2tldCBiZWdpbj0i77u/IiBpZD0iVzVNME1wQ2VoaUh6cmVTek5UY3prYzlkIj8+IDx4OnhtcG1ldGEgeG1sbnM6eD0iYWRvYmU6bnM6bWV0YS8iIHg6eG1wdGs9IkFkb2JlIFhNUCBDb3JlIDUuNi1jMDY3IDc5LjE1Nzc0NywgMjAxNS8wMy8zMC0yMzo0MDo0MiAgICAgICAgIj4gPHJkZjpSREYgeG1sbnM6cmRmPSJodHRwOi8vd3d3LnczLm9yZy8xOTk5LzAyLzIyLXJkZi1zeW50YXgtbnMjIj4gPHJkZjpEZXNjcmlwdGlvbiByZGY6YWJvdXQ9IiIgeG1sbnM6eG1wPSJodHRwOi8vbnMuYWRvYmUuY29tL3hhcC8xLjAvIiB4bWxuczp4bXBNTT0iaHR0cDovL25zLmFkb2JlLmNvbS94YXAvMS4wL21tLyIgeG1sbnM6c3RSZWY9Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC9zVHlwZS9SZXNvdXJjZVJlZiMiIHhtcDpDcmVhdG9yVG9vbD0iQWRvYmUgUGhvdG9zaG9wIENDIDIwMTUgKE1hY2ludG9zaCkiIHhtcE1NOkluc3RhbmNlSUQ9InhtcC5paWQ6QkZCNDYyOTA0RkZBMTFFNjlEQ0JFOTEyMEE0RDM2OTYiIHhtcE1NOkRvY3VtZW50SUQ9InhtcC5kaWQ6QkZCNDYyOTE0RkZBMTFFNjlEQ0JFOTEyMEE0RDM2OTYiPiA8eG1wTU06RGVyaXZlZEZyb20gc3RSZWY6aW5zdGFuY2VJRD0ieG1wLmlpZDpCRkI0NjI4RTRGRkExMUU2OURDQkU5MTIwQTREMzY5NiIgc3RSZWY6ZG9jdW1lbnRJRD0ieG1wLmRpZDpCRkI0NjI4RjRGRkExMUU2OURDQkU5MTIwQTREMzY5NiIvPiA8L3JkZjpEZXNjcmlwdGlvbj4gPC9yZGY6UkRGPiA8L3g6eG1wbWV0YT4gPD94cGFja2V0IGVuZD0iciI/PgH//v38+/r5+Pf29fTz8vHw7+7t7Ovq6ejn5uXk4+Lh4N/e3dzb2tnY19bV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" width="60" height="60" />
	</div>
</div>
<script src="http://m.jollychic.com/special/onelink2016/min/nativeSchema.js?1.0.15"></script>
<script>
if (typeof(nativeSchema) !== "undefined") {
	nativeSchema.loadSchema({
		loadWaiting:3000,
		protocol:"nimini://",
		failIosUrl:"",
		failAndroidUrl:""
	});
}
</script>
</body>
</html>