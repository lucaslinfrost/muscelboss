<?php

if(preg_match("/#/u", $text)){
        $text = mb_substr($text,1);
        //memory.jsonを検索
        //* するためにmemory.jsonを読み込み
        $url = "./json/memory.json";
        $raw_json = file_get_contents($url);
        if($raw_json === false){
            error_log('failed to load json file(cash.json).');
        }
        $memory_json = json_decode($raw_json);
        //*keyを元に検索
        $key = array_search($text, $memory_json);
        $tail = ["", "！", "笑", "ｗｗｗｗ", "↑↑"];
        if(($key)!= FALSE){
            $bot->replyText($event->getReplyToken(), $memory_json[++$key].selectArray($tail));
            exit;
        }
      //preference.json->modeを書き換え
        $pref_json->mode = "input";
        $w_json = fopen("./json/preference.json", "w+b");
        fwrite($w_json, json_encode($pref_json));
        fclose($w_json);
        //cash.jsonをデコード
        $url = "./json/cash.json";
        $raw_json = file_get_contents($url);
        if($raw_json === false){
          error_log('failed to load json file(cash.json).');
        }
        $cash_json = json_decode($raw_json);
        //cash.jsonを書き換え
        $cash_json->pre_message = $text;
        $w_json = fopen("./json/cash.json", "w+b");
        fwrite($w_json, json_encode($cash_json, JSON_UNESCAPED_UNICODE));
        fclose($w_json);
        $word = ["どういう意味？", "なんて意味？","それはどういうこと？"];
        replyTextMessage($bot, $event->getReplyToken(), selectArray($word));
        goto label_end;
    break;

    }   

label_input:
if($pref_json->mode === "input"){
      foreach ($events as $event) {
//メッセージ以外の場合にエラーを吐いてcontinueで抜け
        if (!($event instanceof \LINE\LINEBot\Event\MessageEvent)) {
            error_log('Non message event has come');
            continue;
        }
//テキスト以外の場合もエラー吐いてcontinueで抜け
        if (!($event instanceof \LINE\LINEBot\Event\MessageEvent\TextMessage)) {
            error_log('Non text message has come');
            continue;
        }
        if(preg_match("/だまれ/u", $event->getText())){
            $pref_json->mode = "normal";
            $w_json = fopen("./json/preference.json", "w+b");
            fwrite($w_json, json_encode($pref_json, JSON_UNESCAPED_UNICODE));
            fclose($w_json);
            $bot->replyText($event->getReplyToken(), "ごめんなさい");
            goto label_end;
        }
        //まずpreference.jsonを書き換えて保存する
        $pref_json->mode = "normal";
        $w_json = fopen("./json/preference.json", "w+b");
        fwrite($w_json, json_encode($pref_json, JSON_UNESCAPED_UNICODE));
        fclose($w_json);
        //memory.jsonをデコード
        $url = "./json/memory.json";
        $raw_json = file_get_contents($url);
        if($raw_json === false){
          error_log('failed to load json file(memory.json).');
        }
        $memory_json = json_decode($raw_json, true);
        //cash.jsonをデコード
        $url = "./json/cash.json";
        $raw_json = file_get_contents($url);
        if($raw_json === false){
          error_log('failed to load json file(cash.json).');
        }
        $cash_json = json_decode($raw_json);
        //memory.jsonを書き換え
        $memory_json[] = $cash_json->pre_message;
        $memory_json[] = $event->getText();
        $w_json = fopen("./json/memory.json", "w+b");
        fwrite($w_json, json_encode($memory_json, JSON_UNESCAPED_UNICODE));
        fclose($w_json);
        $answord = array("なるほど","理解した","ご教授いただきありがとうございます");
            $word = selectArray($answord);
        $bot->replyText($event->getReplyToken(), $word);
    }
    goto label_end;
}

      default :
      if(preg_match("/#/u", $text)){
        $text = mb_substr($text,1);
        //memory.jsonを検索
        //* するためにmemory.jsonを読み込み
        $url = "./json/memory.json";
        $raw_json = file_get_contents($url);
        if($raw_json === false){
            error_log('failed to load json file(cash.json).');
        }
        $memory_json = json_decode($raw_json);
        //*keyを元に検索
        $key = array_search($text, $memory_json);
        $tail = ["", "！", "笑", "ｗｗｗｗ", "↑↑"];
        if(($key)!= FALSE){
            $bot->replyText($event->getReplyToken(), $memory_json[++$key].selectArray($tail));
            exit;
        }
      //preference.json->modeを書き換え
        $pref_json->mode = "input";
        $w_json = fopen("./json/preference.json", "w+b");
        fwrite($w_json, json_encode($pref_json));
        fclose($w_json);
        //cash.jsonをデコード
        $url = "./json/cash.json";
        $raw_json = file_get_contents($url);
        if($raw_json === false){
          error_log('failed to load json file(cash.json).');
        }
        $cash_json = json_decode($raw_json);
        //cash.jsonを書き換え
        $cash_json->pre_message = $text;
        $w_json = fopen("./json/cash.json", "w+b");
        fwrite($w_json, json_encode($cash_json, JSON_UNESCAPED_UNICODE));
        fclose($w_json);
        $word = ["どういう意味？", "なんて意味？","それはどういうこと？"];
        replyTextMessage($bot, $event->getReplyToken(), selectArray($word));
        goto label_end;
    break;

    }
