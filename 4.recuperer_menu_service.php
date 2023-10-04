<?php
    
	if($reponseNavigation=='OUI')
		{
			$niveau='menu';
			
			//Identifiant de service pour le Titre de transport
			if($requete=="*4646*8#")
				{
					$serviceId=1; 
				}
			//Identifiant de service pour le SCORE
			else if($requete=="*4646*15#")
				{
					$serviceId=9;
				}
		
			$uri = $authority.'/menu/'.$serviceId;
				
			$result=curl_get($uri, $token);
								
			$obj=json_decode($result);
								
			$code=$obj->code;
							
			if($code==200)
				{
					$obj=json_decode($result);
					
					$menu=$obj->menu;
					
					$resultat=$menu[0]->service;
					
					for($i=0; $i < count($menu); $i++)
						{
							$j=$i+1;
							
							$resultat .="\n".$j.". ".$menu[$i]->nom; 	
						}
				}
		}