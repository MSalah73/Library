<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
// This model to enable text search for this model
use Kyslik\ColumnSortable\Sortable;

class Book extends Model
{
	use Sortable;

    public $sortable = ['title','author'];

	protected $fillable = [
        'title', 'author',
    ];
}