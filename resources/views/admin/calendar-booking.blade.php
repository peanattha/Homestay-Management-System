@extends('layouts.admin')

@section('title', 'Calendar Booking')

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

<script type="text/javascript" src="{{ asset('fullcalendar/packages/core/main.js') }}"></script>

<script type="text/javascript" src="{{ asset('fullcalendar/packages/daygrid/main.js') }}"></script>

<link rel="stylesheet" href="{{ asset('fullcalendar/packages/core/main.css') }}">

<link rel="stylesheet" href="{{ asset('fullcalendar/packages/daygrid/main.css') }}">

@section('page-name')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb m-0">
            <li class="breadcrumb-item"><a href="{{ route('booking-admin') }}">รายการจอง</a></li>
            <li class="breadcrumb-item active" aria-current="page">ปฏิทินการจอง</li>
        </ol>
    </nav>
@endsection

@section('content')
    <div class="mt-4 mb-4">
        <div id='calendar' class="p-4 rounded-3 border border-1 shadow-lg"></div>
    </div>

    <div class="d-none">
        @foreach ($bookings as $booking)
            {{ $booking->promotion }}

            @foreach ($booking->booking_details as $booking_detail)
                {{ $booking_detail->homestay->homestay_name }}
            @endforeach
        @endforeach
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var calendarEl = document.getElementById('calendar');

            var events = [];
            var bookings = <?php echo json_encode($bookings); ?>;
            // console.log(bookings);

            for (let i = 0; i <= (bookings).length - 1; i++) {
                let homestay_name = "";
                for (let a = 0; a <= bookings[i].booking_details.length - 1; a++) {

                    if (a == bookings[i].booking_details.length - 1) {
                        homestay_name = homestay_name.concat(bookings[i].booking_details[a].homestay.homestay_name);
                    } else {
                        homestay_name = homestay_name.concat(bookings[i].booking_details[a].homestay.homestay_name,
                            ", ");
                    }
                }

                var event = {
                    "title": homestay_name,
                    "start": bookings[i].start_date,
                    "end": bookings[i].end_date,
                    "url": "{{ asset('booking-detail/') }}/" + bookings[i].id,
                };
                events.push(event);
                // console.log(events);
            }

            var calendar = new FullCalendar.Calendar(calendarEl, {
                plugins: ['dayGrid'],
                editable: true,
                eventLimit: true, // allow "more" link when too many events
                events
            });

            calendar.render();
        });
    </script>

@endsection
