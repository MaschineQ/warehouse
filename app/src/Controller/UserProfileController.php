<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\UserProfile;
use App\Form\UserProfileType;
use App\Repository\UserProfileRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserProfileController extends AbstractController
{
    #[Route('/profile', name: 'app_profile')]
    public function index(Request $request, UserProfileRepository $profiles, UserRepository $users): Response
    {
        /** @var User $user */
        $user = $this->getUser();
        $userProfile = $user->getUserProfile() ?? new UserProfile();

        $form = $this->createForm(UserProfileType::class, $userProfile);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var UserProfile $userProfile */
            $userProfile = $form->getData();
            $user->setUserProfile($userProfile);

            $users->save($user, true);

            $this->addFlash('success', 'Your user profile settings were saved');

            return $this->redirectToRoute('app_profile');
        }

        return $this->render(
            'profile/index.html.twig',
            [
                'form' => $form->createView()
            ]
        );
    }
}
