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
	else
	{
		$response = "";
	}
	return $response;
}
