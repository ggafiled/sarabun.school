<?php

namespace App\Http\Controllers;

use App\AttachFiles;
use App\Document;
use App\Http\Requests\SendingDocumentRequest;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class DocumentController extends Controller
{
    public function storeFileAndData(Request $request){

        $document = new Document();
        $uploadedFile = $request->file('file');
        
        $document->document_no = $request->get('document_no');
        $document->title = $request->get('title');
        $document->source = $request->get('source');
        $document->destination = $request->get('destination');
        $document->note = $request->get('note');
        $document->document_created_at = $request->get('document_created_at');
        $document->document_type_id = $request->get('document_type_id');
        $document->user()->associate(auth()->user());
        $document->save();

        if(!empty($uploadedFile)) {
            foreach($uploadedFile as $file) { 
                $filename = Storage::putfile('public/images', $file);
                $extension = $file->getClientOriginalExtension();
                $filename = explode('.',basename($filename))[0];
                $document->attach_file()->create(['filename' => $filename, 'extension' => $extension,'document_id' => $document->id, 'originalname'=> $file->getClientOriginalName()]);
            }
        }

    }

    public function retrieveFile($filename)
    {
        $results = AttachFiles::where('filename',$filename)->first();
        if ($results != null){
            try{
                return response()->download(storage_path('/app/public/images/'.$results->filename.".".$results->extension),$results->originalname);
            }
            catch (Exception $e){
                return abort(403); 
            }
        }else{
            return abort(404);
        }
    }

    public function deleteFileAndData($documentid)
    {
        $resultsFile = AttachFiles::where('document_id',$documentid)->get();
        if($resultsFile != null){
            foreach($resultsFile as $file){
                unlink(storage_path('/app/public/images/'.$file->filename.".".$file->extension));
                $file->delete();
            }
        }
        Document::where('id',$documentid)->delete();
        return response()->json("Success");
    }

    public function sendingForm(Request $request)
    {
        return view('sending.sending')->with(['editmode' => filter_var($request->input('editmode'), FILTER_VALIDATE_BOOLEAN), 
        'document' => Document::where([['document_type_id','=',1],['id','=',filter_var($request->input('documentid'), FILTER_VALIDATE_INT)]])->with('attach_file')->with('user')->first(),
        'lastid' => Document::where('document_type_id',1)->orderBy('id', 'desc')->take(1)->first()->id+1]);
    }

    public function sendingSearchForm()
    {
        return view('sending.sending-search');
    }

    public function receivingForm(Request $request)
    {
        return view('receiving.receiving')->with(['editmode' => filter_var($request->input('editmode'), FILTER_VALIDATE_BOOLEAN), 
        'document' => Document::where([['document_type_id','=',2],['id','=',filter_var($request->input('documentid'), FILTER_VALIDATE_INT)]])->with('attach_file')->with('user')->first(),
        'lastid' => Document::where('document_type_id',2)->orderBy('id', 'desc')->take(1)->first()->id+1]);
    }

    public function receivingSearchForm()
    {
        return view('receiving.receiving-search');
    }
}