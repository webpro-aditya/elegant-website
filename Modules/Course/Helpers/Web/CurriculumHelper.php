<?php

namespace Modules\Course\Helpers\Web;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Modules\Course\Entities\Curriculum;

class CurriculumHelper
{

    public function save(array $input)
    {
        if ($curriculum = Curriculum::create($input)) {
            return $curriculum;
        }

        return false;
    }
  
}
