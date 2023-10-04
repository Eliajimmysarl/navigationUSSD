<?php
    
    $uri = $authority.'/navigation/'.$id;
    
    $result=curl_get($uri, $token);
    
    $obj=json_decode($result);
    
    $codeNavigation= $obj->code; 

	$client= $obj->client; 
          
	$commande=$client[0]->commande;
          
	$msisdn=$client[0]->msisdn;
          
	$menu=$client[0]->menu;
          
	$sous_menu1=$client[0]->sous_menu1;
          
	$sous_menu2=$client[0]->sous_menu2;
          
	$sous_menu3=$client[0]->sous_menu3;
          
	$sous_menu4=$client[0]->sous_menu4;
          
	$sous_menu5=$client[0]->sous_menu5;
    
	$contenu_menu=$client[0]->menu;
    
	$contenu_sous_menu1=$client[0]->contenu_sous_menu1;
    
	$contenu_sous_menu2=$client[0]->contenu_sous_menu2;
    
	$contenu_sous_menu3=$client[0]->contenu_sous_menu3;
    
	$contenu_sous_menu4=$client[0]->contenu_sous_menu4;
    
	$contenu_sous_menu5=$client[0]->contenu_sous_menu5;	
  
?>