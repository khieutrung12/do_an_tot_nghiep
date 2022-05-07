<?php

namespace App\Repositories\Category;

use App\Repositories\BaseRepositoryInterface;

interface CategoryRepositoryInterface extends BaseRepositoryInterface
{
    public function getCategoryWhereNull();

    public function getCategoryWithParent();

    public function getCategoryWhereNullWithChild();
}
