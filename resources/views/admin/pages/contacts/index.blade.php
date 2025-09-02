@extends('admin.layouts.sidebar')

@section('title', 'Quản lý liên hệ')

@section('main-content')
    <div class="category-container">
        <!-- Breadcrumb -->
        <div class="content-breadcrumb">
            <ol class="breadcrumb-list">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item current">Liên hệ</li>
            </ol>
        </div>

        <div class="content-card">
            <div class="card-top">
                <div class="card-title">
                    <i class="fas fa-envelope icon-title"></i>
                    <h5>Danh sách liên hệ</h5>
                </div>
                <div class="d-flex gap-2">
                    <button type="button" class="action-button" data-bs-toggle="modal" data-bs-target="#exportModal">
                        <i class="fas fa-download"></i> Xuất dữ liệu
                    </button>
                </div>
            </div>

            <!-- Thống kê -->
            <div class="stats-section mb-3">
                <div class="row">
                    <div class="col-md-6">
                        <div class="stat-card">
                            <div class="stat-icon">
                                <i class="fas fa-users"></i>
                            </div>
                            <div class="stat-content">
                                <div class="stat-number">{{ $totalContacts }}</div>
                                <div class="stat-label">Tổng số liên hệ</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="stat-card">
                            <div class="stat-icon">
                                <i class="fas fa-filter"></i>
                            </div>
                            <div class="stat-content">
                                <div class="stat-number">{{ $filteredContacts }}</div>
                                <div class="stat-label">Kết quả lọc</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Filter Section -->
            <div class="filter-section">
                <form action="{{ route('admin.contacts.index') }}" method="GET" class="filter-form">
                    <div class="row">
                        <div class="col-3">
                            <label for="search_filter">Tìm kiếm</label>
                            <input type="text" id="search_filter" name="search" class="filter-input"
                                placeholder="Tìm theo tên, SĐT, email" value="{{ request('search') }}">
                        </div>
                        <div class="col-3">
                            <label for="date_from_filter">Từ ngày</label>
                            <input type="date" id="date_from_filter" name="date_from" class="filter-input"
                                value="{{ request('date_from') }}">
                        </div>
                        <div class="col-3">
                            <label for="date_to_filter">Đến ngày</label>
                            <input type="date" id="date_to_filter" name="date_to" class="filter-input"
                                value="{{ request('date_to') }}">
                        </div>
                        <div class="col-3">
                            <label>&nbsp;</label>
                            <div class="d-flex gap-2">
                                <button type="submit" class="filter-btn">
                                    <i class="fas fa-filter"></i> Lọc
                                </button>
                                <a href="{{ route('admin.contacts.index') }}" class="filter-clear-btn">
                                    <i class="fas fa-times"></i> Xóa bộ lọc
                                </a>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

            @if (request('search') || request('date_from') || request('date_to'))
                <div class="active-filters">
                    <span class="active-filters-title">Đang lọc: </span>
                    @if (request('search'))
                        <span class="filter-tag">
                            <span>Tìm kiếm: {{ request('search') }}</span>
                            <a href="{{ request()->url() }}?{{ http_build_query(request()->except('search')) }}"
                                class="remove-filter">×</a>
                        </span>
                    @endif
                    @if (request('date_from'))
                        <span class="filter-tag">
                            <span>Từ ngày: {{ \Carbon\Carbon::parse(request('date_from'))->format('d/m/Y') }}</span>
                            <a href="{{ request()->url() }}?{{ http_build_query(request()->except('date_from')) }}"
                                class="remove-filter">×</a>
                        </span>
                    @endif
                    @if (request('date_to'))
                        <span class="filter-tag">
                            <span>Đến ngày: {{ \Carbon\Carbon::parse(request('date_to'))->format('d/m/Y') }}</span>
                            <a href="{{ request()->url() }}?{{ http_build_query(request()->except('date_to')) }}"
                                class="remove-filter">×</a>
                        </span>
                    @endif
                </div>
            @endif

            <div class="card-content">
                @if ($submissions->isEmpty())
                    <div class="empty-state">
                        <div class="empty-state-icon">
                            <i class="fas fa-envelope"></i>
                        </div>
                        @if (request('search') || request('date_from') || request('date_to'))
                            <h4>Không tìm thấy liên hệ nào</h4>
                            <p>Không có liên hệ nào phù hợp với bộ lọc hiện tại.</p>
                            <a href="{{ route('admin.contacts.index') }}" class="action-button">
                                <i class="fas fa-times"></i> Xóa bộ lọc
                            </a>
                        @else
                            <h4>Chưa có liên hệ nào</h4>
                            <p>Chưa có ai gửi liên hệ đến hệ thống.</p>
                        @endif
                    </div>
                @else
                    <div class="data-table-container">
                        <table class="data-table">
                            <thead>
                                <tr>
                                    <th class="column-small">STT</th>
                                    <th class="column-medium">Họ tên</th>
                                    <th class="column-medium">Điện thoại</th>
                                    <th class="column-large">Email</th>
                                    <th class="column-large">Trang gửi</th>
                                    <th class="column-medium">Thời gian</th>
                                    <th class="column-small text-center">Thao tác</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($submissions as $index => $submission)
                                    <tr>
                                        <td class="text-center">
                                            {{ ($submissions->currentPage() - 1) * $submissions->perPage() + $index + 1 }}
                                        </td>
                                        <td class="item-title">
                                            {{ $submission->full_name }}
                                        </td>
                                        <td>
                                            <span class="contact-phone">{{ $submission->phone }}</span>
                                        </td>
                                        <td>
                                            <span class="contact-email">{{ $submission->email }}</span>
                                        </td>
                                        <td class="contact-url">
                                            <a href="{{ $submission->source_url }}" target="_blank" class="text-truncate d-inline-block" style="max-width: 200px;" title="{{ $submission->source_url }}">
                                                {{ $submission->source_url }}
                                            </a>
                                        </td>
                                        <td class="contact-date">
                                            {{ $submission->created_at->format('d/m/Y H:i') }}
                                        </td>
                                        <td>
                                            <div class="action-buttons-wrapper">
                                                <a href="{{ route('admin.contacts.show', $submission) }}"
                                                    class="action-icon view-icon text-decoration-none" title="Xem chi tiết">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                @include('components.delete-form', [
                                                    'id' => $submission->id,
                                                    'route' => route('admin.contacts.destroy', $submission),
                                                    'message' => "Bạn có chắc chắn muốn xóa liên hệ của '{$submission->full_name}'?",
                                                ])
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="pagination-wrapper">
                        <div class="pagination-info">
                            Hiển thị {{ $submissions->firstItem() ?? 0 }} đến {{ $submissions->lastItem() ?? 0 }} của
                            {{ $submissions->total() }} liên hệ
                        </div>
                        <div class="pagination-controls">
                            {{ $submissions->appends(request()->query())->links('components.paginate') }}
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Export Modal -->
    <div class="modal fade" id="exportModal" tabindex="-1" aria-labelledby="exportModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exportModalLabel">Xuất dữ liệu liên hệ</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('admin.contacts.export') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6">
                                <label for="export_date_from" class="form-label">Từ ngày</label>
                                <input type="date" class="form-control" id="export_date_from" name="date_from" value="{{ request('date_from') }}">
                            </div>
                            <div class="col-md-6">
                                <label for="export_date_to" class="form-label">Đến ngày</label>
                                <input type="date" class="form-control" id="export_date_to" name="date_to" value="{{ request('date_to') }}">
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-md-6">
                                <label for="export_format" class="form-label">Định dạng</label>
                                <select class="form-control" id="export_format" name="format" required>
                                    <option value="csv">CSV</option>
                                    <option value="excel">Excel</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="filter-clear-btn" data-bs-dismiss="modal">Đóng</button>
                        <button type="submit" class="btn action-button">
                            <i class="fas fa-download"></i> Xuất dữ liệu
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <style>
        .stats-section {
            background: #f8f9fa;
            border-radius: 8px;
            padding: 20px;
        }

        .stat-card {
            display: flex;
            align-items: center;
            background: white;
            padding: 15px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        .stat-icon {
            width: 50px;
            height: 50px;
            background: #007bff;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 15px;
        }

        .stat-icon i {
            color: white;
            font-size: 20px;
        }

        .stat-number {
            font-size: 24px;
            font-weight: bold;
            color: #333;
        }

        .stat-label {
            color: #666;
            font-size: 14px;
        }

        .contact-phone {
            font-family: monospace;
            background: #e3f2fd;
            padding: 2px 6px;
            border-radius: 4px;
            font-size: 12px;
        }

        .contact-email {
            color: #1976d2;
            font-size: 12px;
        }

        .contact-url {
            font-size: 12px;
        }

        .contact-date {
            font-size: 12px;
            color: #666;
        }

        .view-icon {
            color: #17a2b8;
        }

        .view-icon:hover {
            color: #138496;
        }
    </style>
@endpush

@push('scripts')
    <script>
        document.getElementById('date_from_filter').addEventListener('change', function() {
            if (this.value && document.getElementById('date_to_filter').value) {
                document.querySelector('.filter-form').submit();
            }
        });

        document.getElementById('date_to_filter').addEventListener('change', function() {
            if (this.value && document.getElementById('date_from_filter').value) {
                document.querySelector('.filter-form').submit();
            }
        });

        document.querySelector('#exportModal form').addEventListener('submit', function(e) {
            const dateFrom = document.getElementById('export_date_from').value;
            const dateTo = document.getElementById('export_date_to').value;
            
            if (dateFrom && dateTo && dateFrom > dateTo) {
                e.preventDefault();
                alert('Ngày từ không được lớn hơn ngày đến!');
                return false;
            }
        });
    </script>
@endpush


