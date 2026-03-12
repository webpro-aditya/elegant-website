<?php

namespace Modules\Subscriber\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Subscriber\Http\Requests\Admin\SubscriberListRequest;
use Modules\Subscriber\Http\Requests\Admin\SubscriberListDataRequest;
use Modules\Subscriber\Http\Requests\Admin\SubscriberDeleteRequest;
use Modules\Subscriber\Helpers\SubscriberHelper;
use Yajra\DataTables\DataTables;

class SubscriberController extends Controller
{
    protected $subscriberHelper;

    public function __construct(SubscriberHelper $subscriberHelper)
    {
        $this->subscriberHelper = $subscriberHelper;
    }
    public function listSubscriber(SubscriberListRequest $request)
    {
        $breadcrumbs = [
            ['link' => 'dashboard_home', 'name' => 'Dashboard'],
            ['name' => 'Subscriber'],
        ];

        return view('subscriber::admin.listSubscriber', compact('breadcrumbs'));
    }

    public function SubscriberListData(SubscriberListDataRequest $request)
    {
        $subscriber = $this->subscriberHelper->getSubscriberDatatable($request->all());
        $dataTableJSON = DataTables::of($subscriber)
            ->addIndexColumn()
            ->addColumn('name', function ($subscriber) {
                $data['text'] = $subscriber->email;
                return view('elements.listLink', compact('data'));
            })

            ->addColumn('status', function ($subscriber) {
                return view('elements.listStatus')->with('data', $subscriber);
            })

            ->addColumn('action', function ($subscriber) use ($request) {
                $data['delete_url'] = route('subscriber_delete', ['id' => $subscriber->id]);
                return view('elements.listAction', compact('data'));
            })
            ->make();

        return $dataTableJSON;
    }

    public function deleteSubscriber(SubscriberDeleteRequest $request)
    {
        $subscriber = $this->subscriberHelper->getSubscriber($request->id);

        if ($this->subscriberHelper->delete($request->id)) {

            if ($request->ajax()) {

                activity()->performedOn($subscriber)->event('Subscriber Deleted')->withProperties(['subscriber_id' => $subscriber->id])->log('Subscriber Deleted');

                return response()->json(['status' => 1, 'message' => 'Subscriber deleted successfully']);

            } else {

                return redirect()->route('blog_list')->with('success', 'Subscriber deleted successfully');
            }

        }

        if ($request->ajax()) {
            return response()->json(['status' => 0, 'message' => 'Failed to delete']);
        } else {
            return redirect()->route('subscriber_list')->with('success', 'Failed to delete');
        }
    }

    public function subscriberEmailOptions(Request $request)
    {
        $term = trim($request->search);
        $subscribers = $this->subscriberHelper->searchSubscriber($term);
        $subscribersOptions = [];

        $seenEmails = [];

        foreach ($subscribers as $subscriber) {
            if (!in_array($subscriber->email, $seenEmails)) {
                $subscribersOptions[] = ['id' => $subscriber->email, 'text' => $subscriber->email];
                $seenEmails[] = $subscriber->email;
            }
        }

        return response()->json($subscribersOptions);
    }

}
