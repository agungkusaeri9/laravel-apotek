<?php

namespace App\Services;

use App\Models\Product;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

class WhatsappService
{
    protected $client;
    protected $token;
    protected $wa_admin;

    public function __construct()
    {
        $this->client = new Client();
        $this->wa_admin = env('WA_ADMIN');
        $this->token = env('FONNTE_TOKEN');
    }

    public function send($target = NULL, $message)
    {
        try {
            $response = $this->client->post('https://api.fonnte.com/send', [
                'headers' => [
                    'Authorization' => $this->token,
                ],
                'multipart' => [
                    [
                        'name' => 'target',
                        'contents' => $target,
                    ],
                    [
                        'name' => 'message',
                        'contents' => $message,
                    ]
                ],
            ]);

            // dd($response->getBody()->getContents());
        } catch (RequestException $e) {
            // dd($e->getMessage());
        }
    }

    public function stokMenipis($product_id)
    {
        $product = Product::find($product_id);
        $message = "Halo, Admin.\n\n";
        $message .= "Kami ingin memberitahukan bahwa stok produk berikut sedang menipis:\n\n";
        $message .= "Nama Produk: " . $product->nama . "\n";
        $message .= "Jumlah Tersisa: " . $product->stok . "\n\n";
        $message .= "Mohon segera lakukan pengisian ulang stok agar tidak kehabisan. Terima kasih atas perhatian Anda.\n\nSalam,\nApotek";
        $this->send($this->wa_admin, $message);
    }
}
