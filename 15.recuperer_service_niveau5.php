<?php

	if(($reponseNavigation=='NON') AND ($reponseNavigationNiveau1=='NON') AND ($reponseNavigationNiveau2=='NON') AND ($reponseNavigationNiveau3=='NON') AND ($reponseNavigationNiveau4=='NON') AND ($reponseNavigationNiveau5=='OUI'))
			{
				//Modele de service 1 (EJ Trans)
				if($menu=="*4646*8#")
					{
										
						require_once("modele_service1/service_niveau5.php"); 

					}
				//Modele de service 2 (Ex : EJ Foot)
					else   if($menu=="*4646*15#")
						{
							
							require_once("modele_service2/service_niveau5.php"); 
							
						}
			}
	