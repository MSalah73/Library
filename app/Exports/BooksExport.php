<?php

namespace App\Exports;

use App\Book;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Illuminate\Http\Response;
use Spatie\ArrayToXml\ArrayToXml;

class BooksExport implements FromQuery, WithHeadings
{
    use Exportable;

    public function only(array $exportOnly)
    {
        $this->exportOnly = $exportOnly;
        
        return $this;
    }
    public function query()
    {
        return Book::query()->select($this->exportOnly);
    }

	public function headings(): array
    {
        return $this->exportOnly;
    }

    // Maatwebsite\Excel does not support XML download. Below is a custom fuction to trasulate the data into
    // XML fromated data and send as a downloadable file to the user.
    public function saveXML()
    {
        // Using the Query method to retrive the data with headings and convert it to an array format.
        $data = BooksExport::query()->get()->toArray();

        // Using the ArrayToXml to convert the array to XML file. 
        $xml = ArrayToXml::convert(['__numeric' => $data]);

        // Prepare the reposnce to the user witha a XML file.
        $response = Response::create($xml, 200);
        $response->header('Content-Type', 'text/xml');
        $response->header('Cache-Control', 'public');
        $response->header('Content-Description', 'File Transfer');
        $response->header('Content-Disposition', 'attachment; filename=' . 'books.xml');
        $response->header('Content-Transfer-Encoding', 'binary');
        return $response;
    }

}
