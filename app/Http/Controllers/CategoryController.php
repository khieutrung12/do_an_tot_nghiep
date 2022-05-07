<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Contracts\Cache\Store;
use Illuminate\Support\Facades\Session;
use App\Http\Requests\Category\StoreRequest;
use App\Http\Requests\Category\UpdateRequest;
use App\Repositories\Category\CategoryRepositoryInterface;

class CategoryController extends Controller
{
    protected $categoryRepo;

    public function __construct(
        CategoryRepositoryInterface $categoryRepo
    ) {
        $this->categoryRepo = $categoryRepo;
    }

    public function index()
    {
        $allCategory = $this->categoryRepo->getCategoryWhereNull();

        return view('admin.category.all_category')->with(compact('allCategory'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = $this->categoryRepo->getCategoryWhereNullWithChild();

        return view('admin.category.add_category')->with(compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRequest $request)
    {
        $category = $request->all();
        $slug = createSlug($request->name);
        $category['slug'] = $slug;
        $this->categoryRepo->create($category);

        return redirect()->route('categories.create')
            ->with('mess', __('messages.add-success', ['name' => __('titles.category')]));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $productCategory =   $this->categoryRepo->find($id);
        if (!$productCategory) {
            abort(Response::HTTP_NOT_FOUND);
        }

        $categories = $this->categoryRepo->getCategoryWhereNullWithChild();

        return view('admin.category.edit_category')->with(compact('productCategory', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRequest $request, $id)
    {
        $category = $request->all();
        $slug = createSlug($request->name);
        $category['slug'] = $slug;
        $result = $this->categoryRepo->update($id, $category);
        if (!$result) {
            abort(Response::HTTP_NOT_FOUND);
        }

        return redirect()->route('categories.index')
            ->with('mess', __('messages.update-success', ['name' => __('titles.category')]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $result = $this->categoryRepo->delete($id);
        if (!$result) {
            abort(Response::HTTP_NOT_FOUND);
        }

        return redirect()->route('categories.index')
            ->with('mess', __('messages.delete-success', ['name' => __('titles.category')]));
    }
}
