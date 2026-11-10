<?php
// Client for the standard SMM panel API (v2). https://wholesmm.com/docs/api
class SmmApi
{
    public function __construct(private string $url, private string $key) {}

    public function call(string $action, array $fields = []): array
    {
        $ch = curl_init($this->url);
        curl_setopt_array($ch, [
            CURLOPT_POST => true,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_POSTFIELDS => http_build_query(['key' => $this->key, 'action' => $action] + $fields),
        ]);
        $body = curl_exec($ch);
        $err = curl_error($ch);
        curl_close($ch);
        if ($body === false) return ['error' => $err ?: 'Request failed'];
        return json_decode($body, true) ?? ['error' => 'Invalid JSON answer'];
    }

    public function services(): array { return $this->call('services'); }
    public function add(int $service, string $link, int $quantity, array $extra = []): array
    { return $this->call('add', ['service' => $service, 'link' => $link, 'quantity' => $quantity] + $extra); }
    public function status(int $order): array { return $this->call('status', ['order' => $order]); }
    public function multiStatus(array $orders): array { return $this->call('status', ['orders' => implode(',', $orders)]); }
    public function refill(int $order): array { return $this->call('refill', ['order' => $order]); }
    public function refillStatus(string $refill): array { return $this->call('refill_status', ['refill' => $refill]); }
    public function cancel(array $orders): array { return $this->call('cancel', ['orders' => implode(',', $orders)]); }
    public function balance(): array { return $this->call('balance'); }
}
