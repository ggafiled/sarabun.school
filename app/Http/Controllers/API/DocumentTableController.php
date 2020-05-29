<?php

namespace App\Http\Controllers\API;

use App\Document;
use DataTables;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class DocumentTableController extends Controller
{
    public function sending(Request $request)
    {
        $data = Document::where('document_type_id', 1)->with('attach_file')->with('user');
        // return response()->json(["recordsFiltered" => $data->count(),"recordsTotal" => $data->count(),"data" => $data]);
        return Datatables::of($data)->make(true);
    }

    public function receiving(Request $request)
    {
        $data = Document::where('document_type_id', 2)->with('attach_file')->with('user');
        // return response()->json(["recordsFiltered" => $data->count(),"recordsTotal" => $data->count(),"data" => $data]);
        return Datatables::of($data)->make(true);
    }
}