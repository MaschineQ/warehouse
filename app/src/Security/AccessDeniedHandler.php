<?php

namespace App\Security;

use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\Security\Http\Authorization\AccessDeniedHandlerInterface;

class AccessDeniedHandler implements AccessDeniedHandlerInterface
{
    public function handle(Request $request, AccessDeniedException $accessDeniedException): ?Response
    {
        $request->getSession()->getFlashBag()->add('error', 'You do not have permission for this page.');

        $route = $request->headers->get('referer');

        if (null !== $route) {
            return new RedirectResponse($route);
        }

        return new RedirectResponse('/');
    }
}
