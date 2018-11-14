<?php
require_once 'config.php';
require_once 'FacebookBot.php';
$bot = new FacebookBot(FACEBOOK_VALIDATION_TOKEN, FACEBOOK_PAGE_ACCESS_TOKEN);
$bot->run();
$messages = $bot->getReceivedMessages();
foreach ($messages as $message)
{
	$recipientId = $message->senderId;
	if($message->text)
	{
		$json = '{
  "recipient":{
    "id":"'.$recipientId.'"
  },
  "message":{
    "attachment":{
      "type":"template",
      "payload":{
        "template_type":"button",
        "text":"Try the postback button!",
        "buttons":[
          {
            "type":"postback",
            "title":"Postback Button",
            "payload":"DEVELOPER_DEFINED_PAYLOAD"
          }
        ]
      }
    }
  }
}';
		$url = “https://graph.facebook.com/v2.6/me/messages?access_token=%s”;
		$url = sprintf($url, $this->getPageAccessToken());
		$recipient = new \stdClass();
		$recipient->id = $recipientId;
		$message = new \stdClass();
		
		$button1 = new \stdClass();
		$button1->type = "web_url";
		$button1->url = "www.kikkocaffe.it";
		$button1->title = "Sito Web";
		
		$message->buttons = [$button1,$button1];
		$message->attachment = "risposta bottoni";
		$parameters = [‘recipient’ => $recipient, ‘message’ => $message];
		
		$response = processRequest($message->text);
		if($response=="test")
		   $bot->executePost($url, $parameters, $json = false);
		elseif($response!="")
			$bot->sendTextMessage($recipientId, $response);
		
	}
}

function processRequest($text)
{
	$text = trim($text);
	$text = strtolower($text);
	$response = "";
	if($text=="kikko promo city")
	{
		$response = "Lei puo aderire alle Promo City se risiede tra le seguenti zone:
		
Provincia di Salerno,
Potenza città.
Taranto città.
Reggio Calabria città

Le invio la brochure con le nostre offerte.
https://kikkocaffe.it/wp-content/uploads/2018/11/brochure-offerte-promocity.pdf";
	}
	elseif($text=="listino rivenditori")
	{
		$response = "Se vuole visionare il nostro listino prezzi
può scaricarlo da questa pagina https://kikkocaffe.it/rivenditori
cliccando sulla voce \"Scarica i Listini\"";
	}
	elseif($text=="prezzi")
	{
		$response = "Può vedere i prezzi direttamente sul nostro sito kikkocaffe.it, oppure sei lei risiede nelle seguenti zone:

Provincia di Salerno,
Potenza città.
Taranto città.
Reggio Calabria città

può ordinare anche telefonicamente al numero 0828 177 66 60 e ricevere dei vantaggi extra:
- consegna a domicilio in giornata e gratis
- ricevere le Promo City dei nostri Kikko Store affiliati.";
	}
	elseif($text=="prova")
	{
	$response="test";
	}
	else
	{
		$response = "";
	}	return $response;
}
