@extends('layouts.user')

@section('homestay', 'active')

@section('title', 'homestay Details')

@section('page-name')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb m-0">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">หน้าหลัก</a></li>
            <li class="breadcrumb-item"><a href="javascript:history.back()">ค้นหาที่พัก</a></li>
            <li class="breadcrumb-item active" aria-current="page">รายละเอียดที่พัก</li>
        </ol>
    </nav>
@endsection

@section('content')
    <div class="container">
        <div class="gallery overflow-auto" style="height: 500px;">
            <div class="row">
                @foreach (json_decode($details->homestay_img) as $img)
                    <div class="col-lg-4 mb-2 mb-lg-0">
                        <img src="{{ asset('storage/images/' . $img) }}" data-bs-toggle="modal"
                            data-bs-target="#exampleModal{{ $loop->iteration }}" class="w-100 rounded mb-2"
                            alt="Boat on Calm Water" />
                    </div>
                    <div class="modal fade" id="exampleModal{{ $loop->iteration }}" tabindex="-1"
                        aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <p class="modal-title" id="exampleModalLabel">รูปที่พัก</p>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <a href="{{ asset('storage/images/' . $img) }}" target="_blank"><img
                                            src="{{ asset('storage/images/' . $img) }}" class="w-100" /></a>
                                </div>

                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <div class="container mt-4 ">
        <div class="card rounded-3 border border-1 shadow-lg">
            <div class="card-header">
                รายละเอียดที่พัก
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <label for="homestay" class="form-label">ที่พัก *</label>
                    <input type="text" class="form-control" id="homestay" name="homestay_name"
                        value="{{ $details->homestay_name }}" form="form_edit_homestay" readonly>
                </div>
                <div class="mb-3">
                    <label for="peice" class="form-label">ราคา/คืน *</label>
                    <div class="input-group">
                        <input type="text" class="form-control" id="price" name="price" placeholder="ราคาต่อ 1 คืน"
                            value="{{ $details->homestay_price }}" form="form_edit_homestay" readonly>
                        <span class="input-group-text">บาท</span>
                    </div>
                </div>
                <div class="row md-2">
                    <div class="col-md-4">
                        <label for="number_guests" class="form-label">จำนวนผู้เข้าพักสูงสุด*</label>
                        <input type="number" min="1" step="1" pattern="\d*" class="form-control"
                            id="number_guests" name="number_guests" value="{{ $details->number_guests }}"readonly>
                    </div>
                    <div class="col-md-4">
                        <label for="bedroom" class="form-label">จำนวนห้องนอน*</label>
                        <input type="number" min="1" step="1" pattern="\d*" class="form-control"
                            id="bedroom" name="bedroom" value="{{ $details->num_bedroom }}" readonly>
                    </div>
                    <div class="col-md-4">
                        <label for="bathroom" class="form-label">จำนวนห้องน้ำ*</label>
                        <input type="number" min="1" step="1" pattern="\d*" class="form-control"
                            id="bathroom" name="bathroom" value="{{ $details->num_bathroom }}" readonly>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container mt-4 mb-4">
        <div class="card rounded-3 border border-1 shadow-lg">
            <div class="card-header">
                รีวิวจากลูกค้า
            </div>
            <div class="card-body">
                @if ($reviews->count() == null)
                    <div>
                        <p class="m-0">ที่พักนี้ยังไม่มีการรีวิวจากลูกค้า</p>
                    </div>
                @else
                    @foreach ($reviews as $review)
                        <div>
                            {{ $review->booking->user->firstName }} : {{ $review->review_detail }}
                            @if (isset($review->reply))
                                เจ้าของโฮมสเตย์ : {{ $review->reply }}
                            @endif
                            <hr>
                        </div>
                    @endforeach
                @endif
            </div>
        </div>
    </div>
@endsection
