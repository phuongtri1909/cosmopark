@extends('admin.layouts.sidebar')
@section('title', 'Quản lý ngôn ngữ')

@section('main-content')
<div class="row">
    <div class="col-12">
        <div class="content-card mb-0 mx-0 mx-md-4 mb-md-4">
            <div class="card-top pb-0">
                <h5 class="mb-0">Quản lý ngôn ngữ</h5>
            </div>
            <div class="card-content">
                <div class="row">
                    <!-- Language Selection -->
                    <div class="col-md-3 mb-4">
                        <div class="content-card">
                            <div class="card-top p-3">
                                <h6 class="mb-0">Chọn ngôn ngữ</h6>
                            </div>
                            <div class="card-content p-3">
                                <div class="form-group">
                                    <select id="languageSelect" class="form-control">
                                        <option value="vi">Tiếng Việt</option>
                                        <option value="en">English</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Editor Section -->
                    <div class="col-md-9 mb-4">
                        <div class="content-card">
                            <div class="card-top p-3 d-flex justify-content-between align-items-center">
                                <h6 class="mb-0">Nội dung ngôn ngữ</h6>
                                <div>
                                    <button type="button" class="btn btn-success btn-sm" id="saveBtn">
                                        <i class="fas fa-save"></i> Lưu thay đổi
                                    </button>
                                    <button type="button" class="btn btn-secondary btn-sm" id="resetBtn">
                                        <i class="fas fa-undo"></i> Khôi phục
                                    </button>
                                </div>
                            </div>
                            <div class="card-content p-3">
                                <div class="form-group">
                                    <label for="jsonEditor" class="form-control-label">Nội dung JSON</label>
                                    <textarea id="jsonEditor" class="form-control" rows="20" style="font-family: 'Courier New', monospace;"></textarea>
                                    <small class="form-text text-muted">
                                        Chỉ chỉnh sửa giá trị (value), không thay đổi key. Định dạng JSON phải chính xác.
                                    </small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Loading Modal -->
<div class="modal fade" id="loadingModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-body text-center p-4">
                <div class="spinner-border text-primary" role="status">
                    <span class="visually-hidden">Đang tải...</span>
                </div>
                <p class="mt-3 mb-0">Đang xử lý...</p>
            </div>
        </div>
    </div>
</div>

@endsection

@push('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.2/codemirror.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.2/theme/monokai.min.css">
<style>
    .CodeMirror {
        height: 500px;
        border: 1px solid #ddd;
        border-radius: 4px;
        font-size: 14px;
    }

    .CodeMirror-gutters {
        background-color: #f8f9fa;
        border-right: 1px solid #ddd;
    }

    .CodeMirror-linenumber {
        color: #6c757d;
    }

    .btn-sm {
        padding: 0.375rem 0.75rem;
        font-size: 0.875rem;
    }

    .content-card {
        background: #fff;
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        margin-bottom: 1rem;
    }

    .card-top {
        border-bottom: 1px solid #e9ecef;
        padding: 1rem;
    }

    .card-content {
        padding: 1rem;
    }

    .form-control-label {
        font-weight: 600;
        color: #495057;
        margin-bottom: 0.5rem;
    }
</style>
@endpush

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.2/codemirror.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.2/mode/javascript/javascript.min.js"></script>
<script>
$(document).ready(function() {
    let editor;
    let originalContent = '';
    let currentLanguage = 'vi';

    // Initialize CodeMirror
    editor = CodeMirror.fromTextArea(document.getElementById('jsonEditor'), {
        mode: 'application/json',
        theme: 'monokai',
        lineNumbers: true,
        autoCloseBrackets: true,
        matchBrackets: true,
        indentUnit: 4,
        tabSize: 4,
        lineWrapping: true,
        foldGutter: true,
        gutters: ['CodeMirror-linenumbers'],
        extraKeys: {
            'Ctrl-Space': 'autocomplete'
        }
    });

    // Load language content
    function loadLanguageContent(language) {
        showLoading();

        $.ajax({
            url: '{{ route("admin.languages.get") }}',
            method: 'GET',
            data: { language: language },
            success: function(response) {
                if (response.success) {
                    originalContent = response.content;
                    editor.setValue(response.content);
                    currentLanguage = language;
                    hideLoading();
                } else {
                    hideLoading();
                    showToast('Lỗi khi tải nội dung: ' + response.message,'error');

                }
            },
            error: function() {
                hideLoading();
                showToast('Lỗi kết nối khi tải nội dung','error');
            }
        });
    }

    // Save language content
    function saveLanguageContent() {
        const content = editor.getValue();

        // Validate JSON
        try {
            JSON.parse(content);
        } catch (e) {
            showToast('Lỗi định dạng JSON: ' + e.message,'error');
            return;
        }

        showLoading();

        $.ajax({
            url: '{{ route("admin.languages.update") }}',
            method: 'POST',
            data: {
                language: currentLanguage,
                content: content,
                _token: '{{ csrf_token() }}'
            },
            success: function(response) {
                hideLoading();
                if (response.success) {
                    originalContent = content;
                    showToast('Lưu thành công!','success');
                } else {
                    showToast('Lỗi khi lưu: ' + response.message,'error');
                }
            },
            error: function() {
                hideLoading();
                showToast('Lỗi kết nối khi lưu','error');
            }
        });
    }

    // Reset content
    function resetContent() {
        if (confirm('Bạn có chắc muốn khôi phục nội dung gốc?')) {
            editor.setValue(originalContent);
        }
    }

    // Show loading modal
    function showLoading() {
        $('#loadingModal').modal('show');
    }

    // Hide loading modal
    function hideLoading() {
        $('#loadingModal').modal('hide');
    }

    // Event listeners
    $('#languageSelect').change(function() {
        const language = $(this).val();
        loadLanguageContent(language);
    });

    $('#saveBtn').click(function() {
        saveLanguageContent();
    });

    $('#resetBtn').click(function() {
        resetContent();
    });

    // Load initial content
    loadLanguageContent('vi');
});
</script>
@endpush
