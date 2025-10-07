<?php

namespace App\Http\Requests\Api;

use App\Data\EventData;
use Illuminate\Foundation\Http\FormRequest;

class UpdateEventRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => 'sometimes|required|string|max:255',
            'description' => 'sometimes|required|string',
            'date' => 'sometimes|required|date|after:now',
            'location' => 'sometimes|required|string|max:255',
        ];
    }

    public function toData(): EventData
    {
        return EventData::from($this);
    }
}