<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Carbon;

class CalendarSummaryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
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
            'title' => $content,
            'start' => Carbon::parse($this->entry_date)->format('Y-m-d'),
        ];
    }
}
