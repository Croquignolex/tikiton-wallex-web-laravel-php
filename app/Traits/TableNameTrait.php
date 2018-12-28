<?php

namespace App\Traits;

trait TableNameTrait
{
    /**
     * @return mixed
     */
    public function getTableNameAttribute()
    {
        return text_format($this->name, 20);
    }

    /**
     * @return mixed
     */
    public function getPopoverNameAttribute()
    {
        if($this->table_name === $this->name) return '';
        else return $this->name;
    }
}