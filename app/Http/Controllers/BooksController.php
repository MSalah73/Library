<?php

namespace App\Http\Controllers;

use App\Book;
use Illuminate\Http\Request;
use App\Exports\BooksExport;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Excel as exportAS;

class BooksController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $books = Book::sortable()->latest()->paginate(4);
        return view('books.index', compact('books'));
    }
    /**
     * Display a filtred list of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function search(Request $request)
    {
        $data = $request->validate([
                'query' => 'string',
        ]);

        // The Model::search('')->paginate(''); has some problems with pagination
        // Problem: Some page were empty.
        // Below is one solution but it requires the search the database twice. 
        $ids = Book::search($data['query'])->get()->pluck('id');

        $books = Book::whereIn('id', $ids)->sortable()->paginate(4);

        // Problem: Pagination does not add the query field in the url. 
        // Adding the query to links via {{ $books->appends[]->links}} does not work. I solved the problem with
        // adding it in here via str_replace command.
        $newPath = str_replace("search", "search?query=" . $data['query'], $books->path());

        $books->withPath($newPath);

        return view('books.index', compact('books'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required',
            'author' => 'required',
        ]);
        $book = Book::create($data);

        return redirect()->route('books.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Book  $book
     * @return \Illuminate\Http\Response
     */
    public function show(Book $book)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Book  $book
     * @return \Illuminate\Http\Response
     */
    public function edit(Book $book)
    {
        return view('books.edit', compact('book'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Book  $book
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Book $book)
    {
        $data = request()->validate([
            'author' => 'required',
        ]);

        $book->update($data);

        return redirect()->route('books.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Book  $book
     * @return \Illuminate\Http\Response
     */
    public function destroy(Book $book)
    {
        $book->delete();
        
        return redirect()->route('books.index');
    }

    public function export(Request $request) 
    {
        $data = $request->validate([
            'exportAs' => 'integer',
            'fields' => 'integer',
        ]);

        $fields = ($data['fields'] === '3') ? ['title'] : (($data['fields'] === '2') ? ['author'] : ['title', 'author']);

        if($data['exportAs'] === '1'){
            return (new BooksExport)->only($fields)->download('books.csv', exportAS::CSV, [
                'Content-Type' => 'text/csv',
            ]);
        }

        return (new BooksExport)->only($fields)->saveXML();
    }

}
