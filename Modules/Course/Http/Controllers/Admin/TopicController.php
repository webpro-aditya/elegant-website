<?php

namespace Modules\Course\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Course\Helpers\CourseCategoryHelper;
use Modules\Course\Helpers\TopicHelper;
use Modules\Course\Http\Requests\Admin\Topic\TopicAddRequest;
use Modules\Course\Http\Requests\Admin\Topic\TopicCreateRequest;
use Modules\Course\Http\Requests\Admin\Topic\TopicDeleteRequest;
use Modules\Course\Http\Requests\Admin\Topic\TopicEditRequest;
use Modules\Course\Http\Requests\Admin\Topic\TopicListDataRequest;
use Modules\Course\Http\Requests\Admin\Topic\TopicListRequest;
use Modules\Course\Http\Requests\Admin\Topic\TopicUpdateRequest;
use Yajra\DataTables\DataTables;

class TopicController extends Controller
{
    protected $topicHelper;

    protected $courseCategoryHelper;

    public function __construct(TopicHelper $topicHelper, CourseCategoryHelper $courseCategoryHelper)
    {
        $this->topicHelper = $topicHelper;

        $this->courseCategoryHelper = $courseCategoryHelper;
    }

    public function listTopic(TopicListRequest $request)
    {
        $breadcrumbs = [
            ['link' => 'dashboard_home', 'name' => 'Dashboard'],
            ['name' => 'Topic'],
        ];
        $categories = $this->courseCategoryHelper->getAllCourseCategory();

        return view('course::admin.topic.listTopic', compact('breadcrumbs', 'categories'));
    }

    public function topicListData(TopicListDataRequest $request)
    {
        $topics = $this->topicHelper->getTopicDatatable($request->all());
        $dataTableJSON = DataTables::of($topics)
            ->addIndexColumn()
            ->editColumn('title', function ($topic) {
                $data['url'] = route('topic_edit', ['id' => $topic->id]);
                $data['text'] = $topic->title;

                return view('elements.listLink', compact('data'));
            })

            ->editColumn('category', function ($topic) {
                return ($topic->category) ? $topic->category->name : '';
            })

            ->addColumn('action', function ($topic) use ($request) {
                $data['edit_url'] = route('topic_edit', ['id' => $topic->id]);
                $data['delete_url'] = route('topic_delete', ['id' => $topic->id]);
                $data['view_url'] = route('topic_view', ['id' => $topic->id]);

                return view('elements.listAction', compact('data'));
            })
            ->make();

        return $dataTableJSON;
    }

    public function viewTopic(TopicListRequest $request)
    {
        $breadcrumbs = [
            ['link' => 'dashboard_home', 'name' => 'Dashboard'],
            ['link' => 'topic_list', 'name' => 'Topic', 'permission' => 'topic_read'],
            ['name' => 'View Topic'],
        ];
        $topic = $this->topicHelper->getTopic($request->id);

        return view('course::admin.topic.viewTopic', compact('topic', 'breadcrumbs'));
    }

    public function addTopic(TopicAddRequest $request)
    {
        $breadcrumbs = [
            ['link' => 'dashboard_home', 'name' => 'Dashboard'],
            ['link' => 'topic_list', 'name' => 'Topic', 'permission' => 'topic_read'],
            ['name' => 'Add Topic'],
        ];
        $categories = $this->courseCategoryHelper->getAllCourseCategory();

        return view('course::admin.topic.addTopic', compact('breadcrumbs', 'categories'));
    }

    public function createTopic(TopicCreateRequest $request)
    {
        $inputData = [
            'title' => $request->title,
            'category_id' => $request->category_id,
        ];
        $topic = $this->topicHelper->save($inputData);

        activity()->performedOn($topic)->event('Topic Created')->withProperties(['id' => $topic->id, 'data' => $inputData])->log('Topic Created');

        return redirect()
            ->route('topic_list')
            ->with('success', 'Topic added successfully');
    }

    public function editTopic(TopicEditRequest $request)
    {
        $breadcrumbs = [
            ['link' => 'dashboard_home', 'name' => 'Dashboard'],
            ['link' => 'topic_list', 'name' => 'Topic', 'permission' => 'topic_read'],
            ['name' => 'Topic Details'],
        ];
        $topic = $this->topicHelper->getTopic($request->id);
        $categories = $this->courseCategoryHelper->getAllCourseCategory();

        return view('course::admin.topic.listTopic', compact('topic', 'breadcrumbs', 'categories'));
    }

    public function updateTopic(TopicUpdateRequest $request)
    {
        $inputData = [
            'id' => $request->id,
            'title' => $request->title,
            'category_id' => $request->category_id,
        ];

        $topic = $this->topicHelper->update($inputData);

        activity()->performedOn($topic)->event('Topic Updated')->withProperties(['id' => $topic->id, 'data' => $inputData])->log('Topic Created');

        return redirect()
            ->route('topic_list')
            ->with('success', 'Topic updated successfully');
    }

    public function deleteTopic(TopicDeleteRequest $request)
    {
        if ($this->topicHelper->delete($request->id)) {
            if ($request->ajax()) {
                return response()->json(['status' => 1, 'message' => 'Topic deleted successfully']);
            } else {
                return redirect()->route('topic_list')->with('success', 'Topic deleted successfully');
            }
        }

        if ($request->ajax()) {
            return response()->json(['status' => 0, 'message' => 'Failed to delete']);
        } else {
            return redirect()->route('topic_list')->with('success', 'Failed to delete');
        }
    }

    public function topicOptions(Request $request)
    {
        $term = trim($request->search);
        $topics = $this->topicHelper->searchTopic($term);
        $topicsOptions = [];

        foreach ($topics as $topic) {
            $topicsOptions[] = ['id' => $topic->id, 'text' => $topic->title];
        }

        return response()->json($topicsOptions);
    }
}
