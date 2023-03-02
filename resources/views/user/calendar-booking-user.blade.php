@extends('layouts.user')

@section('calendar-booking-user', 'active')

@section('title', 'Calendar Booking')

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

<script type="text/javascript" src="{{ asset('fullcalendar/packages/core/main.js') }}"></script>

<script type="text/javascript" src="{{ asset('fullcalendar/packages/daygrid/main.js') }}"></script>

<link rel="stylesheet" href="{{ asset('fullcalendar/packages/core/main.css') }}">

<link rel="stylesheet" href="{{ asset('fullcalendar/packages/daygrid/main.css') }}">

@section('page-name')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb m-0">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">หน้าหลัก</a></li>
            <li class="breadcrumb-item active" aria-current="page">ปฏิทินการจอง</li>
        </ol>
    </nav>
@endsection

@section('content')
    <div class="container mt-4">
        <div class="card rounded-3 border border-1 shadow-lg">
            <div class="card-header">
                ค้นหาโฮมสเตย์
            </div>
            <div class="card-body">
                <form action="{{ route('search-calendar-user') }}" method="GET">
                    @csrf
                    <div class="mb-3">
                        <label for="dateRange" class="form-label">เลือกบ้านพัก *</label>
                        <select class="form-select" aria-label="Default select example" name="homestay_filter">
                            <?php
                            $homstay_ids = [];
                            ?>
                            @foreach ($homestays as $homestay)
                                <option value="{{ $homestay->id }}">{{ $homestay->homestay_name }}</option>
                                <?php
                                array_push($homstay_ids, $homestay->id);
                                ?>
                            @endforeach
                            <option value="{{ implode(',', $homstay_ids) }}" selected>บ้านพักทั้งหมด</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-success">
                        <i class='bx bx-search'></i>
                        ค้นหา
                    </button>
                </form>
            </div>
        </div>
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
                                "end": bookings[key][i].end_date
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
    </div>
@endsection
