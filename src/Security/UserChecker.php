<?php


namespace App\Security;


use App\Controller\AccountUserController;
use App\Entity\User;


use Symfony\Component\Security\Core\User\UserCheckerInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class UserChecker implements UserCheckerInterface
{

    /**
     * Checks the user account before authentication.
     *
     * @param UserInterface $user
     * @throws \Exception
     */
    public function checkPreAuth(UserInterface $user)
    {
        if (!$user instanceof User) {
            return;
        }
        //Permet de verifier si le compte est validé
        if ($user->getValid() === 0) {
            $this->redirect();
            //throw new \Exception("Le compte n'est pas valide");
        }
    }

    public function redirect(){
        $ad = new AccountUserController();
        return $ad->redirectToRoute('accueil');
    }

    /**
     * Checks the user account after authentication.
     *
     * @param UserInterface $user
     *
     */
    public function checkPostAuth(UserInterface $user)
    {
        if (!$user instanceof User) {
            return;
        }
    }

}