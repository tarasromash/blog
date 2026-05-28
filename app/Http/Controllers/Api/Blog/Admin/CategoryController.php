<?php

namespace App\Http\Controllers\Api\Blog\Admin;

// use App\Http\Controllers\Controller;
use App\Models\BlogCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoryController extends BaseController
{
    /**
     * Список категорій з пагінацією.
     */
    public function index()
    {
        // dd(__METHOD__);

        $paginator = BlogCategory::paginate(5);

        return $paginator;
    }

    /**
     * Створення нової категорії.
     */
    public function store(Request $request)
    {
        // dd(__METHOD__);

        $data = $request->all();

        if (empty($data['title'])) {
            return [
                'success' => false,
                'message' => 'Поле title є обовʼязковим',
            ];
        }

        if (empty($data['slug'])) {
            $data['slug'] = Str::slug($data['title']);
        }

        $item = BlogCategory::create($data);

        if ($item) {
            return [
                'success' => true,
                'message' => 'Категорію успішно створено',
                'data' => $item,
            ];
        }

        return [
            'success' => false,
            'message' => 'Помилка створення категорії',
        ];
    }

    /**
     * Оновлення категорії.
     */
    public function update(Request $request, $id)
    {
        // dd(__METHOD__);

        $item = BlogCategory::find($id);

        if (empty($item)) {
            return [
                'success' => false,
                'message' => "Запис id=[{$id}] не знайдено",
            ];
        }

        $data = $request->all();

        if (empty($data['slug']) && !empty($data['title'])) {
            $data['slug'] = Str::slug($data['title']);
        }

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
