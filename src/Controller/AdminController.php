<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\AddUserType;
use App\Form\EditUserType;
use App\Entity\PropertySearch;
use App\Form\PropertySearchType;
use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\Security\Guard\GuardAuthenticatorHandler;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;



/**
 * @IsGranted("ROLE_ADMIN")
 */
class AdminController extends AbstractController
{
   
/**
 * @Route("/utilisateurs", name="Users",methods={"GET","POST"})
 */
public function usersList(Request $request)
{

   
    // $propertySearch = new PropertySearch();
    // $form = $this->createForm(PropertySearchType::class,$propertySearch);
    // $form->handleRequest($request);
    
    $users=  $this->getDoctrine()->getRepository(User::class)->findAll(); 
    
    
    // if($form->isSubmitted() && $form->isValid())
    //  {
    // //on récupère le nom d'article tapé dans le formulaireAtelier framework Web côté serveur Symfony 4
    
    // $email = $propertySearch->getEmail();
    //     if ($email!="")
    // //si on a fourni un nom d'article on affiche tous les users ayant ce nom
    //     {
    //         $users= $this->getDoctrine()->getRepository(User::class)->findBy(['email' => $email] );
    //     }
    //     else
    //     {
    // //si si aucun nom n'est fourni on affiche tous les articles
    //     $users= $this->getDoctrine()->getRepository(User::class)->findAll();  
    //     }
    // }
    
    return $this->render('admin/users.html.twig',[  'users' => $users]); 
}
// 'form' =>$form->createView(),

/**
 * @Route("/modifier/{id}", name="modifier_utilisateur")
 */
public function editUser(User $user, Request $request)
{
    $form = $this->createForm(EditUserType::class, $user);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($user);
        $entityManager->flush();

        $this->addFlash('message', 'Utilisateur modifié avec succès');
        return $this->redirectToRoute('Users');
    }
    
    return $this->render('admin/Edit_user.html.twig', [
        'userForm' => $form->createView(),
    ]);
}


   /**
     * @Route("/delete/{id}", name="user_delete", methods={"POST"})
     */
    public function delete(Request $request, User $user): Response
    {
        if ($this->isCsrfTokenValid('delete'.$user->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($user);
            $entityManager->flush();
        }

        return $this->redirectToRoute('Users', [], Response::HTTP_SEE_OTHER);
    }


}

