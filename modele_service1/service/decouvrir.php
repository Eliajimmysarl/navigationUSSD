<?php   
$uri = $authority.'/titre/';

$result=curl_get($uri, $token);
                
$obj = json_decode($result);                      
                   
$code =  $obj->code;
                
if($code ==200)
    {   
        $titres= $obj->titre;     
                                         
        $resultat='Titre de Transport';
    		
    	for($i=0; $i < count($titres); $i++)
    		{
    		    $j=$i+1;
    		
				$resultat .="\n".$j.". ".$titres[$i]->descriptions." : ".$titres[$i]->prix. " FC";
    		} 
                           
    }
    
    $contenu='123';