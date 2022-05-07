<?php

namespace App\Repositories\Category;

use App\Models\Category;
use App\Repositories\BaseRepository;
use App\Repositories\Category\CategoryRepositoryInterface;

class CategoryRepository extends BaseRepository implements CategoryRepositoryInterface
{
    public function getModel()
    {
        return Category::class;
    }

    public function getCategoryWhereNull()
    {
        return $this->model->whereNull('parent_id')->with('childCategories.childCategories')->get();
    }

    public function getCategoryWithParent()
    {
        return $this->model->with('parentCategory.parentCategory')
            ->whereHas('parentCategory.parentCategory')
            ->get();
    }

    public function getCategoryWhereNullWithChild()
    {
        return $this->model->whereNull('parent_id')->with('childCategories')->get();
    }
}
