<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\Storage;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Csv;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class CsvController extends Controller
{
    public function index()
    {
        $if_exist = Storage::disk('public')->exists('csv/file.csv');
        if(!$if_exist || filesize(public_path('csv/file.csv')) == 0 ) {
            $is_empty = true;
            return view('csv.index',compact('is_empty'));
        }
       $file = public_path('csv\file.csv');
       $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($file);
       $sheet = $spreadsheet->getActiveSheet();
       $items = $sheet->toArray();

        $header = $items[0];
        // $items = $this->paginate($items);
        // $items->withPath('');

        $is_empty = false;

        return view('csv.index',compact('items','header','is_empty'));
    }
    
    public function paginate($items, $perPage = 15, $page = null)
    {
        $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);
        $total = count($items);
        $currentpage = $page;
        $offset = ($currentpage * $perPage) - $perPage ;
        $itemstoshow = array_slice($items , $offset , $perPage);
        return new LengthAwarePaginator($itemstoshow ,$total ,$perPage);
    }

    public function create()
    {
       $file = public_path('csv/file.csv');
       $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($file);
       $sheet = $spreadsheet->getActiveSheet();
       $items = $sheet->toArray();

        $titles = $items[0];
        $count_col = count($items[0]);
        $count_row = count($items)+1;

        return view('csv.create',compact('count_col','count_row','titles'));

    }

    public function store(Request $request)
    {
        $file = public_path('csv/file.csv');
        $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($file);
        $sheet = $spreadsheet->getActiveSheet();
        $items = $sheet->toArray();

            $request->request->remove('_token');
            $item = $request->toArray();

            $file = public_path('csv/file.csv');
            $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($file);
            $sheet = $spreadsheet->getActiveSheet();
            foreach ($item as $items => $value) {
                $sheet->setCellValue($items,  $value);
            }        
            $writer = new Csv($spreadsheet);
            $writer->save('csv/file.csv');
            return redirect()->route('csv.index')->with('success','Create a new record succesfuly');
    }

    public function edit($id)
    {
        $file = public_path('csv/file.csv');
        $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($file);
        $sheet = $spreadsheet->getActiveSheet();
        $items = $sheet->toArray();

        $titles = $items[0];
        $count_row = count($items)+1;

        return view('csv.edit',compact('items','id','titles','count_row'));
    }


    public function update(Request $request, $id)
    {
        $items = $request->all();
        $file = public_path('csv/file.csv');
        $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($file);
        $sheet = $spreadsheet->getActiveSheet();
            foreach ($items as $item => $value) {
                $sheet->setCellValue($item,  $value);
            }        
            $writer = new Csv($spreadsheet);
            $writer->save('csv/file.csv');
        return redirect()->route('csv.index')->with('success','updated succesfuly');
    }
    public function delete($id)
    {
        $file = public_path('csv/file.csv');
        $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($file);
        $sheet = $spreadsheet->getActiveSheet()
            ->removeRow($id, 1);
        
        $writer = new Csv($spreadsheet);
        $writer->save('csv/file.csv');

        return redirect()->route('csv.index')->with('deleted','deleted succesfuly');
    }

    public function uploadfile(Request $request)
    {
        $request->validate([
            'file' => ['required','mimes:csv'],
        ]);

        if(!$request->hasFile('file')) {
            return;
        };
        Storage::disk('public')->delete('csv/file.csv');

        $file = $request->file('file');

        $path = $file->storeAs('', 'csv/file.csv', [
                'disk' => 'public'
        ]);
         
        return redirect()->route('csv.index');
    }

    public function download()
    {
         $filename = Date('Y-m-d').'file.csv';

        return response()->download(public_path('csv/file.csv'), $filename ,[
            'Content-Type' => 'application/vnd.ms-csv',
            'Content-Disposition' => 'inline; filename="' . $filename . '"'
        ]);
        return redirect()->route('csv.index')->with('success','download succesfuly');
    }

    public function remove_col($id)
    {
         $x='A';
        for ($i=1; $i < $id ; $i++) { 
            $x++;
        }
        $file = public_path('csv/file.csv');
        $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($file);
        $sheet = $spreadsheet->getActiveSheet()
            ->removeColumn($x, 1);
        
        $writer = new Csv($spreadsheet);
        $writer->save('csv/file.csv');

        return redirect()->route('csv.index')->with('deleted','deleted column succesfuly');
    }

    public function create_col($id)
    {
        return view('csv.create_col',compact('id'));
    }

    public function added_col(Request $request, $id)
    {
        $x='A';
        for ($i=1; $i < $id ; $i++) { 
            $x++;
        }
        ++$x;
        $file = public_path('csv/file.csv');
        $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($file);
        $sheet = $spreadsheet->getActiveSheet()
            ->insertNewColumnBefore($x, 1)
            ->setCellValue($x.'1', $request->col_name);;
        
        $writer = new Csv($spreadsheet);
        $writer->save('csv/file.csv');

        return redirect()->route('csv.index')->with('success','Add Column succesfuly');
    }

    public function edit_col( $id)
    {
        $file = public_path('csv/file.csv');
        $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($file);
        $sheet = $spreadsheet->getActiveSheet();
        $items = $sheet->toArray();

        $titles = $items[0];
        $title = $titles[$id-1];

        return view('csv.edit_col',compact('title','id'));
    }
    
    public function update_col(Request $request, $id)
    {
        $x='A';
        for ($i=1; $i < $id ; $i++) { 
            $x++;
        }
        $file = public_path('csv/file.csv');
        $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($file);
        $sheet = $spreadsheet->getActiveSheet()
            ->setCellValue($x.'1', $request->col_name);
        
        $writer = new Csv($spreadsheet);
        $writer->save('csv/file.csv');

        return redirect()->route('csv.index')->with('success','Update Column succesfuly');
    }


}