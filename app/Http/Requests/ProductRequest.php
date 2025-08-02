<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $productId = $this->route('product') ? $this->route('product')->id : null;

        return [
            'title' => 'required|string|max:255',
            'slug' => [
                'required',
                'string',
                'max:255',
                Rule::unique('products')->ignore($productId)
            ],
            'category_id' => 'required|exists:categories,id',
            'subcategory_id' => 'required|exists:subcategories,id',
            'brand_id' => 'nullable|integer',
            'old_price' => 'nullable|numeric|min:0',
            'price' => 'required|numeric|min:0',
            'short_description' => 'nullable|string|max:500',
            'description' => 'nullable|string',
            'additional_information' => 'nullable|string',
            'shipping_return' => 'nullable|string',
            'status' => 'boolean',
            'colors' => 'nullable|array',
            'colors.*' => 'exists:colors,id',
            'sizes' => 'nullable|array',
            'sizes.*.size_name' => 'required|string|max:50',
            'sizes.*.size_value' => 'nullable',
            'sizes.*.additional_price' => 'nullable',
            'sizes.*.stock_quantity' => 'nullable',
            // Image validation
            'images' => 'nullable|array|max:10', // Maximum 10 images
            'images.*.image_data' => 'required|string', 
            'images.*.mime_type' => 'required|string|in:image/jpeg,image/jpg,image/png,image/gif,image/webp',
            'images.*.original_name' => 'required|string|max:255',
            'images.*.order' => 'nullable|integer|min:0'
        ];
    }

    /**
     * Get custom error messages
     */
    public function messages(): array
    {
        return [
            'title.required' => 'Product title is required.',
            'slug.required' => 'Product slug is required.',
            'slug.unique' => 'This slug is already taken.',
            'category_id.required' => 'Please select a category.',
            'category_id.exists' => 'Selected category does not exist.',
            'subcategory_id.required' => 'Please select a subcategory.',
            'subcategory_id.exists' => 'Selected subcategory does not exist.',
            'price.required' => 'Product price is required.',
            'price.numeric' => 'Price must be a valid number.',
            'price.min' => 'Price must be greater than or equal to 0.',
            'old_price.numeric' => 'Old price must be a valid number.',
            'old_price.min' => 'Old price must be greater than or equal to 0.',
            'sizes.*.size_name.required' => 'Size name is required for each size variation.',
            'sizes.*.size_name.string' => 'Size name must be a string.',
            'sizes.*.size_name.max' => 'Size name cannot be longer than 50 characters.',
            'sizes.*.additional_price.numeric' => 'Additional price must be a valid number.',
            'sizes.*.additional_price.min' => 'Additional price cannot be negative.',
            'sizes.*.stock_quantity.integer' => 'Stock quantity must be a whole number.',
            'sizes.*.stock_quantity.min' => 'Stock quantity cannot be negative.',
            // Image validation messages
            'images.max' => 'You can upload a maximum of 10 images.',
            'images.*.image_data.required' => 'Image data is required for each uploaded image.',
            'images.*.mime_type.required' => 'Image type is required.',
            'images.*.mime_type.in' => 'Invalid image format. Only JPEG, PNG, GIF, and WebP images are allowed.',
            'images.*.original_name.required' => 'Image filename is required.',
            'images.*.original_name.max' => 'Image filename cannot be longer than 255 characters.',
            'images.*.order.integer' => 'Image order must be a number.',
            'images.*.order.min' => 'Image order cannot be negative.',
        ];
    }

    /**
     * Configure the validator instance.
     */
    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            if ($this->old_price && $this->price && $this->old_price <= $this->price) {
                $validator->errors()->add('old_price', 'Old price must be greater than current price.');
            }
            
            // Advanced image validation
            if ($this->has('images') && is_array($this->images)) {
                foreach ($this->images as $index => $image) {
                    if (isset($image['image_data']) && isset($image['mime_type'])) {
                        $this->validateImageData($validator, $image, $index);
                    }
                }
            }
        });
    }
    
    /**
     * Validate image data for format, size, and dimensions
     */
    private function validateImageData($validator, $image, $index)
    {
        $imageData = $image['image_data'];
        $mimeType = $image['mime_type'];
        
        // Check if image data is valid base64
        if (!$this->isValidBase64Image($imageData)) {
            $validator->errors()->add("images.{$index}.image_data", "Invalid image format or corrupted image data.");
            return;
        }
        
        // Remove data URL prefix if present for size calculation
        $base64Data = preg_replace('/^data:image\/[^;]+;base64,/', '', $imageData);
        
        // Check file size (limit to 5MB)
        $fileSizeBytes = (int) (strlen(rtrim($base64Data, '=')) * 3 / 4);
        $maxSizeBytes = 5 * 1024 * 1024; // 5MB
        if ($fileSizeBytes > $maxSizeBytes) {
            $validator->errors()->add("images.{$index}.image_data", "Image file size must not exceed 5MB.");
            return;
        }
        
        // Check minimum file size (1KB)
        $minSizeBytes = 1024; // 1KB
        if ($fileSizeBytes < $minSizeBytes) {
            $validator->errors()->add("images.{$index}.image_data", "Image file size must be at least 1KB.");
            return;
        }
        
        // Validate image dimensions using getimagesizefromstring (if available) or basic validation
        if (function_exists('getimagesizefromstring')) {
            try {
                $imageInfo = getimagesizefromstring(base64_decode($base64Data));
                if ($imageInfo === false) {
                    $validator->errors()->add("images.{$index}.image_data", "Invalid or corrupted image file.");
                    return;
                }
                
                $width = $imageInfo[0];
                $height = $imageInfo[1];
                
                // Check minimum dimensions (50x50)
                if ($width < 50 || $height < 50) {
                    $validator->errors()->add("images.{$index}.image_data", "Image dimensions must be at least 50x50 pixels. Current: {$width}x{$height}");
                    return;
                }
                
                // Check maximum dimensions (4000x4000)
                if ($width > 4000 || $height > 4000) {
                    $validator->errors()->add("images.{$index}.image_data", "Image dimensions must not exceed 4000x4000 pixels. Current: {$width}x{$height}");
                    return;
                }
                
            } catch (\Exception $e) {
                $validator->errors()->add("images.{$index}.image_data", "Unable to process image. Please ensure it's a valid image file.");
                return;
            }
        }
        
        // Validate mime type matches image content
        if (!$this->validateMimeTypeMatch($base64Data, $mimeType)) {
            $validator->errors()->add("images.{$index}.mime_type", "Image file type does not match the expected format.");
        }
    }
    
    /**
     * Check if the provided string is valid base64 image data
     */
    private function isValidBase64Image($imageData)
    {
        // Remove data URL prefix if present
        $base64Data = preg_replace('/^data:image\/[^;]+;base64,/', '', $imageData);
        
        // Check if it's valid base64
        if (!base64_decode($base64Data, true)) {
            return false;
        }
        
        // Check if we can get image info (this works without GD extension)
        if (function_exists('getimagesizefromstring')) {
            try {
                $imageInfo = getimagesizefromstring(base64_decode($base64Data));
                return $imageInfo !== false;
            } catch (\Exception $e) {
                return false;
            }
        }
        
        // Fallback: basic validation - check if decoded data starts with common image signatures
        $decodedData = base64_decode($base64Data);
        if (strlen($decodedData) < 4) {
            return false;
        }
        
        // Check for common image file signatures
        $signatures = [
            'JPEG' => ['\xFF\xD8\xFF'],
            'PNG' => ['\x89\x50\x4E\x47'],
            'GIF' => ['\x47\x49\x46\x38\x37\x61', '\x47\x49\x46\x38\x39\x61'],
            'WEBP' => ['\x52\x49\x46\x46']
        ];
        
        foreach ($signatures as $format => $sigs) {
            foreach ($sigs as $sig) {
                if (substr($decodedData, 0, strlen($sig)) === $sig) {
                    return true;
                }
            }
        }
        
        return false;
    }
    
    /**
     * Validate that the mime type matches the actual image content
     */
    private function validateMimeTypeMatch($base64Data, $expectedMimeType)
    {
        try {
            $imageData = base64_decode($base64Data);
            $finfo = finfo_open(FILEINFO_MIME_TYPE);
            $actualMimeType = finfo_buffer($finfo, $imageData);
            finfo_close($finfo);
            
            // Normalize mime types (handle jpg vs jpeg)
            $normalizedExpected = str_replace('image/jpg', 'image/jpeg', $expectedMimeType);
            $normalizedActual = str_replace('image/jpg', 'image/jpeg', $actualMimeType);
            
            return $normalizedExpected === $normalizedActual;
        } catch (\Exception $e) {
            return false;
        }
    }
}
