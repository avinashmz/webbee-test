<?php

namespace App\Rules;

use Carbon\Carbon;
use App\Models\Booking;
use Illuminate\Contracts\Validation\Rule;
use App\Repository\EventRepositoryInterface;
use App\Repository\Eloquent\EventRepository;
use App\Repository\BookingRepositoryInterface;

class ValidBookingTime implements Rule
{

    private $eventRepository;
    private $bookingRepository;
    private $event;
    private $requestData;
    private $errorCode;

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct(
        EventRepositoryInterface $eventRepository,
        BookingRepositoryInterface $bookingRepository
    ) {
        $this->eventRepository   = $eventRepository;
        $this->bookingRepository = $bookingRepository;

        $this->requestData = request()->all();

        $this->event = $this->eventRepository->find($this->requestData['event_id']);

    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     *
     * @return bool
     */
    public function passes($attribute, $value): bool
    {

        if ( ! $this->checkWithinEventDate()) {
            return false;
        }

        if ( ! $this->checkValidSlotTime()) {
            return false;
        }

        if ( ! $this->checkFutureBooking()) {
            return false;
        }

        if ( ! $this->checkMinimumTimeGap()) {
            return false;
        }

        if ( ! $this->checkSlotAvailable()) {
            return false;
        }

        if ( ! $this->checkWithinEventDate()) {
            return false;
        }

        if ( ! $this->checkWithinEventDate()) {
            return false;
        }

        return true;

    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message(): string
    {

        switch ($this->errorCode) {
            case '1':
                $msg = 'You have selected date out of Event time range';
                break;
            case '2':
                $msg = 'You can book only '.$this->event->future_day_max.' days in future.';
                break;
            case '3':
                $msg = 'You are late, you need to book at least '.$this->event->minimum_time_gap.' minutes before the slot time begins.';
                break;
            case '4':
                $msg = 'All available seats are booked for this slot. Please try selecting another time slot.';
                break;
            case '5':
                $msg = 'Invalid slot start time. Each slot is '.$this->event->slot_duration.' minutes long.';
                break;
            case '6':
                $msg = 'Invalid slot time, its before the day start time ('.$this->event->day_start.').';
                break;
            case '7':
                $msg = 'Invalid slot time, its after the day end time ('.$this->event->day_end.').';
                break;
            case '8':
                $msg = 'Invalid slot time, You have selected a break time ('.$this->event->break_start.'-'.$this->event->break_end.')';
                break;
            default:
                $msg = 'Error in Slot Time.';
                break;
        }

        return $msg;
    }

    /**
     * Check if selected time slot is between open and close time for an event
     *
     * @return bool
     */
    private function checkWithinEventDate(): bool
    {

        // Return true when open and close date is not set. Means always open event
        if ($this->event->open_date === null && $this->event->close_date === null) {
            return true;
        }

        $startDate = Carbon::createFromFormat('Y-m-d H:i:s', $this->event->open_date);
        $endDate   = Carbon::createFromFormat('Y-m-d H:i:s', $this->event->close_date);

        $slotTime = Carbon::createFromFormat('Y-m-d H:i:s', $this->requestData['slot_time'].':00');


        if ($slotTime->between($startDate, $endDate)) {
            return true;
        } else {
            $this->errorCode = '1';

            return false;
        }
    }

    /**
     *
     * Check if provided slot start time is valid or not considering slot duration.
     *
     * @return bool
     */
    private function checkValidSlotTime(): bool
    {
        $slotTime = explode(' ', $this->requestData['slot_time']);

        if (isset($slotTime[1])) {
            $slotMinutes = explode(':',$slotTime[1])[1];

            // Check if selected slot time is correct based on slot duration
            if ($slotMinutes % $this->event->slot_duration != 0) {
                $this->errorCode = 5;

                return false;
            } else {

                $dayStart  = Carbon::createFromFormat('Y-m-d H:i', $slotTime[0].' '.$this->event->day_start);
                $dayEnd    = Carbon::createFromFormat('Y-m-d H:i', $slotTime[0].' '.$this->event->day_end);
                $slotStart = Carbon::createFromFormat('Y-m-d H:i', $this->requestData['slot_time']);

                $breakStart = Carbon::createFromFormat('Y-m-d H:i', $slotTime[0].' '.$this->event->break_start);
                $breakEnd   = Carbon::createFromFormat('Y-m-d H:i', $slotTime[0].' '.$this->event->break_end);


                // Checking if before day start time
                if ($dayStart->gt($slotStart)) {
                    $this->errorCode = 6;

                    return false;
                } elseif ($slotStart->gte($dayEnd)) {
                    // Checking if after date end time
                    $this->errorCode = 7;

                    return false;
                } elseif ($slotStart->between($breakStart, $breakEnd) && $slotTime[1] != $this->event->break_end) {

                    // Checking if in break time
                    $this->errorCode = 8;

                    return false;
                }

            }
        } else {
            $this->errorCode = 5;

            return false;
        }

        return true;
    }

    /**
     * Check if selected time slot is not too much in future as per set with event.
     *
     * @return bool
     */
    private function checkFutureBooking(): bool
    {
        $slotTime    = Carbon::createFromFormat('Y-m-d H:i:s', $this->requestData['slot_time'].':00');
        $currentDate = Carbon::now();
        $diff        = $slotTime->diffInDays($currentDate);

        if ($diff > $this->event->future_day_max) {
            $this->errorCode = 2;

            return false;
        }

        return true;

    }

    /**
     * Check if minimum gap required in event start is as per set in event
     *
     * @return bool
     */
    private function checkMinimumTimeGap(): bool
    {
        $slotTime    = Carbon::createFromFormat('Y-m-d H:i:s', $this->requestData['slot_time'].':00');
        $currentDate = Carbon::now();

        $diff = $slotTime->diffInMinutes($currentDate);


        if ($diff < $this->event->minimum_time_gap) {
            $this->errorCode = 3;

            return false;
        }

        return true;
    }

    /**
     * Check if quantity available for selected slot.
     *
     * @return bool
     */
    private function checkSlotAvailable(): bool
    {

        $slotTime = explode(' ', $this->requestData['slot_time']);

        $bookingCount = $this->bookingRepository->getBookingCountBySlot($this->requestData['event_id'], $slotTime[0],
            $slotTime[1]);

        if ($bookingCount >= $this->event->booking_per_slot) {
            $this->errorCode = 4;

            return false;
        }

        return true;


    }

}
