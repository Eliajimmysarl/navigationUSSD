<?php

	header('Content-Type: text/xml'); 

	echo "<?xml version='1.0' encoding='UTF-8'?>";

		//1)Récupérer la requete USSD 
		require_once("1.recuperer_requete.php");

		//2)Récupérer a navigation USSD
		require_once("2.recuperer_navigation.php");

		//3)Vérifier si la requete demande le menu principal
		require_once("3.verifier_si_requete_concerne_menu_principal.php");

		//4)Récupéré le menu principal de service
		require_once("4.recuperer_menu_service.php");
		
		//5)Enregistrer la premiere navigation, c'est à dire la transaction USSD
		require_once("5.enregistrer_navigation.php");
		
		
		//6)Verifier si c'est le premier niveau de navigation 
		require_once("6.verifier_si_premier_niveau_navigation.php");
		
		//7)Recuperer le service du niveau1 de navigation (si OUI)
		require_once("7.recuperer_service_niveau1.php");
		
		//8)Vérifier si c’est le deuxième niveau de navigation (si NON)
		require_once("8.verifier_si_deuxieme_niveau_navigation.php");
		
		//9)Recuperer le service du  niveau2 de navigation (si OUI)
		require_once("9.recuperer_service_niveau2.php");
		
		//10)Vérifier si c’est le troisième niveau de navigation (si NON)
		require_once("10.verifier_si_troisieme_niveau_navigation.php");
		
		//11)Recuperer le service du niveau3 de navigation (si OUI)
		require_once("11.recuperer_service_niveau3.php");
		
		//12)Vérifier si c’est le quatrième niveau de navigation (si NON)
		require_once("12.verifier_si_quatrieme_niveau_navigation.php");
		
		//13)Recuperer le service du niveau4 de navigation (si OUI)
		require_once("13.recuperer_service_niveau4.php");
		
		//14)Vérifier si c’est le cinquième niveau de navigation (si NON)
		require_once("14.verifier_si_cinquieme_niveau_navigation.php");
		
		//15)Recuperer le service du  niveau5 de navigation (si OUI)
		require_once("15.recuperer_service_niveau5.php");
		
		//16)	Mettre à jour la navigation
		require_once("16.mettre_a_jour_navigation.php");
		
	

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

$tailleRequete=strlen($requete);

// if($telephone==243820642324)
// 	{
// 		$telephone="243110000000";
// 	}

$pseudonumber=substr($telephone, 0,5);

//Gestion Navigation
//1) Verifiez si l'id est enregistré, ou c'est une nouvelle demande en sollicidant le service de verification
    // if($requete=="*4646*8#")
    //       {
    //Verification
    $token='12345';
     $authority="https://api.eliajimmy.net/";
    require_once('composant/curl.php');
    require_once("processus/verifierMenu.php");
              
      if(($code==404) AND (($requete=="*4646*8#") OR ($requete=="*4646*15#")))
          {
            require_once('composant/menu.php');
            
            require_once('composant/navigation.php');
          }
    else if (($code==200) AND (($menu=="*4646*8#") OR ($menu=="*4646*15#")))
          {
            
              if( $sous_menu1==0)
                  {
                      //Affichqge du premier sous menu et mis a jour dans la navigation
                      
                        require_once('composant/etape1.php');
                        
                        require_once('composant/navigation.php');
                       
                        //require_once("processus/updateClient.php");
                        
                        
                        //Partie metier
                        // require_once("processus/demanderTitreTransport.php");
                        //$resultat = 'Service metier 1';
                  }
                  
                else if($sous_menu2==0)
                  {
                      //Affichqge du premier sous menu et mis a jour dans la navigation
                      
                        require_once('composant/etape2.php');
                        
                        require_once('composant/navigation.php');
                        
                    //     $niveau='sous_menu1';
                    //     require_once("processus/updateClient.php");
                        
                        
                    //   //Partie metier, Commander un titre
                    //     require_once("processus/enregistrerCommande.php");
                        
                    //     $resultat = "Confirmez-vous de payer par Mpesa?". "\n" . "1. Oui". "\n".  "0. Non";
                        
                        
                        		
					
                  }
                  
                else if($sous_menu3==0)
                  {
                      //Affichqge du premier sous menu et mis a jour dans la navigation
                         require_once('composant/etape3.php');
                        
                        require_once('composant/navigation.php');
                        
                        
                        // $niveau='sous_menu2';
                        // require_once("processus/updateClient.php");
                        
                        
                        // //Partie metier, Payer le titre de transport
                        // require_once("processus/confirmerPaiement.php");
                        
                        // $resultat ="veuillez patienter pour inserer le code PIN";

                  }
                else if($sous_menu4==0)
                  {
                      //Affichqge du premier sous menu et mis a jour dans la navigation
                        $niveau='sous_menu3';
                        require_once("processus/updateClient.php");
                        $resultat = 'Service metier 4';
                  }
                else if($sous_menu5==0)
                  {
                      //Affichqge du premier sous menu et mis a jour dans la navigation
                        $niveau='sous_menu4';
                        require_once("processus/updateClient.php");
                        $resultat = 'Service metier 5';
                  }
                else if($sous_menu6==0)
                  {
                      //Affichqge du premier sous menu et mis a jour dans la navigation
                        $niveau='sous_menu5';
                        require_once("processus/updateClient.php");
                        $resultat = 'Service metier 6';
                  }
          }





// //Gestion de Projet TRANSPORT
// //Routage menu
// $requeteRoutageUssd="SELECT *FROM  routage_ussd WHERE TransactionId='$id'";
// $resultatRoutageUssd=$connexion->query($requeteRoutageUssd);
// $nbreRequete=mysqli_num_rows($resultatRoutageUssd);
// if($nbreRequete==0)
//     {
//       if($requete=="*4646*8#")
//           {
//               $requeteInsert="INSERT INTO routage_ussd(TransactionId, msisdn,racourci)VALUES('$id','$telephone','$requete')";
// 		        $resultatInsert=$connexion->query($requeteInsert);
//           }
       
//     }
// else
//     {
//         $existe = mysqli_fetch_array($resultatRoutageUssd);

// 		$racourciMenu= $existe['racourci'];
//     }

// if(($requete=="*4646*8#")OR($racourciMenu=="*4646*8#"))
//     {
//         //Verifier si c'est une nouvelle demande en sollicitant ce service au composant de service 'navigation USSD'
//         $uri = 'https://api.eliajimmy.net/navigationussd/'.$id;
//         $ch = curl_init();
//         curl_setopt($ch, CURLOPT_URL, $uri);
//         curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
//         curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
//         $result=curl_exec($ch);
//         $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
//         curl_close($ch);
    
//         $obj=json_decode($result);
//         $code=$obj->code;
    
