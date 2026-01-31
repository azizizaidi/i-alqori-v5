<?php

namespace App\Http\Controllers;

use App\Models\ReportClass;
use App\Services\ToyyibPayService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

class PaymentController extends Controller
{
    protected ToyyibPayService $toyyibPay;

    public function __construct(ToyyibPayService $toyyibPay)
    {
        $this->toyyibPay = $toyyibPay;
    }

    /**
     * Create payment bill and redirect to ToyyibPay
     */
    public function createPayment(Request $request)
    {
        $request->validate([
            'report_class_id' => 'required|exists:report_classes,id',
        ]);

        $report = ReportClass::with(['registrar.user', 'className'])->find($request->report_class_id);

        if (!$report) {
            return back()->with('error', 'Report class not found.');
        }

        $billData = [
            'billName' => "Monthly Fee - {$report->month}",
            'billDescription' => "Class: {$report->className?->name} | Code: {$report->id}",
            'billAmount' => (int) ($report->fee_student * 100),
            'billExternalReferenceNo' => "RC-{$report->id}-" . time(),
            'billTo' => $report->registrar?->user?->name,
            'billEmail' => $report->registrar?->user?->email,
            'billPhone' => $report->registrar?->user?->phone,
            'billExpiryDays' => 3,
        ];

        $result = $this->toyyibPay->createBill($billData);

        if ($result['success']) {
            Session::put('pending_bill_code', $result['bill_code']);
            Session::put('pending_report_id', $report->id);

            return redirect()->away($result['payment_url']);
        }

        return back()->with('error', 'Failed to create payment: ' . ($result['error'] ?? 'Unknown error'));
    }

    /**
     * Callback from ToyyibPay (return URL)
     */
    public function callback(Request $request)
    {
        Log::info('ToyyibPay Callback', $request->all());

        $statusId = (int) $request->status_id;
        $billCode = $request->bill_code;
        $reportId = Session::get('pending_report_id');

        if ($statusId === 2) {
            if ($reportId) {
                $report = ReportClass::find($reportId);
                if ($report) {
                    $report->update([
                        'status' => 1,
                        'transaction_time' => now()->toDateTimeString(),
                        'bill_code' => $billCode,
                    ]);
                }
            }
            Session::forget(['pending_bill_code', 'pending_report_id']);
            return redirect()->route('client.monthly-fee')->with('success', 'Payment successful!');
        }

        Session::forget(['pending_bill_code', 'pending_report_id']);

        if ($statusId === 4) {
            return redirect()->route('client.monthly-fee')->with('info', 'Payment cancelled.');
        }

        return redirect()->route('client.monthly-fee')->with('error', 'Payment failed. Please try again.');
    }

    /**
     * Webhook from ToyyibPay
     */
    public function webhook(Request $request)
    {
        Log::info('ToyyibPay Webhook', $request->all());

        if (!$this->toyyibPay->verifyCallback($request->all())) {
            Log::warning('Invalid ToyyibPay signature');
            return response()->json(['status' => 'invalid'], 400);
        }

        $statusId = (int) $request->status_id;
        $billCode = $request->bill_code;
        $orderId = $request->order_id;

        if (preg_match('/RC-(\d+)-/', $orderId, $matches)) {
            $reportId = $matches[1];
            $report = ReportClass::find($reportId);

            if ($report) {
                $report->update([
                    'status' => $statusId === 2 ? 1 : $report->status,
                    'transaction_time' => $statusId === 2 ? now()->toDateTimeString() : $report->transaction_time,
                    'bill_code' => $billCode,
                ]);
            }
        }

        return response()->json(['status' => 'success']);
    }
}
