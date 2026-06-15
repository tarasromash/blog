<?php

namespace App\Http\Controllers\Api\Blog\Admin;

use App\Http\Requests\BlogPostCreateRequest;
use App\Http\Requests\BlogPostUpdateRequest;
use App\Jobs\BlogPostAfterCreateJob;
use App\Jobs\BlogPostAfterDeleteJob;
use App\Models\BlogPost;
use App\Repositories\BlogCategoryRepository;
use App\Repositories\BlogPostRepository;

class PostController extends BaseController
{
    public function __construct(
        private BlogPostRepository $blogPostRepository,
        private BlogCategoryRepository $blogCategoryRepository
    ) {
        // parent::__construct();
    }

    public function index()
    {
        $paginator = $this->blogPostRepository->getAllWithPaginate();

        return $paginator;
    }

    public function show(string $id)
    {
        $item = $this->blogPostRepository->getShow($id);

        if (empty($item)) {
            return response()->json([
                'success' => false,
                'message' => "Запис id=[{$id}] не знайдено",
            ], 404);
        }

        return [
            'success' => true,
            'data' => $item,
        ];
    }

    public function store(BlogPostCreateRequest $request)
    {
        $data = $request->input();

        $item = (new BlogPost())->create($data);

        if ($item) {
            BlogPostAfterCreateJob::dispatch($item);

            return [
                'success' => 'Успішно збережено',
            ];
        }

        return [
            'msg' => 'Помилка збереження',
        ];
    }

    public function update(BlogPostUpdateRequest $request, string $id)
    {
        $item = $this->blogPostRepository->getEdit($id);

        if (empty($item)) {
            return [
                'message' => "Запис id=[{$id}] не знайдено",
            ];
        }

        $data = $request->all();

        $result = $item->update($data);

        if ($result) {
            return [
                'success' => true,
                'message' => 'Успішно збережено',
            ];
        }

        return [
            'message' => 'Помилка збереження',
        ];
    }

    public function destroy(string $id)
    {
        $result = BlogPost::destroy($id);

        if ($result) {
            BlogPostAfterDeleteJob::dispatch($id)->delay(20);

            return [];
        }

        return [];
    }
}