//         //Si c'est une nouvelle demande, il faut l'enregister
//         if($code==404)
//             {
//                 //$resultat='Resultats des matchs'; 
//                 //Integration de composant processus de demande de menu USSD
//                 require_once("processus/demanderMenuUssd.php");
//             }
//         //Demande titre de sejour
//         else
//             {
//               require_once("processus/demanderTitreTransport.php");
//             }
//     }
else
{
//Fin Transport
$reqbl="SELECT * FROM `blacklisteVodacom` WHERE telephone=$telephone";
	$resbl=$connexion->query($reqbl);
	$existebl=mysqli_num_rows($resbl);

if($pseudonumber=="24311")
	{
		$requete_pseudo="INSERT INTO clientussdpseudo(TransactionId, msisdn, dates, heure, racourci)VALUES('$id','$telephone','$dates', '$heure','$requete')";
		$resultat_pseudo=$connexion->query($requete_pseudo);

		$resultat="Votre numero $telephone n est pas actif, veuillez contacter le service client";
		$action='end';

	}
else if($existebl!=0)
	{
		$reque = "UPDATE `blacklisteVodacom` SET tentative=tentative+1 WHERE telephone=$telephone ";
		$resu=$connexion->query($reque);

		$resultat="Ce numero $telephone n est pas autorise a utiliser ce service, veuillez contacter le service client";
		$action='end';
	}
else
	{
		//On verifit si c'est la première connexion ou pas
		$requete_clientussd="SELECT *FROM  clientussd WHERE TransactionId='$id'";

		$resultat_clientussd=$connexion->query($requete_clientussd);

		$autre = mysqli_fetch_array($resultat_clientussd);

		$nbre_req=mysqli_num_rows($resultat_clientussd);

		$racourci=$autre['racourci'];
		$menu=$autre['menu'];
		$sousmenu1=$autre['sousmenu1'];
		$sousmenu2=$autre['sousmenu2'];
		$sousmenu3=$autre['sousmenu3'];
		$reponse=$autre['reponse'];
		$choix=$autre['element'];
		$client=$autre['client'];
		$confirmation=$autre['detail'];
		$suivant=$autre['suivant'];
		$SuivPrec=$autre['SuivPrec'];
		$menumpesa=$autre['menu'];
		$scorempesa=$autre['scorempesa'];
		$codematch=$autre['codematch'];
		$modepaiement=$autre['modepaiement'];
		$messagempesa=$autre['messagempesa'];
		$pret=$autre['pret'];
		
		//Si c'est la première connexion de l'utilisateur, on ouvre le menu principal en fonction de la syntaxe	
		if($nbre_req==0)
			{
				//On sauvegarde la syntaxe USSD
				$requete_clientussd="INSERT INTO clientussd(TransactionId, msisdn, menu, element, detail, dates, heure, racourci, trackraccourci)VALUES('$id','$telephone', '0', '0', '0','$dates', '$heure','$requete','$requete')";
				$resultat_clientussd=$connexion->query($requete_clientussd);

					//Reservé pour la linafoot
				if($requete=="*42212#")
				//if(($requete=="*4646*1#")OR($requete=="*42212#"))
					{
						$requete_menu="SELECT *FROM  menu_dynamique_vl1 WHERE aide='OUI' ORDER BY numUssd ASC";
						$resultat_menu=$connexion->query($requete_menu);
						$resultat='Menu Vodacom L1';
						while($menu=mysqli_fetch_array($resultat_menu))
							{
								//$idMenu=$menu['idMenu'];
								$idMenu=$menu['numUssd'];
								$nom=$menu['nom'];
								$resultat .="\n".$idMenu.". ".$nom; 	
							}


					}
				//Zone 100% Score Mpesa
				else if($requete=="*4646*6#")
					{
						$resultat='Resultats des matchs';
						$resultat .="\n1. Par numero du match \n2. Par nom de l'equipe\n----";

					
					}

				//Projet Vita
				else if($requete=="*4646*41#")
					{
						$requeteaut="SELECT *FROM  controleVodacom WHERE service='VITA'";
						$resultataut=$connexion->query($requeteaut);
						$aut = mysqli_fetch_array($resultataut);
						$publier = $aut['publier'];

						if($publier=='OUI')
							{
								$resultat='Menu VITA CLUB';
								$resultat .="\n1. Identification\n2. Contibution \n3. Info Vita \n4. Quitter"; 
							}
						else
							{
								$resultat="Vous n etes pas autorise";
								$action="End";
							}
					}

				//Projet Marche
				else if($requete=="*4646*243#")
					{
						$requeteaut="SELECT *FROM  controleVodacom WHERE service='MARCHE'";
						$resultataut=$connexion->query($requeteaut);
						$aut = mysqli_fetch_array($resultataut);
						$publier = $aut['publier'];

						if($publier=='OUI')
							{
								$resultat='Marche RDC';
								$resultat .="\nInserez le numero de votre table"; 
							}
						else
							{
								$resultat="Vous n etes pas autorise";
								$action="End";
							}
					}
				
				//Projet SMS
				else if($requete=="*4646*123#")
					{
						$requeteaut="SELECT *FROM  controleVodacom WHERE service='MARCHE'";
						$resultataut=$connexion->query($requeteaut);
						$aut = mysqli_fetch_array($resultataut);
						$publier = $aut['publier'];

						if($publier=='OUI')
							{
								$resultat='ACTIVATION SMS';
								$resultat .="\nInserez le code du client"; 
							}
						else
							{
								$resultat="Vous n etes pas autorise";
								$action="End";
							}
					}

				//Projet Vignette
				else if($requete=="*4646*33#")
					{
						$requeteaut="SELECT *FROM  controleVodacom WHERE service='MARCHE'";
						$resultataut=$connexion->query($requeteaut);
						$aut = mysqli_fetch_array($resultataut);
						$publier = $aut['publier'];

						if($publier=='OUI')
							{
								$resultat='Paiement Vignette';
								$resultat .="\nInserez le numero plaque de votre Vehicule"; 
							}
						else
							{
								$resultat="Vous n etes pas autorise";
								$action="End";
							}
					}

					//Projet Peage
					else if($requete=="*4646*22#")
					{
						$requeteaut="SELECT *FROM  controleVodacom WHERE service='MARCHE'";
						$resultataut=$connexion->query($requeteaut);
						$aut = mysqli_fetch_array($resultataut);
						$publier = $aut['publier'];

						if($publier=='OUI')
							{
								$resultat='Menu Peage';
								$resultat .="\n1. Payer maintenant \n2. Ouvrir barriere \n3. Plus d'info "; 
							}
						else
							{
								$resultat="Vous n etes pas autorise";
								$action="End";
							}
					}

				//Projet Vignette
				else if($requete=="*4646*111#")
					{
						$requeteaut="SELECT *FROM  controleVodacom WHERE service='MARCHE'";
						$resultataut=$connexion->query($requeteaut);
						$aut = mysqli_fetch_array($resultataut);
						$publier = $aut['publier'];

						if($publier=='OUI')
							{
								$resultat='Paiement Peage';
								$resultat .="\nInserez le numero plaque de votre Vehicule"; 
							}
						else
							{
								$resultat="Vous n etes pas autorise";
								$action="End";
							}
					}

				//Projet Marche tes
				else if($requete=="*4646**243#")
					{
						
						
						$requeteaut="SELECT *FROM  controleVodacom WHERE service='MARCHE'";
						$resultataut=$connexion->query($requeteaut);
						$aut = mysqli_fetch_array($resultataut);
						$publier = $aut['publier'];

						if($publier=='OUI')
							{
								if(($telephone=="243827966699")||($telephone=="243820642324")||($telephone=="243817754016")||($telephone=="243829037858")||($telephone=="243823204840"))
									{
								
										$resultat='Marche RDC';
										$resultat .="\nInserez le numero de la table du Vendeur"; 
									}
								else
									{
										$resultat="Vous n'etes pas autorise pour faire ce controle";
										$action="End";
									}
								

								
								
							}
						else
							{
								$resultat="Vous n etes pas autorise";
								$action="End";
							}
					}


				else if($requete=="*4646*5#")
					{
						// //Imposer Mpesa
						// $requete_m="UPDATE clientussd SET modepaiement=1, messagempesa='Pour un acces rapide, Utlisez :\n *4646*5*numero-de-match#' WHERE TransactionId='$id'";
						// $resultat_m=$connexion->query($requete_m);
						// $resultat='Resultats des matchs';
						// $resultat .="\n1. Par numero du match \n2. Par nom de l'equipe\n----";
						// //Fin Imposition Mpesa




						//Verifier si le client a un forfait actif
						//1. Verification  Forfait MPesa actif
						$requete_mpesa="SELECT *FROM  abonneJournalierMpesa WHERE numero='$telephone' AND choix=4 AND continu='ON' ORDER BY idAbonne DESC";
						$resultat_mpesa=$connexion->query($requete_mpesa);
						$visiteur_mpesa = mysqli_num_rows($resultat_mpesa);

						//1. Verification  Forfait MPesa Airtime
						$requete_airtime="SELECT *FROM  abonneJournalier WHERE numero='$telephone' AND choix=4 AND continu='ON' ORDER BY idAbonne DESC";
						$resultat_airtime=$connexion->query($requete_airtime);
						$visiteur_airtime = mysqli_num_rows($resultat_airtime);	

						//S'il y a un forfait Mpesa Actif, on propose directement la recheche des resultats via Mpesa
						if($visiteur_mpesa!=0)
							{
								
								$requete_m="UPDATE clientussd SET modepaiement=1, messagempesa='Pour un acces rapide, Utlisez :\n *4646*5*numero-de-match#' WHERE TransactionId='$id'";
								$resultat_m=$connexion->query($requete_m);

								$resultat='Resultats des matchs';
								$resultat .="\n1. Par numero du match \n2. Par nom de l'equipe\n----";
							}
						//S'il y a un forfait Airtime Actif, on propose directe la recherche des resultats via Airtime
						else if($visiteur_airtime!=0)
							{
								$requete_m="UPDATE clientussd SET modepaiement=2 WHERE TransactionId='$id'";
												$resultat_m=$connexion->query($requete_m);

								if((($jour=="Samedi")AND ($heure>7)) || ($jour=="Dimanche") || (($jour=="Lundi") AND ($heure<8)))
						
									{
										//Proposition du menu principal ou page principale
										$requete_menu="SELECT *FROM  menu_parifoot WHERE affichage='OUI'";
										$resultat_menu=$connexion->query($requete_menu);
										$resultat='';
										while ($menu = mysqli_fetch_array($resultat_menu))
											{
												++$i;
												$idMenu=$menu['idMenu'];
												$nom=$menu['nom'];
												$resultat .="\n".$i.". ".$nom; 	
											}
									}
								else
									{
										$requetemin="SELECT MAX(NLL) AS max, MIN(NLL) AS min FROM matchesfree WHERE NLL!=''";
										$resultatmin=$connexion->query($requetemin);
										$mon = mysqli_fetch_array($resultatmin);
										$min = $mon['min'];
										$max = $mon['max'];
										$resultat="\n \nEnvoyez un numero compris entre $min et $max  de la liste d'aujourd'hui pour avoir directement le resultat.  \n --- \n Cout : 5U/Jour";
									}
							}
						//S'il y a aucun forfait Actif, on propose au client de choisir le mode de paiement
						else
							{
								$resultat='Resultats des matchs';
								$resultat .="\n1. Par M-pesa \n2. Par des Unites\n----";
							}


						
						
					}

					//Permet de connaitre le dernier enregistrement des articles
				else if($requete=="*42212**0*#")
				{
					$conn = mysqli_connect("localhost","vodacoml1","j'utiliseLGsmartTV","vodacoml_ligue1");

					$query = mysqli_query($conn, "SELECT * FROM `image` ORDER BY idImage DESC");
					
					$row = mysqli_fetch_array($query);

					$idImage = $row['idImage'];

					$resultat='Action : ';
								
					$resultat ="Dernier enregistrement : $idImage ";
				}

				//2e niveau resultat parieur avec MPESA
				else if(( strstr($requete,'*4646*5*'))!='')

					{
						//Verification si le client a deja paye
						$requete_mpesa="SELECT *FROM  abonneJournalierMpesa WHERE numero='$telephone' AND choix=4 AND continu='ON' ORDER BY idAbonne DESC";
						$resultat_mpesa=$connexion->query($requete_mpesa);
						$visiteur_mpesa = mysqli_num_rows($resultat_mpesa);
						//S'il y a un forfait Mpesa Actif, on propose directement la recheche des resultats via Mpesa
						//Si oui, on lui donne le resultat
						if($visiteur_mpesa!=0)
							{
								$requete_m="UPDATE clientussd SET menu=1,  modepaiement=1, racourci='*4646*5#', messagempesa='Enoyez un autre numero de match a partir d ici' WHERE TransactionId='$id'";
								$resultat_m=$connexion->query($requete_m);

								$messagempesa="Enoyez un autre numero de match a partir d'ici";

								require_once("particulier_parieur.php");
							}
						//Si non, on lui propose l'activation
						else
							{
								$requete_m="UPDATE clientussd SET menu=3, modepaiement=1, racourci='*4646*5#' WHERE TransactionId='$id'";
								$resultat_m=$connexion->query($requete_m);

								$resultat="Activation des Resultats\n1. 150 Resultats - 200FC(24Hrs)\n2. 1500 Resultats - 2000FC(7Jrs)\n3. 10000 Resultats - 10000FC(30Jrs)\n---\nN.B. : Payable seulement en FC";

							}	

					}

				else if($requete=="*4646*06#")
				//if(($requete=="*4646*1#")OR($requete=="*42212#"))
					{
						if($telephone=="243820642324")
							{
								//Creation token
								
								require_once("recuperertokenforcheck.php");
								$resultat='Inserer le montant';
								//$resultat .="\n1. Par numero du match \n2. Par nom de l'equipe\n3. Activation";
							}
						else
							{
								$resultat="Cher client, ce code n'existe pas";
								$action="end";	
							}
						
					}	
				//Reinitialiser les cartes KANDA
				else if($requete=="*42212**#")
						{
							if($telephone=="243820642324")
								{
									$requete_m="UPDATE `kanda` SET `acheter`='NON', `utiliser`='NON', `vendupar`='PERSONNE', `validerpar`='PERSONNE'";
									$resultat_m=$connexion->query($requete_m);
									$resultat="KANDA REINTIALISER";
									$action="end";
								}
							else
								{
									$resultat="Cher client, ce code n'existe pas";
									$action="end";	
								}
							
						}	
					
				//Activation pour utiliser gratuitement le service a la demande pour verifier		
				else if($requete=="*4646*#")
				//if(($requete=="*4646*1#")OR($requete=="*42212#"))
					{
						if(($telephone=="243820642324")||($telephone=="243817754016")||($telephone=="243829037858")||($telephone=="243816553806"))
							{
								//Activation Resultat parieur
								$choix[1]=4;
								$choix[2]=5;
								$choix[3]=13;
								$choix[4]=11;
								
								for($i=1;$i<5;++$i)
									{
										$requete_parieur="INSERT INTO abonneJournalier(numero, choix, ordreEnvoi, total_requete, continu, dates, heure)VALUES('$telephone', $choix[$i], 2, 0,'ON', '$dates', '$heure')";
										$resultat_parieur=$connexion->query($requete_parieur);
									}
								

								$resultat='Test Resultat parieur, VL1 est active, vous pouvez tester maintenant';
								$action="end";
								//$resultat .="\n1. Par numero du match \n2. Par nom de l'equipe\n3. Activation";
							}
						else
							{
								$resultat="Cher client, ce code n'existe pas";
								$action="end";	
							}
						
					}

				//Enregistrer client SCORE MPESA
				else if($requete=="*4646*0#")
					{
						
						$requete_menu="SELECT *FROM  `suivie` WHERE `telephone`='$telephone'";
						$resultat_menu=$connexion->query($requete_menu);
						$existe=mysqli_num_rows($resultat_menu);
						if($existe==0)
							{
								$resultat = "Code Invalid!";
								$action='End';
							}
						else
							{
								$resultat .="\n1. Nouveau client \n2. Liste des clients";
							}
					
						
					}
 				
				//Reorganiser les numeros id pour afficher en ordre le calendrier
				else if($requete=="*4646***#")
					{
						if(($telephone=="243820642324")||($telephone=="243817754016")||($telephone=="243816553806"))
							{
								$query = mysqli_query($connexion, "SELECT * FROM `calendrierLinafoot` ORDER BY `idCal` DESC");
					
								$row = mysqli_fetch_array($query);

								$idCal= $row['idCal'];

								$requete_menu="SELECT * FROM `calendrierLinafoot` WHERE dates='$dates'";
								$resultat_menu=$connexion->query($requete_menu);
								$resultat='';
								$i=0;
								while ($menu = mysqli_fetch_array($resultat_menu))
									{
										++$i;
										$idMenu=$menu['idCal'];
										$requete_m="UPDATE `calendrierLinafoot` SET  idCal=$idCal+$i WHERE idCal='$idMenu'";
										$resultat_m=$connexion->query($requete_m);
												
										
												// $nom=$menu['localTeam'];
												// $resultat .="\n".$idMenu.". ".$nom; 	
									}
											
								$resultat ="Traitee";
								
							
								//Activation Resultat parieur
								// $choix[1]=4;
								// $choix[2]=5;
								// $choix[3]=13;
								// $choix[4]=11;
								
								// for($i=1;$i<5;++$i)
								// 	{
								// 		$requete_parieur="INSERT INTO abonneJournalier(numero, choix, ordreEnvoi, total_requete, continu, dates, heure)VALUES('$telephone', $choix[$i], 2, 0,'ON', '$dates', '$heure')";
								// 		$resultat_parieur=$connexion->query($requete_parieur);
								// 	}
								

								// $resultat='Test Resultat parieur, VL1 est active, vous pouvez tester maintenant';
								$action="end";
								//$resultat .="\n1. Par numero du match \n2. Par nom de l'equipe\n3. Activation";
							}
						else
							{
								$resultat="Cher client, ce code n'existe pas";
								$action="end";	
							}
						
					}	
					
					else if($requete=="*4646*06#")
					//if(($requete=="*4646*1#")OR($requete=="*42212#"))
						{
							if($telephone=="243820642324")
								{
									//Creation token
									
									require_once("recuperertokenforcheck.php");
									$resultat='Inserer le montant';
									//$resultat .="\n1. Par numero du match \n2. Par nom de l'equipe\n3. Activation";
								}
							else
								{
									$resultat="Cher client, ce code n'existe pas";
									$action="end";	
								}
							
						}	
					
						//Nouveau abonne VL1 via 4646
					else if($requete=="*42212*#")
						{
							if($telephone=="243823204840")
								{
									
											$requete_parieur="SELECT * FROM `abonnelinafoot` WHERE `source`=4646 AND abonnement='OUI'";
											$resultat_parieur=$connexion->query($requete_parieur);

											$totabon=mysqli_num_rows($resultat_parieur);
										
									
	
									$resultat="Total new abonne VL1 via 4646 : $totabon " ;
									$action="end";
									//$resultat .="\n1. Par numero du match \n2. Par nom de l'equipe\n3. Activation";
								}
							else
								{
									$resultat="Cher client, ce code n'existe pas";
									$action="end";	
								}
							
						}


				else if($requete=="*42212*1#")
					{
				// 		//Connexion vers la base Vodacom Ligue1
				// 		$requete_menu="SELECT *FROM  jouers ";
				// 		$resultat_menu=$connexionvl1->query($requete_menu);
						$resultat='Menu VL1 Award';
						$resultat.="\n Les votes pour le meilleur joueur de la VL1 saison 2020/2021 sont clotures";
						$action='END';
				// 		while($menu=mysqli_fetch_array($resultat_menu))
				// 			{
				// 				$idMenu=$menu['id'];
				// 				$nom=$menu['nom'];
				// 				$equipe=$menu['equipe'];
				// 				$resultat .="\n".$idMenu.". ".$nom." (".$equipe.")"; 	
				// 			}


					}

				else if($requete=="*4646*1#")
				//if(($requete=="*4646*1#")OR($requete=="*42212#"))
					{
						require_once("voyage/index.php");
					}

				else if($requete=="*4646*2#")
				//if(($requete=="*4646*1#")OR($requete=="*42212#"))
					{
						$resultat="Non disponible";
						$action="end";
					}

				// else if($requete=="*4646*33#")
				// //if(($requete=="*4646*1#")OR($requete=="*42212#"))
				// 	{
				// 		require_once("stage/index.php");
				// 	}

				else if($requete=="*42212***#")
				//if(($requete=="*4646*1#")OR($requete=="*42212#"))
					{
						require_once("stage/reporting.php");
					}
				else if($requete=="*4646***#")
				//if(($requete=="*4646*1#")OR($requete=="*42212#"))
					{
						require_once("stage/parifoot.php");
					}


					//Ticketing MPESA
				else if($requete=="*42212*6#")
					{	
						
							$resultat .="Veuillez Selectionner\n1. Compte M-pesa USD \n2. Compte M-pesa FC";		
										
					}
				
				//VL1 Award
				// else if($requete=="*42212*1#")
				// 	{	
						
				// 			$resultat .="Veuillez Selectionner\n1. Compte M-pesa USD \n2. Compte M-pesa FC";		
										
				// 	}

				//Verification billet par USSD
				else if($tailleRequete==15)
					{
						$code=substr($requete, 8, -1);

						$lettre1=substr($requete, 7, 1);


						switch ($lettre1) {
							case '3':
								$code='N'.$code;
								break;

							case '2':
								$code='J'.$code;
								break;

							case '1':
								$code='B'.$code;
								break;
							
							default:
								$code='Non valide';
								break;
						}

						//$resultat="Vous avez saisi $code";
						
						require_once("soap-verification.php");
						//$resultat=$code;
					}


				else if($requete=="*4646*05#")
					{
						$i=0;

						$resultat="Cher client, ce code n'existe pas";
						$action="end";
						
						
						// if((($jour=="Samedi")AND ($heure>7)) || ($jour=="Dimanche") || (($jour=="Lundi") AND ($heure<8)))
						
						// 	{
						// 		//Proposition du menu principal ou page principale
						// 		$requete_menu="SELECT *FROM  menu_parifoot WHERE affichage='OUI'";
						// 		$resultat_menu=$connexion->query($requete_menu);
						// 		$resultat='';
						// 		while ($menu = mysqli_fetch_array($resultat_menu))
						// 			{
						// 				++$i;
						// 				$idMenu=$menu['idMenu'];
						// 				$nom=$menu['nom'];
						// 				$resultat .="\n".$i.". ".$nom; 	
						// 			}
						// 	}
						// else
						// 	{
						// 		$requetemin="SELECT MAX(NLL) AS max, MIN(NLL) AS min FROM matchesfree WHERE NLL!=''";
						// 		$resultatmin=$connexion->query($requetemin);
						// 		$mon = mysqli_fetch_array($resultatmin);
						// 		$min = $mon['min'];
						// 		$max = $mon['max'];
						// 		$resultat="\n \nEnvoyez un numero compris entre $min et $max  de la liste d'aujourd'hui pour avoir directement le resultat.  \n --- \n Cout : 5U/Jour";
						// 	}
					}
				else
					{
						$resultat="Cher client, ce code n'existe pas";
						$action="end";
					}	


			}

		//Gestion page principale 0
		else if($requete=="0")
			{
				require_once("gestion_principal.php");
			}
		
		//Gestion precedent si l'utilisateur saisi #1
		else if($requete=="#1")
			{
				require_once("gestion_precedent.php");
			}
		
		//Gestion suivant	si l'utilisateur saisi #2		
		else if ($requete=='#2')
			{
				require_once("gestion_suivant.php");
			}

		else
			{
				if($racourci=="*42212#")
				//if(($racourci=="*42212#")||($racourci=="*42212*01#"))	
					{
						if($sousmenu1==0)
							{

								// if($requete==1)
								// 	{
								// 		$requete_m="UPDATE clientussd SET menu='1', sousmenu1='1' WHERE TransactionId='$id'";
								// 		$resultat_m=$connexion->query($requete_m);
											
								// 		//require("awards.php");
								// 		require("enregistrement.php");
											
											
								// 	}
					
								// if($requete==2)
								// 	{
								// 		$requete_m="UPDATE clientussd SET menu='2', sousmenu1='2' WHERE TransactionId='$id'";
								// 		$resultat_m=$connexion->query($requete_m);
											
								// 		require("enregistrement.php");
											
											
								// 	}

								if($requete==1765467767667765)
									{
										$requete_m="UPDATE clientussd SET menu='5', sousmenu1='5' WHERE TransactionId='$id'";
										$resultat_m=$connexion->query($requete_m);
											
										require_once("classements.php");
											
											
									}	

							

								else if($requete==1237865564)
									{
									
										$requete_m="UPDATE clientussd SET menu='3', sousmenu1='3' WHERE TransactionId='$id'";
										$resultat_m=$connexion->query($requete_m);

										require("buteurs.php");

										// if($racourci=="*42212*01#")
										// 	{
												//$resultat ="\n1. Buteurs\n2. Cartons\n3. Gardiens"; 
										// 	}
										// else
										// 	{
										// 		require("buteurs.php");
										// 	}
										
										
										
									}

								else if($requete==2)
									{	
										
										$requete_m="UPDATE clientussd SET menu='4', sousmenu1='4' WHERE TransactionId='$id'";
										$resultat_m=$connexion->query($requete_m);

										require("score.php");
									
									}

								// else if($requete==6)
								// 	{
									
								// 		$requete_m="UPDATE clientussd SET menu='6', sousmenu1='6' WHERE TransactionId='$id'";
								// 		$resultat_m=$connexion->query($requete_m);

										
								// 		// if($racourci=="*42212*01#")
								// 		// 	{
													
								// 				$requete_m="UPDATE clientussd SET menu='0', sousmenu1='0', racourci='*42212*6#' WHERE TransactionId='$id'";
								// 				$resultat_m=$connexion->query($requete_m);

								// 				$resultat .="Veuillez Selectionner\n1. Compte M-pesa USD \n2. Compte M-pesa FC";
								// 		// 	}
								// 		// else
								// 		// 	{
								// 		// 		$resultat .="\nLe championnat est fini, merci d'attendre la saison prochaine " ;
								// 		// 		$action="end";
								// 		// 	}

								// 		//require_once("calendrierln.php");

								// 	}


								else if($requete==4)
									{
																			
										

											// if($racourci=="*42212*01#")
											// {
										$requete_m="UPDATE clientussd SET menu='6', sousmenu1='6'  WHERE TransactionId='$id'";
										$resultat_m=$connexion->query($requete_m);

										$resultat ="\n1. Saison 2019 \n2. Saison 2018";

												
										// 	}
										// else
										// 	{
										// 		$requete_m="UPDATE clientussd SET menu='7', sousmenu1='7' WHERE TransactionId='$id'";
										// 		$resultat_m=$connexion->query($requete_m);
												
										// 		// $resultat="Voulez-vous quitter?\n1. Tous les scores \n2.  Vodacom L1 News \n----\n0. Menu Principal";
										// 		$resultat="Voulez-vous quitter?\n1. Tous les scores \n2. News Vodacom L1  \n----\n0. Menu Principal";
										// 	}
									}

								
									else if($requete==1)
										{
											//$resultat ="Composez *1435#";
											$sorti="redirect.php";
											//$action="END";
											
										}

								// else if($requete==7)
								// 	{
																			
								// 		$requete_m="UPDATE clientussd SET menu='7', sousmenu1='7' WHERE TransactionId='$id'";
								// 		$resultat_m=$connexion->query($requete_m);
										
								// 		// $resultat="Voulez-vous quitter?\n1. Tous les scores \n2.  Vodacom L1 News \n----\n0. Menu Principal";
								// 		$resultat="Voulez-vous quitter?\n1. Tous les scores \n2. News Vodacom L1  \n----\n0. Menu Principal";
								// 	}
							
							}

						else
							{
								if($sousmenu1=='1')
									{
										require("enregistrement.php");
											
									}
								else if($sousmenu1=='2')
									{
										require("enregistrement.php");
									}
								else if($sousmenu1=='3')
									{
										
										//require("enregistrement.php");
										// if($requete==1)
										// 	{
												//$resultat="Debut de la saison 2020-2021, le 25 septembre 2020. Avec la Vodacom L1, Vivez la passion du foot ! \n----\n0. Menu Principal";
												require("buteurs.php");
										// 	}
										// else if($requete==2)
										// 	{

										// 		//require("cartons.php");
										// 		//$resultat="gardien";
										// 		$resultat="Debut de la saison 2020-2021, le 25 septembre 2020. Avec la Vodacom L1, Vivez la passion du foot ! \n----\n0. Menu Principal";
										// 	}
										// else if($requete==3)
										// 	{
										// 		//require("gardiens.php");
										// 		//$resultat="carton";
										// 		$resultat="Debut de la saison 2020-2021, le 25 septembre 2020. Avec la Vodacom L1, Vivez la passion du foot ! \n----\n0. Menu Principal";
										// 	}

									}
								else if($sousmenu1=='4')
									{
										require_once("score.php");
									}
								else if($sousmenu1==5)
									{
										require_once("classements.php");
									}
								else if($sousmenu1=='6')
									{
										//require_once("calendrierln.php");
										require_once("awards.php");
									}
								else if($sousmenu1=='7')
									{
										require_once("desabonnement_linafoot.php");
									}
							}

					}	

			else if($racourci=="*4646*0#")
					{
					
						if($sousmenu1==0)
							{
							
								$requete_m="UPDATE clientussd SET sousmenu1=$requete WHERE TransactionId='$id'";
								$resultat_m=$connexion->query($requete_m);
								
								if($requete==1)
									{
										$resultat='Inserer le numero du client';
									}
								else if($requete==2)
									{
										$requete_menu="SELECT *FROM  clientscore WHERE telephoneAgent='$telephone'";
										$resultat_menu=$connexion->query($requete_menu);
										$totals=mysqli_num_rows($resultat_menu);
										$resultat='Total clients: '. $totals."\n\n2. Voir la liste" ;
										// while ($menu = mysqli_fetch_array($resultat_menu))
										// 	{
										// 		++$i;
												
										// 		$telephones=$menu['telephoneClient'];
										// 		$resultat .="\n".$i.". ".$telephones; 	
										// 	}
									}
								else{
										$resultat .="\n1. Nouveau client \n2. Liste des clients";
									}
							}
						else
							{
								if($sousmenu1==1)
									{
										$requete_parieur="INSERT INTO clientscore(telephoneAgent, telephoneClient, dates, heures)VALUES('$telephone', '$requete', '$dates', '$heure')";
										$resultat_parieur=$connexion->query($requete_parieur);
										$resultat='Felicitation, le client '.$requete.' est enregistrE';
									}
								else if($sousmenu1==2)
									{
										$requete_menu="SELECT *FROM  clientscore WHERE telephoneAgent='$telephone'";
										$resultat_menu=$connexion->query($requete_menu);
										$resultat='Liste clients';
										while ($menu = mysqli_fetch_array($resultat_menu))
											{
												++$i;
												
												$telephones=$menu['telephoneClient'];
												$resultat .="\n".$i.". ".$telephones; 	
											}
									}
							}

					}

			// else if($racourci=="*4646*1#")
			// 		{
			// 			require_once("voyage/index.php");
			// 		}

                else if($racourci=="*42212*1#")
					//else if($racourci=="*42212*1#")
					{
					   if($menu=='0')
					        {
        					    $requete_m="UPDATE clientussd SET menu=$requete  WHERE TransactionId='$id'";
        						$resultat_m=$connexion->query($requete_m);
        					    
        					    $resultat='Vous votez votre meilleur Joueur avec :';
        					    	//Connexion vers la base Vodacom Ligue1
        						$requete_menu="SELECT *FROM  unites ";
        						$resultat_menu=$connexionvl1->query($requete_menu);
        						
        						while($menu=mysqli_fetch_array($resultat_menu))
        							{
        								$idMenu=$menu['id'];
        								$unite=$menu['nbre_unites'];
        								$vote=$menu['vote'];
        								
        								$resultat .="\n".$idMenu.". ".$unite." USD pour  ".$vote." vote(s)"; 	
        							}
					        }
					   else
					        {   
					            $requete_vo="INSERT INTO `votants` (`phone`) VALUES ('$telephone')";
					            $resultat_vo=$connexionvl1->query($requete_vo);
					           $last_id=mysqli_insert_id($connexionvl1);
					           
					             $requete_m="INSERT INTO mouvements(numero, fk_jouers, 	fk_unites, 	fk_votants, 	transactionid) VALUES ('$telephone', $menu, 	$requete, $last_id,$id)";
        						$resultat_m=$connexionvl1->query($requete_m);
					           
					           //Enoyer requete billing
					           require_once("vote.php");
					           
					            
					           
        						
        						$resultat ="Merci de voter";
        						$action="END";
					            
					        }
					}
				else if($racourci=="*42212*6#")
					//else if($racourci=="*42212*1#")
					{
						if($choix==0)
							{
								
								if(($requete==1)||($requete==2))
									{
										$requete_m="UPDATE clientussd SET menu=$requete, element=$requete  WHERE TransactionId='$id'";
										$resultat_m=$connexion->query($requete_m);

										$requetes="SELECT *FROM  typeTicket WHERE evenement_id=10 ";					
										$resultats=$connexion->query($requetes);	

										$resultat='Veillez Selectionner';
																	
										while($menu=mysqli_fetch_array($resultats))
											{
												$id=$menu['id'];
												$description=$menu['description'];
												if($requete==1)
													{
														$montant=$menu['montantUSD'];
														$devise=$menu['deviseUSD'];
													}
												else if($requete==2)
													{
														$montant=$menu['montant'];
														$devise=$menu['devise'];
													}
												$resultat .="\n".$id.". ".$description." : ".$montant." ".$devise;
																									
											}				
																		
										$resultat .="\n --- \n0 Menu Principal" ;
									}
								else
									{
									
										$resultat .="Veuillez Selectionner\n1. Compte M-pesa USD \n2. Compte M-pesa FC";
										
									}
							}

						//Message de confirmation et lancement pop up Mpesa
						else
							{
								//Traitement Kanda pour confirmation de lecture et lancement pop up
								if($sousmenu2==0)
									{
										if(($requete==1)||($requete==2)||($requete==3))
											{	
												$requete_m="UPDATE clientussd SET sousmenu2=$requete WHERE TransactionId='$id'";
												$resultat_m=$connexion->query($requete_m);

												//Mettre a jour le token
												//require_once("token.php");

												$resultat ="Confirmer avoir lu et accepte les conditions sur wwww.vodacoml1.com?\n1. Confirmer --- \n0. Annuler" ;
											}
										else
											{
												$requetes="SELECT *FROM  typeTicket WHERE evenement_id=10 ";					
												$resultats=$connexion->query($requetes);	

												$resultat='Veillez Selectionner';
																			
												while($menu=mysqli_fetch_array($resultats))
													{
														$id=$menu['id'];
														$description=$menu['description'];
														if($menumpesa==1)
															{
																$montant=$menu['montantUSD'];
																$devise=$menu['deviseUSD'];
															}
														else if($menumpesa==2)
															{
																$montant=$menu['montant'];
																$devise=$menu['devise'];
															}
														$resultat .="\n".$id.". ".$description." : ".$montant." ".$devise;
																											
													}				
																				
												$resultat .="\n --- \n0 Menu Principal" ;	
											}
									}
								else
									{

										if($requete==1)
											{
												require("recuperertokenvl1.php");
												
												$cmd="php -f /var/www/html/popupmpesa.php $id $telephone $choix &";

												exec($cmd ."> /dev/null &");

												$resultat ="veuillez patienter pour inserer le code PIN";
												
												$action="end";	

											}

										else
											{	

												$resultat ="Confirmer avoir lu et accepte les conditions sur wwww.vodacoml1.com?\n1. Confirmer --- \n0. Annuler" ;

											}
									}	

											
										
									}

					}

					else if($racourci=='*4646*05#')
						{
							// $requete_m="UPDATE clientussd SET sousmenu1=sousmenu1+1 WHERE TransactionId='$id'";
							// $resultat_m=$connexion->query($requete_m);

							
							if((($jour=="Samedi")AND ($heure>7)) || ($jour=="Dimanche") || (($jour=="Lundi") AND ($heure<8)))
							
								{
									//Si l'utilisateur n'a pas encore selectionné un de palmares, on lui propose les championnats  d'envoyer
									if($sousmenu1==0)
										{
											require_once("choix_dun_element_du_menu_principal_dynamique_parieur.php");
										}
									else
										{
											
											if($sousmenu1==1)
												{
													$liste='NLL';
												}
											else if($sousmenu1==2)
												{
													$liste='NMM';
												}
											$choix=1;

											$requete_m="UPDATE clientussd SET compteurrequete=compteurrequete+1 WHERE TransactionId='$id'";
											$resultat_m=$connexion->query($requete_m);

											require_once("liste.php");
										}
								}
							else
								{
									$liste='NLL';
									$choix=1;

									$requete_m="UPDATE clientussd SET compteurrequete=compteurrequete+1 WHERE TransactionId='$id'";
									$resultat_m=$connexion->query($requete_m);

									require_once("liste.php");
								}

						}


				else if($racourci=="*4646*5#")
				//if(($requete=="*4646*1#")OR($requete=="*42212#"))

					{
						
						
						if ($modepaiement==0)
							{
								
								if($requete==1)
									{
										$requete_m="UPDATE clientussd SET modepaiement=1 WHERE TransactionId='$id'";
										$resultat_m=$connexion->query($requete_m);

										$resultat='Resultats des matchs';
										$resultat .="\n1. Par numero du match \n2. Par nom de l'equipe\n----";
									}

								else if($requete==2)
									{ 
										$requete_m="UPDATE clientussd SET modepaiement=2 WHERE TransactionId='$id'";
												$resultat_m=$connexion->query($requete_m);

										if((($jour=="Samedi")AND ($heure>7)) || ($jour=="Dimanche") || (($jour=="Lundi") AND ($heure<8)))
						
											{
												//Proposition du menu principal ou page principale
												$requete_menu="SELECT *FROM  menu_parifoot WHERE affichage='OUI'";
												$resultat_menu=$connexion->query($requete_menu);
												$resultat='';
												while ($menu = mysqli_fetch_array($resultat_menu))
													{
														++$i;
														$idMenu=$menu['idMenu'];
														$nom=$menu['nom'];
														$resultat .="\n".$i.". ".$nom; 	
													}
											}
										else
											{
												$requetemin="SELECT MAX(NLL) AS max, MIN(NLL) AS min FROM matchesfree WHERE NLL!=''";
												$resultatmin=$connexion->query($requetemin);
												$mon = mysqli_fetch_array($resultatmin);
												$min = $mon['min'];
												$max = $mon['max'];
												$resultat="\n \nEnvoyez un numero compris entre $min et $max  de la liste d'aujourd'hui pour avoir directement le resultat.  \n --- \n Cout : 5U/Jour";
											}
									}
								else 
									{
										//On verifi le mode de paiement
										//Par Mpesa
										$resultat='Resultats des matchs';
										$resultat .="\n1. Par M-pesa \n2. Par des Unites\n----";
									}



							
							}
						else
							{
								if($modepaiement==1)
									{
										require_once("listempesa.php");	
									}
								else if($modepaiement==2)
									{
										// $liste='NLL';
										// $choix=1;

										// $requete_m="UPDATE clientussd SET compteurrequete=compteurrequete+1 WHERE TransactionId='$id'";
										// $resultat_m=$connexion->query($requete_m);

										// require_once("liste.php");

										if((($jour=="Samedi")AND ($heure>7)) || ($jour=="Dimanche") || (($jour=="Lundi") AND ($heure<8)))
							
											{
												//Si l'utilisateur n'a pas encore selectionné un de palmares, on lui propose les championnats  d'envoyer
												if($sousmenu1==0)
													{
														require_once("choix_dun_element_du_menu_principal_dynamique_parieur.php");
													}
												else
													{
														
														if($sousmenu1==1)
															{
																$liste='NLL';
															}
														else if($sousmenu1==2)
															{
																$liste='NMM';
															}
														$choix=1;

														$requete_m="UPDATE clientussd SET compteurrequete=compteurrequete+1 WHERE TransactionId='$id'";
														$resultat_m=$connexion->query($requete_m);

														require_once("liste.php");
													}
											}
										else
											{
												$liste='NLL';
												$choix=1;

												$requete_m="UPDATE clientussd SET compteurrequete=compteurrequete+1 WHERE TransactionId='$id'";
												$resultat_m=$connexion->query($requete_m);

												require_once("liste.php");
											}


									}
							}
						
						//$resultat='MPESA Score';
						//$resultat .="\n1. Par numero du match \n2. Par nom de l'equipe\n3. Activation";
						
					}

				//100% Score MPESA, 
				else if($racourci=="*4646*6#")
					{
						//choix par numero ou par nom de l'equipe
						if($menu==0)
							{
								

								if($requete==1)
									{
										$requete_m="UPDATE clientussd SET menu=$requete WHERE TransactionId='$id'";
										$resultat_m=$connexion->query($requete_m);

										if((($jour=="Samedi")AND ($heure>7)) || ($jour=="Dimanche") || (($jour=="Lundi") AND ($heure<8)))
						
											{
												//Proposition du menu principal ou page principale
												$requete_menu="SELECT *FROM  menu_parifoot WHERE affichage='OUI'";
												$resultat_menu=$connexion->query($requete_menu);
												$resultat='';
												while ($menu = mysqli_fetch_array($resultat_menu))
													{
														++$i;
														$idMenu=$menu['idMenu'];
														$nom=$menu['nom'];
														$resultat .="\n".$i.". ".$nom; 	
													}
											}
										else
											{
												$requetemin="SELECT MAX(NLL) AS max, MIN(NLL) AS min FROM matchesfree WHERE NLL!=''";
												$resultatmin=$connexion->query($requetemin);
												$mon = mysqli_fetch_array($resultatmin);
												$min = $mon['min'];
												$max = $mon['max'];
												$resultat="\n \nEnvoyez un numero compris entre $min et $max  de la liste d'aujourd'hui pour avoir directement le resultat.  \n --- \n0 Menu principal";
											}
									}
								else if($requete==2)
									{
										
										$requete_m="UPDATE clientussd SET menu=$requete WHERE TransactionId='$id'";
										$resultat_m=$connexion->query($requete_m);
												
										$resultat='SCORE EN DIRECT';
										$resultat.="\nEnvoyez les initiales de votre equipe pour avoir directement le resultat(ex: barce pour barcelone). \n --- \n0 Menu principal";
											
											
									}
								else
									{

										$resultat='Resultats des matchs';
										$resultat .="\n1. Par numero du match \n2. Par nom de l'equipe\n----";
									}
								
							}
						
						else
							{
								
								$requete_mpesa="SELECT *FROM  abonneJournalierMpesa WHERE numero='$telephone' AND choix=4 AND continu='ON' ORDER BY idAbonne DESC";
								$resultat_mpesa=$connexion->query($requete_mpesa);
								$visiteur_mpesa = mysqli_num_rows($resultat_mpesa);

								if($menu==1)
									{
										//S'il y a un forfait Mpesa Actif, on propose directement les resultats
										if($visiteur_mpesa!=0)
											{
												$message=trim($requete);	
												
												if (is_numeric($message)) 
													{

														if((($jour=="Samedi")AND ($heure>7)) || ($jour=="Dimanche") || (($jour=="Lundi") AND ($heure<8)))
											
															{
																//Si l'utilisateur n'a pas encore selectionn� un de palmares, on lui propose les championnats  d'envoyer
																if($sousmenu1==0)
																	{
																		$requete_majmenu="UPDATE clientussd SET sousmenu1='$requete' WHERE TransactionId='$id'";
																		$resultat_majmenu=$connexion->query($requete_majmenu);

																		
																		if ($requete=='1')
																			{
																				$requetemin="SELECT MAX(NLL) AS max, MIN(NLL) AS min FROM matchesfree WHERE NLL!=''";
																				$resultatmin=$connexion->query($requetemin);

																			
																				$mon = mysqli_fetch_array($resultatmin);
																				$min = $mon['min'];
																				$max = $mon['max'];
																				
																				// $resultat="\n \nEnvoyez un numero de la liste longue Taux compris entre $min et $max pour avoir directement le resultat. \n --- \n#1 Precedent \n0 Menu principal";
																				// $resultat="\n \nEnvoyez un numero de la liste longue compris entre $min et $max pour avoir directement le resultat. \n --- \n#1 Precedent \n0 Menu principal";
																				$resultat="\n \nEnvoyez un numero compris entre $min et $max  de la liste TOT d'aujourd'hui pour avoir directement le resultat.\n ---";
																							
																			}
																			
																		
																		else if ($requete=='2')
																			{
																				$requetemin="SELECT MAX(NMM) AS max, MIN(NMM) AS min FROM matchesfree WHERE NMM!=''";
																				$resultatmin=$connexion->query($requetemin);
																				$mon =mysqli_fetch_array($resultatmin);
																				$min = $mon['min'];
																				$max = $mon['max'];
																				// $resultat="\n \nEnvoyez un numero de la liste longue Tard compris entre $min et $max pour avoir directement le resultat. \n --- \n 0 Menu principal";
																				$resultat="\n \nEnvoyez un numero compris entre $min et $max  de la liste TARD d'aujourd'hui pour avoir directement le resultat.\n --- ";
																							
																			}
																	}
																else
																	{
																					
																		if($sousmenu1==1)
																			{
																				$liste='NLL';
																			}
																		else if($sousmenu1==2)
																			{
																				$liste='NMM';
																			}
																		$choix=1;

																		$requete_m="UPDATE clientussd SET compteurrequete=compteurrequete+1 WHERE TransactionId='$id'";
																		$resultat_m=$connexion->query($requete_m);

																		require_once("listedetailmpesa.php");
																	}
															}
														else
															{
																$liste='NLL';
																$choix=1;

																$requete_m="UPDATE clientussd SET compteurrequete=compteurrequete+1 WHERE TransactionId='$id'";
																$resultat_m=$connexion->query($requete_m);

																require_once("listedetailmpesa.php");
															}

													}
																
												else
													{
														$requetemin="SELECT MAX(NLL) AS max, MIN(NLL) AS min FROM matchesfree WHERE NLL!=''";
														$resultatmin=$connexion->query($requetemin);
														$resultat="ERREUR D'ENVOIE!!!";
														$mon = mysqli_fetch_array($resultatmin);
														$min = $mon['min'];
														$max = $mon['max'];
														$resultat.="\nEnvoyez un numero compris entre $min et $max  de la liste d'aujourd'hui\n --- \n0 Menu principal";
														//$resultat.="\nEnvoyez un numero de match de la liste d'aujourd'hui\n --- \n0 Menu principal";
													}
											}
										else
											{
												//Si le client n'a jamais accepté les termers et conditions, on lui propose
												$requete_m="SELECT *FROM  abonneAccepteTermesMpesa WHERE numero='$telephone'";
												$resultat_m=$connexion->query($requete_m);
												$visiteur_m = mysqli_num_rows($resultat_m);
						
												//S'il y a un forfait Mpesa Actif, on propose directement la recheche des resultats via Mpesa
												if($visiteur_m==0)
													{

														if($choix==0)
															{
																	//S'il n'a pas un forfait acti, on lui propose la confirmation qu'il a lu les conditions VL1
																	$requete_m="UPDATE clientussd SET element=1 WHERE TransactionId='$id'";
																	$resultat_m=$connexion->query($requete_m);
																
																	$resultat ="Confirmer avoir lu et accepte les conditions sur wwww.scoredufoot.com?\n1. Confirmer --- \n0. Annuler" ;
															}
														else
															{
																if($requete==1)
																	{
																		//Insertion confirmation pour la premiere fois
																		$requete_parieur="INSERT INTO abonneAccepteTermesMpesa(numero, dates, heure, TransactionId, raccourci )VALUES('$telephone', '$dates', '$heure', '$id', '*4646*6#')";
																		$resultat_parieur=$connexion->query($requete_parieur);


																		
																		require("recuperertoken.php");
																		//require_once("soapbillingmpesa.php");
									
																		$cmd="php -f /var/www/html/commandetest.php $id $telephone Salut &";
									
																		exec($cmd ."> /dev/null &");
									
																		//sleep(5);
									
																		$resultat ="veuillez patienter pour inserer le code PIN";
																		$action="end";	
									
									
																		// $resultat ="Veuillez patienter pour inserer votre code PIN ou reessayez si ca traine" ;
									
																		// $action='end';	
																	}
									
																else
																	{	
									
																		$resultat ="Confirmer avoir lu et accepte les conditions sur wwww.scoredufoot.com?\n1. Confirmer --- \n0. Annuler" ;
									
																	}
									
															}	
													}
												else
													{
														$choix=1;

														require("recuperertoken.php");
																		
														$cmd="php -f /var/www/html/commandetest.php $id $telephone Salut &";
									
														exec($cmd ."> /dev/null &");
									
														$resultat ="veuillez patienter pour inserer le code PIN";
														
														$action="end";	
														
													}	
												
												
											}
									}
								else if($menu==2)
									{
										//S'il y a un forfait Mpesa Actif, on propose directement les resultats
										if($visiteur_mpesa!=0)
											{
												//Si la requete est soit 1 ou 2 et le code du match existe, dans ce cas l'utilisateur demande les buteurs ou les cartons
												if((($requete==1)||($requete==2))&&($codematch!=0))
													{
														//Les buteurs
														if($requete==1)
															{
																$resultat="Buteurs :";
																$requetes="SELECT * FROM `evenementmatch` WHERE `matchid`=$codematch AND `types`='goal' ORDER BY minute ASC";
																$resultats=$connexion->query($requetes);
																$tot=mysqli_num_rows($resultats);
																if($tot==0)
																	{
																		$resultat .="\nAucun buteur pour ce match\n---\n2. Voir les cartons\n0. Menu Principal";
																	}
																else
																	{
																		while ($menu = mysqli_fetch_array($resultats))
																			{
																				++$i;
																				$player_local=$menu['player_local'];
																				$player_visitor=$menu['player_visitor'];
																				$player=$menu['player_visitor'];
																				$minute=$menu['minute'];
																				$result=$menu['result'];

																				$resultat .="\n".$minute."min. ".$player_local." ".$result." ".$player_visitor; 	
																			}

																		$resultat .="\n---\n2. Voir les cartons\n0. Menu Principal";
																	}
																	
															}
														//Les cartons	
														else
															{
																$resultat="Cartons :";
																$requetes="SELECT * FROM `evenementmatch` WHERE `matchid`=$codematch AND (`types`='yellowcard' OR `types`='redcard') ORDER BY minute ASC";
																$resultats=$connexion->query($requetes);
																$tot=mysqli_num_rows($resultats);
																if($tot==0)
																	{
																		$resultat .="\nAucun carton pour ce match\n---\n1. Voir les buteurs\n0. Menu Principal";
																	}
																else
																	{
																		while ($menu = mysqli_fetch_array($resultats))
																			{
																				++$i;
																				$player_local=$menu['player_local'];
																				$player_visitor=$menu['player_visitor'];
																				$player=$menu['player_visitor'];
																				$minute=$menu['minute'];
																				$result=$menu['types'];
																				switch ($result) {
																					case 'yellowcard':
																						$carton="Jaune";
																						break;
																					case 'redcard':
																						$carton="Rouge";
																						break;
																					
																					default:
																						# code...
																						break;
																				}


																				$resultat .="\n".$player_local."".$player_visitor." : ".$carton." ".$minute."min."; 	
																			}
																		$resultat .="\n---\n1. Voir les buteurs\n0. Menu Principal";
																	}
															}
													}
												//Sinon, l'utilisateur demande les resultats des matchs	
												else
													{	

														$espace=' ';
														$posEspace=mb_substr_count($requete, $espace);
												
														//Recuperation de l'equipe
														//$equipe = $requete;
														$equipe=trim($requete);
																		
																		
														//Nombre de caract�re de l'equipe
														$equipes=strlen($equipe);
																
														//Verifier si le mot a au moins 3 caract�res,
														//Si non, on envoie un message les initiales doivent avoir au moins 3 caract�res
														//Si oui, on lance la recherche du match
														if($equipes<3)
															{
																// $statuten="FAIL";
																$match="<3";
																$resultat="Les initiales doivent avoir au minimum 3 caracteres. Ex:  BARC pour le match de BARCELONE";
																				
																				
															}
														
														else
															{
																//Recherche du match
																$requetex="SELECT *FROM  matchesfree WHERE equipeA LIKE  '%$equipe%' OR  equipeAFR LIKE  '%$equipe%' OR equipeB LIKE  '%$equipe%' OR equipeBFR LIKE  '%$equipe%' OR autreMotLocal LIKE  '%$equipe%' OR autreMotVisiteur LIKE  '%$equipe%'";
																		
																//Traitement de resultat
																$resultatx=$connexion->query($requetex);
																				
																//Nombre de ligne de resultat, qui permettra de savoir combien de matchs sont trouv�s
																$nbre_ligne=mysqli_num_rows($resultatx);
																				
																//Si aucun match n'est trouv� par rapport � la requ�te	
																//On recherche l'erreur pour corriger, ou on envoie les matchs pass�s ou futur s'il y a rien
																if($nbre_ligne==0)
																	{
																						
																		$resultat="Ce match n'est pas du jour ou vous avez mal saisi les mots";
																						
																	}
																
																//Un seul match
																else if($nbre_ligne==1)
																	{
																		//Si le match est  trouv�, deux cas sont possible et seront trait�s
																		//1er cas, lorsqu'on a au plus 3 match pour une seule requ�te, on envoie 3 SMS successifs
																		//2eme cas, lorsqu'on a au moins 4 match pour une seule requ�te, on envoie le SMS contenant 4 match au maximum
																						
																		//Nbre de ligne est inferieur � 3 et superieur � 0, on a envoie les SMS en fonction de nombre de match au maximum 3 SMS
																						
																		require_once("flexysms/maximum_direct_mpesa.php");
																	}
																				//Plusieurs match, alors prevenir pour que le client ne recoit pas plusieurs sms
																else
																	{
																		require_once("flexysms/plusieurs_direct_mpesa.php");
																		//$resultat="Suggestion orthographe";
																	}
															}
														}
											}
										//Activation Forfait
										else
											{
												
												//Si le client n'a jamais accepté les termers et conditions, on lui propose
												$requete_m="SELECT *FROM  abonneAccepteTermesMpesa WHERE numero='$telephone'";
												$resultat_m=$connexion->query($requete_m);
												$visiteur_m = mysqli_num_rows($resultat_m);
						
												//S'il y a un forfait Mpesa Actif, on propose directement la recheche des resultats via Mpesa
												if($visiteur_m==0)
													{
														if($choix==0)
															{
																	//S'il n'a pas un forfait acti, on lui propose la confirmation qu'il a lu les conditions VL1
																	$requete_m="UPDATE clientussd SET element=1 WHERE TransactionId='$id'";
																	$resultat_m=$connexion->query($requete_m);
																
																	$resultat ="Confirmer avoir lu et accepte les conditions sur wwww.scoredufoot.com?\n1. Confirmer --- \n0. Annuler" ;
															}
														else
															{
																if($requete==1)
																	{
																		//Insertion confirmation pour la premiere fois
																		$requete_parieur="INSERT INTO abonneAccepteTermesMpesa(numero, dates, heure, TransactionId, raccourci )VALUES('$telephone', '$dates', '$heure', '$id', '*4646*6#')";
																		$resultat_parieur=$connexion->query($requete_parieur);
																		
																		require("recuperertoken.php");
																		//require_once("soapbillingmpesa.php");
									
																		$cmd="php -f /var/www/html/commandetest.php $id $telephone Salut &";
									
																		exec($cmd ."> /dev/null &");
									
																		//sleep(5);
									
																		$resultat ="veuillez patienter pour inserer le code PIN";
																		$action="end";	
									
									
																		// $resultat ="Veuillez patienter pour inserer votre code PIN ou reessayez si ca traine" ;
									
																		// $action='end';	
																	}
									
																else
																	{	
									
																		$resultat ="Confirmer avoir lu et accepte les conditions sur wwww.scoredufoot.com?\n1. Confirmer --- \n0. Annuler" ;
									
																	}
									
															}	
													}
												else
													{
														$choix=1;

														require("recuperertoken.php");
																		
														$cmd="php -f /var/www/html/commandetest.php $id $telephone Salut &";
									
														exec($cmd ."> /dev/null &");
									
														$resultat ="veuillez patienter pour inserer le code PIN";
														
														$action="end";	
														
													}	
														
												
											}
	
									}
							
							}
					}	

				//Marche kinshasa
				else if($racourci=="*4646*243#")
				//if(($requete=="*4646*1#")OR($requete=="*42212#"))

					{

						//Verifier si  le venteur est enregistre
						$connexionmarche= mysqli_connect("localhost","marcherd_ejsarl","eliamaisongo@","marcherd_recoltes");
						$requet="SELECT * FROM `vendeur` WHERE numeroTable=$requete OR  numeroTable=$sousmenu1";
						$resultatmarche=$connexionmarche->query($requet);
						$totres=mysqli_num_rows($resultatmarche);
						$recuperer=mysqli_fetch_array($resultatmarche);
						$prenom = $recuperer['prenom'];
						$nom = $recuperer['nom'];
						$sexe=$recuperer['sexe'];
						if($sexe=='masculin')
							{
								$textesexe = 'Monsieur';
							}
						else
							{
								
								$textesexe = 'Madame';
								
							}
						if($totres==0)
							{
								$resultat ="Ce numero de table n est pas enregistre";
								$action="end";
							}
						else
							{
								//Demander la confirmation
								if($sousmenu1==0)
									{
										$requete_m="UPDATE clientussd SET sousmenu1=$requete WHERE TransactionId='$id'";
										$resultat_m=$connexion->query($requete_m);
										$resultat ="Confirmez le paiement de taxe pour $textesexe $prenom $nom ?\n---\n1. OUI\n2. NON";	
									}
								else
									{
										if($requete==1)
											{
												require("recuperertokenmarche.php");
												
												$cmd="php -f /var/www/html/commandemarche.php $id $telephone Salut &";
										
												exec($cmd ."> /dev/null &");
										
												$resultat ="veuillez patienter";
												$action="end";
											}
										else
											{
												$resultat ="Vous avez annulE l'operation";
												$action="end";	
											}

									}
							}	

						//require_once("listempesaforcheck.php");
						//$sortie="rien.php";
						//$resultat='MPESA Score';
						//$resultat .="\n1. Par numero du match \n2. Par nom de l'equipe\n3. Activation";
						
					}

						//PROJET SMS
						else if($racourci=="*4646*123#")
						//if(($requete=="*4646*1#")OR($requete=="*42212#"))
		
							{
		
								//Verifier si  le venteur est enregistre
								$connexionsms = mysqli_connect("localhost", "eliajimm_sms",  "j'utiliseSMS243","eliajimm_sms");
								$requet="SELECT * FROM `user` WHERE id=$requete OR  id=$sousmenu1";
								$resultatsms=$connexionsms->query($requet);
								$totres=mysqli_num_rows($resultatsms);
								$recuperer=mysqli_fetch_array($resultatsms);
								$prenom = $recuperer['prenom'];
								$nom = $recuperer['nom'];
								
								if($totres==0)
									{
										$resultat ="Ce code client  n'existe pas";
										$action="end";
									}
								else
									{
										//Demander la confirmation
										if($sousmenu1==0)
											{
												$requete_m="UPDATE clientussd SET sousmenu1=$requete WHERE TransactionId='$id'";
												$resultat_m=$connexion->query($requete_m);
												$resultat ="Inserer le nombre de SMS du client $requete $prenom $nom ";	
											}
										else
											{
												$requete_m="UPDATE solde SET quantite_achetee=quantite_achetee+$requete WHERE solde_client='$sousmenu1'";
												$resultat_m=$connexionsms->query($requete_m);
											
												$resultat ="Vous avez ajoute $requete SMS pour $sousmenu1";
												$action="end";
		
											}
									}	
		
								//require_once("listempesaforcheck.php");
								//$sortie="rien.php";
								//$resultat='MPESA Score';
								//$resultat .="\n1. Par numero du match \n2. Par nom de l'equipe\n3. Activation";
								
							}

					//Paiement vignette
					else if($racourci=="*4646*33#")
						{
	
							//Verifier si  le venteur est enregistre
							$connexion1= mysqli_connect("localhost","pret_vignette","villedekinshasa@","pret_vignette");
							$requet="SELECT vehicule.id AS idvehicule, vehicule.proprietaire, vehicule.genre, vehicule.annee_de_fabrication, vehicule.numeroplaque, vehicule.marque, proprietaire.prenom, proprietaire.nom , proprietaire.sexe, vignette.id AS idvignette FROM vehicule, proprietaire, vignette WHERE vehicule.proprietaire=proprietaire.id AND vignette.id=vehicule.categorie_cv AND (vehicule.numeroplaque='$requete' OR vehicule.numeroplaque='$pret')";
							$resultatmarche=$connexion1->query($requet);
							$totres=mysqli_num_rows($resultatmarche);
							$recuperer=mysqli_fetch_array($resultatmarche);
							$prenom = $recuperer['prenom'];
							$nom = $recuperer['nom'];
							$sexe=$recuperer['sexe'];
							$marque= $recuperer['marque'];
							$genre= $recuperer['genre'];
							$annee= $recuperer['annee_de_fabrication'];
							$idvignette= $recuperer['idvignette'];
							$idvehicule= $recuperer['idvehicule'];

							if($sexe=='masculin')
								{
									$textesexe = 'Monsieur';
								}
							else
								{
									
									$textesexe = 'Madame';
									
								}
							if($totres==0)
								{
									$resultat ="Ce numero de plaque n est pas enregistre";
									$action="end";
								}
							else
								{
									//Demander la confirmation
									if($sousmenu1==0)
										{
											$requete_m="UPDATE clientussd SET sousmenu1=1, pret='$requete' WHERE TransactionId='$id'";
											$resultat_m=$connexion->query($requete_m);
											$resultat ="Confirmez le paiement vignette $genre $marque $annee pour $textesexe $prenom $nom ?\n---\n1. OUI\n2. NON";	
										}
									else
										{
											if($requete==1)
												{
													require("recuperertokenvignette.php");
													
													$cmd="php -f /var/www/html/commandevignette.php $id $telephone Salut &";
											
													exec($cmd ."> /dev/null &");
											
													$resultat ="veuillez patienter";
													$action="end";
												}
											else
												{
													$resultat ="Vous avez annule l'operation";
													$action="end";	
												}
	
										}
								}	
	
							//require_once("listempesaforcheck.php");
							//$sortie="rien.php";
							//$resultat='MPESA Score';
							//$resultat .="\n1. Par numero du match \n2. Par nom de l'equipe\n3. Activation";
							
						}

					//Paiement peage
					else if($racourci=="*4646*22#")
						{
	
							if($sousmenu1==0)
										{
											
											$requete_m="UPDATE clientussd SET sousmenu1=$requete, pret='$requete' WHERE TransactionId='$id'";
											$resultat_m=$connexion->query($requete_m);
											
											if($requete==1)
    											{
    											 $resultat ="Veuillez inserer le code peage que vous voulez payer maintenat";
    											}
										    else if($requete==2)
										        {
										             $resultat ="Veuillez inserer le code peage que vous voulez ouvrir";
										        }
										   else if($requete==3)
										        {
										             $resultat ="Pour plus d'info, appelez le numero 0820642324";
										        }
										   else
										        {
										             $resultat ="Erreur";
										             $action="END";
										        }
										       
										}
									else
										{
											
											$sender='EJSARL';
											$telep=243853092429;
                                            
                                            if($sousmenu1==1)
                                                {
                                                  if($sousmenu2==0)
                                                  {
                                                  $requete1="UPDATE clientussd SET sousmenu2=1, reponse='$requete'";
                                                  $resultat1=$connexion->query($requete1);
                                                  
                                                  	$requete_p="INSERT INTO user(telephone)VALUES($telephone)";
												$resultat_p=$connexionpeage->query($requete_p);  
												
										$requete_p1="SELECT * FROM peage WHERE code=$requete ";
						$resultat_p1=$connexionpeage->query($requete_p1);
						$totres1=mysqli_num_rows($resultat_p1);
						$recuperer=mysqli_fetch_array($resultat_p1);
						$nom=$recuperer['nom'];
						$prix=$recuperer['prix'];
						$resultat ="Voulez-vous payer $prix FC pour le peage de $nom?\n\n1. OUI \n2. Non";
                                                      
                                                  }
                                                 else
                                                 {
                                                     if($requete==1)
                                                     {
                                                         //Inserer dans la table commande l'utilisateur et son choix et ensuite lancer le pop up Mpesa et recupration token
                                       require ("recuperertokenpeage.php");
                                       
                                      
                                                         
                                                         
													$cmd="php -f /var/www/html/commandepeage.php $id $telephone Salut &";

						exec($cmd ."> /dev/null &");


						$resultat ="veuillez patienter pour inserer le code PIN";
						$action="end";
                                                       
                                                     }
                                                     else
                                                     {
                                                         $resu="QUITTER";
                                                         $action="END";
                                                     }
                                                 }
												
                                                }
											else if($sousmenu1==2)
												{
												    
												    				$requete_p2="SELECT *FROM commande  WHERE telephone_users='$telephone' ORDER BY id DESC ";
						$resultat_p2=$connexionpeage->query($requete_p2);
						$recuperer1=mysqli_fetch_array($resultat_p2);
						$payer=$recuperer1['payer'];
						if($payer=='OUI')	
									{			
													$message='OUVRIR';
													$resu='Ouverture de la barriere en cours';
													
													$requeteup="UPDATE commande  SET payer='USE', barriere='OUI' WHERE 	telephone_users='$telephone' AND payer='OUI'";

    $resultatup=$connexionpeage->query($requeteup);
													
													$action="end";
												
										
												
											$url="http://smsuser.dream-digital.info:6005/api/v2/SendSMS?ApiKey=78HrvshCi+wm56S6XUe0FBeCZ23eC7ozxJuK+GZMsHc=&ClientId=62f65558-8a81-49ed-a0e3-ac322ddc9530&SenderId=$sender&Message=$message&MobileNumbers=$telep";
                                                                                                              
											// create curl resource 
											$ch = curl_init(); 

											// set url 
											curl_setopt($ch, CURLOPT_URL, $url); 

											//return the transfer as a string 
											curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 

											// $output contains the output string 
											$output = curl_exec($ch); 

											// close curl resource to free up system resources 
											curl_close($ch);
											$resultat =$resu;	

								            	}
								        else
								            {
								                 $resultat="Merci de payer d'abord avant d'ouvrir la barriere";
								                 $action='end';
								            }
										    }
										
										
									}
							//Verifier si  le venteur est enregistre
							// $connexion1= mysqli_connect("localhost","pret_vignette","villedekinshasa@","pret_vignette");
							// $requet="SELECT vehicule.id AS idvehicule, vehicule.proprietaire, vehicule.genre, vehicule.annee_de_fabrication, vehicule.numeroplaque, vehicule.marque, proprietaire.prenom, proprietaire.nom , proprietaire.sexe, vignette.id AS idvignette FROM vehicule, proprietaire, vignette WHERE vehicule.proprietaire=proprietaire.id AND vignette.id=vehicule.categorie_cv AND (vehicule.numeroplaque='$requete' OR vehicule.numeroplaque='$pret')";
							// $resultatmarche=$connexion1->query($requet);
							// $totres=mysqli_num_rows($resultatmarche);
							// $recuperer=mysqli_fetch_array($resultatmarche);
							// $prenom = $recuperer['prenom'];
							// $nom = $recuperer['nom'];
							// $sexe=$recuperer['sexe'];
							// $marque= $recuperer['marque'];
							// $genre= $recuperer['genre'];
							// $annee= $recuperer['annee_de_fabrication'];
							// $idvignette= $recuperer['idvignette'];
							// $idvehicule= $recuperer['idvehicule'];

							// if($sexe=='masculin')
							// 	{
							// 		$textesexe = 'Monsieur';
							// 	}
							// else
							// 	{
									
							// 		$textesexe = 'Madame';
									
							// 	}
							// if($totres==0)
							// 	{
							// 		$resultat ="Ce numero de plaque n est pas enregistre";
							// 		$action="end";
							// 	}
							// else
							// 	{
							// 		//Demander la confirmation
							// 		if($sousmenu1==0)
							// 			{
							// 				$requete_m="UPDATE clientussd SET sousmenu1=1, pret='$requete' WHERE TransactionId='$id'";
							// 				$resultat_m=$connexion->query($requete_m);
							// 				$resultat ="Confirmez le paiement vignette $genre $marque $annee pour $textesexe $prenom $nom ?\n---\n1. OUI\n2. NON";	
							// 			}
							// 		else
							// 			{
							// 				if($requete==1)
							// 					{
							// 						require("recuperertokenvignette.php");
													
							// 						$cmd="php -f /var/www/html/commandevignette.php $id $telephone Salut &";
											
							// 						exec($cmd ."> /dev/null &");
											
							// 						$resultat ="veuillez patienter";
							// 						$action="end";
							// 					}
							// 				else
							// 					{
							// 						$resultat ="Vous avez annule l'operation";
							// 						$action="end";	
							// 					}
	
							// 			}
									
	
							//require_once("listempesaforcheck.php");
							//$sortie="rien.php";
							//$resultat='MPESA Score';
							//$resultat .="\n1. Par numero du match \n2. Par nom de l'equipe\n3. Activation";
							
						}

				else if($racourci=="*4646**243#")
				//if(($requete=="*4646*1#")OR($requete=="*42212#"))

					{


						//Verifier si  le venteur est enregistre
						$connexionmarche= mysqli_connect("localhost","marcherd_ejsarl","eliamaisongo@","marcherd_recoltes");
						$requet="SELECT * FROM `payement` WHERE numero_table=$requete ";
						$resultatmarche=$connexionmarche->query($requet);
						$totres=mysqli_num_rows($resultatmarche);
						$recuperer=mysqli_fetch_array($resultatmarche);
						
					
						if($totres==0)
							{
								$resultat ="Ce numero de table $requete n'est pas en ordre";
								
							}
						else
							{
								$resultat ="Ce numero de table $requete est  en ordre";
								
							}	

						
					}

				else if($racourci=="*4646*06#")
				//if(($requete=="*4646*1#")OR($requete=="*42212#"))

					{
						
						$cmd="php -f /var/www/html/commandetest.php $id $telephone Salut &";

						exec($cmd ."> /dev/null &");

						//sleep(5);

						$resultat ="veuillez patienter pour inserer le code PIN";
						$action="end";

						//require_once("listempesaforcheck.php");
						//$sortie="rien.php";
						//$resultat='MPESA Score';
						//$resultat .="\n1. Par numero du match \n2. Par nom de l'equipe\n3. Activation";
						
					}	
					
					else if($racourci=="*4646*41#")
					//if(($requete=="*4646*1#")OR($requete=="*42212#"))
	
						{
							if($menu==0)
								{
									$requete_m="UPDATE clientussd SET menu=$requete WHERE TransactionId='$id'";
									$resultat_m=$connexion->query($requete_m);

									if($requete==1)
										{
											$resultat ="Choisir votre District";
											$resultat .="\n1. Lukunga \n2. Mont Amba\n3. Funa \n4. Tshangu \n---\n0. Precedent";
										}
									else if ($requete==2)
										{
											$resultat ="Choisir votre Montant";
											$resultat .="\n1. 1 USD\n2. 5 USD\n3. 10 USD\n4. 50 USD \n5. 100 USD \n---\n0. Precedent";
										}
									else if ($requete==3)
										{
											$resultat ="Info Vitaup";
											$resultat .="\n1. News Info\n2. Classement \n3. Matchs\n4. Buteurs \n---\n0. Precedent";
										}
								}
							else
								{
									if($sousmenu1==0)
										{
											$requete_m="UPDATE clientussd SET sousmenu1=$requete WHERE TransactionId='$id'";
											$resultat_m=$connexion->query($requete_m);

											
											if($menu==1)
												{
													$resultat ="Choisir votre Commune";
													$resultat .="\n1. Ngaliema \n2. Barumbu\n3. Kinshasa\n4. Lingwala \n5. Kitambo \n6. Lingwala \n---\n0. Precedent";

												}
											else if ($menu==2)
												{
													require("recuperertokenvita.php");
													//require_once("soapbillingmpesa.php");
				
													$cmd="php -f /var/www/html/commandevita.php $id $telephone Salut &";
				
													exec($cmd ."> /dev/null &");
				
													//sleep(5);
				
													$resultat ="veuillez patienter pour inserer le code PIN";
													$action="end";	
			
				
													$resultat ="veuillez patienter pour inserer le code PIN";
													$action="end";	
			
												}
												
										}
									else
										{
											
											if($sousmenu2==0)
												{
													$requete_m="UPDATE clientussd SET sousmenu2=1 WHERE TransactionId='$id'";
													$resultat_m=$connexion->query($requete_m);
													$resultat ="Saisissez votre nom complet";
												}
											else
												{
													$requete_m="INSERT INTO membreVita(telephone, noms)VALUES('$telephone','$requete')";
													$resultat_m=$connexion->query($requete_m);
													$resultat ="Felicitation, vous etes bien enregistre";
													$action="End";	
												}
											
										}
								}
	
							
							
						}	
			}

	
}
}
			

	require_once("mt/$sorti");
