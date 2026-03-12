<?php

namespace Modules\Course\Helpers;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Modules\Course\Entities\Batch;

class BatchHelper
{
    protected $batch;

    public function __construct(Batch $batch)
    {
        $this->batch = $batch;
    }

    /*
    |--------------------------------------------------------------------------
    | CRUD FUNCTIONS
    |--------------------------------------------------------------------------
    */

    public function save(array $input)
    {
        if ($category = $this->batch->create($input)) {
            return $category;
        }

        return false;
    }

    public function delete($categoryId)
    {
        try {
            $category = $this->batch->findOrFail($categoryId);
            $category->delete();

            return true;
        } catch (ModelNotFoundException $e) {
            return false;
        }
    }

    public function update($data)
    {
        $category = $this->batch->find($data['id']);

        if ($category->update($data)) {
            return $category;
        }

        return false;
    }

    /*
    |--------------------------------------------------------------------------
    | ACCESSORS
    |--------------------------------------------------------------------------
    */

    public function getBatchDatatable($data)
    {
        $batches = $this->batch->select($this->batch->getTable() . '.*');

        if (isset($data['status'])) {
            $batches->where('status', $data['status']);
        }

        if (isset($data['course_id'])) {
            $batches->where('course_id', $data['course_id']);
        }

        return $batches;
    }

    public function getBatch($id)
    {
        return $this->batch->with('course')->find($id);
    }

    public function getAllBatch()
    {
        $categories = $this->batch->get();

        return $categories;
    }

    /*
    |--------------------------------------------------------------------------
    | ADDITIONAL FUNCTIONS
    |--------------------------------------------------------------------------
    */

    public function searchBatch($keyword)
    {
        $categories = $this->batch->where('name', 'like', "%{$keyword}%");

        return $categories->paginate(30, ['*'], 'page', request()->get('page'));
    }
}
