@extends('layouts.admin')

@section('title', 'Promotion')

<link rel="stylesheet" href="{{ asset('css/table.css') }}">

@section('content')

    <div class="container mb-3">
        <h3>ตอบกลับการรีวิว</h3>
        <label for="details" class="form-label">การรีวิว </label>
        <textarea class="form-control" id="details" name="details" rows="3" readonly required>บรรยากาศดี บริการดี  วิวสวย สะอาด  กาแฟอร่อย คาเฟ่สวยน่ารัก แนะนำเลยถ้ามาภูผาม่านต้องมาค่าเฟ่ที่นี้ แต่ส่วนที่พักจองบ้านภูผาม่านราคา1000 ไม่คุ้มเงินเลยบอกเลยไม่คุ้มเงิน จริงๆ ถ้า1000ก็ควรจะทำห้องให้ดีกว่านี้เครื่องทำน้ำอุ่นก็ใช้ไม่ได้
ทีวีเปิดไม่ติด  ตรงที่ตั้งกาน้ำร้อนก็ไม่มีที่เสียบปลั้กแถมยังมีน้ำในกาเหลือจากคนเก่าที่พักก่อนน่าด้วย ส่วนบ้าน Family house เป็นห้องน้ำรวม แต่ประตูห้องน้ำล็อคไม่ได้เลย  เเนะนำแค่คาเฟ่เท่านั้นเฉพาะคนชอบกินกาแฟถ่ายรูป</textarea>
<hr>
<label for="details" class="form-label">ตอบกลับการรีวิว </label>
<textarea class="form-control" id="details" name="details" rows="3" required></textarea>
        <input type="submit" class="btn btn-success mt-3" value="แก้ใขการตอบกลับ">
        <input type="submit" class="btn btn-danger mt-3" value="ลบการตอบกลับ">
    </div>

@endsection
