<?php

namespace App\Repositories\Gender;

use App\Models\Gender;
use App\Repositories\BaseRepository;
use Illuminate\Support\Facades\File;
use App\Repositories\Gender\GenderRepositoryInterface;

class GenderRepository extends BaseRepository implements GenderRepositoryInterface
{
    public function getModel()
    {
        return Gender::class;
    }
}
