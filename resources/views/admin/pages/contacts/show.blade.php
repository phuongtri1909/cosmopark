@extends('admin.layouts.sidebar')

@section('title', 'Chi tiết liên hệ')

@section('main-content')
    <div class="category-container">
        <!-- Breadcrumb -->
        <div class="content-breadcrumb">
            <ol class="breadcrumb-list">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.contacts.index') }}">Liên hệ</a></li>
                <li class="breadcrumb-item current">Chi tiết</li>
            </ol>
        </div>

        <div class="content-card">
            <div class="card-top">
                <div class="card-title">
                    <i class="fas fa-envelope icon-title"></i>
                    <h5>Chi tiết liên hệ #{{ $contact->id }}</h5>
                </div>
                <div class="d-flex gap-2">
                    <a href="{{ route('admin.contacts.index') }}" class="action-button">
                        <i class="fas fa-arrow-left"></i> Quay lại
                    </a>
                </div>
            </div>

            <div class="card-content">
                <div class="contact-details">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="detail-item">
                                <div class="detail-label">
                                    <i class="fas fa-user"></i>
                                    <span>Họ tên</span>
                                </div>
                                <div class="detail-value">{{ $contact->full_name }}</div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="detail-item">
                                <div class="detail-label">
                                    <i class="fas fa-phone"></i>
                                    <span>Điện thoại</span>
                                </div>
                                <div class="detail-value">
                                    <span class="contact-phone">{{ $contact->phone }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="detail-item">
                                <div class="detail-label">
                                    <i class="fas fa-envelope"></i>
                                    <span>Email</span>
                                </div>
                                <div class="detail-value">
                                    <span class="contact-email">{{ $contact->email }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="detail-item">
                                <div class="detail-label">
                                    <i class="fas fa-clock"></i>
                                    <span>Thời gian gửi</span>
                                </div>
                                <div class="detail-value">
                                    <span class="contact-date">{{ $contact->created_at->format('d/m/Y H:i:s') }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12">
                            <div class="detail-item">
                                <div class="detail-label">
                                    <i class="fas fa-link"></i>
                                    <span>Trang gửi</span>
                                </div>
                                <div class="detail-value">
                                    <a href="{{ $contact->source_url }}" target="_blank" class="contact-url">
                                        {{ $contact->source_url }}
                                        <i class="fas fa-external-link-alt ms-1"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12">
                            <div class="detail-item">
                                <div class="detail-label">
                                    <i class="fas fa-info-circle"></i>
                                    <span>Thông tin bổ sung</span>
                                </div>
                                <div class="detail-value">
                                    <div class="contact-meta">
                                        <span class="meta-item">
                                            <strong>ID:</strong> {{ $contact->id }}
                                        </span>
                                        <span class="meta-item">
                                            <strong>IP:</strong> {{ request()->ip() }}
                                        </span>
                                        <span class="meta-item">
                                            <strong>User Agent:</strong> {{ request()->userAgent() ?? 'Không xác định' }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="contact-actions mt-4">
                    <div class="d-flex gap-2">
                        <a href="{{ route('admin.contacts.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Quay lại danh sách
                        </a>
                        @include('components.delete-form', [
                            'id' => $contact->id,
                            'route' => route('admin.contacts.destroy', $contact),
                            'message' => "Bạn có chắc chắn muốn xóa liên hệ của '{$contact->full_name}'?",
                        ])
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <style>
        .contact-details {
            background: #f8f9fa;
            border-radius: 8px;
            padding: 20px;
        }

        .detail-item {
            margin-bottom: 20px;
        }

        .detail-label {
            display: flex;
            align-items: center;
            margin-bottom: 8px;
            font-weight: 600;
            color: #495057;
        }

        .detail-label i {
            margin-right: 8px;
            color: #007bff;
            width: 16px;
        }

        .detail-value {
            padding: 12px 16px;
            background: white;
            border-radius: 6px;
            border-left: 4px solid #007bff;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        }

        .contact-phone {
            font-family: monospace;
            background: #e3f2fd;
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 14px;
        }

        .contact-email {
            color: #1976d2;
            font-size: 14px;
        }

        .contact-url {
            color: #1976d2;
            text-decoration: none;
            word-break: break-all;
        }

        .contact-url:hover {
            text-decoration: underline;
        }

        .contact-date {
            font-size: 14px;
            color: #666;
        }

        .contact-meta {
            display: flex;
            flex-wrap: wrap;
            gap: 16px;
        }

        .meta-item {
            background: #e9ecef;
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 12px;
        }

        .contact-actions {
            border-top: 1px solid #dee2e6;
            padding-top: 20px;
        }
    </style>
@endpush


