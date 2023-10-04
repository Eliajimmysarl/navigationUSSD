<?php

	if($reponseNavigation=='OUI')
		{
			$uri = $authority.'/navigation/';
			
			$data = array(
                'id' =>(int)$id,
				
                'menu' => (string)$requete,
				
                'msisdn' => (int)$telephone
            );
			
			$result=curl_post($uri, $token, $data);
		}