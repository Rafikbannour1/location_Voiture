<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Voiture;
use App\Entity\Location;
use App\Form\VoitureType;
use App\Form\LocationType;
use App\Entity\PropertySearch;
use App\Form\PropertySearchType;
use App\Repository\VoitureRepository;
use App\Repository\LocationRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints\DateTime;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;



class VoitureController extends AbstractController
{
    /**
     * @IsGranted("ROLE_USER")
     * @Route("/voiture", name="voiture_index",methods={"GET"})
     */
    public function index(VoitureRepository $voitureRepository ,Request $request):Response
    {
        $user=$this->getUser(); 
        $roles=$user->getRoles(); 
    if(in_array("ROLE_EDITOR",$roles)  || in_array("ROLE_ADMIN",$roles)) 
        return $this->render('voiture/index.html.twig', [
            'voitures' => $voitureRepository->findAll(),
        ]);
        else 

        {
    if(isset ($_GET['search']) && isset($_GET['search_value']))  {

        if($_GET['search_value']!="")
        {
        return $this->render('voiture/index_user.html.twig', [
            'voitures' => $voitureRepository->findByMarque($_GET['search_value']),
     
        ]);  
                }
        
                else  
                {
        return $this->render('voiture/index_user.html.twig', [
            'voitures' => $voitureRepository->findAll(),]);  
        }
                
      
    }
    else
    {
        return $this->render('voiture/index_user.html.twig', [
            'voitures' => $voitureRepository->findAll(),
     
        ]);  
                
    }
  
}
    }

    /**
     * @IsGranted("ROLE_EDITOR")
     * @Route("/voiture/new", name="voiture_new", methods={"GET", "POST"})
     */
    public function new(Request $request)
    {
      
   $voiture = new voiture();
   
   $form = $this->createFormBuilder($voiture)
   ->add('matricule')
   ->add('code_voiture') 
   ->add('marque') 
   ->add('modele')
   ->add('nb_places')
   ->add('couleur') 
   ->add('prix') 
    
   
       ->add('etat', ChoiceType::class    , ['choices'  => [
           'Disponible'=> 'Disponible' ,
           'Non disponible' => 'Non disponible' 
       ]],) 
   ->add('image', FileType::class, array('label'=>'Upload Image'))
   ->getForm(); // get form : pour que le resultat sera mis dans $form
  // creer une formulaire

  $form->handleRequest($request); //pour remplir l'object article depuis la formulaire $form 
  
   if($form->isSubmitted() && $form->isValid()) 
   {
   $voiture = $form->getData();
   
   $file = $voiture->getImage() ; 

   $upload_directory = $this->getParameter('uploads_directory') ;
       
   $Filename = md5(uniqid()).'.'.$file->guessExtension();

   $file->move($upload_directory,$Filename) ; 
   
   $entityManager = $this->getDoctrine()->getManager();
   
   $voiture->setImage($Filename) ; 

   $entityManager->persist($voiture);
   
   $entityManager->flush();
   
   return $this->redirectToRoute('voiture_index');
   }
   return $this->render('Voiture/new.html.twig',['form' => $form->createView()]);
   

   
    }


    /**
     * @Route("/show/{id}", name="voiture_show",methods={"GET", "POST"})
     */
    public function show(Voiture $voiture,Request $request, EntityManagerInterface $entityManager,LocationRepository $location_repository): Response
    {
        $user=$this->getUser();
        $roles=$user->getRoles(); 
    if(in_array("ROLE_ADMIN",$roles)|| in_array("ROLE_EDITOR",$roles))
        return $this->render('voiture/show.html.twig', [
            'voiture' => $voiture,
        ]);  
       
        else 
        
        
        $location = new Location();
       
        $form = $this->createForm(LocationType::class, $location);
       
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            
         $locations = $location_repository->findAll();   
        
            
         $test = false ; 
        
         foreach($locations as $loc)
        {
                $moyen_date_existant = $loc->getDateFin()->diff($loc->getDateDebut())  ; 
                $moyen_date_ajouter = $location->getDateFin()->diff($location->getDateDebut()); 
            
              //$moyen_date_existant_nouveau =   \DateTime::createFromFormat('Y-m-d');  
              //$moyen_date_ajouter_nouveau =   \DateTime::createFromFormat('Y-m-d');  
               
              $newDate_date_existant_fin = $loc->getDateFin()->format('m-d-Y');  
              $newDate_date_existant_debut = $loc->getDateDebut()->format('m-d-Y');
               
              $newDate_date_ajouter_fin = $location->getDateFin()->format('m-d-Y'); 
              $newDate_date_ajouter_debut = $location->getDateDebut()->format('m-d-Y');
             
             
              if (($loc->getCodeVoiture()  == $location->getCodeVoiture())) 
               
            {
               
                   
                if(!(($newDate_date_existant_fin<$newDate_date_ajouter_debut)||($newDate_date_ajouter_fin<$newDate_date_existant_debut)))
                        {
                            $test = true ;  
                        }

                
                        
           
            }
   
    }  

    if ($test == true)
    {
        echo '<script> alert("Voiture non disponible ou code existant") </script>' ;  
    }
    
    else if($test == false)
    {
        $entityManager->persist($location);
        $entityManager->flush();

        return $this->redirectToRoute('voiture_index', [], Response::HTTP_SEE_OTHER);   
    }

        
    
        }



        return $this->render('voiture/show_user.html.twig', [
            'voiture' => $voiture,
            'location' => $location,
            'form' => $form->createView(),
            
        ]); 

    }

    /**
     *  @IsGranted("ROLE_EDITOR")
     * @Route("/{id}", name="voiture_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Voiture $voiture, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(VoitureType::class, $voiture);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('voiture_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('voiture/edit.html.twig', [
            'voiture' => $voiture,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @IsGranted("ROLE_EDITOR")
     * @Route("/{id}/delete", name="voiture_delete")
     *  @Method({"DELETE"})
     */
    public function delete(Request $request, $id): Response
    {
        
    $voiture = $this->getDoctrine()->getRepository(voiture::class)->find($id);
   
    $entityManager = $this->getDoctrine()->getManager();
    
    $entityManager->remove($voiture);
    
    $entityManager->flush();
    
    $response = new Response();
   
    $response->send();
    
    return $this->redirectToRoute('voiture_index');
    }














}
