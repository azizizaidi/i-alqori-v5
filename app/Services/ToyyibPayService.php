<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ToyyibPayService
{
    protected string $secretKey;
    protected string $categoryCode;
    protected string $baseUrl;

    public function __construct()
    {
        $this->secretKey = config('services.toyyibpay.secret_key');
        $this->categoryCode = config('services.toyyibpay.category_code');
        $this->baseUrl = config('services.toyyibpay.sandbox', true)
            ? 'https://dev.toyyibpay.com'
            : 'https://toyyibpay.com';
    }

    /**
     * Generate HMAC-SHA256 signature
     */
    protected function generateSignature(array $data): string
    {
        $flattened = $this->flattenData($data);
        return hash_hmac('sha256', $flattened, $this->secretKey);
    }

    /**
     * Flatten data for signature
     */
    protected function flattenData(array $data): string
    {
        $result = '';
        foreach ($data as $key => $value) {
            if (is_array($value)) {
                $result .= $this->flattenData($value);
            } else {
                $result .= $key . $value;
            }
        }
        return $result;
    }

    /**
     * Create a new bill
     */
    public function createBill(array $billData): array
    {
        $default = [
            'billName' => '',
            'billDescription' => '',
            'billPriceSetting' => 0, // 0 = fixed price, 1 = buyer set price
            'billPayorInfo' => 0, // 0 = not required, 1 = required
            'billAmount' => 0,
            'billReturnUrl' => route('payment.callback'),
            'billCallbackUrl' => route('payment.webhook'),
            'billExternalReferenceNo' => '',
            'billTo' => '',
            'billEmail' => '',
            'billPhone' => '',
            'billSplitPayment' => 0,
            'billSplitPaymentArgs' => '',
            'billPaymentChannel' => 0, // 0 = all, 2 = FPX only
            'billContentEmail' => '',
            'billChargeToCustomer' => 0,
            'billExpiryDays' => 3,
            'billExpiryDate' => '',
        ];

        $payload = array_merge($default, $billData);
        $payload['billCategoryCode'] = $this->categoryCode;
        $payload['billSignature'] = $this->generateSignature($payload);

        try {
            $response = Http::post("{$this->baseUrl}/index.php/api/createBill", $payload);

            if ($response->successful()) {
                $data = $response->json();
                if (isset($data[0]['BillCode'])) {
                    return [
                        'success' => true,
                        'bill_code' => $data[0]['BillCode'],
                        'payment_url' => "{$this->baseUrl}/{$data[0]['BillCode']}",
                    ];
                }
                return ['success' => false, 'error' => 'Invalid response'];
            }

            Log::error('ToyyibPay CreateBill Error', ['response' => $response->body()]);
            return ['success' => false, 'error' => $response->body()];
        } catch (\Exception $e) {
            Log::error('ToyyibPay Exception', ['message' => $e->getMessage()]);
            return ['success' => false, 'error' => $e->getMessage()];
        }
    }

    /**
     * Get bill status
     */
    public function getBillStatus(string $billCode): array
    {
        $payload = [
            'billCode' => $billCode,
            'billSignature' => $this->generateSignature(['billCode' => $billCode]),
        ];

        try {
            $response = Http::post("{$this->baseUrl}/index.php/api/getBillStatus", $payload);

            if ($response->successful()) {
                return ['success' => true, 'data' => $response->json()];
            }

            return ['success' => false, 'error' => $response->body()];
        } catch (\Exception $e) {
            Log::error('ToyyibPay GetBillStatus Exception', ['message' => $e->getMessage()]);
            return ['success' => false, 'error' => $e->getMessage()];
        }
    }

    /**
     * Verify callback signature
     */
    public function verifyCallback(array $data): bool
    {
        if (!isset($data['status_id'], $data['bill_code'], $data['order_id'])) {
            return false;
        }

        $expectedSignature = $this->generateSignature([
            'status_id' => $data['status_id'],
            'bill_code' => $data['bill_code'],
            'order_id' => $data['order_id'],
        ]);

        return hash_equals($expectedSignature, $data['signature'] ?? '');
    }

    /**
     * Get payment status label
     */
    public function getStatusLabel(int $statusId): string
    {
        return match ($statusId) {
            1 => 'Pending',
            2 => 'Paid',
            3 => 'Failed',
            4 => 'Cancelled',
            default => 'Unknown',
        };
    }
}
