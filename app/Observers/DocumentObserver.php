<?php

namespace App\Observers;

use App\Document;
use App\Enums\DocumentType;

class DocumentObserver
{
    /**
     * Handle the document "created" event.
     *
     * @param  \App\Document  $document
     * @return void
     */
    public function created(Document $document)
    {
        //
    }

    /**
     * Handle the document "updated" event.
     *
     * @param  \App\Document  $document
     * @return void
     */
    public function updated(Document $document)
    {
        //
    }

    /**
     * Handle the document "deleted" event.
     *
     * @param  \App\Document  $document
     * @return void
     */
    public function deleted(Document $document)
    {
    }

    /**
     * Handle the document "restored" event.
     *
     * @param  \App\Document  $document
     * @return void
     */
    public function restored(Document $document)
    {
        //
    }

    /**
     * Handle the document "force deleted" event.
     *
     * @param  \App\Document  $document
     * @return void
     */
    public function forceDeleted(Document $document)
    {
        //
    }

    public function creating (Document $document)
    {
        switch($document->document_type_id){
            case DocumentType::Sending:
                $document->run_no = $document->getDocumentLastIdFor(DocumentType::Sending);
                break;
            case DocumentType::Receiving:
                $document->run_no = $document->getDocumentLastIdFor(DocumentType::Receiving);
                break;
            case DocumentType::Command:
                $document->run_no = $document->getDocumentLastIdFor(DocumentType::Command);
                break;
            case DocumentType::Memorandum:
                $document->run_no = $document->getDocumentLastIdFor(DocumentType::Memorandum);
                break;
            default:
                return;
        }
    }
}