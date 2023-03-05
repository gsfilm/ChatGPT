<?php
	class ChatGPT{
		private $API_KEY	= "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";
		private $textURL	= "https://api.openai.com/v1/completions";
		private $imageURL	= "https://api.openai.com/v1/images/generations";
		public $curl;		// 创建CURL对象
		public $data = [];	// 请求数据数组
		public function __construct(){
			$this->curl = curl_init();
		}

		public function initialize($requestType = "text" || "image"){
			$this->curl = curl_init();
			if ($requestType === 'image')
				curl_setopt($this->curl, CURLOPT_URL, $this->imageURL);
			if ($requestType === 'text')
				curl_setopt($this->curl, CURLOPT_URL, $this->textURL);
			curl_setopt($this->curl, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($this->curl, CURLOPT_POST, true);
			curl_setopt($this->curl, CURLOPT_PROXY, "173.82.209.215");
			curl_setopt($this->curl, CURLOPT_PROXYPORT, 33658);
			curl_setopt($this->curl, CURLOPT_PROXYUSERPWD, "igmsy:admin5828110");
			$headers = array(
				"Content-Type: application/json",
				"Authorization: Bearer $this->API_KEY"
			);
			curl_setopt($this->curl, CURLOPT_HTTPHEADER, $headers);
		}

		// 返回 Text 文本
		public function createTextRequest($prompt, $model = 'text-davinci-003', $temperature = 0.5, $maxTokens = 1000){
			curl_reset($this->curl);
			$this->initialize('text');
			$this->data["model"] = $model;
			$this->data["prompt"] = $prompt;
			$this->data["temperature"] = $temperature;
			$this->data["max_tokens"] = $maxTokens;
			curl_setopt($this->curl, CURLOPT_POSTFIELDS, json_encode($this->data));
			$response = curl_exec($this->curl);
			$response = json_decode($response, true);
			return $response['choices'][0]['text'] ?? '网络拥堵，请重试...';	// 返回文本 OR 错误信息
		}

		// 返回带有图像的 Url
		public function generateImage($prompt, $imageSize = '512x512', $numberOfImages = 1){
			curl_reset($this->curl);
			$this->initialize('image');
			$this->data["prompt"] = $prompt;
			$this->data["n"] = $numberOfImages;
			$this->data["size"] = $imageSize;
			curl_setopt($this->curl, CURLOPT_POSTFIELDS, json_encode($this->data));
			$response = curl_exec($this->curl);
			$response = json_decode($response, true);
			return $response['data'][0]['url'] ?? '网络拥堵，请重试...';	// 返回图像地址 OR 错误信息
		}
	}
?>