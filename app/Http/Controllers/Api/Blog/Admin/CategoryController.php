<?php

namespace App\Http\Controllers\Api\Blog\Admin;

use App\Http\Requests\BlogCategoryCreateRequest;
use App\Http\Requests\BlogCategoryUpdateRequest;
use App\Http\Resources\Api\Blog\Admin\CategoryResource;
use App\Models\BlogCategory;
use App\Repositories\BlogCategoryRepository;

class CategoryController extends BaseController
{
    public function __construct(private BlogCategoryRepository $blogCategoryRepository)
    {
        // parent::__construct();
    }

    public function index()
    {
        $paginator = $this->blogCategoryRepository->getAllWithPaginate(25);

        return CategoryResource::collection($paginator);
    }

    public function show(string $id)
    {
        $item = $this->blogCategoryRepository->getEdit($id);

        if (empty($item)) {
            return response()->json([
                'success' => false,
                'message' => "Запис id=[{$id}] не знайдено",
            ], 404);
        }

        return new CategoryResource($item);
    }

    public function store(BlogCategoryCreateRequest $request)
    {
        $data = $request->input();

        $item = BlogCategory::create($data);

        if ($item) {
            return [
                'success' => true,
                'message' => 'Успішно збережено',
                'data' => new CategoryResource($item),
            ];
        }

        return [
            'success' => false,
            'message' => 'Помилка збереження',
        ];
    }

    public function update(BlogCategoryUpdateRequest $request, $id)
    {
        $item = $this->blogCategoryRepository->getEdit($id);

        if (empty($item)) {
            return [
                'success' => false,
                'message' => "Запис id=[{$id}] не знайдено",
            ];
        }

        $data = $request->input();

        $result = $item->update($data);

        if ($result) {
            return [
                'success' => true,
                'message' => 'Успішно збережено',
                'data' => new CategoryResource($item),
            ];
        }

        return [
            'success' => false,
            'message' => 'Помилка збереження',
        ];
    }

    public function destroy(string $id)
    {
        $result = BlogCategory::destroy($id);

        if ($result) {
            return [
                'success' => true,
                'message' => 'Успішно видалено',
            ];
        }

        return [
            'success' => false,
            'message' => 'Помилка видалення',
        ];
    }
}
