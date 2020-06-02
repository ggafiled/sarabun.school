<?php

namespace App\Http\Controllers\API;

use App\Document;
use App\User;
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
        return Datatables::of($data)->make(true);
    }

    public function command(Request $request)
    {
        $data = Document::where('document_type_id', 3)->with('attach_file')->with('user');
        return Datatables::of($data)->make(true);
    }

    public function memorandum(Request $request)
    {
        $data = Document::where('document_type_id', 4)->with('attach_file')->with('user');
        return Datatables::of($data)->make(true);
    }

    public function usercontent(Request $request)
    {
        $data = User::all();
        return Datatables::of($data)->addColumn('status', function($data){
            if($data->isOnline()){
                return "<i class='fas fa-circle text-success'> กำลังใช้งาน </i>";
            }else{
                return "<i class='fas fa-circle text-secondary'> ไม่ได้ใช้งาน </i>";
            }
        })->rawColumns(['status'])->make(true);
    }

    public function getSendingLastId()
    {
        $lastid = Document::where('document_type_id',1)->orderBy('run_no', 'desc')->first();
        if($lastid!=null) {
            $lastid = $lastid->run_no + 1;
        }else {
            $lastid = 1;
        }
        return response()->json($lastid);
    }

    public function getReceivingLastId()
    {
        $lastid = Document::where('document_type_id',2)->orderBy('run_no', 'desc')->first();
        if($lastid!=null) {
            $lastid = $lastid->run_no + 1;
        }else {
            $lastid = 1;
        }
        return response()->json($lastid);
    }

    public function getCommandLastId()
    {
        $lastid = Document::where('document_type_id',3)->orderBy('run_no', 'desc')->first();
        if($lastid!=null) {
            $lastid = $lastid->run_no + 1;
        }else {
            $lastid = 1;
        }
        return response()->json($lastid);
    }

    public function getMemorandumLastId()
    {
        $lastid = Document::where('document_type_id',4)->orderBy('run_no', 'desc')->first();
        if($lastid!=null) {
            $lastid = $lastid->run_no + 1;
        }else {
            $lastid = 1;
        }
        return response()->json($lastid);
    }
}