<?php

if($reponseRecupererService=='OUI')
    {
		//De l'activité précédente (recuperer service), On recupere l'entité qui represente la table contenant les détails du produit (nom, prix, quantité, ...), car nous sommes dans un cas mutualisé
		$services= $obj->service;
                    
		$entite= $services[0]->entite; 
      
		 //Recuperons les detais du produit pour preparer la requete de facturation
		$uri = 'https://api.eliajimmy.net/'.$entite.'/'.$product_id;

		$result=curl_get($uri,$token);

		$obj = json_decode($result);

		$codeProduit = $obj->code;
	}
	