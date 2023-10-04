<?php  
$client_id=78;

$uri = $authority.'/titre/client/'.$client_id;

$result=curl_get($uri, $token);
                
$obj = json_decode($result);                      
                   
$code =  $obj->code;
                
if($code ==200)
    {   
       // $titres= $obj->titre; 
        $recharges= $obj->recharge;
        
       
                                         
        $resultat="Mon ticket";
        
        
    	
    	$total=count($recharges)-1;
 
    		
				$resultat .="\n".$recharges[$total]->descriptions."\nEtat : ".$recharges[$total]->actif."\n Renouveller : ".$recharges[$total]->date_enregistrement."\n Heure : ".$recharges[$total]->heure."\n Expire : ".$recharges[$total]->expiration."\n Montant : ".$recharges[$total]->prix." CDF";
				
				$action="end"; 
    	
                           
    }
    
    $contenu='';
    
   