<?php
/**
 * Categories data transformer.
 */

namespace App\Form\DataTransformer;

use App\Entity\Category;
use App\Service\CategoryServiceInterface;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Form\DataTransformerInterface;

/**
 * Class CategoriesDataTransformer.
 *
 * @implements DataTransformerInterface<mixed, mixed>
 */
class CategoriesDataTransformer implements DataTransformerInterface
{
    /**
     * Category service.
     */
    private CategoryServiceInterface $categoryService;

    /**
     * Constructor.
     *
     * @param CategoryServiceInterface $categoryService Category service
     */
    public function __construct(CategoryServiceInterface $categoryService)
    {
        $this->categoryService = $categoryService;
    }

    /**
     * Transform array of categories to string of category titles.
     *
     * @param Collection<int, Category> $value Categoriees entity collection
     *
     * @return string Result
     */
    public function transform($value): string
    {
        if ($value->isEmpty()) {
            return '';
        }

        $categoryTitles = [];

        foreach ($value as $category) {
            $categoryTitles[] = $category->getTitle();
        }

        return implode(', ', $categoryTitles);
    }

    /**
     * Transform string of category names into array of Category entities.
     *
     * @param string $value String of caategory names
     *
     * @return array<int, Category> Result
     */
    public function reverseTransform($value): array
    {
        $categoryTitles = explode(',', $value);

        $categories = [];

        foreach ($categoryTitles as $categoryTitle) {
            if ('' !== trim($categoryTitle)) {
                $category = $this->categoryService->findOneByTitle(strtolower($categoryTitle));
                if (null == $category) {
                    $category = new Category();
                    $category->setTitle($categoryTitle);

                    $this->categoryService->save($category);
                }
                $categories[] = $category;
            }
        }

        return $categories;
    }
}
