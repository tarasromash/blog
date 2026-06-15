<?php

namespace App\Repositories;

use App\Models\BlogPost as Model;

class BlogPostRepository extends CoreRepository
{
    protected function getModelClass()
    {
        return Model::class;
    }

    public function getAllWithPaginate()
    {
        $columns = [
            'id',
            'title',
            'slug',
            'is_published',
            'published_at',
            'user_id',
            'category_id',
        ];

        $result = $this
            ->startConditions()
            ->select($columns)
            ->orderBy('id', 'DESC')
            ->with([
                'category' => function ($query) {
                    $query->select(['id', 'title']);
                },
                'user:id,name',
            ])
            ->paginate(25);

        return $result;
    }

    public function getEdit($id)
    {
        return $this->startConditions()->find($id);
    }

    public function getShow($id)
    {
        $columns = [
            'id',
            'title',
            'slug',
            'excerpt',
            'content_raw',
            'content_html',
            'is_published',
            'published_at',
            'user_id',
            'category_id',
        ];

        $result = $this
            ->startConditions()
            ->select($columns)
            ->with([
                'category:id,title',
                'user:id,name',
            ])
            ->find($id);

        return $result;
    }
}
