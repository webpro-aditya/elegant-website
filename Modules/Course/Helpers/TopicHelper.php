<?php

namespace Modules\Course\Helpers;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Modules\Course\Entities\Topic;

class TopicHelper
{
    public function searchTopic($keyword)
    {
        $topics = Topic::where('title', 'like', "%{$keyword}%");

        return $topics->paginate(30, ['*'], 'page', request()->get('page'));
    }

    public function save(array $input)
    {
        if ($topic = Topic::create($input)) {
            return $topic;
        }

        return false;
    }

    public function getTopicDatatable($data)
    {
        $topics = Topic::select(app(Topic::class)->getTable() . '.*')->with('category');

        if (isset($data['category_id'])) {
            $topics->where('category_id', $data['category_id']);
        }

        return $topics->latest();
    }

    public function delete($topicId)
    {
        try {
            $topic = Topic::findOrFail($topicId);
            $topic->delete();

            return true;
        } catch (ModelNotFoundException $e) {
            return false;
        }
    }

    public function getTopic($id)
    {
        return Topic::find($id);
    }

    public function update($data)
    {
        $topic = Topic::find($data['id']);

        if ($topic->update($data)) {
            return $topic;
        }

        return false;
    }

    public function getAllTopic()
    {
        return Topic::All();
    }
}
