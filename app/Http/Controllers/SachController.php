<?php

namespace App\Http\Controllers;

use App\Models\Sach;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SachController extends Controller
{
    public function index()
    {
        $saches = Sach::orderBy('id', 'desc')->get();

        $title = 'Trang chủ';
        return view('index', compact('saches', 'title'));
    }

    public function theoTheLoai($id)
    {
        $saches = Sach::where('the_loai', $id)->orderBy('id', 'desc')->get();

        $title = 'Sách theo thể loại';
        return view('index', compact('saches', 'title'));
    }

    public function show($id)
    {
        $sach = Sach::findOrFail($id);

        $sachCungTheLoai = Sach::where('the_loai', $sach->the_loai)
            ->where('id', '<>', $sach->id)
            ->take(5)
            ->get();

        $title = $sach->tieu_de;

        return view('show', compact('sach', 'sachCungTheLoai', 'title'));
    }

    public function cartadd(Request $request)
    {
        $request->validate([
            "id" => ["required", "numeric"],
            "num" => ["required", "numeric", "min:1"]
        ]);

        $id = $request->id;
        $num = $request->num;
        $cart = [];

        if (session()->has('cart')) {
            $cart = session()->get('cart');
            if (isset($cart[$id])) {
                $cart[$id] += $num;
            } else {
                $cart[$id] = $num;
            }
        } else {
            $cart[$id] = $num;
        }

        session()->put('cart', $cart);

        return response()->json(count($cart));
    }

    public function order()
    {
        $data = [];
        $quantity = [];

        if (session()->has('cart') && count(session('cart')) > 0) {

            $cart = session('cart');
            $bookIds = array_keys($cart);

            $data = DB::table('sach')->whereIn('id', $bookIds)->get();

            foreach ($cart as $id => $value) {
                $quantity[$id] = $value;
            }
        }

        $title = 'Giỏ hàng';

        return view('order', compact('data', 'quantity', 'title'));
    }

    public function cartdelete(Request $request)
    {
        $request->validate([
            "id" => ["required", "numeric"]
        ]);

        $id = $request->id;
        $cart = [];

        if (session()->has('cart')) {
            $cart = session()->get("cart");
            unset($cart[$id]);
        }

        session()->put("cart", $cart);

        return redirect()->route('order');
    }

    public function ordercreate(Request $request)
    {
        $request->validate([
            'hinh_thuc_thanh_toan' => ['required', 'numeric'],
            'book_id' => ['required', 'array'],
            'book_id.*' => ['required', 'numeric'],
        ]);

        $bookIds = $request->book_id;
        $soLuong = $request->so_luong ?? [];

        $data = DB::table('sach')->whereIn('id', $bookIds)->get();
        $quantity = [];

        foreach ($bookIds as $id) {
            $quantity[$id] = isset($soLuong[$id]) ? (int) $soLuong[$id] : 1;
        }

        DB::transaction(function () use ($request, $data, $quantity) {
            $id_don_hang = DB::table('don_hang')->insertGetId([
                'ngay_dat_hang' => now(),
                'tinh_trang' => 1,
                'hinh_thuc_thanh_toan' => $request->hinh_thuc_thanh_toan,
                'user_id' => Auth::id(),
            ]);

            $detail = [];

            foreach ($data as $row) {
                $detail[] = [
                    'ma_don_hang' => $id_don_hang,
                    'sach_id' => $row->id,
                    'so_luong' => $quantity[$row->id],
                    'don_gia' => $row->gia_ban,
                ];
            }

            DB::table('chi_tiet_don_hang')->insert($detail);
        });

        if (session()->has('cart')) {
            $cart = session('cart');

            foreach ($bookIds as $id) {
                if (isset($cart[$id])) {
                    unset($cart[$id]);
                }
            }

            session()->put('cart', $cart);
        }

        $message = $request->order_type === 'buy_now'
            ? 'Mua hàng thành công'
            : 'Đặt hàng thành công';

        if ((int) $request->hinh_thuc_thanh_toan === 2) {
            $message .= '. Hình thức thanh toán Chuyển khoản đang được phát triển';
        }

        if ((int) $request->hinh_thuc_thanh_toan === 3) {
            $message .= '. Hình thức thanh toán VNPay đang được phát triển';
        }

        return redirect()->route('order')->with('status', $message);
    }

    public function buyNow(Request $request)
    {
        $request->validate([
            'id' => ['required', 'numeric'],
            'num' => ['required', 'numeric', 'min:1']
        ]);

        $id = $request->id;
        $num = $request->num;

        $data = DB::table('sach')->where('id', $id)->get();
        $quantity = [
            $id => $num
        ];

        $title = 'Đặt hàng';

        return view('order', compact('data', 'quantity', 'title'));
    }
}