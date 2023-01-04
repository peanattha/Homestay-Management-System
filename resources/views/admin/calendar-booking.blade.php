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

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var calendarEl = document.getElementById('calendar');
            var events = [];
            var bookings = @json($bookings);
            // console.log(bookings);

            for (const key in bookings) {
                let homestay_name = "";
                for (let i = 0; i <= bookings[key].length - 1; i++) {
                    if (i == bookings[key].length - 1) {
                        homestay_name = homestay_name.concat(bookings[key][i].homestay_name);
                        var event = {
                            "title": homestay_name,
                            "start": bookings[key][i].start_date,
                            "end": bookings[key][i].end_date,
                            "url": "{{ asset('booking-detail/') }}/" + bookings[key][i].id,
                        };
                        events.push(event);
                        // console.log(events);
                    } else {
                        homestay_name = homestay_name.concat(bookings[key][i].homestay_name, ", ");
                    }
                }
            }

            var calendar = new FullCalendar.Calendar(calendarEl, {
                plugins: ['dayGrid'],
                editable: true,
                eventLimit: true,
                events
            });
            calendar.render();
        });
    </script>

@endsection
