<?php

	$notification = file_get_contents("php://input");

	$xml = new SimpleXMLElement($notification);

	$id=$xml->params->param->value->struct->member[0]->value->string[0];

	$idmpesa=$xml->params->param->value->struct->member[0]->value->string[0];

	$telephone=$xml->params->param->value->struct->member[2]->value->string[0];

	$shortcode=$xml->params->param->value->struct->member[3]->value->string[0];

	$requete=$xml->params->param->value->struct->member[4]->value->string[0];

	$reponse=$xml->params->param->value->struct->member[5]->value->string[0];
			
	$action='request';

	$sorti="xml.php";
	
	$token='12345@kibati-00';
	
	$authority="https://api.eliajimmy.net/";
