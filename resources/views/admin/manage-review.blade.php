@extends('layouts.admin')

@section('title', 'Promotion')

<link rel="stylesheet" href="{{ asset('css/table.css') }}">

@section('content')
    <h3>การรีวิวที่ยังไม่ได้ตอบกลับ</h3>

    <div class="table100 ver2 mb-4">
        <div class="table100-head">
            <table>
                <thead>
                    <tr>
                        <th style="width: 10%">ลำดับ</th>
                        <th style="width: 25%">รีวิว</th>
                        <th style="width: 10%">วิเคราะห์ความคิดเห็น</th>
                        <th style="width: 10%">วันนที่รีวิว</th>
                        <th style="width: 25%">ตอบกลับ</th>

                    </tr>
                </thead>
            </table>
        </div>
        <div class="table100-body js-pscroll">
            <table>
                <tbody>

                    <tr>
                        <td style="width: 10%">1</td>
                        <td style="width: 25%;">บรรยากาศดี บริการดี  วิวสวย สะอาด  กาแฟอร่อย คาเฟ่สวย.....</td>
                        <td class="text-success" style="width: 10%">Positive</td>
                        <td style="width: 10%">28/07/2022</td>
                        <td style="width: 25%"><a class="link-primary" href="">ตอบกลับ</a></td>
                    </tr>
                    <tr>
                        <td style="width: 10%">2</td>
                        <td style="width: 25%;">ห้องพักสะอาด ที่พักดีครับ ลืมของไว้โทรกลับมา.....</td>
                        <td class="text-success" style="width: 10%">Positive</td>
                        <td style="width: 10%">08/04/2022</td>
                        <td style="width: 25%"><a class="link-primary" href="">ตอบกลับ</a></td>
                    </tr>
                    <tr>
                        <td style="width: 10%">3</td>
                        <td style="width: 25%;">จองบ้านภูผาม่านราคา1000 ไม่คุ้มเงินเลยบอกเลยไม่คุ้มเงิน.....</td>
                        <td class="text-danger" style="width: 10%">Negative</td>
                        <td style="width: 10%">21/04/2022</td>
                        <td style="width: 25%"><a class="link-primary" href="">ตอบกลับ</a></td>
                    </tr>

                </tbody>
            </table>
        </div>
    </div>

    @endsection
