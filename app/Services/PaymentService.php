<?php

namespace App\Services;

use App\Models\Order;
use App\Models\PaypalSetting;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use Exception;

class PaymentService
{
    protected $paypalSettings;
    protected $baseUrl;

    public function __construct()
    {
        $this->paypalSettings = PaypalSetting::first();
        $this->baseUrl = $this->paypalSettings && $this->paypalSettings->mode === 'live'
            ? 'https://api-m.paypal.com'
            : 'https://api-m.sandbox.paypal.com';

        Log::info('PaymentService initialized', [
            'mode' => $this->paypalSettings->mode ?? 'sandbox',
            'base_url' => $this->baseUrl
        ]);
    }

    /**
     * Process a payment based on the selected method
     */
    public function processPayment(Order $order, string $paymentMethod)
    {
        switch ($paymentMethod) {
            case 'paypal':
                return $this->processPaypalPayment($order);
            case 'mastercard':
                return $this->processCreditCardPayment($order);
            default:
                throw new Exception("Unsupported payment method: {$paymentMethod}");
        }
    }

    /**
     * Process a payment using PayPal API v2
     */
    protected function processPaypalPayment(Order $order)
    {
        if (!$this->paypalSettings) {
            throw new Exception("PayPal settings are not configured");
        }

        try {
            // Get access token
            $accessToken = $this->getAccessToken();

            // Create PayPal order
            $paypalOrder = $this->createPaypalOrder($order, $accessToken);

            // Get approval URL
            $approvalUrl = $this->getApprovalUrl($paypalOrder);

            // Save PayPal order ID to our order
            $order->payment_id = $paypalOrder['id'];
            $order->save();

            return [
                'success' => true,
                'redirect_url' => $approvalUrl,
                'paypal_order_id' => $paypalOrder['id']
            ];
        } catch (\Exception $e) {
            Log::error('PayPal payment error', [
                'order_id' => $order->id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            throw new Exception("Failed to process PayPal payment: " . $e->getMessage());
        }
    }

    /**
     * Get PayPal access token
     */
    protected function getAccessToken()
    {
        $clientId = $this->getClientId();
        $clientSecret = $this->getClientSecret();

        $response = Http::withBasicAuth($clientId, $clientSecret)
            ->asForm()
            ->post($this->baseUrl . '/v1/oauth2/token', [
                'grant_type' => 'client_credentials'
            ]);

        if (!$response->successful()) {
            throw new Exception('Failed to get PayPal access token: ' . $response->body());
        }

        $data = $response->json();
        return $data['access_token'];
    }

    /**
     * Create PayPal order using API v2
     */
    protected function createPaypalOrder(Order $order, $accessToken)
    {
        $orderData = [
            'intent' => 'CAPTURE',
            'purchase_units' => [
                [
                    'reference_id' => $order->order_code,
                    'amount' => [
                        'currency_code' => 'USD',
                        'value' => number_format($order->total_amount, 2, '.', '')
                    ],
                    'description' => "Order #{$order->order_code}",
                    'invoice_id' => $order->order_code
                ]
            ],
            'application_context' => [
                'return_url' => route('payment.paypal.success', ['order_id' => $order->id]),
                'cancel_url' => route('payment.paypal.cancel', ['order_id' => $order->id]),
                'brand_name' => config('app.name'),
                'landing_page' => 'LOGIN',
                'user_action' => 'PAY_NOW'
            ]
        ];

        $response = Http::withToken($accessToken)
            ->withHeaders([
                'Content-Type' => 'application/json',
                'PayPal-Request-Id' => (string) Str::uuid()
            ])
            ->post($this->baseUrl . '/v2/checkout/orders', $orderData);

        if (!$response->successful()) {
            Log::error('PayPal order creation failed', [
                'status' => $response->status(),
                'response' => $response->body(),
                'order_data' => $orderData
            ]);
            throw new Exception('Failed to create PayPal order: ' . $response->body());
        }

        return $response->json();
    }

    /**
     * Get approval URL from PayPal order response
     */
    protected function getApprovalUrl($paypalOrder)
    {
        foreach ($paypalOrder['links'] as $link) {
            if ($link['rel'] === 'approve') {
                return $link['href'];
            }
        }

        throw new Exception('Approval URL not found in PayPal response');
    }

    /**
     * Capture PayPal payment after user approval
     */
    public function capturePaypalPayment($paypalOrderId, Order $order)
    {
        try {
            $accessToken = $this->getAccessToken();

            Log::debug('Capture request sending', [
                'url' => $this->baseUrl . "/v2/checkout/orders/{$paypalOrderId}/capture",
            ]);

            $client = new \GuzzleHttp\Client();
            $response = $client->post("{$this->baseUrl}/v2/checkout/orders/{$paypalOrderId}/capture", [
                'headers' => [
                    'Authorization' => "Bearer {$accessToken}",
                    'PayPal-Request-Id' => (string) Str::uuid(),
                    'Content-Type' => 'application/json',
                ],
                'body' => null,
            ]);



            $captureData = json_decode($response->getBody(), true);

            // Check capture status
            if ($captureData['status'] === 'COMPLETED') {
                // Update order status
                $order->status_payment = 'pending';
                $order->status = 'pending';
                $order->payment_id = $paypalOrderId;

                // Save capture details
                if (isset($captureData['purchase_units'][0]['payments']['captures'][0])) {
                    $capture = $captureData['purchase_units'][0]['payments']['captures'][0];
                    $order->payment_transaction_id = $capture['id'];
                }

                $order->save();

                return [
                    'success' => true,
                    'message' => 'Payment completed successfully',
                    'capture_data' => $captureData
                ];
            } else {
                throw new Exception("Payment capture status: " . $captureData['status']);
            }
        } catch (\Exception $e) {
            Log::error('PayPal capture error', [
                'order_id' => $order->id,
                'error' => $e->getMessage(),
                'paypal_order_id' => $paypalOrderId
            ]);

            throw new Exception("Failed to capture PayPal payment: " . $e->getMessage());
        }
    }

    /**
     * Process payment using credit card (demo mode)
     */
    protected function processCreditCardPayment(Order $order)
    {
        try {
            // Generate a payment confirmation token
            $paymentToken = Str::random(32);

            // Update order with payment info
            $order->payment_id = $paymentToken;
            $order->status_payment = 'completed';
            $order->status = 'processing';
            $order->save();

            Log::info('Credit card payment processed', [
                'order_id' => $order->id,
                'amount' => $order->total_amount,
                'payment_token' => $paymentToken,
                'demo_mode' => true
            ]);

            return [
                'success' => true,
                'redirect_url' => route('user.checkout.success', ['order' => $order->id]),
                'message' => 'Payment processed successfully'
            ];
        } catch (\Exception $e) {
            Log::error('Credit card payment error', [
                'order_id' => $order->id,
                'error' => $e->getMessage()
            ]);

            throw new Exception("Failed to process credit card payment: " . $e->getMessage());
        }
    }

    /**
     * Handle PayPal webhook notifications
     */
    public function handlePaypalWebhook(array $webhookData)
    {
        Log::info('PayPal webhook received', $webhookData);

        try {
            $eventType = $webhookData['event_type'] ?? '';

            switch ($eventType) {
                case 'CHECKOUT.ORDER.APPROVED':
                    $this->handleOrderApproved($webhookData);
                    break;

                case 'PAYMENT.CAPTURE.COMPLETED':
                    $this->handlePaymentCaptureCompleted($webhookData);
                    break;

                case 'PAYMENT.CAPTURE.DENIED':
                case 'PAYMENT.CAPTURE.FAILED':
                    $this->handlePaymentCaptureFailed($webhookData);
                    break;

                default:
                    Log::info('Unhandled PayPal webhook event', ['event_type' => $eventType]);
            }

            return true;
        } catch (\Exception $e) {
            Log::error('PayPal webhook processing error', [
                'error' => $e->getMessage(),
                'webhook_data' => $webhookData
            ]);
            return false;
        }
    }

    /**
     * Handle order approved webhook
     */
    protected function handleOrderApproved($webhookData)
    {
        $resource = $webhookData['resource'] ?? [];
        $orderId = $resource['id'] ?? null;

        if ($orderId) {
            $order = Order::where('payment_id', $orderId)->first();
            if ($order && $order->status_payment === 'pending') {
                $order->status_payment = 'completed';
                $order->save();

                Log::info('Order approved via webhook', ['order_id' => $order->id]);
            }
        }
    }

    /**
     * Handle payment capture completed webhook
     */
    protected function handlePaymentCaptureCompleted($webhookData)
    {
        $resource = $webhookData['resource'] ?? [];
        $captureId = $resource['id'] ?? null;
        $orderId = $resource['custom_id'] ?? null;

        if ($orderId) {
            $order = Order::where('order_code', $orderId)->first();
            if ($order) {
                $order->status_payment = 'completed';
                $order->status = 'processing';
                $order->payment_transaction_id = $captureId;
                $order->save();

                Log::info('Payment capture completed via webhook', [
                    'order_id' => $order->id,
                    'capture_id' => $captureId
                ]);
            }
        }
    }

    /**
     * Handle payment capture failed webhook
     */
    protected function handlePaymentCaptureFailed($webhookData)
    {
        $resource = $webhookData['resource'] ?? [];
        $orderId = $resource['custom_id'] ?? null;

        if ($orderId) {
            $order = Order::where('order_code', $orderId)->first();
            if ($order) {
                $order->status_payment = 'failed';
                $order->status = 'cancelled';
                $order->save();

                Log::info('Payment capture failed via webhook', ['order_id' => $order->id]);
            }
        }
    }

    /**
     * Get PayPal client ID based on mode
     */
    protected function getClientId()
    {
        if ($this->paypalSettings->mode === 'sandbox') {
            return $this->paypalSettings->sandbox_username;
        } else {
            return $this->paypalSettings->live_username;
        }
    }

    /**
     * Get PayPal client secret based on mode
     */
    protected function getClientSecret()
    {
        if ($this->paypalSettings->mode === 'sandbox') {
            return $this->paypalSettings->sandbox_secret;
        } else {
            return $this->paypalSettings->live_secret;
        }
    }

    /**
     * Process PayPal refund using API v2
     */
    public function refundPaypalPayment(Order $order, $amount = null, $reason = '')
    {
        if (!$order->payment_transaction_id) {
            throw new Exception("No capture ID found for this order");
        }

        try {
            $accessToken = $this->getAccessToken();

            $refundData = [
                'amount' => [
                    'currency_code' => 'USD',
                    'value' => number_format($amount ?? $order->total_amount, 2, '.', '')
                ]
            ];

            if ($reason) {
                $refundData['note_to_payer'] = $reason;
            }

            $response = Http::withToken($accessToken)
                ->withHeaders([
                    'Content-Type' => 'application/json',
                    'PayPal-Request-Id' => (string) Str::uuid() // SỬA LẠI DÒNG NÀY
                ])
                ->post($this->baseUrl . "/v2/payments/captures/{$order->payment_transaction_id}/refund", $refundData);

            if (!$response->successful()) {
                throw new Exception('Failed to process PayPal refund: ' . $response->body());
            }

            $refundResponse = $response->json();

            if ($refundResponse['status'] === 'COMPLETED') {
                $order->status_payment = 'refunded';
                $order->status = 'cancelled';
                $order->refund_amount = $amount ?? $order->total_amount;
                $order->refund_reason = $reason;
                $order->refunded_at = now();
                $order->save();

                return [
                    'success' => true,
                    'message' => 'Refund processed successfully',
                    'refund_data' => $refundResponse
                ];
            } else {
                throw new Exception("Refund status: " . $refundResponse['status']);
            }
        } catch (\Exception $e) {
            Log::error('PayPal refund error', [
                'order_id' => $order->id,
                'error' => $e->getMessage()
            ]);

            throw new Exception("Failed to process PayPal refund: " . $e->getMessage());
        }
    }
}
