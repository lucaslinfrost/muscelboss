<?php
//星座功能介面 (文字版)
require_once('./LINEBotTiny.php');
require_once('./utf8_chinese.class.php');
$channelAccessToken = getenv('LINE_CHANNEL_ACCESSTOKEN');
$channelSecret = getenv('LINE_CHANNEL_SECRET');

$client = new LINEBotTiny($channelAccessToken, $channelSecret);
// 取得事件(只接受文字訊息)
foreach ($client->parseEvents() as $event) {
switch ($event['type']) {       
    case 'message':
        // 讀入訊息
        $message = $event['message'];
        $c = new utf8_chinese;
        $message['text'] = $c->gb2312_big5($message['text']);
        $code = explode(' ', $message['text']);
        
        if (strpos($code[1], '白羊') !== false||strpos($code[1], '牡羊') != false||strpos($code[1], '牧羊') != false){$snum = '0';}
        if (strpos($code[1], '金牛') !== false||strpos($code[1], '牡牛') != false||strpos($code[1], '牧牛') != false){$snum = '1';}
        if (strpos($code[1], '雙子') !== false){$snum = '2';}
        if (strpos($code[1], '巨蟹') !== false){$snum = '3';}
        if (strpos($code[1], '獅子') !== false){$snum = '4';}
        if (strpos($code[1], '處女') !== false){$snum = '5';}
        if (strpos($code[1], '天秤') !== false||strpos($code[1], '天平') != false){$snum = '6';}
        if (strpos($code[1], '天蠍') !== false){$snum = '7';}
        if (strpos($code[1], '射手') !== false){$snum = '8';}
        if (strpos($code[1], '魔羯') !== false||strpos($code[1], '山羊') != false||strpos($code[1], '摩羯') != false){$snum = '9';}
        if (strpos($code[1], '水瓶') !== false||strpos($code[1], '寶瓶') != false){$snum = '10';}
        if (strpos($code[1], '雙魚') !== false){$snum = '11';}
        
        $url = 'http://astro.click108.com.tw/daily_0.php?iAstro='.$snum;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_FILE, fopen('php://stdout', 'w'));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_URL, $url);
        $html = curl_exec($ch); 
        curl_close($ch);
        // create document object model
        $dom = new DOMDocument();
        // load html into document object model
        @$dom->loadHTML('<?xml encoding="UTF-8">' . $html);
        // create domxpath instance
        $xPath = new DOMXPath($dom);
        // get all elements with a particular id and then loop through and print the href attribute
        $data1 = $xPath->evaluate('string(//*[@class="TODAY_CONTENT"]/p[1]/span/text())');
        $data2 = $xPath->evaluate('string(//*[@class="TODAY_CONTENT"]/p[2]/text())');
        $data3 = $xPath->evaluate('string(//*[@class="TODAY_CONTENT"]/p[3]/span/text())');
        $data4 = $xPath->evaluate('string(//*[@class="TODAY_CONTENT"]/p[4]/text())');
        $data5 = $xPath->evaluate('string(//*[@class="TODAY_CONTENT"]/p[5]/span/text())');
        $data6 = $xPath->evaluate('string(//*[@class="TODAY_CONTENT"]/p[6]/text())');
        $data1 = $xPath->evaluate('string(//*[@class="TODAY_CONTENT"]/p[7]/span/text())');
        $data8 = $xPath->evaluate('string(//*[@class="TODAY_CONTENT"]/p[8]/text())');

$dataall = $data1."\n".$data2."\n\n".$data3."\n".$data4."\n\n".$data5."\n".$data6."\n\n".$data7."\n".$data8;
        
error_log("星座第【".$snum."】號。
網址為
【".$url."】");
        
        break;
    default:
        error_log("Unsupporeted event type: " . $event['type']);
        break;
}
};