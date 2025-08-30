<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\DeliveryMan;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class DeliveryController extends Controller
{
    public function dashboard()
    {
        $deliveryMan = Auth::user()->deliveryMan;
        
        if (!$deliveryMan) {
            return redirect()->route('home')->with('error', 'Delivery man profile not found.');
        }

        // Get today's orders
        $todayOrders = Order::where('delivery_man_id', $deliveryMan->id)
            ->whereDate('created_at', Carbon::today())
            ->count();

        // Get pending orders
        $pendingOrders = Order::where('delivery_man_id', $deliveryMan->id)
            ->whereIn('status', ['assigned', 'picked_up'])
            ->count();

        // Get today's earnings
        $todayEarnings = Order::where('delivery_man_id', $deliveryMan->id)
            ->whereDate('created_at', Carbon::today())
            ->where('status', 'delivered')
            ->sum('delivery_fee');

        // Get recent orders
        $recentOrders = Order::where('delivery_man_id', $deliveryMan->id)
            ->with(['customer', 'product', 'supplier'])
            ->latest()
            ->take(5)
            ->get();

        return view('delivery.dashboard', compact(
            'deliveryMan',
            'todayOrders',
            'pendingOrders',
            'todayEarnings',
            'recentOrders'
        ));
    }

    public function orders()
    {
        $deliveryMan = Auth::user()->deliveryMan;
        
        if (!$deliveryMan) {
            return redirect()->route('home')->with('error', 'Delivery man profile not found.');
        }

        $orders = Order::where('delivery_man_id', $deliveryMan->id)
            ->with(['customer', 'product', 'supplier'])
            ->latest()
            ->paginate(10);

        return view('delivery.orders', compact('orders', 'deliveryMan'));
    }

    public function orderDetails($id)
    {
        $deliveryMan = Auth::user()->deliveryMan;
        
        if (!$deliveryMan) {
            return redirect()->route('home')->with('error', 'Delivery man profile not found.');
        }

        $order = Order::where('delivery_man_id', $deliveryMan->id)
            ->where('id', $id)
            ->with(['customer', 'product', 'supplier'])
            ->firstOrFail();

        return view('delivery.order-details', compact('order', 'deliveryMan'));
    }

    public function updateOrderStatus(Request $request, $id)
    {
        $deliveryMan = Auth::user()->deliveryMan;
        
        if (!$deliveryMan) {
            return redirect()->back()->with('error', 'Delivery man profile not found.');
        }

        $order = Order::where('delivery_man_id', $deliveryMan->id)
            ->where('id', $id)
            ->firstOrFail();

        $request->validate([
            'status' => 'required|in:assigned,picked_up,delivered,cancelled'
        ]);

        $order->update([
            'status' => $request->status,
            'actual_delivery_time' => $request->status === 'delivered' ? now() : null
        ]);

        // Update delivery man status based on order status
        if ($request->status === 'picked_up') {
            $deliveryMan->update(['status' => 'busy']);
        } elseif ($request->status === 'delivered') {
            $deliveryMan->update(['status' => 'available']);
        }

        return redirect()->back()->with('success', 'Order status updated successfully.');
    }

    public function updateLocation(Request $request)
    {
        $deliveryMan = Auth::user()->deliveryMan;
        
        if (!$deliveryMan) {
            return response()->json(['error' => 'Delivery man profile not found.'], 404);
        }

        $request->validate([
            'lat' => 'required|numeric',
            'lng' => 'required|numeric'
        ]);

        $deliveryMan->updateLocation($request->lat, $request->lng);

        return response()->json(['success' => true]);
    }

    public function updateStatus(Request $request)
    {
        $deliveryMan = Auth::user()->deliveryMan;
        
        if (!$deliveryMan) {
            return redirect()->back()->with('error', 'Delivery man profile not found.');
        }

        $request->validate([
            'status' => 'required|in:available,busy,offline'
        ]);

        $deliveryMan->update([
            'status' => $request->status,
            'last_active' => now()
        ]);

        return redirect()->back()->with('success', 'Status updated successfully.');
    }

    public function earnings()
    {
        $deliveryMan = Auth::user()->deliveryMan;
        
        if (!$deliveryMan) {
            return redirect()->route('home')->with('error', 'Delivery man profile not found.');
        }

        // Get earnings for different time periods
        $todayEarnings = Order::where('delivery_man_id', $deliveryMan->id)
            ->whereDate('created_at', Carbon::today())
            ->where('status', 'delivered')
            ->sum('delivery_fee');

        $weekEarnings = Order::where('delivery_man_id', $deliveryMan->id)
            ->whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])
            ->where('status', 'delivered')
            ->sum('delivery_fee');

        $monthEarnings = Order::where('delivery_man_id', $deliveryMan->id)
            ->whereMonth('created_at', Carbon::now()->month)
            ->whereYear('created_at', Carbon::now()->year)
            ->where('status', 'delivered')
            ->sum('delivery_fee');

        // Get earnings history
        $earningsHistory = Order::where('delivery_man_id', $deliveryMan->id)
            ->where('status', 'delivered')
            ->selectRaw('DATE(created_at) as date, SUM(delivery_fee) as total_earnings, COUNT(*) as deliveries')
            ->groupBy('date')
            ->orderBy('date', 'desc')
            ->take(30)
            ->get();

        return view('delivery.earnings', compact(
            'deliveryMan',
            'todayEarnings',
            'weekEarnings',
            'monthEarnings',
            'earningsHistory'
        ));
    }

    public function profile()
    {
        $deliveryMan = Auth::user()->deliveryMan;
        
        if (!$deliveryMan) {
            return redirect()->route('home')->with('error', 'Delivery man profile not found.');
        }

        return view('delivery.profile', compact('deliveryMan'));
    }

    public function updateProfile(Request $request)
    {
        $deliveryMan = Auth::user()->deliveryMan;
        
        if (!$deliveryMan) {
            return redirect()->back()->with('error', 'Delivery man profile not found.');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
            'emergency_contact' => 'nullable|string|max:255',
            'emergency_phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:500',
            'city' => 'nullable|string|max:100',
            'vehicle_type' => 'nullable|string|max:100',
            'vehicle_number' => 'nullable|string|max:50',
            'license_number' => 'nullable|string|max:50',
        ]);

        // Update user information
        Auth::user()->update([
            'name' => $request->name,
            'phone' => $request->phone,
            'address' => $request->address,
            'city' => $request->city,
        ]);

        // Update delivery man information
        $deliveryMan->update([
            'emergency_contact' => $request->emergency_contact,
            'emergency_phone' => $request->emergency_phone,
            'vehicle_type' => $request->vehicle_type,
            'vehicle_number' => $request->vehicle_number,
            'license_number' => $request->license_number,
        ]);

        return redirect()->back()->with('success', 'تم تحديث الملف الشخصي بنجاح');
    }

    public function exportOrders()
    {
        $deliveryMan = Auth::user()->deliveryMan;
        
        if (!$deliveryMan) {
            return redirect()->back()->with('error', 'Delivery man profile not found.');
        }

        $orders = Order::where('delivery_man_id', $deliveryMan->id)
            ->with(['customer', 'product', 'supplier'])
            ->latest()
            ->get();

        $filename = 'orders_' . $deliveryMan->id . '_' . date('Y-m-d_H-i-s') . '.csv';
        
        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $callback = function() use ($orders) {
            $file = fopen('php://output', 'w');
            
            // Add BOM for UTF-8
            fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF));
            
            // CSV Headers
            fputcsv($file, [
                'رقم الطلب',
                'اسم العميل',
                'رقم هاتف العميل',
                'اسم المنتج',
                'الكمية',
                'المبلغ الإجمالي',
                'رسوم التوصيل',
                'عنوان التوصيل',
                'حالة الطلب',
                'تاريخ الطلب',
                'وقت التوصيل الفعلي'
            ]);

            foreach ($orders as $order) {
                fputcsv($file, [
                    $order->order_number ?? $order->id,
                    $order->customer->name ?? 'غير محدد',
                    $order->customer->phone ?? 'غير محدد',
                    $order->product->name ?? 'غير محدد',
                    $order->quantity ?? 1,
                    $order->total_amount ?? 0,
                    $order->delivery_fee ?? 0,
                    $order->delivery_address ?? 'غير محدد',
                    $order->status_text ?? $order->status,
                    $order->created_at->format('Y-m-d H:i:s'),
                    $order->actual_delivery_time ? $order->actual_delivery_time->format('Y-m-d H:i:s') : 'لم يتم التوصيل'
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function exportEarnings()
    {
        $deliveryMan = Auth::user()->deliveryMan;
        
        if (!$deliveryMan) {
            return redirect()->back()->with('error', 'Delivery man profile not found.');
        }

        // Get earnings data
        $todayEarnings = Order::where('delivery_man_id', $deliveryMan->id)
            ->whereDate('created_at', Carbon::today())
            ->where('status', 'delivered')
            ->sum('delivery_fee');

        $weekEarnings = Order::where('delivery_man_id', $deliveryMan->id)
            ->whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])
            ->where('status', 'delivered')
            ->sum('delivery_fee');

        $monthEarnings = Order::where('delivery_man_id', $deliveryMan->id)
            ->whereMonth('created_at', Carbon::now()->month)
            ->whereYear('created_at', Carbon::now()->year)
            ->where('status', 'delivered')
            ->sum('delivery_fee');

        $earningsHistory = Order::where('delivery_man_id', $deliveryMan->id)
            ->where('status', 'delivered')
            ->selectRaw('DATE(created_at) as date, SUM(delivery_fee) as total_earnings, COUNT(*) as deliveries')
            ->groupBy('date')
            ->orderBy('date', 'desc')
            ->take(30)
            ->get();

        $filename = 'earnings_' . $deliveryMan->id . '_' . date('Y-m-d_H-i-s') . '.csv';
        
        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $callback = function() use ($todayEarnings, $weekEarnings, $monthEarnings, $earningsHistory) {
            $file = fopen('php://output', 'w');
            
            // Add BOM for UTF-8
            fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF));
            
            // Summary Section
            fputcsv($file, ['ملخص الأرباح']);
            fputcsv($file, ['أرباح اليوم', $todayEarnings]);
            fputcsv($file, ['أرباح الأسبوع', $weekEarnings]);
            fputcsv($file, ['أرباح الشهر', $monthEarnings]);
            fputcsv($file, []); // Empty row
            
            // History Section
            fputcsv($file, ['تاريخ', 'إجمالي الأرباح', 'عدد التوصيلات', 'متوسط التوصيل']);
            
            foreach ($earningsHistory as $earning) {
                $avgDelivery = $earning->deliveries > 0 ? $earning->total_earnings / $earning->deliveries : 0;
                fputcsv($file, [
                    $earning->date,
                    $earning->total_earnings,
                    $earning->deliveries,
                    number_format($avgDelivery, 2)
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function exportProfile()
    {
        $deliveryMan = Auth::user()->deliveryMan;
        
        if (!$deliveryMan) {
            return redirect()->back()->with('error', 'Delivery man profile not found.');
        }

        $user = Auth::user();

        $filename = 'profile_' . $deliveryMan->id . '_' . date('Y-m-d_H-i-s') . '.csv';
        
        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $callback = function() use ($user, $deliveryMan) {
            $file = fopen('php://output', 'w');
            
            // Add BOM for UTF-8
            fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF));
            
            // Personal Information
            fputcsv($file, ['المعلومات الشخصية']);
            fputcsv($file, ['الاسم الكامل', $user->name]);
            fputcsv($file, ['البريد الإلكتروني', $user->email]);
            fputcsv($file, ['رقم الهاتف', $user->phone ?? 'غير محدد']);
            fputcsv($file, ['العنوان', $user->address ?? 'غير محدد']);
            fputcsv($file, ['المدينة', $user->city ?? 'غير محدد']);
            fputcsv($file, ['تاريخ التسجيل', $user->created_at->format('Y-m-d')]);
            fputcsv($file, []); // Empty row
            
            // Delivery Information
            fputcsv($file, ['معلومات التوصيل']);
            fputcsv($file, ['الرقم الوطني', $deliveryMan->national_id ?? 'غير محدد']);
            fputcsv($file, ['نوع المركبة', $deliveryMan->vehicle_type ?? 'غير محدد']);
            fputcsv($file, ['رقم المركبة', $deliveryMan->vehicle_number ?? 'غير محدد']);
            fputcsv($file, ['رقم الرخصة', $deliveryMan->license_number ?? 'غير محدد']);
            fputcsv($file, ['جهة اتصال الطوارئ', $deliveryMan->emergency_contact ?? 'غير محدد']);
            fputcsv($file, ['رقم الطوارئ', $deliveryMan->emergency_phone ?? 'غير محدد']);
            fputcsv($file, ['الحالة', $deliveryMan->status ?? 'غير محدد']);
            fputcsv($file, ['التقييم', $deliveryMan->rating ?? 'غير محدد']);
            fputcsv($file, ['إجمالي التوصيلات', $deliveryMan->total_deliveries ?? 0]);
            fputcsv($file, ['إجمالي الأرباح', $deliveryMan->total_earnings ?? 0]);
            fputcsv($file, ['آخر نشاط', $deliveryMan->last_active ? $deliveryMan->last_active->format('Y-m-d H:i:s') : 'غير محدد']);

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
