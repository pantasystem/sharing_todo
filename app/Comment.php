<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Todo;

class Comment extends Model
{
    //

    public function todo()
    {
        return $this->belongsTo(Todo::class);
    }

    public function author()
    {

    }

    

}
