<?php
/**
 * Movie controller.
 */

namespace App\Controller;

use App\Entity\Movie;
use App\Repository\MovieRepository;
use App\Service\MovieServiceInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;

/**
 * Class MovieController.
 */
#[Route('/movie')]
class MovieController extends AbstractController
{
    /**
     * Movie service.
     */
    private MovieServiceInterface $movieService;

    /**
     * Translator.
     *
     * @var TranslatorInterface
     */
    private TranslatorInterface $translator;

    /**
     * Constructor.
     */
    public function __construct(MovieServiceInterface $movieService)
    {
        $this->movieService = $movieService;
    }

    /**
     * Index action.
     *
     * @param Request            $request         HTTP Request
     *
     * @return Response HTTP response
     */
    #[Route(name: 'movie_index', methods: 'GET')]
    public function index(Request $request): Response
    {
        $pagination = $this->movieService->getPaginatedList(
            $request->query->getInt('page', 1)
        );

        return $this->render('movie/index.html.twig', [
           'pagination' => $pagination
        ]);
    }

    /**
     * Show action.
     *
     * @param Movie $movie Movie entity
     *
     * @return Response HTTP response
     */
    #[Route(
        '/{id}',
        name: 'movie_show',
        requirements: ['id' => '[1-9]\d*'],
        methods: 'GET',
    )]
    public function show(Movie $movie): Response
    {
        return $this->render(
            'movie/show.html.twig',
            ['movie' => $movie]
        );
    }
}
