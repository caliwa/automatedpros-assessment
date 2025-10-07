<?php

namespace App\Http\Requests\Api;

use App\Data\TicketData;
use Illuminate\Foundation\Http\FormRequest;

class StoreTicketRequest extends FormRequest
{
    public function authorize(): bool
    {
        $event = $this->route('event');
        return $this->user()->can('update', $event);
    }

    public function rules(): array
    {
        return [
            'type' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'quantity' => 'required|integer|min:1',
        ];
    }

    public function toData(): TicketData
    {
        return TicketData::from($this);
    }
}