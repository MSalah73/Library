<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
// This model to enable text search for this model
use Laravel\Scout\Searchable;
use Kyslik\ColumnSortable\Sortable;

class Book extends Model
{
	use Searchable;
	
	use Sortable;

    public $sortable = ['title','author'];

	protected $fillable = [
        'title', 'author',
    ];
}