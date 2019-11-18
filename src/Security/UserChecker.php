<?php


namespace App\Security;



use App\Entity\User;

use App\Exception\AccountInvalidException;
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
            throw new AccountInvalidException();
        }
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