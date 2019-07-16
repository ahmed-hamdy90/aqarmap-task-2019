<?php

namespace App\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

/**
 * CurrentLoginUserExtension Class represent custom Twig extension(function extension)
 * which responsible for getting the current login user instance(if was already exists one)
 * under aqarmap task application.
 * for details about custom twig extension:
 *  - @link https://symfony.com/doc/current/templating/twig_extension.html
 *  - @link https://symfonycasts.com/screencast/symfony-doctrine/twig-extension
 * @package App\Twig
 * @author Ahmed Hamdy <ahmedhamdy20@gmail.com>
 */
class CurrentLoginUserExtension extends AbstractExtension
{
    /**
     * {@inheritdoc}
     */
    public function getFunctions()
    {
        return [
            new TwigFunction('currentUser', [CurrentLoginUserRuntime::class, 'getCurrentLoginUser'])
        ];
    }
}
