<?php
namespace App\Policies;

use App\Models\ShipmentRequest;
use App\Models\User;

class ShipmentRequestPolicy
{
    public function view(User $user, ShipmentRequest $shipmentRequest): bool
    {
        return $user->id === $shipmentRequest->user_id || $user->isAdminOrStaff();
    }
}
