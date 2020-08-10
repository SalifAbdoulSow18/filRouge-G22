<?php

namespace App\Security\Voter;

use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\User\UserInterface;

class GrpeCompetenceVoter extends Voter
{
    protected function supports($attribute, $subject)
    { 
        return in_array($attribute, ['VIEW'])
            && $subject instanceof \App\Entity\GpeCompetence;
    }

    protected function voteOnAttribute($attribute, $cpt, TokenInterface $token)
    {
        $user = $token->getUser(); 

        // if the user is anonymous, do not grant access
        if (!$user instanceof UserInterface) {
            return false;
        }
        
        // ... (check conditions and return true to grant permission) ...
        switch ($attribute) {
            case 'VIEW': 
                return $user -> getRoles()[0] === "ROLE_ADMIN" ;   
                break;
           
        }

        return false;
    }
}
