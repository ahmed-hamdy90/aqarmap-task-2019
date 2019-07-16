<?php

namespace App\Twig;

use App\Entity\User;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

/**
 * CurrentLoginUserIsAdminExtension Class represent custom Twig extension(filter extension)
 * which responsible for determine if current login user was admin(user has admin role) or not
 * under aqarmap task application.
 * @package App\Twig
 * @author Ahmed Hamdy <ahmedhamdy20@gmail.com>
 */
class CurrentLoginUserIsAdminExtension extends AbstractExtension
{
    /**
     * {@inheritdoc}
     */
    public function getFilters()
    {
        return [
            new TwigFilter('isUserAdmin', [$this, 'isCurrentLoginUserWithAdminRole'])
        ];
    }

    /**
     * Determine whether given current login user instance if he has admin role or not
     * @param User $currentUser current login user instance
     * @return bool true if given current user was admin user otherwise false
     */
    public function isCurrentLoginUserWithAdminRole(User $currentUser) : bool
    {
        return ($currentUser->getRole() === User::ADMIN_ROLE);
    }
}
