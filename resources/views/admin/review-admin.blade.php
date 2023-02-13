@extends('layouts.admin')

@section('title', 'Review')

<link rel="stylesheet" href="{{ asset('css/table.css') }}">

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

<script>
    // Delete Review
    function showModelDelReview(id) {
        window.id_review = id;
        $("#modal-del-review").modal("show");
    }

    function confirmDelReview() {
        document
            .getElementById("del-review" + window.id_review)
            .submit();
    }
</script>
@section('page-name')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb m-0">
            <li class="breadcrumb-item active" aria-current="page">การรีวิวบ้านพัก</li>
        </ol>
    </nav>
@endsection

@section('content')
    {{-- Model Delete Review --}}
    <div class="modal fade" id="modal-del-review" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">แจ้งเตือน</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">คุณเเน่ใจที่จะลบการรีวิวนี้</div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success" onclick="confirmDelReview()">ยืนยัน</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ยกเลิก</button>
                </div>
            </div>
        </div>
    </div>

    <div class="card rounded-3 border border-1 shadow-lg">
        <div class="card-header">
            การรีวิวบ้านพัก
        </div>
        <div class="card-body">
            <form action="#" method="GET">
                @csrf
                <div class="mb-3">
                    <label for="polarity" class="form-label">การวิเคราะห์ความคิดเห็น</label>
                    <select class="form-select" id="polarity" name="polarity" required>
                        <option value="0" selected>การวิเคราะห์ความคิดเห็น</option>
                        <option value="1">Positive</option>
                        <option value="2">Negative</option>
                        <option value="3">Natural</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="type_reply" class="form-label">การตอบกลับ</label>
                    <select class="form-select" id="type_reply" name="type_reply" required>
                        <option value="0" selected>การตอบกลับ</option>
                        <option value="1">ตอบกลับเเล้ว</option>
                        <option value="2">ยังไม่ได้ตอบกลับ</option>
                    </select>
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
                        <th style="width: 25%">รีวิว</th>
                        <th style="width: 10%">ผลวิเคราะห์ความคิดเห็น</th>
                        <th style="width: 15%">วันที่รีวิว</th>
                        <th style="width: 10%">รายละเอียด</th>
                        <th style="width: 10%">ลบการรีวิว</th>
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
                            <td style="width: 15%">{{ $review->updated_at }}</td>
                            <td style="width: 10%"><a href="{{ route('review-detail', $review->id) }}"
                                    class="btn btn-primary">รายละเอียด</a></td>
                            <td style="width: 10%">
                                <form action="{{ route('delete-review-admin', ['id' => $review->id]) }}" method="POST"
                                    id="del-review{{ $review->id }}" class="m-0 ">
                                    @csrf
                                </form>
                                <button type="button" class="btn btn-danger"
                                    onclick="showModelDelReview({{ $review->id }})">
                                    ลบการรีวิว
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
