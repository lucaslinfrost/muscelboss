<?php

//星座功能介面 (文字版)

require_once('./LINEBotTiny.php');
$channelAccessToken = getenv('LINE_CHANNEL_ACCESSTOKEN');
$channelSecret = getenv('LINE_CHANNEL_SECRET');
$googledataspi = getenv('googledataspi4');
$client = new LINEBotTiny($channelAccessToken, $channelSecret);

// 取得事件(只接受文字訊息)
foreach ($client->parseEvents() as $event) {
switch ($event['type']) {       
    case 'message':
        // 讀入訊息
        $message = $event['message'];

        // 將Google表單轉成JSON資料
        $json = file_get_contents($googledataspi);
        $data = json_decode($json, true);
        $code = explode(' ', $message['text']);
        $datatime = date("Y-m-d");
        $dataall = "沒有這個星座的運勢資訊。";
        // 資料起始從feed.entry          
        foreach ($data['feed']['entry'] as $item) {
            // 將keywords欄位依,切成陣列
            $keywords = explode(',', $item['gsx$key']['$t']);
            // 以關鍵字比對文字內容
            foreach ($keywords as $keyword) {
                if (strpos($code[1], $keyword) !== false) {
                $dataall = $item['gsx$data1']['$t']." (".$datatime.")\n\n".$item['gsx$data2']['$t']."\n".$item['gsx$data3']['$t']."\n\n".$item['gsx$data4']['$t']."\n".$item['gsx$data5']['$t']."\n\n".$item['gsx$data6']['$t']."\n".$item['gsx$data7']['$t']."\n\n".$item['gsx$data8']['$t']."\n".$item['gsx$data9']['$t']."\n\n今日短評：\n".$item['gsx$data10']['$t']."\n\n幸運數字：".$item['gsx$data11']['$t']."\n\n幸運顏色：".$item['gsx$data12']['$t']."\n\n開運方位：".$item['gsx$data13']['$t']."\n\n今日吉時：".$item['gsx$data14']['$t']."\n\n幸運星座：".$item['gsx$data15']['$t'];
                }
            }
        }
        break;
    default:
        error_log("Unsupporeted event type: " . $event['type']);
        break;
}
};