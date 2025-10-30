<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreHuntingBookingRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }


    public function rules(): array
    {
        return [
            'tour_name'          => ['required', 'string', 'max:255'],
            'hunter_name'        => ['required', 'string', 'max:255'],
            'guide_id'           => ['required', 'integer', 'exists:guides,id'],
            'date'               => ['required', 'date_format:Y-m-d', 'after_or_equal:today'],
            'participants_count' => ['required', 'integer', 'min:1', 'max:10'],
        ];
    }


    public function messages(): array
    {
        return [
            'date.after_or_equal'    => 'Дата бронирования не может быть в прошлом.',
            'participants_count.max' => 'Максимум 10 участников на одно бронирование.',
        ];
    }
}
