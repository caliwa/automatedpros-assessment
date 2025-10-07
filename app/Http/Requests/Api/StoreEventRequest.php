<?php

namespace App\Http\Requests\Api;

use App\Data\EventData;
use Illuminate\Foundation\Http\FormRequest;

class StoreEventRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'date' => 'required|date|after:now',
            'location' => 'required|string|max:255',
        ];
    }
    
    public function toData(): EventData
    {
        return EventData::from($this);
    }
}