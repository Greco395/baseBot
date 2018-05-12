<?php

//////////////////////////////////////////////////////////
//                                                      //
//   PHP baseCode by Greco395 ( https://greco395.it )   //
//                                                      //
//////////////////////////////////////////////////////////
/*
   --> change where your_value is written to make everything work <--
*/
header("Content-Type: application/json");

$CONFIG = array(
        "BOT_TOKEN"   => "your_value",
        "WEBHOOK_URL" => "https://your.site/path_to/basebot.php"
);

class FirstConfig{
  public function setWebHook(){
  global $CONFIG;
    $curl = curl_init();
    curl_setopt_array($curl, array(
       CURLOPT_RETURNTRANSFER => 1,
       CURLOPT_URL => $final_url   = "https://api.telegram.org/bot{$CONFIG['BOT_TOKEN']}/setWebhook?url={$CONFIG['WEBHOOK_URL']}",
   ));
   $resp = curl_exec($curl);
   curl_close($curl);
   print_r($resp);
  }
}


class TELEGRAM{
  public function getResponse(){
    $content = file_get_contents("php://input");
    $update = json_decode($content, true);

    return $update;
  }

  public function get(){
   $update_id        = $this->getResponse()['update_id'];
   $message_id       = $this->getResponse()['message']['message_id'];
   $message_from     = $this->getResponse()['message']['from']['id'];
   $message_is_bot   = $this->getResponse()['message']['from']['is_bot'];
   $message_name     = $this->getResponse()['message']['from']['first_name'];
   $message_surname  = $this->getResponse()['message']['from']['last_name'];
   $message_username = $this->getResponse()['message']['from']['username'];
   $message_language = $this->getResponse()['message']['from']['language_code'];
   $chat_id       = $this->getResponse()['message']['chat']['id'];
   $chat_name     = $this->getResponse()['message']['chat']['first_name'];
   $chat_username = $this->getResponse()['message']['chat']['username'];
   $chat_type     = $this->getResponse()['message']['chat']['type'];
   $date        = $this->getResponse()['message']['date'];
   $text        = trim(strtolower($this->getResponse()['message']['text']));
   $text_offset = $this->getResponse()['message']['entities']['offset'];
   $text_length = $this->getResponse()['message']['entities']['length'];
   $text_type   = $this->getResponse()['message']['entities']['type'];

   return array(
     "update_id" => $update_id,
     
     "message_id"    => $message_id,
     "message_from"  => $message_from,
     "message_isbot" => $message_is_bot,
     "message_name"  => $message_name,
     "message_surname"  => $message_surname,
     "message_username" => $message_username,
     "message_lang" => $message_language,
     "message_text" => $text,
     "message_date" => $date,
     "message_text_offset" => $text_offset,
     "message_text_length" => $text_length,
     "message_text_type"   => $text_type,
     
     "chat_id"   => $chat_id,
     "chat_name" => $chat_name,
     "chat_username" => $chat_username,
     "chat_type"     => $chat_type
   );
  }

  public function sendMessage($message, $chat_id = 1){
    if(empty($message)){ return null; }
    if($chat_id = 1){ $chat_id = $this->get()['chat_id']; }
    $parameters = array('chat_id' => $chat_id, "text" => $message);
    $parameters["method"] = "sendMessage";
    return json_encode($parameters);
  }
}
$telegram = new TELEGRAM;





// example 
if(strpos($telegram->get()['message_text'], "/hello") !== false){
	  echo $telegram->sendMessage("ciao ".$telegram->get()['message_name']."", 1);
}
// // // //

// the first time use this code
$config = new FirstConfig;
echo $config->setWebHook();
