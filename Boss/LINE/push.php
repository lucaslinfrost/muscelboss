<?php
// HTTPヘッダを設定
$channelToken = getenv('LINE_CHANNEL_ACCESSTOKEN');
$headers = [
	'Authorization: Bearer ' . $channelToken,
	'Content-Type: application/json; charset=utf-8',
];

// POSTデータを設定してJSONにエンコード
$post = [
	'to' => 'U050cf6e710dac0fbccf92d605a991d90',
	'messages' => [
		[
			'type' => 'text',
			'text' => '@3@',
		],
	],
];
$post = json_encode($post);

// HTTPリクエストを設定
$ch = curl_init('https://api.line.me/v2/bot/message/push');
$options = [
	CURLOPT_CUSTOMREQUEST => 'POST',
	CURLOPT_HTTPHEADER => $headers,
	CURLOPT_RETURNTRANSFER => true,
	CURLOPT_BINARYTRANSFER => true,
	CURLOPT_HEADER => true,
	CURLOPT_POSTFIELDS => $post,
];
curl_setopt_array($ch, $options);

// 実行
$result = curl_exec($ch);

// エラーチェック
$errno = curl_errno($ch);
if ($errno) {
	return;
}

// HTTPステータスを取得
$info = curl_getinfo($ch);
$httpStatus = $info['http_code'];

$responseHeaderSize = $info['header_size'];
$body = substr($result, $responseHeaderSize);

// 200 だったら OK
echo $httpStatus . ' ' . $body;
