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

                    <div class="col-md-9 mb-4">
                        <div class="content-card">
                            <div class="card-top p-3 d-flex justify-content-between align-items-center">
                                <h6 class="mb-0">Nội dung ngôn ngữ</h6>
                                <div>
                                    <button type="button" class="btn btn-outline-success btn-sm" id="saveBtn">
                                        <i class="fas fa-save"></i> Lưu thay đổi
                                    </button>
                                    <button type="button" class="btn btn-outline-secondary btn-sm" id="resetBtn">
                                        <i class="fas fa-undo"></i> Khôi phục
                                    </button>
                                    <button type="button" class="btn btn-outline-info btn-sm" id="validateBtn">
                                        <i class="fas fa-check"></i> Kiểm tra
                                    </button>
                                </div>
                            </div>
                            <div class="card-content p-3">
                                <div class="form-group">
                                    <label for="jsonEditor" class="form-control-label">Nội dung JSON</label>
                                    <div id="jsonEditor"></div>
                                    <small class="form-text text-muted">
                                        <strong>Lưu ý:</strong> Chỉ chỉnh sửa giá trị (value), không thay đổi key. Hệ thống sẽ tự động bảo vệ các key.
                                    </small>
                                    <div id="validationResult" class="mt-2"></div>
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
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jsoneditor/9.9.2/jsoneditor.min.css">
<style>
    #jsonEditor {
        height: 500px;
        border: 1px solid #ddd;
        border-radius: 4px;
    }

    .jsoneditor {
        border: 1px solid #ddd !important;
        border-radius: 4px !important;
    }

    .jsoneditor-menu {
        background-color: #c1c1c1  !important;
        border-bottom: 1px solid #ddd !important;
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

    .validation-success {
        color: #28a745;
        background-color: #d4edda;
        border: 1px solid #c3e6cb;
        padding: 0.5rem;
        border-radius: 4px;
        margin-top: 0.5rem;
    }

    .validation-error {
        color: #dc3545;
        background-color: #f8d7da;
        border: 1px solid #f5c6cb;
        padding: 0.5rem;
        border-radius: 4px;
        margin-top: 0.5rem;
    }

    .validation-warning {
        color: #856404;
        background-color: #fff3cd;
        border: 1px solid #ffeaa7;
        padding: 0.5rem;
        border-radius: 4px;
        margin-top: 0.5rem;
    }
</style>
@endpush

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jsoneditor/9.9.2/jsoneditor.min.js"></script>
<script>
$(document).ready(function() {
    let editor;
    let originalContent = '';
    let currentLanguage = 'vi';
    let originalKeys = [];

    editor = new JSONEditor(document.getElementById('jsonEditor'), {
        mode: 'tree',
        modes: ['tree', 'code'],
        onChange: function() {
            validateContent();
        },
        onError: function(err) {
            console.error('JSON Editor Error:', err);
        }
    });

    function loadLanguageContent(language) {
        showLoading();

        $.ajax({
            url: '{{ route("admin.languages.get") }}',
            method: 'GET',
            data: { language: language },
            success: function(response) {
                if (response.success) {
                    try {
                        const jsonData = JSON.parse(response.content);
                        originalContent = response.content;
                        originalKeys = extractKeys(jsonData);
                        
                        editor.set(jsonData);
                        currentLanguage = language;
                        
                        hideLoading();
                        
                        setTimeout(() => {
                            disableKeyEditing();
                            validateContent();
                        }, 200);
                        
                    } catch (e) {
                        hideLoading();
                        showToast('Lỗi định dạng JSON: ' + e.message, 'error');
                    }
                } else {
                    hideLoading();
                    showToast('Lỗi khi tải nội dung: ' + response.message, 'error');
                }
            },
            error: function(xhr, status, error) {
                hideLoading();
                showToast('Lỗi kết nối khi tải nội dung', 'error');
            }
        });
    }

    function extractKeys(obj, prefix = '') {
        let keys = [];
        for (let key in obj) {
            if (obj.hasOwnProperty(key)) {
                const fullKey = prefix ? prefix + '.' + key : key;
                if (typeof obj[key] === 'object' && obj[key] !== null) {
                    keys = keys.concat(extractKeys(obj[key], fullKey));
                } else {
                    keys.push(fullKey);
                }
            }
        }
        return keys;
    }

    function disableKeyEditing() {
        setTimeout(() => {
            const treeContainer = document.querySelector('.jsoneditor-tree');
            if (treeContainer) {
                const keyElements = treeContainer.querySelectorAll('.jsoneditor-field');
                keyElements.forEach(el => {
                    el.style.pointerEvents = 'none';
                    el.style.color = '#6c757d';
                    el.style.fontWeight = 'bold';
                });
            }
        }, 100);
    }

    function validateContent() {
        try {
            const currentData = editor.get();
            const currentKeys = extractKeys(currentData);
            
            const missingKeys = originalKeys.filter(key => !currentKeys.includes(key));
            const newKeys = currentKeys.filter(key => !originalKeys.includes(key));
            
            let validationHtml = '';
            let validationClass = 'validation-success';
            
            if (missingKeys.length > 0) {
                validationClass = 'validation-error';
                validationHtml = `
                    <div class="${validationClass}">
                        <strong>⚠️ Cảnh báo:</strong> Các key sau đã bị xóa/mất:
                        <ul class="mb-0 mt-1">
                            ${missingKeys.map(key => `<li><code>${key}</code></li>`).join('')}
                        </ul>
                        <small>Hãy khôi phục các key này để tránh lỗi ứng dụng.</small>
                    </div>
                `;
            } else if (newKeys.length > 0) {
                validationClass = 'validation-warning';
                validationHtml = `
                    <div class="${validationClass}">
                        <strong>ℹ️ Thông báo:</strong> Phát hiện ${newKeys.length} key mới:
                        <ul class="mb-0 mt-1">
                            ${newKeys.map(key => `<li><code>${key}</code></li>`).join('')}
                        </ul>
                        <small>Các key mới sẽ được thêm vào hệ thống.</small>
                    </div>
                `;
            } else {
                validationHtml = `
                    <div class="${validationClass}">
                        <strong>✅ Tất cả key đều được bảo toàn!</strong>
                        <small>Bạn có thể an toàn lưu thay đổi.</small>
                    </div>
                `;
            }
            
            $('#validationResult').html(validationHtml);
            
            if (missingKeys.length > 0) {
                $('#saveBtn').prop('disabled', true).addClass('btn-outline-danger').removeClass('btn-outline-success');
            } else {
                $('#saveBtn').prop('disabled', false).removeClass('btn-outline-danger').addClass('btn-outline-success');
            }
            
        } catch (e) {
            $('#validationResult').html(`
                <div class="validation-error">
                    <strong>❌ Lỗi JSON:</strong> ${e.message}
                </div>
            `);
            $('#saveBtn').prop('disabled', true);
        }
    }

    // Save language content
    function saveLanguageContent() {
        try {
            const content = editor.get();
            const jsonString = JSON.stringify(content, null, 2);
            
            const currentKeys = extractKeys(content);
            const missingKeys = originalKeys.filter(key => !currentKeys.includes(key));
            
            if (missingKeys.length > 0) {
                if (!confirm('Phát hiện một số key bị mất. Bạn có chắc muốn lưu? Điều này có thể gây lỗi ứng dụng.')) {
                    return;
                }
            }

            showLoading();

            $.ajax({
                url: '{{ route("admin.languages.update") }}',
                method: 'POST',
                data: {
                    language: currentLanguage,
                    content: jsonString,
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    hideLoading();
                    if (response.success) {
                        originalContent = jsonString;
                        originalKeys = extractKeys(content);
                        showToast('Lưu thành công!', 'success');
                        validateContent();
                    } else {
                        showToast('Lỗi khi lưu: ' + response.message, 'error');
                    }
                },
                error: function() {
                    hideLoading();
                    showToast('Lỗi kết nối khi lưu', 'error');
                }
            });
        } catch (e) {
            showToast('Lỗi định dạng JSON: ' + e.message, 'error');
        }
    }

    function resetContent() {
        if (confirm('Bạn có chắc muốn khôi phục nội dung gốc?')) {
            try {
                const jsonData = JSON.parse(originalContent);
                editor.set(jsonData);
                originalKeys = extractKeys(jsonData);
                validateContent();
                showToast('Đã khôi phục nội dung gốc', 'info');
            } catch (e) {
                showToast('Lỗi khi khôi phục: ' + e.message, 'error');
            }
        }
    }

    function showLoading() {
        $('#loadingModal').modal('show');
    }

    function hideLoading() {
        try {
            $('#loadingModal').modal('hide');
            setTimeout(() => {
                if ($('#loadingModal').hasClass('show')) {
                    $('#loadingModal').removeClass('show').hide();
                    $('body').removeClass('modal-open');
                    $('.modal-backdrop').remove();
                }
            }, 100);
        } catch (e) {
            console.error('Error hiding loading modal:', e);
            $('#loadingModal').hide();
            $('body').removeClass('modal-open');
            $('.modal-backdrop').remove();
        }
    }

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

    $('#validateBtn').click(function() {
        validateContent();
    });

    loadLanguageContent('vi');
});
</script>
@endpush
