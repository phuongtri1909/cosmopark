@extends('admin.layouts.sidebar')
@section('title', 'Liên hệ')

@section('main-content')
<div class="row">
    <div class="col-12">
        <div class="content-card mb-0 mx-0 mx-md-4 mb-md-4">
            <div class="card-top pb-0 d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Danh sách liên hệ</h5>
                <form method="GET" class="d-flex" action="{{ route('admin.contacts.index') }}">
                    <input type="text" name="search" class="form-control me-2" placeholder="Tìm kiếm..." value="{{ request('search') }}" />
                    <button class="btn btn-primary">Tìm</button>
                </form>
            </div>
            <div class="card-content p-0">
                <div class="table-responsive">
                    <table class="table mb-0">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Họ tên</th>
                                <th>Điện thoại</th>
                                <th>Email</th>
                                <th>Trang gửi</th>
                                <th>Thời gian</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($submissions as $item)
                                <tr>
                                    <td>{{ $item->id }}</td>
                                    <td>{{ $item->full_name }}</td>
                                    <td>{{ $item->phone }}</td>
                                    <td>{{ $item->email }}</td>
                                    <td class="text-truncate" style="max-width: 220px;">
                                        <a href="{{ $item->source_url }}" target="_blank">{{ $item->source_url }}</a>
                                    </td>
                                    <td>{{ $item->created_at->format('d/m/Y H:i') }}</td>
                                    <td class="text-end">
                                        <a href="{{ route('admin.contacts.show', $item) }}" class="btn btn-sm btn-secondary">Xem</a>
                                        <form action="{{ route('admin.contacts.destroy', $item) }}" method="POST" class="d-inline" onsubmit="return confirm('Xóa liên hệ này?')">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-sm btn-danger">Xóa</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center p-4">Chưa có liên hệ</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="p-3">
                {{ $submissions->links('components.paginate') }}
            </div>
        </div>
    </div>
</div>
@endsection


