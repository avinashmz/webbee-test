<?php

namespace App\Http\Requests;

use App\Rules\ValidBookingTime;
use Illuminate\Foundation\Http\FormRequest;
use App\Repository\EventRepositoryInterface;
use App\Repository\BookingRepositoryInterface;

class SaveBookingRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @param  EventRepositoryInterface  $eventRepository
     * @param  BookingRepositoryInterface  $bookingRepository
     *
     * @return array
     */
    public function rules(EventRepositoryInterface $eventRepository, BookingRepositoryInterface $bookingRepository): array
    {
        return [
            'event_id' => 'required',
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email',
            'slot_time' => ['required', 'date_format:Y-m-d H:i', new ValidBookingTime($eventRepository, $bookingRepository)]
        ];
    }
}
