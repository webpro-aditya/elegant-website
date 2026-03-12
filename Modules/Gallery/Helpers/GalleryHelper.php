<?php

namespace Modules\Gallery\Helpers;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Storage;
use Modules\Gallery\Entities\Gallery;
use Modules\Gallery\Entities\GalleryImage;

class GalleryHelper
{
    /*
    |--------------------------------------------------------------------------
    | Gallery
    |--------------------------------------------------------------------------
    */
    public function save(array $input)
    {
        if ($gallery = Gallery::create($input)) {
            return $gallery;
        }

        return false;
    }

    public function getGalleryDatatable($data)
    {
        $gallery = Gallery::select(app(Gallery::class)->getTable() . '.*')->with('items');

        if (isset($data['status'])) {
            $gallery->where('status', $data['status']);
        }

        return $gallery;
    }

    public function getGallery($id)
    {
        try {
            $gallery = Gallery::findOrFail($id);

            return $gallery;
        } catch (ModelNotFoundException $e) {
            return false;
        }
    }

    public function delete($galleryId)
    {
        try {
            $gallery = Gallery::findOrFail($galleryId);
            $gallery->delete();

            return true;
        } catch (ModelNotFoundException $e) {
            return false;
        }
    }

    public function update($data)
    {
        $gallery = Gallery::find($data['id']);

        if ($gallery->update($data)) {
            return $gallery;
        }

        return false;
    }

    public function deleteGallerytems($galleryId, $notInIds)
    {
        $items = GalleryImage::whereNotIn('id', $notInIds)->where('gallery_id', $galleryId)->get();

        foreach ($items as $item) {
            if (Storage::disk('elegant')->delete($item->image_path)) {
                $item->delete();
            }
        }
    }

    public function getAllImages()
    {
        return Gallery::with('items')->get();
    }

    /*
    |--------------------------------------------------------------------------
    | Dropzone
    |--------------------------------------------------------------------------
    */
    public function saveImage(array $input)
    {
        if (isset($input['id']) && $input['id']) {
            $galleryImage = GalleryImage::find($input['id']);
            $galleryImage->update($input);

            return $galleryImage;
        } elseif ($galleryImage = GalleryImage::create($input)) {
            return $galleryImage;
        }

        return false;
    }

    public function get($id)
    {
        return Gallery::find($id);
    }

    public function getGalleryItem($id)
    {
        return GalleryImage::find($id);
    }

    public function deleteImage($id)
    {
        return GalleryImage::where('id', $id)->delete();
    }

    public function updateContentItems(array $input)
    {
        $contentItem = GalleryImage::find($input['id']);
        unset($input['id']);

        if ($contentItem->update($input)) {
            return $contentItem;
        }

        return false;
    }
}
