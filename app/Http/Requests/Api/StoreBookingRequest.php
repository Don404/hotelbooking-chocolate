<?php

namespace App\Http\Requests\Api;

use App\Models\Booking;
use Illuminate\Foundation\Http\FormRequest;

class StoreBookingRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'room_id' => 'required|exists:rooms,id',
            'customer_id' => 'required|exists:customers,id',
            'check_in_date' => 'required|date',
            'check_out_date' => 'required|date|after:check_in_date',
            'total_price' => 'required'
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            if (!$this->isRoomAvailable()) {
                $validator->errors()->add('room_not_available', 'Room is not available for the selected dates.');
            }
        });
    }

    protected function isRoomAvailable()
    {
        $existingBookings = Booking::where('room_id', $this->room_id)
            ->where(function ($query) {
                $query->whereBetween('check_in_date', [$this->check_in_date, $this->check_out_date])
                    ->orWhereBetween('check_out_date', [$this->check_in_date, $this->check_out_date])
                    ->orWhere(function ($query) {
                        $query->where('check_in_date', '<', $this->check_in_date)
                            ->where('check_out_date', '>', $this->check_out_date);
                    });
            })
            ->count();

        return $existingBookings === 0;
    }
}
