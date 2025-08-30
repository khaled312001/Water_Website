<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Order status API
Route::get('/orders/{id}/status', function ($id) {
    $order = \App\Models\Order::with(['deliveryMan.user', 'payment'])->find($id);
    
    if (!$order) {
        return response()->json(['success' => false, 'message' => 'Order not found'], 404);
    }
    
    return response()->json([
        'success' => true,
        'order' => [
            'id' => $order->id,
            'status' => $order->status,
            'status_text' => $order->status_text,
            'updated_at' => $order->updated_at,
            'updated_at_diff' => $order->updated_at->diffForHumans(),
            'delivery_man' => $order->deliveryMan ? [
                'id' => $order->deliveryMan->id,
                'user' => [
                    'name' => $order->deliveryMan->user->name,
                    'phone' => $order->deliveryMan->user->phone
                ]
            ] : null,
            'payment' => $order->payment ? [
                'status' => $order->payment->status,
                'payment_method' => $order->payment->payment_method,
                'notes' => $order->payment->notes
            ] : null
        ]
    ]);
}); 