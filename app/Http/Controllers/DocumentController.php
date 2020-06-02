<?php

namespace App\Http\Controllers;

use Exception;
use App\AttachFiles;
use App\Document;
use App\Http\Requests\SendingDocumentRequest;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class DocumentController extends Controller
{
    public function storeFileAndData(Request $request){

        if((bool) $request->get("editmode") == true){  
            $uploadedFile = $request->file('file');      
            $document = Document::where(['id' => $request->get('id'),'document_type_id' => $request->get('document_type_id')])->first();
            $document->update([
                'document_no' => $request->get('document_no'),
                'title' => $request->get('title'),
                'source' => $request->get('source'),
                'destination' => $request->get('destination'),
                'note' => $request->get('note'),
                'user_id' => $request->get('user'),
                'document_created_at' => $request->get('document_created_at'),
            ]);
        }else {
            $uploadedFile = $request->file('file');
            $document = new Document();   
            $document->run_no = $request->get('run_no');
            $document->document_no = $request->get('document_no');
            $document->title = $request->get('title');
            $document->source = $request->get('source');
            $document->destination = $request->get('destination');
            $document->note = $request->get('note');
            $document->document_created_at = $request->get('document_created_at');
            $document->document_type_id = $request->get('document_type_id');
            $document->user()->associate(auth()->user());
            $document->save();
        }

        if(!empty($uploadedFile)) {
            foreach($uploadedFile as $file) { 
                $filename = Storage::putfile('public/images', $file);
                $extension = explode('.',basename($filename))[1];
                $filename = explode('.',basename($filename))[0];
                $size = $file->getSize();
                $document->attach_file()->create(['filename' => $filename, 'extension' => $extension,'document_id' =>  $document->id, 'originalname'=> $file->getClientOriginalName(),'size' => $size]);
            }
        }

    }

    public function retrieveFile($filename)
    {
        $results = AttachFiles::where('filename',$filename)->first();
        if ($results != null){
            try{
                if(Str::lower($results->extension) == "pdf"){
                    $path = storage_path('/app/public/images/'.$results->filename.".".$results->extension);
                    $headers = ['Content-Disposition' => 'inline; filename="'.$results->originalname.".".$results->extension.'"',
                    'Content-Type' => 'application/pdf'];
                    return response()->download($path,$results->originalname.".".$results->extension, $headers, 'inline');
                }else{
                    $path = storage_path('/app/public/images/'.$results->filename.".".$results->extension);
                    $headers = [];
                    return response()->download($path,$results->originalname.".".$results->extension, $headers, 'inline');
                }
            }
            catch (Exception $e){
                return abort(403); 
            }
        }else{
            return abort(404);
        }
    }

    public function renameFile(Request $request)
    {
        $resultsFile = AttachFiles::where('id',$request->fileid)->first();
        if($resultsFile != null){
            $resultsFile->update([
                'originalname' => $request->newname
            ]);
            return response()->json("Success");
        }else {
            return abort(401, "File Not Found!");
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

    public function deleteFile($fileid)
    {
        $resultsFile = AttachFiles::where('id',$fileid)->first();
        if($resultsFile != null){
            unlink(storage_path('/app/public/images/'.$resultsFile->filename.".".$resultsFile->extension));
            $resultsFile->delete();
            return response()->json("Success");
        }else {
            return abort(401, "File Not Found!");
        }
    }

    public function sendingForm(Request $request)
    {
        return view('sending.sending')->with(['editmode' => filter_var($request->input('editmode'), FILTER_VALIDATE_BOOLEAN), 
        'document' => Document::where([['document_type_id','=',1],['id','=',filter_var($request->input('documentid'), FILTER_VALIDATE_INT)]])->with('attach_file')->with('user')->first()]);
    }

    public function sendingSearchForm()
    {
        return view('sending.sending-search');
    }

    public function receivingForm(Request $request)
    {
        return view('receiving.receiving')->with(['editmode' => filter_var($request->input('editmode'), FILTER_VALIDATE_BOOLEAN), 
        'document' => Document::where([['document_type_id','=',2],['id','=',filter_var($request->input('documentid'), FILTER_VALIDATE_INT)]])->with('attach_file')->with('user')->first()]);
    }

    public function receivingSearchForm()
    {
        return view('receiving.receiving-search');
    }

    public function commandForm(Request $request)
    {
        return view('command.command')->with(['editmode' => filter_var($request->input('editmode'), FILTER_VALIDATE_BOOLEAN), 
        'document' => Document::where([['document_type_id','=',3],['id','=',filter_var($request->input('documentid'), FILTER_VALIDATE_INT)]])->with('attach_file')->with('user')->first()]);
    }

    public function commandSearchForm()
    {
        return view('command.command-search');
    }

    public function memorandumForm(Request $request)
    {
        return view('memorandum.memorandum')->with(['editmode' => filter_var($request->input('editmode'), FILTER_VALIDATE_BOOLEAN), 
        'document' => Document::where([['document_type_id','=',4],['id','=',filter_var($request->input('documentid'), FILTER_VALIDATE_INT)]])->with('attach_file')->with('user')->first()]);
    }

    public function memorandumSearchForm()
    {
        return view('memorandum.memorandum-search');
    }

}