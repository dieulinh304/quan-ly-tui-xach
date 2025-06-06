<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sanpham;
use App\Models\Danhmuc;
use App\Repositories\ISanphamRepository;
use DB;
class HomeController extends Controller
{
    private $sanphamRepository;

    public function __construct(ISanphamRepository $sanphamRepository) {
        $this->sanphamRepository = $sanphamRepository;
    }

    public function index() {
    $alls = $this->sanphamRepository->allProduct();
    $sanphams = $this->sanphamRepository->featuredProducts();
    $gucciProducts = $this->sanphamRepository->getProductsByCategory(9);
    $diorProducts = $this->sanphamRepository->getProductsByCategory(10);
    $hermesProducts = $this->sanphamRepository->getProductsByCategory(11);
    $chanelProducts = $this->sanphamRepository->getProductsByCategory(12);

    return view('pages.home', [
        'alls' => $alls,
        'sanphams' => $sanphams,
        'gucciProducts' => $gucciProducts,
        'diorProducts' => $diorProducts,
        'hermesProducts' => $hermesProducts,
        'chanelProducts' => $chanelProducts,
    ]);
}

    public function congiong() {
        $danhmucs = Danhmuc::all();
        return view('pages.congiong', [
            'danhmucs' => $danhmucs,
        ]);
    }

    public function detail($id) {
        $sanpham = Sanpham::findOrFail($id);
        $soluongDaBan = DB::table('chitiet_donhang')
        ->where('id_sanpham', $id)
        ->sum('soluong');
         $sanpham->soluong = max($sanpham->soluong - $soluongDaBan, 0);
        $randoms = $this->sanphamRepository->randomProduct()->take(5);
        $comments = \App\Models\Comment::where('sanpham_id', $id)->with('user')->get();

        return view('pages.detail', [
            'sanpham' => $sanpham,
            'randoms' => $randoms,
            'comments' => $comments,
        ]);
    }

    public function search(Request $request) {
        $searchs = $this->sanphamRepository->searchProduct($request);
        return view('pages.search')->with('searchs', $searchs)->with('tukhoa', $request->input('tukhoa'));
    }

    public function viewAll(Request $request) {
        $danhmucs = Danhmuc::all();
        $viewAllPaginations = $this->sanphamRepository->getAllByDanhMuc($request);

        return view('pages.viewall', [
            'sanphams' => $viewAllPaginations,
            'danhmucs' => $danhmucs,
        ]);
    }

    public function services() {
        $danhmucs = Danhmuc::all();
        return view('pages.services', [
            'danhmucs' => $danhmucs,
        ]);
    }
}
