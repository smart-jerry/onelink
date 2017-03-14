<?php
	function sendApiRequest($url, $params = array(), $type = 'GET', $headers = array(), $timeout = 5, $getHttpCode = false){
		$ch = curl_init();
		if($type == 'GET'){
			if($params){
				foreach($params as $paramKey=>$paramVal){
					$paramArr[] = $paramKey.'='.$paramVal;
				}
				$url = $url.'?'.implode('&',$paramArr);
			}
		}
		curl_setopt ($ch, CURLOPT_URL, $url);
		if($headers){
			curl_setopt ($ch, CURLOPT_HTTPHEADER, $headers);
		}
		curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_NOSIGNAL, true);               //注意，毫秒超时一定要设置这个
		curl_setopt($ch, CURLOPT_TIMEOUT_MS, $timeout*1000);   //超时时间200毫秒
		switch ($type){
			case "GET" :
				curl_setopt($ch, CURLOPT_HTTPGET, true);
				break;
			case "POST":
				curl_setopt($ch, CURLOPT_POST,true);
				curl_setopt($ch, CURLOPT_POSTFIELDS,$params);
				break;
			case "POSTSTRING":
				curl_setopt($ch, CURLOPT_POST,true);
				$postDataStr = implode('&',$params);
				curl_setopt($ch, CURLOPT_POSTFIELDS,$postDataStr);
				break;
			case "PUT" :
				curl_setopt ($ch, CURLOPT_CUSTOMREQUEST, "PUT");
				curl_setopt($ch, CURLOPT_POSTFIELDS,http_build_query($params));
				break;
			case "DELETE":
				curl_setopt ($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
				curl_setopt($ch, CURLOPT_POSTFIELDS,$params);
				break;
		}
		$result = curl_exec($ch);
		if($getHttpCode) {
			$httpCode = curl_getinfo($ch,CURLINFO_HTTP_CODE);
		}
		curl_close($ch);
		if($getHttpCode) {
			return array(
				'status' => $httpCode,
				'data' => $result
			);
		} else {
			return $result;
		}
	}
?>