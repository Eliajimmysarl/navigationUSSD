<?php

	if(($reponseNavigation=='NON') AND ($reponseNavigationNiveau1=='OUI'))
		     
		//Modele de service 1 (EJ Trans)
		if($menu=="*4646*8#")
			{
							
				require_once("modele_service1/service_niveau1.php"); 

			}
		//Modele de service 2 (Ex : EJ Foot)
		else   if($menu=="*4646*15#")
			{
				require_once("modele_service2/service_niveau1.php"); 
			}

				
		}


	