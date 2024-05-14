<?php

error_reporting(0);

ob_start();
header("Content-Type: application/json; charset=UTF-8");
echo file_get_contents("https://api.telegram.org/bot" . API_KEY . "/setwebhook?url=" . $_SERVER['SERVER_NAME'] . "" . $_SERVER['SCRIPT_NAME']);
$API_KEY = "6711097028:AAH9ivfM3MjeW2f-rCA7qCNfUwFnZGxVJbM" ;
define('API_KEY',$API_KEY);
define("IDBot", explode(":", $API_KEY)[0]);


function bot($method, $datas = []) {
    $url = "https://api.telegram.org/bot" . API_KEY . "/" . $method;
    $options = [
        'http' => [
            'method'  => 'POST',
            'content' => http_build_query($datas),
            'header'  => 'Content-Type: application/x-www-form-urlencoded\r\n',
        ],
    ];
    $context  = stream_context_create($options);
    $res = file_get_contents($url, false, $context);

    if ($res === FALSE) {
        return json_encode(['error' => 'Request failed']);
    } else {
        return json_decode($res);
    }
}


$update = json_decode(file_get_contents('php://input'));
if($update->callback_query ){
$data = $update->callback_query->data;
$chat_id = $update->callback_query->message->chat->id;
$title = $update->callback_query->message->chat->title;
$message_id = $update->callback_query->message->message_id;
$name = $update->callback_query->message->chat->first_name;
$user = $update->callback_query->message->chat->username;
$from_id = $update->callback_query->from->id;
}

   
if($update->message){
	$message = $update->message;
$message_id = $update->message->message_id;
$username = $message->from->username;
$chat_id = $message->chat->id;
$title = $message->chat->title;
$text = $message->text;
$user = $message->from->username;
$name = $message->from->first_name;
$from_id = $message->from->id;
}

$admin = 6565529894; //ايدي الادمن 
if($text == '/start'){
    bot ( 'sendmessage',[
        'chat_id'=>$chat_id,
        'text'=>"
        مرحبا بك عزيزي في بوت رشق المشاهدات المجاني 
        ارسل الرابط التيليكرام لطلب 1000 مشاهده مجانيه
        ",
        'parse_mode'=>"Markdown",
    ]);
}elseif(preg_match("/t.me/",$text)){
    $k = json_decode(file_get_contents("https://smm-speed.com/api/v2?action=add&service=2666&link=$text&quantity=1000&key=539b55dc24467105b4085c1d58aaeafe"));
   if($k->order){
    bot ( 'sendmessage',[
        'chat_id'=>$chat_id,
        'text'=>"
[#تم_الارسال_المشاهدات]
للرابط : [$text] .
        ",
        'parse_mode'=>"Markdown",
    ]);
}else{
    bot ( 'sendmessage',[
        'chat_id'=>$chat_id,
        'text'=>"
[#فشل_الارسال_حاول_مجددا_بعد_قريب]
        ",
        'parse_mode'=>"Markdown",
    ]);
    bot ( 'sendmessage',[
        'chat_id'=>$admin,
        'text'=>"
عزيزي ادمن البوت :
هنالك مشاكل في الاتصالات والطلبات يتم رفضها
اغلب الاسباب :
تم حضر حسابك في الموقع بسبب انتهاكيات الاستخدام
ان API_KEY_SITE غلط

        ",
        'parse_mode'=>"Markdown",
    ]);
}
}else{
    bot ( 'sendmessage',[
        'chat_id'=>$chat_id,
        'text'=>"
يرجي ارسال الرابط بشكل صحيح !

مثال :
[https://t.me/Sero_Bots/6665]

        ",
        'parse_mode'=>"Markdown",
    ]);
}