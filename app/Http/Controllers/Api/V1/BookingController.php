<?php


namespace App\Http\Controllers\Api\V1;

use App\Http\Requests\GetBookingsRequest;
use App\Http\Controllers\BaseController;
use App\Http\Requests\SaveBookingRequest;
use App\Repository\EventRepositoryInterface;
use App\Repository\BookingRepositoryInterface;
use Illuminate\Http\JsonResponse;
use App\Repository\CustomerRepositoryInterface;

class BookingController extends BaseController
{
    private $bookingRepository;
    private $eventRepository;
    private $customerRepository;

    /**
     * BookingController constructor.
     *
     * @param  EventRepositoryInterface  $eventRepository
     * @param  BookingRepositoryInterface  $bookingRepository
     * @param  CustomerRepositoryInterface  $customerRepository
     */
    public function __construct(
        EventRepositoryInterface $eventRepository,
        BookingRepositoryInterface $bookingRepository,
        CustomerRepositoryInterface $customerRepository
    ) {
        $this->eventRepository    = $eventRepository;
        $this->bookingRepository  = $bookingRepository;
        $this->customerRepository = $customerRepository;
    }


    /**
     * @param  GetBookingsRequest  $request
     *
     * @return JsonResponse
     */
    public function index(GetBookingsRequest $request): JsonResponse
    {
        $event = $this->eventRepository->find($request->input('event_id'), ['*'], ['bookings.customer']);

        return response()->json($event);
    }

    /**
     * @param  SaveBookingRequest  $request
     *
     * @return JsonResponse
     */
    public function store(SaveBookingRequest $request): JsonResponse
    {

        // Check Customer data and insert if new email else update
        $customer = $this->customerRepository->findByEmail($request->input('email'));

        $customerData = [
            'first_name' => $request->input('first_name'),
            'last_name'  => $request->input('last_name'),
            'email'      => $request->input('email'),
        ];

        $this->customerRepository->createOrUpdate($customer, $customerData);

        $timeSlot = explode(' ', $request->input('slot_time'));

        // Insert Booking Data
        $bookingData = [
            'event_id'    => $request->input('event_id'),
            'customer_id' => $customer->id,
            'date'        => $timeSlot[0],
            'start_time'  => $timeSlot[1]
        ];

        $this->bookingRepository->create($bookingData);
        $response = [
            'status'  => true,
            'message' => 'Booking accepted successfully.'
        ];

        return response()->json($response);
    }

}