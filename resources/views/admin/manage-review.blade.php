@extends('layouts.admin')

@section('title', 'Reply Review')

<link rel="stylesheet" href="{{ asset('css/table.css') }}">

@section('page-name')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb m-0">
            <li class="breadcrumb-item"><a href="{{ route('review-admin') }}">การรีวิวบ้านพัก</a></li>
            <li class="breadcrumb-item active" aria-current="page">การรีวิวที่ยังไม่ได้ตอบกลับ</li>
        </ol>
    </nav>
@endsection

@section('content')
    {{-- <div>
        <form action="#" method="GET">
            @csrf
            <select name="type" id="type" class="form-select" required>
                <option value="0" selected>การวิเคราะห์ความคิดเห็น</option>
                <option value="1">Positive</option>
                <option value="2">Negative</option>
                <option value="3">Natural</option>
            </select>
        </form>
    </div> --}}

    <div class="table100 ver2 mb-4 mt-4">
        <div class="table100-head">
            <table>
                <thead>
                    <tr>
                        <th style="width: 5%">ลำดับ</th>
                        <th style="width: 25%">รีวิว</th>
                        <th style="width: 10%">ผลวิเคราะห์ความคิดเห็น</th>
                        <th style="width: 15%">วันที่รีวิว</th>
                        <th style="width: 10%">รายละเอียด</th>
                    </tr>
                </thead>
            </table>
        </div>
        <div class="table100-body js-pscroll">
            <table>
                <tbody>
                    @foreach ($reviews as $review)
                        <tr>
                            <td style="width: 5%">{{ $loop->iteration }}</td>
                            <td style="width: 25%;">
                                {{ Illuminate\Support\Str::limit($review->review_detail, 40, $end = '...') }}</td>
                            @if ($review->review_type == 1)
                                <td style="width: 10%"><span class="badge bg-success">Positive</span></td>
                            @elseif ($review->review_type == 2)
                                <td style="width: 10%"><span class="badge bg-danger">Negative</span></td>
                            @elseif ($review->review_type == 3)
                                <td style="width: 10%"><span class="badge bg-warning text-dark">Natural</span></td>
                            @endif
                            <td style="width: 15%">{{ $review->created_at }}</td>
                            <td style="width: 10%"><a href="{{ route('review-detail', $review->id) }}"
                                    class="btn btn-primary">ตอบกลับการรีวิว</a></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
