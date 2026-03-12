<?php

namespace Modules\Gallery\Http\Controllers\Admin\Includes;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Modules\Gallery\Helpers\GalleryHelper;

trait Image
{
    protected $galleryHelper;

    public function __construct(GalleryHelper $galleryHelper)
    {
        $this->galleryHelper = $galleryHelper;
    }

    public function imageSave(Request $request)
    {
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $filePath = 'gallery_images';
            $fileName = Storage::disk('elegant')->putFile($filePath, $file);
            $imageFileName = explode('/', $fileName)[1];
            $imagesUrl = Storage::disk('elegant')->url($fileName);

            $inputImageData = [
                'image_path' => $file,
            ];
            $galleryImage = $this->galleryHelper->saveImage($inputImageData);
            $returnArray = [
                'id' => $galleryImage->id,
                'status' => true,
                'fileName' => $fileName,
                'imageUrl' => $imagesUrl,
                'imageFileName' => $request->file('file'),
            ];

            $returnArray['form'] = (string) view('elements.dropzoneImageForm', compact('returnArray'));

            return response()->json($returnArray, 200);
        }

        return response()->json('Upload Failed!', 400);
    }

    public function imageData(Request $request)
    {
        $gallery = $this->galleryHelper->get($request->gallery_id);
        $items = [];
        foreach ($gallery->items as $key => &$item) {
            $item->url = Storage::disk('elegant')->url($item->image_path);
            $returnArray = [
                'id' => $item->id,
                'fileName' => $item->image_path,
                'link' => $item->link,
                'title' => $item->title,
            ];
            $item->form = (string) view('elements.dropzoneImageForm', compact('returnArray'));
        }

        return $gallery->items;
    }

    public function imageDelete(Request $request)
    {
        $galleryItem = $this->galleryHelper->getGalleryItem($request->id);

        if ($galleryItem->gallery_id) {
            if (Storage::disk('elegant')->delete($request->file)) {
                $this->galleryHelper->deleteImage($request->id);
            }
        }
    }

    public function dataUpdate(Request $request)
    {
        $updateData = [
            'id' => $request->id,
            'name' => $request->name,
            'title' => $request->title,
            'link' => $request->link,
        ];
        $this->galleryHelper->updateContentItems($updateData);

        return response()->json(['status' => true, 'message' => 'Data Updated'], 200);
    }
}
