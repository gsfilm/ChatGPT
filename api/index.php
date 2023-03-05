<?
	require_once ( $_SERVER['DOCUMENT_ROOT']."/api/ChatAPI.php" );
	$prompt = $_POST['prompt'];
	$Chat = new Chat();
	/*$msg = $Chat->post('你好');
	echo $msg;*/
	
	/*$url = "https://api.gpt87.com/api/send?message=你好";
	$data = array('message'=>'你好');
	print_r ($Chat->http($url,$data));*/
	
	//发起get请求并携参数不带header值
	$string_data =http_build_query(array('message'=>'你好'));
	$url = 'https://api.gpt87.com/api/send?' . $string_data;
	print_r ($Chat->http($url,$data));
?>