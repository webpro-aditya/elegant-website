<?php

namespace Modules\Gallery\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Modules\Cms\Helpers\ContentHelper;
use Modules\Gallery\Helpers\GalleryHelper;
use Modules\Translation\Helpers\TranslationHelper;

class GalleryController extends Controller
{
    protected $galleryHelper;
    protected $translationHelper;
    protected $cmsHelper;


    public function __construct(GalleryHelper $galleryHelper, ContentHelper $cmsHelper, TranslationHelper $translationHelper)
    {
        $this->galleryHelper = $galleryHelper;
        $this->cmsHelper = $cmsHelper;
        $this->translationHelper = $translationHelper;

    }

    public function gallery()
    {
        $galleries = $this->galleryHelper->getAllImages();
        $translations = $this->translationHelper->getKeyValue();

        return view('gallery::web.gallery', compact('galleries', 'translations'));
    }
}
