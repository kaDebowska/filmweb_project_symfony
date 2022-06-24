<?php
/**
 * User controller.
 */

namespace App\Controller;

use App\Entity\UserDetail;
use App\Form\Type\ChangePasswordType;
use App\Form\Type\UserDetailsType;
use App\Repository\UserDetailRepository;
use App\Service\UserDetailServiceInterface;
use App\Service\UserServiceInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\User;
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
     * User detail service.
     */
    private UserDetailServiceInterface $userDetailService;

    /**
     * Constructor.
     *
     * @param UserServiceInterface $userService User service
     * @param TranslatorInterface      $translator  Translator
     * @param UserPasswordHasherInterface $userPasswordHasher User password hasher
     */
    public function __construct(
        UserServiceInterface $userService,
        TranslatorInterface $translator,
        UserPasswordHasherInterface $userPasswordHasher,
        UserDetailServiceInterface $userDetailService,
    ) {
        $this->userService = $userService;
        $this->translator = $translator;
        $this->userPasswordHasher = $userPasswordHasher;
        $this->userDetailService = $userDetailService;
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
     * Edit user details action.
     *
     * @param Request  $request  HTTP request
     * @param User $user User entity
     *
     * @return Response HTTP response
     */
    #[Route('/{id}/edit-details', name: 'user_edit_details', requirements: ['id' => '[1-9]\d*'], methods: 'GET|PUT')]
    #[IsGranted('EDIT', subject: 'user')]
    public function editUserDetails(Request $request, User $user): Response
    {
//        $userId = $user->getId();
//        $userDetail = $this->userDetailRepository->findOneBy(['user' => $userId]);
        $userDetail = $this->userDetailService->findOneByUserId($user);
        $form = $this->createForm(UserDetailsType::class, $userDetail, [
            'method' => 'PUT',
            'action' => $this->generateUrl('user_edit_details', ['id' => $userDetail->getId()]),
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->userDetailService->save($userDetail);

            $this->addFlash(
                'success',
                $this->translator->trans('message.edited_successfully')
            );

            return $this->redirectToRoute('movie_index');
        }

        return $this->render(
            'user/details.html.twig',
            [
                'form' => $form->createView(),
                'userDetail' => $userDetail,
            ]
        );
    }

    /**
     * Change password action.
     *
     * @param Request  $request  HTTP request
     * @param User $user User entity
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
}
