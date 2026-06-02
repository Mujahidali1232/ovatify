<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class InvestmentResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'asset' => [
                'id' => $this->asset->id,
                'title' => $this->asset->title,
                'type' => $this->asset->asset_type,
                'valuation' => $this->asset->total_valuation,
            ],
            'blocks_purchased' => (int)$this->blocks_purchased,
            'investment_amount' => (float)$this->investment_amount,
            'ownership_percentage' => (float)$this->ownership_percentage,
            'expected_roi' => (float)($this->expected_roi ?? 0),
            'invested_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}