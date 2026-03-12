<?php

namespace Modules\Gallery\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Modules\Gallery\Helpers\GalleryHelper;
use Modules\Gallery\Http\Controllers\Admin\Includes\Image;
use Modules\Gallery\Http\Requests\Admin\GalleryAddRequest;
use Modules\Gallery\Http\Requests\Admin\GalleryCreateRequest;
use Modules\Gallery\Http\Requests\Admin\GalleryDeleteRequest;
use Modules\Gallery\Http\Requests\Admin\GalleryEditRequest;
use Modules\Gallery\Http\Requests\Admin\GalleryListDataRequest;
use Modules\Gallery\Http\Requests\Admin\GalleryListRequest;
use Modules\Gallery\Http\Requests\Admin\GalleryUpdateRequest;
use Modules\Settings\Helpers\SettingsHelper;
use Yajra\DataTables\DataTables;

class GalleryController extends Controller
{
    use Image;
    protected $galleryHelper;
    protected $settingsHelper;

    public function __construct(GalleryHelper $galleryHelper, SettingsHelper $settingsHelper)
    {
        $this->galleryHelper = $galleryHelper;
        $this->settingsHelper = $settingsHelper;
    }
    public function addGallery(GalleryAddRequest $request)
    {
        $languages = $this->settingsHelper->getLanguages();

        return view('gallery::admin.addGallery', compact('languages'));
    }
    public function listGallery(GalleryListRequest $request)
    {
        $breadcrumbs = [
            ['link' => 'dashboard_home', 'name' => 'Dashboard'],
            ['name' => 'Gallery'],
        ];

        return view('gallery::admin.listGallery', compact('breadcrumbs'));
    }
    public function galleryListData(GalleryListDataRequest $request)
    {
        $gallery = $this->galleryHelper->getGalleryDatatable($request->all());
        $dataTableJSON = DataTables::of($gallery)
            ->addIndexColumn()
            ->addColumn('name', function ($gallery) {
                $data['url'] = route('gallery_edit', ['id' => $gallery->id]);
                $data['text'] = $gallery->name_en;

                return view('elements.listLink', compact('data'));
            })

            ->addColumn('status', function ($gallery) {
                return view('elements.listStatus')->with('data', $gallery);
            })

            ->addColumn('action', function ($gallery) use ($request) {
                $data['edit_url'] = route('gallery_edit', ['id' => $gallery->id]);
                $data['delete_url'] = route('gallery_delete', ['id' => $gallery->id]);

                return view('elements.listAction', compact('data'));
            })
            ->make();

        return $dataTableJSON;
    }
    public function saveGallery(GalleryCreateRequest $request)
    {
        $inputData = [
            'name_en' => $request->name_en,
            'name_ar' => $request->name_ar,
            'name_sp' => $request->name_sp,
            'name_fr' => $request->name_fr,
            'status' => $request->status,
            'thumbnail_alt' => $request->thumbnail_alt,
        ];

        if ($request->hasFile('thumbnail_picture')) {
            $filePath = 'gallery/thumbnail_picture';
            $fileName = Storage::disk('elegant')->putFile($filePath, $request->file('thumbnail_picture'));
            $inputData['thumbnail_picture'] = $fileName;
        }

        $gallery = $this->galleryHelper->save($inputData);

        if ($request->has('images')) {
            foreach ($request->images as $id => $file) {
                $inputImageData = [
                    'id' => $id,
                    'gallery_id' => $gallery->id,
                    'image_path' => $file,
                ];
                $this->galleryHelper->saveImage($inputImageData);
            }
        }

        activity()->performedOn($gallery)->event('Gallery Created')->withProperties(['gallery_id' => $gallery->id, 'data' => $inputData])->log('Gallery Created');

        return redirect()->route('gallery_list')->with('success', 'Gallery added successfully');
    }
    public function editGallery(GalleryEditRequest $request)
    {
        $breadcrumbs = [
            ['link' => 'dashboard_home', 'name' => 'Dashboard'],
            ['link' => 'gallery_list', 'name' => 'Gallery'],
            ['name' => 'galleryDetails'],
        ];
        $gallery = $this->galleryHelper->getGallery($request->id);

        $languages = $this->settingsHelper->getLanguages();

        return view('gallery::admin.editGallery', compact('gallery', 'languages', 'breadcrumbs'));
    }
    public function updateGallery(GalleryUpdateRequest $request)
    {
        $updateData = [
            'id' => $request->id,
            'name_en' => $request->name_en,
            'name_ar' => $request->name_ar,
            'name_sp' => $request->name_sp,
            'name_fr' => $request->name_fr,
            'status' => $request->status,
            'thumbnail_alt' => $request->thumbnail_alt,
        ];

        if ($request->hasFile('thumbnail_picture')) {
            $filePath = 'gallery/thumbnail_picture';
            $fileName = Storage::disk('elegant')->putFile($filePath, $request->file('thumbnail_picture'));
            $updateData['thumbnail_picture'] = $fileName;
        } elseif ($request->thumbnail_picture_remove == 1) {
            $updateData['thumbnail_picture'] = '';
        }

        $gallery = $this->galleryHelper->update($updateData);

        if (isset($request->images) && $request->images) {
            $galleryItemIds = [];

            if ($request->has('images')) {
                foreach ($request->images as $id => $file) {
                    $inputImageData = [
                        'id' => $id,
                        'gallery_id' => $gallery->id,
                        'image_path' => $file,
                    ];
                    $galleryItem = $this->galleryHelper->saveImage($inputImageData);
                    $galleryItemIds[] = $galleryItem->id;
                }
            }
            $this->galleryHelper->deleteGallerytems($galleryItem->id, $notIn = $galleryItemIds);
        }

        activity()->performedOn($gallery)->event('Gallery Updated')->withProperties(['gallery_id' => $gallery->id, 'data' => $updateData])->log('Gallery Updated');

        return redirect()
            ->route('gallery_list')
            ->with('success', 'Gallery updated successfully');
    }
    public function deleteGallery(GalleryDeleteRequest $request)
    {
        $gallery = $this->galleryHelper->getGallery($request->id);

        if ($this->galleryHelper->delete($request->id)) {

            if ($request->ajax()) {

                activity()->performedOn($gallery)->event('Gallery Deleted')->withProperties(['gallery_id' => $gallery->id])->log('Gallery Deleted');

                return response()->json(['status' => 1, 'message' => 'Gallery deleted successfully']);

            } else {

                return redirect()->route('blog_list')->with('success', 'Gallery deleted successfully');
            }

        }

        if ($request->ajax()) {
            return response()->json(['status' => 0, 'message' => 'Failed to delete']);
        } else {
            return redirect()->route('gallery_list')->with('success', 'Failed to delete');
        }
    }
}
