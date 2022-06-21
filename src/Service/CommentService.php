<?php
/**
 * Comment service.
 */

namespace App\Service;

use App\Entity\Comment;
use App\Entity\Movie;
use App\Repository\CommentRepository;
use App\Repository\MovieRepository;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Knp\Component\Pager\PaginatorInterface;

/**
 * Class CategoryService.
 */
class CommentService implements CommentServiceInterface
{
    /**
     * Comment repository.
     */
    private CommentRepository $commentRepository;

    /**
     * Paginator.
     */
    private PaginatorInterface $paginator;


    /**
     * Constructor.
     *
     * @param CommentRepository $commentRepository Comment repository
     * @param PaginatorInterface $paginator Paginator
     */
    public function __construct(CommentRepository $commentRepository, PaginatorInterface $paginator)
    {
        $this->commentRepository = $commentRepository;
        $this->paginator = $paginator;
    }

    /**
     * Save entity.
     *
     * @param Comment $comment Comment entity
     */
    public function save(Comment $comment): void
    {
        $this->commentRepository->save($comment);
    }

    /**
     * Delete entity.
     *
     * @param Comment $comment Comment entity
     */
    public function delete(Comment $comment): void
    {
        $this->commentRepository->delete($comment);
    }

    /**
     * Get paginated list.
     *
     * @param int $page Page number
     *
     * @return PaginationInterface<string, mixed> Paginated list
     */
    public function getPaginatedList(int $page): PaginationInterface
    {
        return $this->paginator->paginate(
            $this->commentRepository->queryAll(),
            $page,
            CommentRepository::PAGINATOR_ITEMS_PER_PAGE
        );
    }
}
