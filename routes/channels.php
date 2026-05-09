<?php

use Illuminate\Support\Facades\Broadcast;

// Public channel — mobile app bisa subscribe tanpa auth
Broadcast::channel('orders.{orderId}', function () {
    return true; // public, karena customer tidak login
});