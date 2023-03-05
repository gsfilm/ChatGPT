<?php
	class Api{
		private function secret_key(){
			return $secret_key = 'Bearer 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';
		}

		public function post($engine, $prompt, $max_tokens){ 

			$request_body = [
			"prompt" => $prompt,
			"max_tokens" => $max_tokens,
			"temperature" => 0.7,
			"top_p" => 1,
			"presence_penalty" => 0.75,
			"frequency_penalty"=> 0.75,
			"best_of"=> 1,
			"stream" => false,
			];

			$postfields = json_encode($request_body);
			$curl = curl_init();
			curl_setopt_array($curl, [
				CURLOPT_URL => "https://api.openai.com/v1/engines/" . $engine . "/completions",
				CURLOPT_RETURNTRANSFER => true,
				CURLOPT_FOLLOWLOCATION => true,
				CURLOPT_ENCODING => "",
				CURLOPT_MAXREDIRS => 10,
				CURLOPT_TIMEOUT => 30,
				CURLOPT_PROXY => "173.82.209.215",
				CURLOPT_PROXYPORT => 33658,
				CURLOPT_PROXYUSERPWD => "igmsy:admin5828110",
				CURLOPT_PROXYTYPE => CURLPROXY_HTTP,
				CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
				CURLOPT_CUSTOMREQUEST => "POST",
				CURLOPT_POSTFIELDS => $postfields,
				CURLOPT_HTTPHEADER => [
					'Content-Type: application/json',
					'Authorization: ' . $this->secret_key()
				],
			]);

			$response = curl_exec($curl);
			$response = json_decode($response, true);
			return $response['choices'][0]['text'] ?? '网络拥堵，请重试...';	// 返回文本 OR 错误信息
			curl_close($curl);
		}
	}
?>