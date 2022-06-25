<?php
/**
 * User controller.
 */

namespace App\Controller;

use App\Entity\User;
use App\Form\Type\ChangePasswordType;
use App\Form\Type\UserType;
use App\Service\UserServiceInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;

/**
 * Class UserController.
 */
#[Route('/settings')]
class UserController extends AbstractController
{
    /**
     * User service.
     */
    private UserServiceInterface $userService;

    /**
     * Translator.
     */
    private TranslatorInterface $translator;

    /**
     * User password hasher.
     */
    private UserPasswordHasherInterface $userPasswordHasher;

    /**
     * Constructor.
     *
     * @param UserServiceInterface        $userService        User service
     * @param TranslatorInterface         $translator         Translator
     * @param UserPasswordHasherInterface $userPasswordHasher User password hasher
     */
    public function __construct(UserServiceInterface $userService, TranslatorInterface $translator, UserPasswordHasherInterface $userPasswordHasher)
    {
        $this->userService = $userService;
        $this->translator = $translator;
        $this->userPasswordHasher = $userPasswordHasher;
    }

    /**
     * User settings action.
     *
     * @return Response HTTP response
     */
    #[Route('', name: 'user_settings', methods: 'GET')]
    public function userSettings(): Response
    {
        $user = $this->getUser();

        return $this->render(
            'user/settings.html.twig',
            ['user' => $user]
        );
    }

    /**
     * Change password action.
     *
     * @param Request $request HTTP request
     * @param User    $user    User entity
     *
     * @return Response HTTP response
     */
    #[Route('/{id}/change-password', name: 'user_change_password', requirements: ['id' => '[1-9]\d*'], methods: 'GET|PUT')]
    #[IsGranted('EDIT', subject: 'user')]
    public function changePassword(Request $request, User $user): Response
    {
        $form = $this->createForm(
            ChangePasswordType::class,
            $user,
            [
                'method' => 'PUT',
                'action' => $this->generateUrl('user_change_password', ['id' => $user->getId()]),
            ]
        );
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user->setPassword(
                $this->userPasswordHasher->hashPassword(
                    $user,
                    $form->get('plainPassword')->getData()
                )
            );
            $this->userService->save($user);

            $this->addFlash(
                'success',
                $this->translator->trans('message.edited_successfully')
            );

            return $this->redirectToRoute('movie_index');
        }

        return $this->render('user/password.html.twig', [
            'form' => $form->createView(),
            'user' => $user,
        ]);
    }

    /**
     * Change password action.
     *
     * @param Request $request HTTP request
     * @param User    $user    User entity
     *
     * @return Response HTTP response
     */
    #[Route('/{id}/change-user-details', name: 'user_change_details', requirements: ['id' => '[1-9]\d*'], methods: 'GET|PUT')]
    #[IsGranted('EDIT', subject: 'user')]
    public function changeUserDetails(Request $request, User $user): Response
    {
        $form = $this->createForm(
            UserType::class,
            $user,
            [
                'method' => 'PUT',
                'action' => $this->generateUrl('user_change_details', ['id' => $user->getId()]),
            ]
        );
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->userService->save($user);

            $this->addFlash(
                'success',
                $this->translator->trans('message.edited_successfully')
            );

            return $this->redirectToRoute('movie_index');
        }

        return $this->render('user/details.html.twig', [
            'form' => $form->createView(),
            'user' => $user,
        ]);
    }
}
