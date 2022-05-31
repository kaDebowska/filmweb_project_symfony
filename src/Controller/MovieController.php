<?php
/**
 * Movie controller.
 */

namespace App\Controller;

use App\Entity\Movie;
use App\Repository\MovieRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class MovieController.
 */
#[Route('/movie')]
class MovieController extends AbstractController
{
    /**
     * Index action.
     *
     * @param MovieRepository $movieRepository Movie repository
     *
     * @return Response HTTP response
     */
    #[Route(
        name: 'movie_index',
        methods: 'GET'
    )]
    /**
     * Index action.
     *
     * @param Request            $request         HTTP Request
     * @param MovieRepository    $movieRepository Movie repository
     * @param PaginatorInterface $paginator       Paginator
     *
     * @return Response HTTP response
     */
    #[Route(name: 'movie_index', methods: 'GET')]
    public function index(Request $request, MovieRepository $movieRepository, PaginatorInterface $paginator): Response
    {
        $pagination = $paginator->paginate(
            $movieRepository->queryAll(),
            $request->query->getInt('page', 1),
            MovieRepository::PAGINATOR_ITEMS_PER_PAGE
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
