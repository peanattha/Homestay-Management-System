@extends('layouts.admin')

@section('active-review-admin', 'active')

@section('title', 'Review Details')

@section('page-name')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb m-0">
            <li class="breadcrumb-item"><a href="{{ route('review-admin') }}">การรีวิวบ้านพัก</a></li>
            <li class="breadcrumb-item active" aria-current="page">รายละเอียดการรีวิวบ้านพัก</li>
        </ol>
    </nav>
@endsection

@section('content')
    <div class="card rounded-3 border border-1 shadow-lg">
        <div class="card-header">
            รายละเอียดการรีวิวบ้านพัก
            @if ($review->review_type == 1)
                <span class="badge bg-success">Positive</span>
            @elseif ($review->review_type == 2)
                <span class="badge bg-danger">Negative</span>
            @elseif ($review->review_type == 3)
                <span class="badge bg-warning text-dark">Natural</span>
            @endif
        </div>
        <div class="card-body">
            <form action="{{ route('update-review-admin', ['id' => $review->id]) }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="details" class="form-label">การรีวิว *</label>
                    <textarea class="form-control" id="details" name="details" rows="5" readonly required>{{ $review->review_detail }}</textarea>
                    <hr>
                </div>

                @if ($review->reply != null)
                    <div class="mb-3">
                        <label for="reply" class="form-label">ตอบกลับการรีวิว *</label>
                        <textarea class="form-control" id="reply" name="reply" rows="5" required>{{ $review->reply }}</textarea>
                    </div>
                    <input type="submit" class="btn btn-success" value="แก้ใขการตอบกลับ">
                @else
                    <div class="mb-3">
                        <label for="reply" class="form-label">ตอบกลับการรีวิว *</label>
                        <textarea class="form-control" id="reply" name="reply" rows="5" required></textarea>
                    </div>
                    <input type="submit" class="btn btn-success" value="ตอบกลับการรีวิว">
                @endif
            </form>
        </div>
    </div>

@endsection
