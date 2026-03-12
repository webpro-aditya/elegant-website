<?php

namespace Modules\Course\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Modules\Course\Helpers\BatchHelper;
use Modules\Course\Http\Requests\Admin\Batch\BatchAddRequest;
use Modules\Course\Http\Requests\Admin\Batch\BatchCreateRequest;
use Modules\Course\Http\Requests\Admin\Batch\BatchDeleteRequest;
use Modules\Course\Http\Requests\Admin\Batch\BatchEditRequest;
use Modules\Course\Http\Requests\Admin\Batch\BatchListDataRequest;
use Modules\Course\Http\Requests\Admin\Batch\BatchListRequest;
use Modules\Course\Http\Requests\Admin\Batch\BatchUpdateRequest;
use Modules\Course\Traits\TabViewHandler;
use Yajra\DataTables\DataTables;
use Modules\Course\Helpers\CourseHelper;

class BatchController extends Controller
{
    use TabViewHandler;

    protected $batchHelper;
    protected $courseHelper;

    public function __construct(CourseHelper $courseHelper, BatchHelper $batchHelper)
    {
        $this->batchHelper = $batchHelper;
        $this->courseHelper = $courseHelper;
    }

    public function listBatch(Request $request)
    {
        $breadcrumbs = [
            ['link' => 'dashboard_home', 'name' => 'Dashboard'],
            ['name' => 'Batch'],
        ];

        return view('course::admin.batch.listBatch', compact('breadcrumbs'));
    }

    public function batchListData(Request $request)
    {
        $categories = $this->batchHelper->getBatchDatatable($request->all());
        $dataTableJSON = DataTables::of($categories)
            ->addIndexColumn()
            ->editColumn('duration', function ($batch) {
                $data['url'] = route('batch_edit', ['id' => $batch->id]);
                $data['text'] = $batch->duration . ' Hours';

                return view('elements.listLink', compact('data'));
            })

            ->addColumn('status', function ($batch) {
                return view('elements.listStatus')->with('data', $batch);
            })

            ->addColumn('action', function ($batch) use ($request) {
                $data['edit_url'] = route('batch_edit', ['id' => $batch->id]);
                $data['delete_url'] = route('batch_delete', ['id' => $batch->id]);
                // $data['view_url'] = route('batch_view', ['id' => $batch->id]);

                return view('elements.listAction', compact('data'));
            })
            ->make();

        return $dataTableJSON;
    }

    public function viewBatch(Request $request)
    {
        $breadcrumbs = [
            ['link' => 'dashboard_home', 'name' => 'Dashboard'],
            ['link' => 'batch_list', 'name' => 'Batch', 'permission' => 'batch_read'],
            ['name' => 'View Batch'],
        ];
        $batch = $this->batchHelper->getBatch($request->id);

        return view('course::admin.batch.viewBatch', compact('batch', 'breadcrumbs'));
    }

    public function addBatch(BatchAddRequest $request)
    {
        $breadcrumbs = [
            ['link' => 'dashboard_home', 'name' => 'Dashboard'],
            ['link' => 'batch_list', 'name' => 'Batch', 'permission' => 'batch_read'],
            ['name' => 'Add Batch'],
        ];

        return view('course::admin.batch.addBatch', compact('breadcrumbs'));
    }

    public function createBatch(Request $request)
    {
        try {
            $inputData = [
                // 'name' => $request->name ?? 'null',
                'name' => $request->name,
                'course_id' => $request->course_id,
                'duration' => $request->duration,
                'start_time' => $request->start_time . ' ' . $request->start_period,
                'end_time' => $request->end_time . ' ' . $request->end_period
            ];
            $this->batchHelper->save($inputData);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }

        return redirect()
            ->route('batch_list')
            ->with('success', 'batch added successfully');
    }

