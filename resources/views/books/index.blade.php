<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Library') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
	<div class="container">
		<div class='d-flex justify-content-between '>
			<div class="row">
				<form method="POST" action="/book"enctype="multipart/form-data" >
		        @csrf
		        <div class="row">
		            <div class="col">
		                <div class='row'>
		                    <h1>Add A Book</h1>
		                </div>
		                <div class="card-body">
		                    <div class="form-group row">
		                        <label for="title" class="col-md- col-form-label">Book Title</label>

		                        <input id="title" type="text" class="form-control @error('title') is-invalid @enderror" name="title" value="{{ old('title') }}" required autocomplete="title" autofocus>

		                        @error('title')
		                            <span class="invalid-feedback" role="alert">
		                                <strong>{{ $message }}</strong>
		                            </span>
		                        @enderror
		                    </div>
		                    <div class="form-group row">
		                        <label for="author" class="col-md- col-form-label">Book Author</label>

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
				<form method="POST" action="/books"enctype="multipart/form-data" >
		        @csrf
		        <div class="row">
		            <div class="col">
		                <div class='row'>
		                    <h1>Download Books</h1>
		                </div>
		                <div class="card-body">
		                	<div class="row align-items-baseline pb-2">
								<span class="pr-4">Fields:</span>
								<div class="row">
									<select class="custom-select">
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
										<input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio1" value="option1" checked>
										<label class="form-check-label" for="inlineRadio1">CSV</label>
									</div>
									<div class="pr-1 form-check form-check-inline">
								  		<input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio2" value="option2">
									  	<label class="form-check-label" for="inlineRadio2">XML</label>
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
			<div class="">
		    <div class="row pt-2 pb-4">
		        <div class="col-12">
				  
		        	<table class="table table-striped table-dark text-center">
		        		<thead>
						    <tr>
						      <th scope="col">#</th>
						      <th scope="col">Title</th>
						      <th scope="col">Author</th>
						      <th scope="col">Edit</th>
						      <th scope="col">Delete</th>
						    </tr>
						</thead>
						<tbody>
							@foreach($books->sortBy('') as $book)
						    <tr>
						    	<th scope="row" class="col-1">{{ $loop->iteration }}</th>
						    	<td class="col-4">{{ $book->title }}</td>
						    	<td class="col-4">{{ $book->author }}</td>
						      	<td class="col-1"><button>	</button></td>
						      	<td class='col-1'><button>	</button></td>
						    </tr>
						    @endforeach
						</tbody>
					</table> 
		        </div>
		    </div>
		    
</body>
</html>
