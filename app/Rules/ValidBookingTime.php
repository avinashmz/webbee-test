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
    public function __construct(EventRepositoryInterface $eventRepository, BookingRepositoryInterface $bookingRepository)
    {
        $this->eventRepository = $eventRepository;
        $this->bookingRepository = $bookingRepository;

        $this->requestData = request()->all();

        $this->event = $this->eventRepository->find($this->requestData['event_id']);

    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value): bool
    {

        if(!$this->checkWithinEventDate()) return false;

        if(!$this->checkFutureBooking()) return false;

        if(!$this->checkMinimumTimeGap()) return false;

        if(!$this->checkSlotAvailable()) return false;

        if(!$this->checkWithinEventDate()) return false;

        if(!$this->checkWithinEventDate()) return false;

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
            default:
                $msg = 'Error in Slot Time.';
                break;
        }

        return $msg;
    }

    private function checkWithinEventDate(): bool
    {
        $startDate = Carbon::createFromFormat('Y-m-d H:i:s', $this->event->open_date);
        $endDate = Carbon::createFromFormat('Y-m-d H:i:s', $this->event->close_date);

        $slotTime = Carbon::createFromFormat('Y-m-d H:i:s', $this->requestData['slot_time'].':00');


        if($slotTime->between($startDate, $endDate)) {
            return true;
        } else {
            $this->errorCode = '1';
            return false;
        }
    }

    private function checkFutureBooking(): bool
    {
        $slotTime = Carbon::createFromFormat('Y-m-d H:i:s', $this->requestData['slot_time'].':00');
        $currentDate = Carbon::now();
        $diff = $slotTime->diffInDays($currentDate);

        if($diff > $this->event->future_day_max) {
            $this->errorCode = 2;
            return false;
        }

        return true;

    }

    private function checkMinimumTimeGap(): bool
    {
        $slotTime = Carbon::createFromFormat('Y-m-d H:i:s', $this->requestData['slot_time'].':00');
        $currentDate = Carbon::now();

        $diff = $slotTime->diffInMinutes($currentDate);


        if($diff < $this->event->minimum_time_gap) {
            $this->errorCode = 3;
            return false;
        }

        return true;
    }

    private function checkSlotAvailable(): bool
    {

        $slotTime = explode(' ', $this->requestData['slot_time']);

        $bookingCount = $this->bookingRepository->getBookingCountBySlot($this->requestData['event_id'], $slotTime[0], $slotTime[1]);

        if($bookingCount >= $this->event->booking_per_slot) {
            $this->errorCode = 4;
            return false;
        }

        return true;


    }

}
