<?php

namespace App\Http\Resources;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Carbon;

class CalendarSummaryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
     * @return array|Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $content = <<<HTML
                <strong>Posted:</strong> {$this->posted}<br>
                <strong>Draft:</strong> {$this->draft}<br>
                <strong>Billable:</strong> {$this->billable}<br>
                <strong>Non-billable:</strong> {$this->non_billable}<br>
            HTML;

        return [
            'date' => Carbon::parse($this->entry_date)->format('Y-m-d'),
            'posted' => (float) $this->posted,
            'draft' => (float) $this->draft,
            'billable' => (float) $this->billable,
            'non_billable' => (float) $this->non_billable,
            // Retained for the legacy Livewire FullCalendar payload.
            'title' => $content,
            'start' => Carbon::parse($this->entry_date)->format('Y-m-d'),
        ];
    }
}
