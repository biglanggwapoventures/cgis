<?php

namespace App\Traits;

trait RemoveCommasTrait
{

    public function setAttribute($key, $value)
    {
        if ($value && in_array($key, $this->removeCommas)) {
            $value = str_replace(',', '', $value);
        }

        return parent::setAttribute($key, $value);
    }

}
