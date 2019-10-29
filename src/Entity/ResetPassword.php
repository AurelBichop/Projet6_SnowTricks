<?php

namespace App\Entity;


use Symfony\Component\Validator\Constraints as Assert;


class ResetPassword
{
    /**
     * @Assert\Length(min=8, minMessage="Le mot de passe ne peut pas faire moins de 8 caracteres")
     */
    private $newPassword;

    /**
     * @Assert\EqualTo(propertyPath="newPassword", message="Vous avez pas correctement confirmé votre mot de passe")
     */
    private $confirmPassword;



    public function getNewPassword(): ?string
    {
        return $this->newPassword;
    }

    public function setNewPassword(string $newPassword): self
    {
        $this->newPassword = $newPassword;

        return $this;
    }

    public function getConfirmPassword(): ?string
    {
        return $this->confirmPassword;
    }

    public function setConfirmPassword(string $confirmPassword): self
    {
        $this->confirmPassword = $confirmPassword;

        return $this;
    }
}
