<?php
namespace App\Services;

use App\Models\Entry;
use App\Models\SubMatter;
use Carbon\Carbon;

class EntryService
{
    public function getEntryByDate($param)
    {
        return Entry::query()
            ->where('entry_date', Carbon::parse($param))
            ->orderBy('created_at', 'desc')
            ->get()
            ->toArray();
    }

    public function create($timeEntry, $isDraft)
    {
        $entry = new Entry();
        $entry->client_id = $timeEntry['client_id'];

        $matter = SubMatter::find($timeEntry['sub_matter_id']);

        $timeEntry['matter_id'] = $matter->id;

        $entry->matter_id = $timeEntry['matter_id'];
        $entry->sub_matter_id = $timeEntry['sub_matter_id'];
        $entry->office_id = $timeEntry['office_id'];
        $entry->entry_date = $timeEntry['entry_date'];
        $entry->duration = $timeEntry['duration'];
        $entry->narrative = $timeEntry['narrative'];
        $entry->template_name = $timeEntry['template_name'];
        $entry->is_template = $timeEntry['is_template'] ?? null;
        $entry->is_draft = $isDraft;
        $entry->is_billable = $timeEntry['is_billable'];
        $entry->save();
    }
}
