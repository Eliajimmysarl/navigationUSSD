<?php
    $service_id=1;
    
    $uri = $authority.'/commander/';

    $data = array(
    'product_id' => (string)$requete,
    'service_id' =>(int)$service_id,
    'msisdn' => (int)$telephone
    );

    $result=curl_post($uri,$token,$data);

    $obj = json_decode($result);                      
    
    $code =  $obj->code;

    if($code ==200)
        {   
            $commandes =  $obj->commande;
            $commandeId=$commandes->commande_id; 
            $referenceCommande=$commandes->reference_commande; 

            $produits =  $obj->product;
            $description=$produits->descriptions; 
            $periode=$produits->periode; 
            $prix=$produits->prix; 
            $zone=$produits->zone; 
            $resultat=  $description."\n Prix : ".$prix;
            $resultat .= "\n Confirmez-vous de payer par Mpesa?". "\n" . "1. Oui". "\n".  "0. Non";
     
    }
else if ($code ==400)
    {
        echo $result; 
    }

//Info à stocker et à reutiliser pour le paiement
$contenu="$referenceCommande";


?>