?>


<?php

//Debut

	//1)Récupérer la commande 
	require_once("1.recuperer_commande.php");

	//2)Vérifier si la commande vient d’USSD
	require_once("2.verifier_si_commande_ussd.php");

	//3)Récupérer l’identifiant du client si la commande vient d’USSD
	require_once("3.recuperer_identifiant_client.php");

	//4)Enregistrer la commande
	require_once("4.enregistrer_commande.php");

	//5)Vérifier si la commande est enregistrée
	require_once("5.verifier_si_commande_enregistre.php");

	//6)Récupérer les détails de service (si la commande est enregistrée)
	require_once("6.recuperer_service.php");

	//7)Envoyer message d’erreur sur enregistrement  de la commande
	require_once("7.envoyer_erreur_commande.php");

	//8)Vérifier si le service est bien récupéré
	require_once("8.verifier_si_service_recupere.php");

	//9)Récupérer les détails du produit (si le service est récupéré)
	require_once("9.recuperer_produit.php");

	//10)Envoyer message d’erreur sur la récupération de service
	require_once("10.envoyer_erreur_service.php");

	//11)Vérifier si le produit est bien récupéré
	require_once("11.verifier_si_produit_recupere.php");

	//12)Envoyer message d’erreur sur la récupération du produit
	require_once("12.envoyer_details_commande.php");

	//13)Envoyer les détails de la commande (si le produit est récupéré)
	require_once("13.envoyer_erreur_produit.php");


//Fin
?>

 


