@extends('layouts.user')

@section('homestay', 'active')

@section('title', 'homestay')

<style>
    .homestay {
        display: flex;
        justify-content: center;
        align-items: center;
        flex-direction: row;
        flex-wrap: wrap;
    }

    .card-block {
        padding: 20px;
    }

    .carousel-item.active {
        background-color: rgba(0, 0, 0, 0);
    }

    .carousel-item img {
        border-top-left-radius: 3px;
        border-top-right-radius: 3px;
        height: 300px;
        object-position: 0% 100%;
        object-fit: cover;
    }
</style>

<script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />

@section('content')
    <div class="container">
        <form action="{{ route('search-homestay') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="dateRange" class="form-label">ช่วงวันที่เข้าพัก *</label>
                @if (isset($dateRange))
                    <?php
                    $dateArr = explode(' - ', $dateRange);
                    $start_date = date('d-m-Y', strtotime($dateArr[0]));
                    $end_date = date('d-m-Y', strtotime($dateArr[1]));
                    $valueDate = $start_date . ' - ' . $end_date;
                    ?>
                @else
                    <?php
                    $currentDate = date('d-m-Y');
                    $d = date('d-m-Y', strtotime($currentDate . ' +1 days'));
                    $valueDate = $currentDate . ' - ' . $d;
                    ?>
                @endif
                <input type="text" name="dateRange" value="{{ $valueDate }}" class="form-control" required />
                <script>
                    $(function() {
                        var today = new Date();
                        var date = (today.getDate()) + '-' + (today.getMonth() + 1) + '-' + today.getFullYear()
                        $('input[name="dateRange"]').daterangepicker({
                            opens: 'left',
                            minDate: date,
                            locale: {
                                format: 'DD-MM-YYYY'
                            }
                        });
                    });
                </script>
            </div>
            <div class="mb-3">
                <label for="number_guests" class="form-label">จำนวนผู้เข้าพัก</label>
                @if (isset($number_guests))
                    <?php
                    $valueGuests = $number_guests;
                    ?>
                @else
                    <?php
                    $valueGuests = 1;
                    ?>
                @endif
                <input type="number" min="1" step="1" pattern="\d*" class="form-control" id="number_guests"
                    name="number_guests" placeholder="จำนวนผู้เข้าพัก" value="{{ $valueGuests }}" required>
            </div>
            <input type="submit" class="btn btn-success" value="ค้นหา">
        </form>

        <div class="homestay">
            @if (isset($homestays))
                @foreach ($homestays as $homestay)
                    <div class="card m-4" style="width: 22rem;">
                        <div id="carouselExampleSlidesOnly" class="carousel slide" data-bs-ride="carousel">
                            <div class="carousel-inner">
                                <?php $i = 0; ?>
                                @foreach (json_decode($homestay->homestay_img) as $img)
                                    @if ($i == 0)
                                        <?php $i += 1; ?>
                                        <div class="carousel-item active">
                                            <img src="{{ asset('storage/images/' . $img) }}" class="card-img-top"
                                                alt="...">
                                        </div>
                                    @else
                                        <div class="carousel-item">
                                            <img src="{{ asset('storage/images/' . $img) }}" class="card-img-top"
                                                alt="...">
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                        <div class="card-body">
                            <h5 class="card-title">{{ $homestay->homestay_name }}</h5>
                            <p class="card-text text-black-50 mt-4">โฮมสเตย์ตากะยาย ภูผาม่าน, 210 บ้าน ตำบล ภูผาม่าน อำเภอ
                                ภูผาม่าน
                                ขอนแก่น 40350</p>
                            <p class="card-text text-black-50 mt-4">{{$homestay->homestay_detail}}</p>
                            <hr class="mt-4">
                            {{-- <h5 class="card-title">สิ่งอำนวยความสะดวก</h5>
                            <div class="facilities">
                                <img src="../images/wifi.svg" class="m-2" width="50" height="50" alt="">
                                <img src="../images/toilet.svg" class="m-2" width="50" height="50" alt="">
                                <img src="../images/parking.svg" class="m-2" width="50" height="50"
                                    alt="">
                                <img src="../images/cafe.svg" class="m-2" width="50" height="50" alt="">
                            </div> --}}
                            <a href="{{ route('homestay-details-user', ['id' => $homestay->id, 'date' => $dateRange, 'guests' => $valueGuests]) }}"
                                class="btn btn-success mt-4">ดูรายละเอียด</a>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
    </div>
@endsection
