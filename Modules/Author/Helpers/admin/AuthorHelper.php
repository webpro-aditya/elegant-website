<?php

namespace Modules\Author\Helpers\admin;

use Illuminate\Database\Eloquent\ModelNotFoundException;

use Modules\Author\Entities\Author;
use Modules\Author\Entities\AuthorLocal;
use Modules\Cms\Entities\Language;

class AuthorHelper
{
    public function save(array $input)
    {
        if ($author = Author::create($input)) {
            return $author;
        }

        return false;
    }

    public function getDatatable($data)
    {
        $authorQuery = Author::select(app(Author::class)->getTable() . '.*')->with('locales');
      
        if (isset($data['status'])) {
            $authorQuery->where('status', '=', $data['status']);
        }
     
        $authors = $authorQuery->get();

     
        return $authors;
    
    }

    public function get($id)
    {
        return Author::find($id);
    }
    public function getAuthorWithName($id)
    {
        $englishLanguageId = Language::where('code', 'en')->value('id');

        $author = Author::find($id);
        $englishName = AuthorLocal::where('author_id', $author->id)->where('language_id', $englishLanguageId)->value('name');

        $author->english_name = $englishName;

        return $author;
    }

    public function getLocaleContents($id)
    {
        $contentLocales = AuthorLocal::where('author_id', $id)->get();

        $languageCodes = Language::pluck('code', 'id');

        $groupedContentLocales = $contentLocales->groupBy(function ($contentLocale) use ($languageCodes) {
            return $languageCodes[$contentLocale->language_id];
        });

        return $groupedContentLocales;
    }

    public function update($data)
    {
        $author = Author::find($data['id']);
        if ($author->update($data)) {
            return $author;
        }

        return false;
    }

    public function delete($id)
    {
        try {
            $author = Author::findOrFail($id);
            $author->delete();

            return true;
        } catch (ModelNotFoundException $e) {
            return false;
        }
    }

    public function searchAuthor($keyword)
    {
        $englishLanguageId = Language::where('code', 'en')->value('id');
    
        $authors = Author::where('status', 'active') // Add the status filter here
        ->whereHas('locales', function ($query) use ($keyword, $englishLanguageId) {
            $query->where('language_id', $englishLanguageId)
                  ->where('name', 'like', "%{$keyword}%");
        })
        ->paginate(30);
    
        return $authors;
    }

}