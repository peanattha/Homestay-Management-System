@extends('layouts.admin')

@section('title', 'homestay Admin')

<link rel="stylesheet" href="{{ asset('css/table.css') }}">

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

<link rel="stylesheet" href="{{ asset('css/calendar.css') }}">
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

<script type="text/javascript" src="{{ asset('js/manage-homestay.js') }}"></script>
@section('page-name')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb m-0">
            <li class="breadcrumb-item active" aria-current="page">รายการที่พัก</li>
        </ol>
    </nav>
@endsection
@section('content')
    <div>
        <div class="row">
            <div class="col-md-12">
                <div class="content w-100">
                    <div class="calendar-container">
                        <div class="calendar">
                            <div class="year-header">
                                <span class="left-button fa fa-chevron-left" id="prev"> </span>
                                <span class="year" id="label"></span>
                                <span class="right-button fa fa-chevron-right" id="next"> </span>
                            </div>
                            <table class="months-table w-100">
                                <tbody>
                                    <tr class="months-row">
                                        <td class="month">Jan</td>
                                        <td class="month">Feb</td>
                                        <td class="month">Mar</td>
                                        <td class="month">Apr</td>
                                        <td class="month">May</td>
                                        <td class="month">Jun</td>
                                        <td class="month">Jul</td>
                                        <td class="month">Aug</td>
                                        <td class="month">Sep</td>
                                        <td class="month">Oct</td>
                                        <td class="month">Nov</td>
                                        <td class="month">Dec</td>
                                    </tr>
                                </tbody>
                            </table>

                            <table class="days-table w-100">
                                <td class="day">Sun</td>
                                <td class="day">Mon</td>
                                <td class="day">Tue</td>
                                <td class="day">Wed</td>
                                <td class="day">Thu</td>
                                <td class="day">Fri</td>
                                <td class="day">Sat</td>
                            </table>
                            <div class="frame">
                                <table class="dates-table w-100">
                                    <tbody class="tbody">
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="events-container">
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="d-none">
        @foreach ($bookings as $booking)
            {{ $booking->promotion }}

            @foreach ($booking->booking_details as $booking_detail)
                {{ $booking_detail->homestay->homestay_name }}
            @endforeach
        @endforeach
    </div>

    <script type="text/javascript">
        // Setup the calendar with the current date
        $(document).ready(function() {
            var date = new Date();
            var today = date.getDate();
            // Set click handlers for DOM elements
            $(".right-button").click({
                date: date
            }, next_year);
            $(".left-button").click({
                date: date
            }, prev_year);
            $(".month").click({
                date: date
            }, month_click);
            // Set current month as active
            $(".months-row")
                .children()
                .eq(date.getMonth())
                .addClass("active-month");
            init_calendar(date);
            var events = check_events(
                today,
                date.getMonth() + 1,
                date.getFullYear()
            );
            show_events(events, months[date.getMonth()], today);
        });

        // Initialize the calendar by appending the HTML dates
        function init_calendar(date) {
            $(".tbody").empty();
            $(".events-container").empty();
            var calendar_days = $(".tbody");
            var month = date.getMonth();
            var year = date.getFullYear();
            var day_count = days_in_month(month, year);
            var row = $("<tr class='table-row'></tr>");
            var today = date.getDate();
            // Set date to 1 to find the first day of the month
            date.setDate(1);
            var first_day = date.getDay();
            // 35+firstDay is the number of date elements to be added to the dates table
            // 35 is from (7 days in a week) * (up to 5 rows of dates in a month)
            for (var i = 0; i < 35 + first_day; i++) {
                // Since some of the elements will be blank,
                // need to calculate actual date from index
                var day = i - first_day + 1;
                // If it is a sunday, make a new row
                if (i % 7 === 0) {
                    calendar_days.append(row);
                    row = $("<tr class='table-row'></tr>");
                }
                // if current index isn't a day in this month, make it blank
                if (i < first_day || day > day_count) {
                    var curr_date = $("<td class='table-date nil'>" + "</td>");
                    row.append(curr_date);
                } else {
                    var curr_date = $("<td class='table-date'>" + day + "</td>");
                    var events = check_events(day, month + 1, year);
                    if (today === day && $(".active-date").length === 0) {
                        curr_date.addClass("active-date");
                        show_events(events, months[month], day);
                    }
                    // If this date has any events, style it with .event-date
                    if (events.length !== 0) {
                        // curr_date.addClass("event-date");
                    }
                    // Set onClick handler for clicking a date
                    curr_date.click({
                            events: events,
                            month: months[month],
                            day: day
                        },
                        date_click
                    );
                    row.append(curr_date);
                }
            }
            // Append the last row and set the current year
            calendar_days.append(row);
            $(".year").text(year);
        }

        // Get the number of days in a given month/year
        function days_in_month(month, year) {
            var monthStart = new Date(year, month, 1);
            var monthEnd = new Date(year, month + 1, 1);
            return (monthEnd - monthStart) / (1000 * 60 * 60 * 24);
        }

        // Event handler for when a date is clicked
        function date_click(event) {
            $(".events-container").show(250);
            $("#dialog").hide(250);
            $(".active-date").removeClass("active-date");
            $(this).addClass("active-date");
            show_events(event.data.events, event.data.month, event.data.day);
        }

        // Event handler for when a month is clicked
        function month_click(event) {
            $(".events-container").show(250);
            $("#dialog").hide(250);
            var date = event.data.date;
            $(".active-month").removeClass("active-month");
            $(this).addClass("active-month");
            var new_month = $(".month").index(this);
            date.setMonth(new_month);
            init_calendar(date);
        }

        // Event handler for when the year right-button is clicked
        function next_year(event) {
            $("#dialog").hide(250);
            var date = event.data.date;
            var new_year = date.getFullYear() + 1;
            $("year").html(new_year);
            date.setFullYear(new_year);
            init_calendar(date);
        }

        // Event handler for when the year left-button is clicked
        function prev_year(event) {
            $("#dialog").hide(250);
            var date = event.data.date;
            var new_year = date.getFullYear() - 1;
            $("year").html(new_year);
            date.setFullYear(new_year);
            init_calendar(date);
        }

        // Display all events of the selected date in card views
        function show_events(events, month, day) {
            // Clear the dates container
            $(".events-container").empty();
            $(".events-container").show(250);
            console.log(event_data["events"]);
            // If there are no events for this date, notify the user
            if (events.length === 0) {
                var event_card = $("<div class='event-card'></div>");
                var event_name = $(
                    "<div class='event-name'>" + day + " " + month + " บ้านพักว่างทุกหลัง.</div>"
                );
                $(event_card).css({
                    "border-left": "10px solid #FF1744"
                });
                $(event_card).append(event_name);
                $(".events-container").append(event_card);
            } else {
                // Go through and add each event as a card to the events container
                for (var i = 0; i < events.length; i++) {
                    var event_card = $("<div class='event-card'></div>");
                    var event_name = $(
                        "<div class='event-name'>บ้านพัก : </div>"
                    );
                    var event_count = $(
                        "<div class='event-count'>" +
                        events[i]["homestay_name"] +
                        " </div>"
                    );
                    $(event_card).append(event_name).append(event_count);
                    $(".events-container").append(event_card);
                }
            }
        }

        // Checks if a specific date has any events
        function check_events(day, month, year) {
            var events = [];
            for (var i = 0; i < event_data["events"].length; i++) {
                var event = event_data["events"][i];
                if (
                    event["day"] === day &&
                    event["month"] === month &&
                    event["year"] === year
                ) {
                    events.push(event);
                }
            }
            return events;
        }

        // Given data for events in JSON format
        var event_data = {
            events: []
        };

        const months = [
            "January",
            "February",
            "March",
            "April",
            "May",
            "June",
            "July",
            "August",
            "September",
            "October",
            "November",
            "December",
        ];

        $bookings = <?php echo json_encode($bookings); ?>
        // const bookings = ("<?php echo json_encode($bookings); ?>");

        Object.keys($bookings).forEach(key => {
            console.log(key, $bookings[key]);
        });


        let n = 0;
        for (let i = 0; i <= ($bookings).length - 1; i++) {
            var result = "";
            var myArray = $bookings[i].start_date.split("-");
            for (let a = 0; a <= $bookings[i].booking_details.length - 1; a++) {

                var event = {
                    "homestay_name": $bookings[i].booking_details[a].homestay.homestay_name,
                    "year": parseInt(myArray[0]),
                    "month": parseInt(myArray[1]),
                    "day": parseInt(myArray[2])
                };
                event_data["events"].push(event);
            }

        }
    </script>



    {{-- Alert Message --}}
    @if (Session::has('message'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ Session::get('message') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    @if (Session::has('warning'))
        <div class="alert alert-warning alert-dismissible fade show" role="alert">
            {{ Session::get('warning') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    {{-- Model Delete homestay --}}
    <div class="modal fade" id="modal-del-homestay" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">แจ้งเตือน</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="textModelDelhomestay"></div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success" onclick="confirmDelhomestay()">ยืนยัน</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ยกเลิก</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modal-search-none" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">แจ้งเตือน</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="textModelSearchNone">ไม่มีรายการตรงกับที่คุณค้นหา</div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ยืนยัน</button>
                </div>
            </div>
        </div>
    </div>
    <div class="card rounded-3 border border-1 shadow-lg">
        <div class="card-header">
            รายการที่พัก
        </div>
        <div class="card-body">
            <form action="{{ route('search-homestay-admin') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="mb-3">
                    <label for="homestay" class="form-label">ค้นหารายการที่พัก</label>
                    <input type="text" class="form-control" id="homestay" name="homestay_name"
                        placeholder="ชื่อที่พัก">
                    <div id="help" class="form-text">กรอกชื่อที่พักเพื่อทำการค้นหารายการที่พัก</div>
                </div>
                <div class="mb-3">
                    <input type="text" class="form-control" id="homestay" name="homestay_type"
                        placeholder="ชื่อประเภทที่พัก">
                    <div id="help" class="form-text">กรอกชื่อประเภทที่พักเพื่อทำการค้นหารายการที่พัก</div>
                </div>
                <button type="submit" class="btn btn-success">
                    <i class='bx bx-search'></i>
                    ค้นหา
                </button>
            </form>
        </div>
    </div>

    <div class="table100 ver2 mb-4 mt-4">
        <div class="table100-head">
            <table>
                <thead>
                    <tr>
                        <th style="width: 5%">ลำดับ</th>
                        <th style="width: 20%">ชื่อที่พัก</th>
                        <th style="width: 20%">ประเภทที่พัก</th>
                        <th style="width: 15%">สถานะ</th>
                        <th style="width: 25%">รายละเอียด / แก้ไข</th>
                        <th style="width: 10%">ลบที่พัก</th>
                    </tr>
                </thead>
            </table>
        </div>
        <div class="table100-body js-pscroll">
            <table>
                <tbody>
                    @foreach ($homestays as $homestay)
                        <tr>
                            <td style="width: 5%">{{ $loop->iteration }}</td>
                            <td style="width: 20%">{{ $homestay->homestay_name }}</td>
                            <td style="width: 20%">{{ $homestay->homestay_type->homestay_type_name }}</td>
                            @if ($homestay->status == 1)
                                <td style="width: 15%">ใช้งาน</td>
                            @elseif ($homestay->status == 2)
                                <td style="width: 15%">ปรับปรุง</td>
                            @else
                                <td style="width: 15%">ยกเลิกใช้งาน</td>
                            @endif
                            <td style="width: 25%"><a class="btn btn-primary"
                                    href="{{ route('homestay-details-admin', ['id' => $homestay->id]) }}">รายละเอียด /
                                    แก้ไข</a>
                            </td>
                            <td style="width: 10%">
                                <form action="{{ route('delete-homestay', ['id' => $homestay->id]) }}" method="POST"
                                    id="del-homestay{{ $homestay->id }}" class="m-0">
                                    @csrf

                                </form>
                                <button type="button" class="btn btn-danger" data-bs-toggle="modal"
                                    data-bs-target="#modal-del-homestay"
                                    onclick="showModelDelhomestay({{ $homestay->id }},'{{ $homestay->homestay_name }}')">
                                    ลบที่พัก
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
