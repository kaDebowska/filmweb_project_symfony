<?php
/**
 * User controller.
 */

namespace App\Controller;

use App\Service\UserServiceInterface;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use App\Entity\User;
use App\Form\Type\UserType;
use Symfony\Contracts\Translation\TranslatorInterface;

/**
 * Class UserController.
 */

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
     * @param UserServiceInterface $userService User service
     * @param TranslatorInterface      $translator  Translator
     */
    public function __construct(UserServiceInterface $userService, TranslatorInterface $translator, UserPasswordHasherInterface $userPasswordHasher)
    {
        $this->userService = $userService;
        $this->translator = $translator;
        $this->userPasswordHasher = $userPasswordHasher;
    }

    /**
     * Change password action.
     *
     * @param Request  $request  HTTP request
     * @param User $user User entity
     *
     * @return Response HTTP response
     */
    #[Route('/settings', name: 'user_settings', methods: 'GET|PUT')]
    public function changePassword(Request $request, User $user): Response
    {
        if (!$this->isGranted('IS_AUTHENTICATED_FULLY')) {
            $this->addFlash(
                'danger',
                $this->translator->trans('message.access_denied')
            );

            return $this->redirectToRoute('movie_index');
        }
        //$user = $this->getUser();
        $form = $this->createForm(UserType::class, $user, [
            'method' => 'PUT',
            'action' => $this->generateUrl('user_settings'),
        ]);
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

            return $this->redirectToRoute('app_login');
        }

        return $this->render('user/settings.html.twig', [
            'form' => $form->createView(),
            'user' => $user,
        ]);

    }
}




