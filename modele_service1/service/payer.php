<?php
$uri = $authority.'/payer/';

$mode="mpesa";

// Setup request to send json via POST
$data = array(
    'transaction' =>(int)$id,
    'mode'=> $mode

);

$result=curl_post($uri, $token, $data);

$paiement=json_decode($result);
   
$code =  $paiement->code;

if($code ==201)
        {   
          
                    $referenceCommande =  $paiement->reference_commande;
                    
                     $resultat=  $referenceCommande;
            $resultat .= "\n Veuillez patienter pour inserer votre code pin";
                   
              
                 $action="end"; 
        }
    else
        {
            echo $result;
        }


$contenu='453';

?>