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
		$response = processRequest($message->text);
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

Le invio la brochure con le nostre offerte.";
	}
	else
	{
		$response = "Ciao, presto un nostro operatore sarà a tua completa disposizione. Grazie!";
	}
	return $response;
}
