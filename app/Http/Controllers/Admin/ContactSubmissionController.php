<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactSubmission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Carbon\Carbon;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Writer\Csv;

class ContactSubmissionController extends Controller
{
    public function index(Request $request)
    {
        $query = ContactSubmission::query();

        if ($search = $request->get('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('full_name', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        if ($dateFrom = $request->get('date_from')) {
            $query->whereDate('created_at', '>=', $dateFrom);
        }

        if ($dateTo = $request->get('date_to')) {
            $query->whereDate('created_at', '<=', $dateTo);
        }

        $query->latest();

        $totalContacts = ContactSubmission::count();
        
        $filteredContacts = $query->count();
        
        $submissions = $query->paginate(12)->withQueryString();

        return view('admin.pages.contacts.index', compact('submissions', 'totalContacts', 'filteredContacts'));
    }

    public function show(ContactSubmission $contact)
    {
        return view('admin.pages.contacts.show', compact('contact'));
    }

    public function destroy(ContactSubmission $contact)
    {
        $contact->delete();
        return redirect()->route('admin.contacts.index')->with('success', 'Xóa thành công');
    }

    public function export(Request $request)
    {
        $request->validate([
            'date_from' => 'nullable|date',
            'date_to' => 'nullable|date|after_or_equal:date_from',
            'format' => 'required|in:excel,csv'
        ]);

        $query = ContactSubmission::query();

        if ($dateFrom = $request->get('date_from')) {
            $query->whereDate('created_at', '>=', $dateFrom);
        }

        if ($dateTo = $request->get('date_to')) {
            $query->whereDate('created_at', '<=', $dateTo);
        }

        $query->latest();

        $contacts = $query->get();

        if ($request->format === 'csv') {
            return $this->exportToCsv($contacts);
        } else {
            return $this->exportToExcel($contacts);
        }
    }

    private function exportToCsv($contacts)
    {
        $filename = 'contacts_' . now()->format('Y-m-d_H-i-s') . '.csv';
        
        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $callback = function() use ($contacts) {
            $file = fopen('php://output', 'w');
            
            fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF));
            
            fputcsv($file, [
                'ID', 'Họ tên', 'Điện thoại', 'Email', 'Trang gửi', 'Thời gian tạo'
            ]);

            foreach ($contacts as $contact) {
                fputcsv($file, [
                    $contact->id,
                    $contact->full_name,
                    $contact->phone,
                    $contact->email,
                    $contact->source_url,
                    $contact->created_at->format('d/m/Y H:i:s')
                ]);
            }

            fclose($file);
        };

        return Response::stream($callback, 200, $headers);
    }

    private function exportToExcel($contacts)
    {
        $filename = 'contacts_' . now()->format('Y-m-d_H-i-s') . '.xlsx';
        
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        
        $sheet->setCellValue('A1', 'ID');
        $sheet->setCellValue('B1', 'Họ tên');
        $sheet->setCellValue('C1', 'Điện thoại');
        $sheet->setCellValue('D1', 'Email');
        $sheet->setCellValue('E1', 'Trang gửi');
        $sheet->setCellValue('F1', 'Thời gian tạo');
        
        $sheet->getStyle('A1:F1')->getFont()->setBold(true);
        $sheet->getStyle('A1:F1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID);
        $sheet->getStyle('A1:F1')->getFill()->getStartColor()->setRGB('E3F2FD');
        
        $row = 2;
        foreach ($contacts as $contact) {
            $sheet->setCellValue('A' . $row, $contact->id);
            $sheet->setCellValue('B' . $row, $contact->full_name);
            $sheet->setCellValue('C' . $row, $contact->phone);
            $sheet->setCellValue('D' . $row, $contact->email);
            $sheet->setCellValue('E' . $row, $contact->source_url);
            $sheet->setCellValue('F' . $row, $contact->created_at->format('d/m/Y H:i:s'));
            $row++;
        }
        
        foreach (range('A', 'F') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }
        
        $writer = new Xlsx($spreadsheet);
        
        $tempFile = tempnam(sys_get_temp_dir(), 'contacts_export_');
        $writer->save($tempFile);
        
        $content = file_get_contents($tempFile);
        unlink($tempFile);
        
        $headers = [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
            'Content-Length' => strlen($content),
        ];

        return Response::make($content, 200, $headers);
    }
}


