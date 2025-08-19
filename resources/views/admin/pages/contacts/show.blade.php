@extends('admin.layouts.sidebar')
@section('title', 'Chi tiết liên hệ')

@section('main-content')
<div class="row">
    <div class="col-12">
        <div class="content-card mb-0 mx-0 mx-md-4 mb-md-4">
            <div class="card-top pb-0">
                <h5 class="mb-0">Chi tiết liên hệ #{{ $contact->id }}</h5>
            </div>
            <div class="card-content p-3">
                <div class="mb-3">
                    <strong>Họ tên:</strong>
                    <div>{{ $contact->full_name }}</div>
                </div>
                <div class="mb-3">
                    <strong>Điện thoại:</strong>
                    <div>{{ $contact->phone }}</div>
                </div>
                <div class="mb-3">
                    <strong>Email:</strong>
                    <div>{{ $contact->email }}</div>
                </div>
                <div class="mb-3">
                    <strong>Trang gửi:</strong>
                    <div><a href="{{ $contact->source_url }}" target="_blank">{{ $contact->source_url }}</a></div>
                </div>
                <div class="mb-3">
                    <strong>Thời gian:</strong>
                    <div>{{ $contact->created_at->format('d/m/Y H:i') }}</div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection


