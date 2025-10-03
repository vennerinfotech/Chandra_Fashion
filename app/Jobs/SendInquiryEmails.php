<?php


namespace App\Jobs;

use Log;
use App\Models\Product;
use App\Mail\InquiryUserMail;
use Illuminate\Bus\Queueable;
use App\Mail\InquiryAdminMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class SendInquiryEmails implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $inquiry;

    public function __construct($inquiry)
    {
        $this->inquiry = $inquiry;
    }

   public function handle(): void
    {
        // 1. Fetch product and variants
        $product = Product::with('variants')->find($this->inquiry['product_id']);

        if (!$product) {
            Log::error('Product not found for inquiry ID: '.$this->inquiry['id']);
            return;
        }

        // 2. Product variants from DB
        $variants = [];
        foreach ($product->variants as $variant) {
            $images = json_decode($variant->images ?? '[]', true);
            if (!$images) $images = [];

            $variants[] = [
                'product_code'  => $variant->product_code,
                'color'         => $variant->color,
                'size'          => $variant->size,
                'min_order_qty' => $variant->moq,
                'images'        => $images
            ];
        }

        // 3. User selected variant details (if any)
        $selectedVariant = [];
        if (!empty($this->inquiry['variant_details'])) {
            $selectedVariant = $this->inquiry['variant_details'] ?? [];
        }

        // 4. Selected images from user form
        $selectedImages = [];
        if (!empty($this->inquiry['selected_images'])) {
            $selectedImages = $this->inquiry['selected_images'] ?? [];
        }

        // 5. Prepare data for email
        $data = [
            'inquiry' => [
                'name'     => $this->inquiry['name'] ?? 'Customer',
                'company'  => $this->inquiry['company'] ?? null,
                'email'    => $this->inquiry['email'] ?? null,
                'phone'    => $this->inquiry['phone'] ?? null,
                'country'  => $this->inquiry['country'] ?? null,
                'quantity' => $this->inquiry['quantity'] ?? null,
                'selected_size'   => $this->inquiry['selected_size'] ?? null,
                'selected_images' => $selectedImages,
                'variant_details' => $selectedVariant,
            ],
            'product' => [
                'id'            => $product->id,
                'name'          => $product->name,
                'description'   => $product->description,
                'category_id'   => $product->category_id,
                'materials'     => $product->materials,
                'delivery_days' => $product->delivery_time,
                'variants'      => $variants,
            ],
        ];


        // 5. Send emails
        try {
            if (!empty($data['inquiry']['email'])) {
                Mail::to($data['inquiry']['email'])->queue(new InquiryUserMail($data));
            }

            Mail::to(env('ADMIN_EMAIL'))->queue(new InquiryAdminMail($data));

        } catch (\Exception $e) {
            Log::error('SendInquiryEmails failed: '.$e->getMessage());
        }

    }
}
