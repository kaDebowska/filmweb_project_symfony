<?php
/**
 * Movie service interface.
 */

namespace App\Service;

use App\Entity\Movie;
use Knp\Component\Pager\Pagination\PaginationInterface;

/**
 * Interface MovieServiceInterface.
 */
interface MovieServiceInterface
{
    /**
     * Get paginated list.
     *
     * @param int $page Page number
     *
     * @return PaginationInterface<string, mixed> Paginated list
     */
    public function getPaginatedList(int $page): PaginationInterface;


    /**
     * Save entity.
     *
     * @param Movie $movie Task entity
     */
    public function save(Movie $movie): void;

    /**
     * Delete entity.
     *
     * @param Movie $movie Task entity
     */
    public function delete(Movie $movie): void;
}
