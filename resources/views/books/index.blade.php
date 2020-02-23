@extends('layouts.app')

@section('content')
<div class="container">
	<div class='d-flex justify-content-between '>
		<div class="row">
			<form method="POST" action="/book" enctype="multipart/form-data" >
	        @csrf
	        <div class="row">
	            <div class="col">
	                <div class='row'>
	                    <h1>Add A Book</h1>
	                </div>
	                <div class="card-body">
	                    <div class="form-group row">
	                        <label for="title" class="col-md- col-form-label">Title</label>

	                        <input id="title" type="text" class="form-control @error('title') is-invalid @enderror" name="title" value="{{ old('title') }}" required autocomplete="title" autofocus>

	                        @error('title')
	                            <span class="invalid-feedback" role="alert">
	                                <strong>{{ $message }}</strong>
	                            </span>
	                        @enderror
	                    </div>
	                    <div class="form-group row">
	                        <label for="author" class="col-md- col-form-label">Author</label>

	                        <input id="author" type="text" class="form-control @error('author') is-invalid @enderror" name="author" value="{{ old('author') }}" required autocomplete="author" autofocus>

	                        @error('author')
	                            <span class="invalid-feedback" role="alert">
	                                <strong>{{ $message }}</strong>
	                            </span>
	                        @enderror
	                    </div>
	                    <div class="row pt-4">
	                        <button class="btn btn-primary">Add A New Book                            
	                        </button>
	                    </div>
	                </div>
	            </div>
	        </div>
	    	</form>
    	</div>
    	<div class="row">
			<form method="GET" action="/book/export"enctype="multipart/form-data" >
	        <!-- @csrf  No csrf needed -->
	        <div class="row">
	            <div class="col">
	                <div class='row'>
	                    <h1>Download Books</h1>
	                </div>
	                <div class="card-body">
	                	<div class="row align-items-baseline pb-2">
							<span class="pr-4">Fields:</span>
							<div class="row form-group form-check form-check-inline">
								<select name="fields" class="form-control">
								  <option value="1" selected>Author and title</option>
								  <option value="2">Author</option>
								  <option value="3">Title</option>
								</select>
							</div>	
						</div>
						<div class="row align-items-baseline">
							<span class="pr-4">Download as:</span>
							<div class="row">
								<div class="pr-1 form-check form-check-inline">
									<input class="form-check-input" type="radio" name="exportAs" value="1" id="CSV"checked>
									<label class="form-check-label" for="CSV">CSV</label>
								</div>
								<div class="pr-1 form-check form-check-inline">
							  		<input class="form-check-input" type="radio" name="exportAs" value="2" id="XML">
								  	<label class="form-check-label" for="XML">XML</label>
								</div>
							</div>
						</div>
	                    <div class="row pt-4">
	                        <button class="btn btn-primary">Download                            
	                        </button>
	                    </div>
	                </div>
	            </div> 
	        </div>
	    	</form>
		</div>
	</div>
    <div class="row pt-2 pb-4">
        <div class="col-12">
		   <form method="GET" action="/book/search">
	            <div class="pb-4 row">
	                <div class="col-md-6">
	                    <input type="text" name="query" class="form-control" placeholder="Search">
	                </div>
	                <div class="col-md-6">
	                    <button class="btn btn-primary">Search</button>
	                </div>
	            </div>
	        </form>
        	<table class="table table-striped table-dark text-center">
        		<thead>
				    <tr>
				      <th scope="col">#</th>
				      <th scope="col">@sortablelink('title')</th>
				      <th scope="col">@sortablelink('author')</th>
				      <th scope="col">Edit</th>
				      <th scope="col">Delete</th>
				    </tr>
				</thead>
				<tbody>
					@foreach($books as $book)
				    <tr>
				    	<th scope="row" class="col-1">{{ $loop->iteration }}</th>
				    	<td class="col-4">{{ $book->title }}</td>
				    	<td class="col-4">{{ $book->author }}</td>
				      	<td class="col-1"><button ><a href="/book/{{ $book->id}}/edit"><i class="material-icons">edit</i></a></button></td>
				      	<form method="POST" action="/book/{{ $book->id }}"enctype="multipart/form-data" >
					        @csrf
					        @method('DELETE')
				      			<td class='col-1'><button ><i class="material-icons">delete_forever</i></a>	</button></td>
				      		</form>
				    </tr>
				    @endforeach
				</tbody>
			</table> 
        </div>
    </div>
    @if($books->perPage() < $books->total())
		<div class="row">
    		<div class="col-12 d-flex justify-content-center">
    			<!-- The line below adds the sortable params to the url to persist the sort  between all the pages  -->
        		{{ $books->appends(['sort' => request()->sort,'direction' => request()->direction ,])->links() }}
    		</div>
		</div>
	@endif
</div>
@endsection