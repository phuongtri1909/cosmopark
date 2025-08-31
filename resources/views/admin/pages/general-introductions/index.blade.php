@extends('admin.layouts.sidebar')

@section('title', 'Quản lý giới thiệu chung')

@section('main-content')
<div class="category-container">
    <!-- Breadcrumb -->
    <div class="content-breadcrumb">
        <ol class="breadcrumb-list">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item current">Giới Thiệu Chung</li>
        </ol>
    </div>

    <div class="content-card">
        <div class="card-top">
            <div class="card-title">
                <i class="fas fa-info-circle icon-title"></i>
                <h5>Thông tin giới thiệu chung</h5>
            </div>
            @if($generalIntroduction)
                <a href="{{ route('admin.general-introductions.edit', $generalIntroduction) }}" class="action-button btn-sm btn-primary">
                    <i class="fas fa-edit"></i> Chỉnh sửa
                </a>
            @else
                <a href="{{ route('admin.general-introductions.create') }}" class="action-button btn-sm btn-outline-primary">
                    <i class="fas fa-plus"></i> Tạo mới
                </a>
            @endif
        </div>
        
        <div class="card-content">
            <!-- Tab Navigation -->
            <div class="tab-navigation">
                <button class="tab-button action-button {{ request()->get('tab') == 'features' ? '' : 'active' }}" data-tab="general-info">
                    <i class="fas fa-info-circle"></i>
                    Thông tin chung
                </button>
                <button class="tab-button action-button {{ request()->get('tab') == 'features' ? 'active' : '' }}" data-tab="features">
                    <i class="fas fa-chart-bar"></i>
                    Tính năng giới thiệu
                </button>
            </div>

            <!-- Tab Content -->
            <div class="tab-content">
                <!-- Tab 1: General Info -->
                <div class="tab-pane {{ request()->get('tab') == 'features' ? '' : 'active' }}" id="general-info">
                    @if($generalIntroduction)
                        <div class="info-display">
                                                <div class="info-section">
                        <h6 class="info-label">Tiêu đề:</h6>
                        <div class="info-content">
                            <div class="language-content">
                                <strong>VI:</strong> {{ $generalIntroduction->getTranslation('title', 'vi') }}
                            </div>
                            <div class="language-content">
                                <strong>EN:</strong> {{ $generalIntroduction->getTranslation('title', 'en') }}
                            </div>
                        </div>
                    </div>
                    
                    <div class="info-section">
                        <h6 class="info-label">Nội dung:</h6>
                        <div class="info-content">
                            <div class="language-content">
                                <strong>VI:</strong> {{ $generalIntroduction->getTranslation('content', 'vi') }}
                            </div>
                            <div class="language-content">
                                <strong>EN:</strong> {{ $generalIntroduction->getTranslation('content', 'en') }}
                            </div>
                        </div>
                    </div>
                            
                            <div class="info-section">
                                <h6 class="info-label">Trạng thái:</h6>
                                <span class="status-badge {{ $generalIntroduction->is_active ? 'active' : 'inactive' }}">
                                    {{ $generalIntroduction->is_active ? 'Hiển thị' : 'Ẩn' }}
                                </span>
                            </div>
                            
                            <div class="info-section">
                                <h6 class="info-label">Cập nhật lần cuối:</h6>
                                <p class="info-content">{{ $generalIntroduction->updated_at->format('d/m/Y H:i') }}</p>
                            </div>
                        </div>
                    @else
                        <div class="empty-state">
                            <div class="empty-state-icon">
                                <i class="fas fa-info-circle"></i>
                            </div>
                            <h4>Chưa có thông tin giới thiệu</h4>
                            <p>Bắt đầu bằng cách tạo thông tin giới thiệu chung cho website.</p>
                            <a href="{{ route('admin.general-introductions.create') }}" class="action-button">
                                <i class="fas fa-plus"></i> Tạo thông tin giới thiệu
                            </a>
                        </div>
                    @endif
                </div>

                <!-- Tab 2: Features -->
                <div class="tab-pane {{ request()->get('tab') == 'features' ? 'active' : '' }}" id="features">
                    <div class="features-header">
                        <h6>Quản lý tính năng giới thiệu</h6>
                        <a href="{{ route('admin.intro-features.create') }}" class="action-button small">
                            <i class="fas fa-plus"></i> Thêm tính năng
                        </a>
                    </div>
                    
                    <div class="features-content">
                        @php
                            $introFeatures = \App\Models\IntroFeature::active()->ordered()->get();
                        @endphp
                        
                        @if($introFeatures->isEmpty())
                            <div class="empty-state">
                                <div class="empty-state-icon">
                                    <i class="fas fa-chart-bar"></i>
                                </div>
                                <h4>Chưa có tính năng giới thiệu nào</h4>
                                <p>Bắt đầu bằng cách thêm tính năng đầu tiên.</p>
                                <a href="{{ route('admin.intro-features.create') }}" class="action-button">
                                    <i class="fas fa-plus"></i> Thêm tính năng mới
                                </a>
                            </div>
                        @else
                            <div class="data-table-container">
                                <table class="data-table">
                                    <thead>
                                        <tr>
                                            <th class="column-small">STT</th>
                                            <th class="column-large">Tên tính năng</th>
                                            <th class="column-medium">Giá trị</th>
                                            <th class="column-small">Đơn vị</th>
                                            <th class="column-small">Thứ tự</th>
                                            <th class="column-small text-center">Trạng thái</th>
                                            <th class="column-small text-center">Thao tác</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($introFeatures as $index => $feature)
                                            <tr>
                                                <td class="text-center">{{ $index + 1 }}</td>
                                                <td class="item-name">
                                                    <div class="language-content">
                                                        <strong>VI:</strong> {{ $feature->getTranslation('name', 'vi') }}<br>
                                                        <strong>EN:</strong> {{ $feature->getTranslation('name', 'en') }}
                                                    </div>
                                                </td>
                                                <td class="text-center">
                                                    <div class="language-content">
                                                        <strong>VI:</strong> {{ $feature->getTranslation('value', 'vi') }}<br>
                                                        <strong>EN:</strong> {{ $feature->getTranslation('value', 'en') }}
                                                    </div>
                                                </td>
                                                <td class="text-center">
                                                    <div class="language-content">
                                                        <strong>VI:</strong> {{ $feature->getTranslation('unit', 'vi') }}<br>
                                                        <strong>EN:</strong> {{ $feature->getTranslation('unit', 'en') }}
                                                    </div>
                                                </td>
                                                <td class="text-center">
                                                    <span class="order-badge">{{ $feature->sort_order }}</span>
                                                </td>
                                                <td class="text-center">
                                                    @if($feature->is_active)
                                                        <span class="status-badge active">Hiển thị</span>
                                                    @else
                                                        <span class="status-badge inactive">Ẩn</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    <div class="action-buttons-wrapper">
                                                        <a href="{{ route('admin.intro-features.edit', $feature) }}" class="action-icon edit-icon text-decoration-none" title="Chỉnh sửa">
                                                            <i class="fas fa-edit"></i>
                                                        </a>
                                                        @include('components.delete-form', [
                                                            'id' => $feature->id,
                                                            'route' => route('admin.intro-features.destroy', $feature),
                                                            'message' => "Bạn có chắc chắn muốn xóa tính năng '{$feature->getTranslation('name', 'vi')}'?"
                                                        ])
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const tabButtons = document.querySelectorAll('.tab-button');
    const tabPanes = document.querySelectorAll('.tab-pane');
    
    // Check if there's a tab parameter in URL
    const urlParams = new URLSearchParams(window.location.search);
    const activeTab = urlParams.get('tab');
    
    // If there's a tab parameter, activate that tab
    if (activeTab && activeTab === 'features') {
        // Remove active class from all buttons and panes
        tabButtons.forEach(btn => btn.classList.remove('active'));
        tabPanes.forEach(pane => pane.classList.remove('active'));
        
        // Add active class to features tab
        document.querySelector('[data-tab="features"]').classList.add('active');
        document.getElementById('features').classList.add('active');
    }
    
    tabButtons.forEach(button => {
        button.addEventListener('click', function() {
            const targetTab = this.getAttribute('data-tab');
            
            // Remove active class from all buttons and panes
            tabButtons.forEach(btn => btn.classList.remove('active'));
            tabPanes.forEach(pane => pane.classList.remove('active'));
            
            // Add active class to clicked button and target pane
            this.classList.add('active');
            document.getElementById(targetTab).classList.add('active');
            
            // Update URL without page reload
            const newUrl = new URL(window.location);
            if (targetTab === 'general-info') {
                newUrl.searchParams.delete('tab');
            } else {
                newUrl.searchParams.set('tab', targetTab);
            }
            window.history.pushState({}, '', newUrl);
        });
    });
});
</script>
@endsection     