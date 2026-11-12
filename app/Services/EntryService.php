<?php

namespace App\Services;

use App\Models\Entry;
use App\Models\SubMatter;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

class EntryService
{
    public function getEntryByDate($param)
    {
        $date = Carbon::parse($param)->format('Y-m-d');

        return Entry::query()
            ->whereDate('entry_date', $date)
            ->where(function ($query) {
                $query->where('is_template', false)->orWhereNull('is_template');
            })
            ->orderBy('created_at', 'desc')
            ->get()
            ->toArray();
    }

    /**
     * Get daily duration totals for a calendar range.
     */
    public function getCalendarSummary(string $start, string $end): Collection
    {
        return Entry::query()
            ->select([
                DB::raw('SUM(CASE WHEN is_draft THEN duration ELSE 0 END) as draft'),
                DB::raw('SUM(CASE WHEN NOT is_draft THEN duration ELSE 0 END) as posted'),
                DB::raw('SUM(CASE WHEN is_billable THEN duration ELSE 0 END) as billable'),
                DB::raw('SUM(CASE WHEN NOT is_billable THEN duration ELSE 0 END) as non_billable'),
                'entry_date',
            ])
            ->whereBetween('entry_date', [$start, $end])
            ->where(function ($query) {
                $query->where('is_template', false)->orWhereNull('is_template');
            })
            ->groupBy('entry_date')
            ->orderBy('entry_date')
            ->get();
    }

    public function create(array $timeEntry, bool $isDraft): Entry
    {
        return $this->fillEntry(new Entry, $timeEntry, $isDraft);
    }

    public function update(Entry $entry, array $timeEntry, bool $isDraft): Entry
    {
        return $this->fillEntry($entry, $timeEntry, $isDraft);
    }

    private function fillEntry(Entry $entry, array $timeEntry, bool $isDraft): Entry
    {
        $subMatter = SubMatter::findOrFail($timeEntry['sub_matter_id']);

        $entry->client_id = $timeEntry['client_id'];
        $entry->matter_id = $subMatter->matter_id;
        $entry->sub_matter_id = $subMatter->id;
        $entry->office_id = $timeEntry['office_id'];
        $entry->entry_date = $timeEntry['entry_date'];
        $entry->duration = $timeEntry['duration'];
        $entry->narrative = $timeEntry['narrative'] ?? '';
        $entry->template_name = $timeEntry['template_name'] ?? null;
        $entry->is_template = $timeEntry['is_template'] ?? false;
        $entry->is_draft = $isDraft;
        $entry->is_billable = $timeEntry['is_billable'] ?? false;
        $entry->save();

        return $entry;
    }
}
