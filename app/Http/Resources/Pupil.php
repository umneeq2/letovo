<?php

namespace App\Http\Resources;

use App\Helpers\PhoneHelper;
use Illuminate\Http\Resources\Json\JsonResource;

class Pupil extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'fullname' => $this->fullname,
            'address' => $this->address,
            'address_normalized' => $this->address_normalized,
            'geo_lat' => $this->geo_lat,
            'geo_lon' => $this->geo_lon,
            'email' => $this->email,
            'mobile_phone' => $this->mobile_phone ? PhoneHelper::beautifyMobile($this->mobile_phone) : null,
            'created_at' => $this->created_at ? $this->created_at->format('d.m.Y H:i:s') : null,
            'updated_at' => $this->updated_at ? $this->updated_at->format('d.m.Y H:i:s') : null,
        ];
    }
}
