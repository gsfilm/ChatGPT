<?php
	class Chat{
		public function post($prompt){ 
			$request_body = [
			"message" => $prompt
			];
			$postfields = json_encode($request_body);
			$curl = curl_init();
			curl_setopt_array($curl, [
				CURLOPT_URL => "https://api.gpt87.com/api/send",
				CURLOPT_RETURNTRANSFER => true,
				CURLOPT_FOLLOWLOCATION => true,
				CURLOPT_ENCODING => "",
				CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
				CURLOPT_CUSTOMREQUEST => "POST",
				CURLOPT_POSTFIELDS => $postfields,
				CURLOPT_HTTPHEADER => [
					'Content-Type: application/json'
				],
			]);
			$response = curl_exec($curl);
			$response = json_decode($response, true);
			return $response ?? '网络拥堵，请重试...';	// 返回文本 OR 错误信息
			curl_close($curl);
		}
		/**
		* @param string $url 请求地址
		* @param array $data 请求参数 
		* @param array $header 设置头部参数
		* @param bool $json  是否已json格式发送post请求
		*  @return string 返回json字符串
		*/
		function http($url, $data = [], $header = [], $json = true):string{
			set_time_limit(0);
			$curl = curl_init();
			curl_setopt($curl, CURLOPT_URL, $url);
			if (!empty($header)) {
				curl_setopt($curl, CURLOPT_HTTPHEADER, $header);
			}
			curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
			curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
			curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 120);
			curl_setopt($curl, CURLOPT_POST, true);
			if (!empty($data)) {
				if ($json && is_array($data)) {
					$data = json_encode($data);
				}
				curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
				if ($json) { //发送JSON数据
					curl_setopt($curl, CURLOPT_HEADER, 0);
					curl_setopt(
						$curl,
						CURLOPT_HTTPHEADER,
						array(
							'Content-Type: application/json; charset=utf-8',
							'Content-Length:' . strlen($data)
						)
					);
				}
			}
			curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
			$res = curl_exec($curl);
			/*$errorno = curl_errno($curl);
			if ($errorno) {
				return false;
			}*/
			curl_close($curl);
			return $res;
		}
	}
?>