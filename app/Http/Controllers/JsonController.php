<?php

namespace App\Http\Controllers;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Storage;

use function PHPSTORM_META\type;

class JsonController extends Controller
{
    public function index()
    {
        $if_exist = Storage::disk('public')->exists('json/file.json');
        if(!$if_exist || filesize(public_path('json/file.json')) == 0 ) {
            $is_empty = true;      

            return view('json.index',compact('is_empty'));
        }

        $yhy = file_get_contents(public_path('json/file.json'));
        $data = json_decode($yhy, true);
        if($data) {
            $yahy = $data[0];
            $information = [];
            $i = 0;
            foreach ($yahy as $key => $val) {
                $information[++$i] = $key;
            }

            $data = $this->paginate($data);
            $data->withPath('');
            
                    // dd((($data[0])));
            $is_empty = false;
            return view('json.index', compact('data', 'information','is_empty'));

        }
        $is_empty = true;      

        return view('json.index',compact('is_empty'));

    }

    public function paginate($items, $perPage = 15, $page = null, $options = [])
    {
        $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);
        $items = $items instanceof Collection ? $items : Collection::make($items);
        return new LengthAwarePaginator($items->forPage($page, $perPage), $items->count(), $perPage, $page, $options);
    }


    public function create()
    {
        $yhy = file_get_contents(public_path('json/file.json'));
        $data = json_decode($yhy, true);
        $data = $data[1];

        $information = [];
        $i = 0;
        foreach ($data as $key => $val) {
            $information[$i++] = $key;
        }
        return view('json.create', compact('information'));
    }

    public function store(Request $request)
    {
        $yhy = file_get_contents(public_path('json/file.json'));
        $items = json_decode($yhy, true);
        $count = count($items);
        $i = 0;
        foreach ($items[1] as $key => $val) {
            $information[$i++] = $key;
        }
        for ($i = 0; $i < count($information); $i++) {
            $items[$count][(string)$information[$i]]  = $request[(string)$information[$i]];
        }
        file_put_contents('json/file.json', json_encode($items));

        return redirect()->route('json.index')->with('success','Create a new record succesfuly');
    }

    public function destroy($id)
    {
        $yhy = file_get_contents(public_path('json/file.json'));
        $items = json_decode($yhy, true);
        array_splice($items, $id, 1);

        $items = json_encode($items, JSON_PRETTY_PRINT);
        file_put_contents('json/file.json', $items);

        return redirect()->route('json.index');
    }

    public function edit($id)
    {
        $yhy = file_get_contents(public_path('json/file.json'));
        $data = json_decode($yhy, true);
        $data = $data[$id];

        $information = [];
        $i = 0;
        foreach ($data as $key => $val) {
            $information[++$i] = $key;
        }
        return view('json.edit', compact('information', 'data', 'id'));
    }

    public function update(Request $request, $id)
    {
        $yhy = file_get_contents(public_path('json/file.json'));
        $items = json_decode($yhy, true);
        $i = 0;
        foreach ($items[$id] as $key => $val) {
            $information[$i++] = $key;
        }

        for ($i = 0; $i < count($information); $i++) {
            $items[$id][(string)$information[$i]]  = $request[(string)$information[$i]];
        }
        file_put_contents('json/file.json', json_encode($items));

        return redirect()->route('json.index')->with('success','Updated succesfuly');
    }

    public function uploadfromlink(Request $request)
    {
        if(!$request->json) {
            return redirect()->route('json.index');
        }

        $json = file_get_contents((string)$request->json);


        if($json) {
            unlink('json/file.json');
            $json = json_decode($json);
            $items = json_encode($json, JSON_PRETTY_PRINT);

            file_put_contents(public_path('json/file.json'), $items);

        }
        return redirect()->route('json.index');

    }

    public function download()
    {
         $filename = Date('Y-m-d').'file.json';

        return response()->download(public_path('json/file.json'), $filename );
    }

    public function uploadfile(Request $request)
    {
        $request->validate([
            'file' => ['required','mimes:json'],
        ]);

        if(!$request->hasFile('file')) {
            return;
        }
        Storage::disk('public')->delete('json/file.json');

        $file = $request->file('file');

        $path = $file->storeAs('', 'json/file.json', [
                'disk' => 'public'
        ]);
        
        return redirect()->route('json.index');
    }

}
