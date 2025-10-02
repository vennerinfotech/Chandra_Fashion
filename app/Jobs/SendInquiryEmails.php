<?php


namespace App\Jobs;

use App\Mail\InquiryUserMail;
use App\Mail\InquiryAdminMail;
use App\Models\Product;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

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
        try {
            // 1. Fetch product and variants
            $product = Product::with('variants')->find($this->inquiry['product_id']);

            if (!$product) {
                Log::error('Product not found for inquiry ID: '.$this->inquiry['id']);
                return;
            }

            // 2. Prepare product variants
            $variants = [];

            foreach ($product->variants as $variant) {
                $images = json_decode($variant->images ?? '[]', true);
                if (!$images) $images = [];

                $variants[] = [
                    'product_code' => $variant->product_code,
                    'color'        => $variant->color,
                    'size'         => $variant->size,
                    'min_order_qty'=> $variant->moq,
                    'images'       => $images
                ];
            }

            // 3. Add inquiry-specific variant_details
            if (!empty($this->inquiry['variant_details'])) {
                $selectedVariant = json_decode($this->inquiry['variant_details'], true);
                if ($selectedVariant) {
                    $variants[] = [
                        'product_code' => $selectedVariant['product_code'] ?? 'N/A',
                        'color'        => $selectedVariant['color'] ?? 'N/A',
                        'size'         => $selectedVariant['size'] ?? [],
                        'min_order_qty'=> $selectedVariant['min_order_qty'] ?? 'N/A',
                        'images'       => $selectedVariant['images'] ?? []
                    ];
                }
            }

            // 4. Decode inquiry selected_images
            $selectedImages = [];
            if (!empty($this->inquiry['selected_images'])) {
                $selectedImages = json_decode($this->inquiry['selected_images'], true);
            }

            // 5. Prepare data for emails
            $data = [
                'user_name'   => $this->inquiry['name'] ?? 'Customer',
                'user_email'  => $this->inquiry['email'] ?? null,
                'company'     => $this->inquiry['company'] ?? null,
                'phone'       => $this->inquiry['phone'] ?? null,
                'country'     => $this->inquiry['country'] ?? null,
                'quantity'    => $this->inquiry['quantity'] ?? null,
                'selected_size'   => $this->inquiry['selected_size'] ?? null,
                'selected_images' => $selectedImages,
                'product' => [
                    'id'            => $product->id,
                    'name'          => $product->name,
                    'description'   => $product->description,
                    'materials'     => $product->materials,
                    'delivery_days' => $product->delivery_time,
                    'variants'      => $variants,
                ],
            ];

            // 6. Send user email
            if(!empty($data['user_email'])) {
                Mail::to($data['user_email'])->queue(new InquiryUserMail($data));
            }

            // 7. Send admin email
            Mail::to(env('ADMIN_EMAIL'))->queue(new InquiryAdminMail($data));

        } catch (\Exception $e) {
            Log::error('SendInquiryEmails failed: '.$e->getMessage());
        }
    }
}