    public function editBatch(Request $request)
    {
        $breadcrumbs = [
            ['link' => 'dashboard_home', 'name' => 'Dashboard'],
            ['link' => 'batch_list', 'name' => 'Batch', 'permission' => 'batch_read'],
            ['name' => 'Edit Batch'],
        ];
        $old = [];


        $return = '';
        if ($request->return && isset($request->return)) {
            $return = $request->return;
        }
        $batch = $this->batchHelper->getBatch($request->id);

        $startTime = explode(' ', $batch->start_time);
        $batch->start_time = $startTime[0];
        $batch->start_period = $startTime[1];

        $endTime = explode(' ', $batch->end_time);
        $batch->end_time = $endTime[0];
        $batch->end_period = $endTime[1];


        if (old('course_id', $batch->course_id)) {
            $old['course_id'] = $this->courseHelper->getCourseAndTitle($batch->course_id);
        }
        return view('course::admin.batch.editBatch', compact('breadcrumbs', 'old', 'batch', 'return'));
    }

    public function updateBatch(Request $request)
    {
        $inputData = [
            'id' => $request->id,
            'name' => $request->name ?? 'null',
            'course_id' => $request->course_id,
            'duration' => $request->duration,
            'start_time' => $request->start_time . ' ' . $request->start_period,
            'end_time' => $request->end_time . ' ' . $request->end_period
        ];

        if ($request->hasFile('image')) {
            $filePath = 'batch/image';
            $fileName = Storage::disk('elegant')->putFile($filePath, $request->file('image'));
            $inputData['image'] = $fileName;
        } elseif ($request->image_remove == 1) {
            $inputData['image'] = '';
        }

        $batch = $this->batchHelper->update($inputData);

        activity()->performedOn($batch)->event('Batch Updated')->withProperties(['id' => $batch->id, 'data' => $inputData])->log('Batch Created');

        if (isset($request->return) && $request->return == 'yes') {
            return redirect()
                ->route('course_view', ['id' => $request->course_id])
                ->with('success', 'Batch updated successfully');
        } else {
            return redirect()
                ->route('batch_list')
                ->with('success', 'Batch updated successfully');
        }
    }

    public function deleteBatch(Request $request)
    {
        if ($this->batchHelper->delete($request->id)) {
            if ($request->ajax()) {
                return response()->json(['status' => 1, 'message' => 'Batch deleted successfully']);
            } else {
                return redirect()->route('batch_list')->with('success', 'Batch deleted successfully');
            }
        }

        if ($request->ajax()) {
            return response()->json(['status' => 0, 'message' => 'Failed to delete']);
        } else {
            return redirect()->route('batch_list')->with('success', 'Failed to delete');
        }
    }

    public function batchOptions(Request $request)
    {
        $term = trim($request->search);
        $categories = $this->batchHelper->searchBatch($term);
        $categoriesOptions = [];

        foreach ($categories as $batch) {
            $categoriesOptions[] = ['id' => $batch->id, 'text' => $batch->name];
        }

        return response()->json($categoriesOptions);
    }

    public function listCourseBatchData(Request $request)
    {
        $categories = $this->batchHelper->getBatchDatatable($request->all());
        $dataTableJSON = DataTables::of($categories)
            ->addIndexColumn()
            ->editColumn('duration', function ($batch) {
                $data['url'] = route('batch_edit', ['id' => $batch->id]);
                $data['text'] = $batch->duration  . ' Hours';

                return view('elements.listLink', compact('data'));
            })

            ->addColumn('status', function ($batch) {
                return view('elements.listStatus')->with('data', $batch);
            })

            ->addColumn('action', function ($batch) use ($request) {
                $data['edit_url'] = route('batch_edit', ['id' => $batch->id, 'return' => 'yes']);
                $data['delete_url'] = route('batch_delete', ['id' => $batch->id]);
                // $data['view_url'] = route('batch_view', ['id' => $batch->id]);

                return view('elements.listAction', compact('data'));
            })
            ->make();

        return $dataTableJSON;
    }
}
