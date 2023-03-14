<?php

namespace App\Http\Controllers;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Pagination\Factory;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;

class XmlController extends Controller
{
    public function index()
    {
        $if_exist = Storage::disk('public')->exists('xml/file.xml');
        if(!$if_exist || filesize(public_path('xml/file.xml')) == 0 ) {
            $is_empty = true;
            return view('xml.index',compact('is_empty'));
        }
        $xml = simplexml_load_file(public_path('xml/file.xml'));
        if($xml) {

            $parent = $xml->children()->getName();
            $information=[];
                $i=0;
            foreach($xml->children()->children() as $child)
            {
                $information[++$i] =$child->getName() ;
            }

            $objJsonDocument = json_encode($xml);

            $arrOutput = json_decode($objJsonDocument, TRUE);

            $arrOutput = $this->paginate($arrOutput[$parent]);
            $arrOutput->withPath('');
            $is_empty = false;
            // $vgv= ($arrOutput['product'][0]['category']);
            // dd(json_encode($vgv));

            return view('xml.index',compact('information','parent','arrOutput','is_empty'));
        }
        $is_empty = true;
        return view('xml.index',compact('is_empty'));

        
    }
    public function paginate($items, $perPage = 15, $page = null, $options = [])
    {
        $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);
        $items = $items instanceof Collection ? $items : Collection::make($items);
        return new LengthAwarePaginator($items->forPage($page, $perPage), $items->count(), $perPage, $page, $options);
    }
    public function destroy($id)
    {
        $xml = simplexml_load_file(public_path('xml/file.xml'));
        $parent = $xml->children()->getName();

        unset($xml->$parent[(int)$id]);
        file_put_contents('xml/file.xml', $xml->asXML());

        return redirect()->route('xml.index');
    }


    public function create()
    {
        $xml = simplexml_load_file(public_path('xml/file.xml'));

        $parent = $xml->children()->getName();
        $information=[];
        $i=0;

        foreach($xml->children()->children() as $child)
        {
            $information[++$i] =$child->getName() ;
        }
        return view('xml.create',compact('information'));
    }
    public function store(Request $request)
    {
        $xml = simplexml_load_file(public_path('xml/file.xml'));
        $parent = $xml->children()->getName();

        $information=[];
        $i=0;
        foreach($xml->children()->children() as $child)
        {
            $information[++$i] =$child->getName() ;
        }

        $item = $xml->addChild($parent);
        for ($i=1; $i <= count($information) ; $i++) {
            $index = $information[$i] ;
            $item->addChild($index, $request->$index);
        }

        file_put_contents('xml/file.xml', $xml->asXML());
        return redirect()->route('xml.index')->with('success','Create a new record succesfuly');;

    }


    public function edit($id)
    {
        $xml = simplexml_load_file(public_path('xml/file.xml'));
        $parent = $xml->children()->getName();

        $item = $xml->$parent[(int)$id];

        $parent = $xml->children()->getName();

        $information=[];
        $i=0;

        foreach($xml->children()->children() as $child)
        {
            $information[++$i] =$child->getName() ;
        }

        return view('xml.edit',compact('information','item','id'));

    }

    public function update(Request $request, $id)
    {
        $xml = simplexml_load_file(public_path('xml/file.xml'));
        $parent = $xml->children()->getName();

        $information=[];
        $i=0;
        foreach($xml->children()->children() as $child)
        {
            $information[++$i] =$child->getName() ;
        }

        for ($i=1; $i <= count($information) ; $i++) {
             $index = $information[$i] ;
            $xml->$parent[(int)$id]->$index = $request->$index;
        }

        file_put_contents('xml/file.xml', $xml->asXML());



        return redirect()->route('xml.index')->with('success','Updated succesfuly');;

    }

    public function uploadfromlink(Request $request)
    {
        if(!$request->xml) {
            return redirect()->route('xml.index');
        }

        $respo = file_get_contents((string)$request->xml);
        if($respo) {
            file_put_contents( public_path('xml/file.xml'), '');
            // dd(0);

            file_put_contents('xml/file.xml', $respo);
        }
        return redirect()->route('xml.index');

    }

    public function download()
    {
         $filename = Date('Y-m-d').'file.xml';

        return response()->download(public_path('xml/file.xml'), $filename );
        return redirect()->route('xml.index');
    }

    public function uploadfile(Request $request)
    {
        $request->validate([
            'file' => ['required','mimes:xml'],
        ]);

        if(!$request->hasFile('file')) {
            return;
        }

        Storage::disk('public')->delete('xml/file.xml');

        $file = $request->file('file');
        $path = $file->storeAs('', 'xml/file.xml', [
                'disk' => 'public'
        ]);
        
        
        return redirect()->route('xml.index');

    }

}