<?php

namespace App\Traits;

use App\Models\Content;
trait SaveContentData
{
    public function saveContent(array $data, Content $content = null): Content
    {
        if ($content) {
            $content->update([
                'title' => $data['title'],
                'body'  => $data['content'],
            ]);
        } else {
            $content = Content::create([
                'title' => $data['title'],
                'body'  => $data['content'],
            ]);
        }
        $content->users()->sync($data['users']);
        return $content;
    }
}
