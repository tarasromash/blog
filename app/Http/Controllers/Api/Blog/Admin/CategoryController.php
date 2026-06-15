<?php

namespace App\Http\Controllers\Api\Blog\Admin;

use App\Http\Requests\BlogCategoryCreateRequest;
use App\Http\Requests\BlogCategoryUpdateRequest;
use App\Models\BlogCategory;
use App\Repositories\BlogCategoryRepository;
use App\Http\Resources\Api\Blog\Admin\CategoryResource;

class CategoryController extends BaseController
{
    public function __construct(private BlogCategoryRepository $blogCategoryRepository)
    {
        // parent::__construct();
    }

    /**
     * Список категорій з пагінацією.
     */
    public function index()
    {
        $paginator = $this->blogCategoryRepository->getAllWithPaginate(5);

        return CategoryResource::collection($paginator);
    }

    /**
     * Створення нової категорії.
     */
    public function store(BlogCategoryCreateRequest $request)
    {
        $data = $request->input();

        $item = BlogCategory::create($data);

        if ($item) {
            return [
                'success' => true,
                'message' => 'Успішно збережено',
                'data' => $item,
            ];
        }

        return [
            'success' => false,
            'message' => 'Помилка збереження',
        ];
    }

    /**
     * Оновлення категорії.
     */
    public function update(BlogCategoryUpdateRequest $request, $id)
    {
        // $item = BlogCategory::find($id);

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
                'data' => $item,
            ];
        }

        return [
            'success' => false,
            'message' => 'Помилка збереження',
        ];
    }
}
