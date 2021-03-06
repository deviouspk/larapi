<?php

namespace Modules\Script\Exceptions;

use Foundation\Exceptions\Exception;

class ScriptReviewReplyAlreadyExistsException extends Exception
{

    public function __construct()
    {
        parent::__construct("This review already has a reply", 409, null);
    }

}
