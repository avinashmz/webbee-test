<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400"></a></p>



## Setup

- Clone the repository
- setup .env file with required database details
- run `php artisan migrate:fresh --seed` command

Above command will insert one event.

## API Details

### 1) Get Booking Details

API to get all booking details for given event.

**Method**: Get

**URL**: /api/v1/bookings

**Params**:

event_id

### 2) Get Booking Details

API to save new Booking.

**Method**: POST

**URL**: /api/v1/store-booking

**Params**:

event_id

first_name

last_name

email

slot_time **(YYYY-MM-DD HH:II)**