<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;

class Category extends Model
{
    public function get_all_category()
    {
        $data = DB::select("
            SELECT
                *
            FROM
                kategori
        ");
        return $data;
    }
}
