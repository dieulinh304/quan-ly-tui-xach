<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Models\Sanpham;
use App\Models\Danhmuc;
use App\Http\Controllers\Controller;

use App\Repositories\IProductRepository;

class ProductController extends Controller
{

    private $productRepository;

    public function __construct(IProductRepository $productRepository) {
        $this->productRepository = $productRepository;
    }

    // Hàm resize ảnh giữ tỉ lệ dùng GD
    private function resizeImageKeepRatio($sourcePath, $destPath, $maxWidth = 800, $maxHeight = 800) {
        list($origWidth, $origHeight, $imageType) = getimagesize($sourcePath);

        $ratio = min($maxWidth / $origWidth, $maxHeight / $origHeight);

        if ($ratio >= 1) {
            // Ảnh nhỏ hơn max thì copy luôn
            copy($sourcePath, $destPath);
            return true;
        }

        $newWidth = intval($origWidth * $ratio);
        $newHeight = intval($origHeight * $ratio);

        switch ($imageType) {
            case IMAGETYPE_JPEG:
                $image = imagecreatefromjpeg($sourcePath);
                break;
            case IMAGETYPE_PNG:
                $image = imagecreatefrompng($sourcePath);
                break;
            case IMAGETYPE_GIF:
                $image = imagecreatefromgif($sourcePath);
                break;
            default:
                return false;
        }

        $newImage = imagecreatetruecolor($newWidth, $newHeight);

        // Giữ trong suốt cho PNG và GIF
        if ($imageType == IMAGETYPE_PNG || $imageType == IMAGETYPE_GIF) {
            imagecolortransparent($newImage, imagecolorallocatealpha($newImage, 0, 0, 0, 127));
            imagealphablending($newImage, false);
            imagesavealpha($newImage, true);
        }

        imagecopyresampled($newImage, $image, 0, 0, 0, 0, 
            $newWidth, $newHeight, $origWidth, $origHeight);

        switch ($imageType) {
            case IMAGETYPE_JPEG:
                imagejpeg($newImage, $destPath, 90);
                break;
            case IMAGETYPE_PNG:
                imagepng($newImage, $destPath);
                break;
            case IMAGETYPE_GIF:
                imagegif($newImage, $destPath);
                break;
        }

        imagedestroy($image);
        imagedestroy($newImage);

        return true;
    }

    public function index(){
        $products = $this->productRepository->allProduct();

        return view('admin.products.index', ['products' => $products]);
    }

    public function create(){
        $list_danhmucs = Danhmuc::all();
        return view('admin.products.create', ['list_danhmucs' => $list_danhmucs]);
    }

    public function store(Request $request){

    $validatedData = $request->validate([
        'tensp' => 'required',
        'anhsp' => 'required|image',
        'giasp' => 'required|decimal:0,2',
        'mota' => 'nullable',
        'giamgia' => 'nullable|numeric',
        'giakhuyenmai' => 'nullable|decimal:0,2',
        'soluong' => 'required|numeric',
        'id_danhmuc' => 'required'
    ]);

    // Kiểm tra tên sản phẩm đã tồn tại chưa
    $existingProduct = $this->productRepository->findByName($validatedData['tensp']);
    if ($existingProduct) {
        return redirect()->back()
            ->withInput()
            ->withErrors(['tensp' => 'Tên sản phẩm đã tồn tại, vui lòng chọn tên khác.']);
    }

    // Xử lý upload và resize ảnh
    $image = $request->file('anhsp');

    $imageName = time() . '.' . $image->getClientOriginalExtension();
    $destinationPath = public_path('frontend/upload');

    if (!file_exists($destinationPath)) {
        mkdir($destinationPath, 0755, true);
    }

    $sourcePath = $image->getRealPath();
    $destPath = $destinationPath . '/' . $imageName;

    $this->resizeImageKeepRatio($sourcePath, $destPath, 800, 800);

    $validatedData['anhsp'] = "frontend/upload/" . $imageName;

    // Tính giá khuyến mãi
    $giagoc = $validatedData['giasp'];
    $giamgia = $validatedData['giamgia'] ?? 0;

    $tinh = ($giagoc * $giamgia) / 100;
    $validatedData['giakhuyenmai'] = $giagoc - $tinh;

    $this->productRepository->storeProduct($validatedData);

    return redirect()->route('product.index');
    }


    public function edit($id){
        $list_danhmucs = Danhmuc::all();
        $product = $this->productRepository->findProduct($id);
        return view('admin.products.edit', ['product' => $product, 'list_danhmucs' => $list_danhmucs]);
    }

    public function update($id, Request $request){
        $validatedData = $request->validate([
            'tensp' => 'required',
            'anhsp' => 'nullable|image',
            'giasp' => 'required|decimal:0,2',
            'mota' => 'nullable',
            'giamgia' => 'nullable|numeric',
            'giakhuyenmai' => 'nullable|decimal:0,2',
            'soluong' => 'required|numeric',
            'id_danhmuc' => 'required'
        ]);

        if ($request->file('anhsp')) {
            $image = $request->file('anhsp');

            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $destinationPath = public_path('frontend/upload');

            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0755, true);
            }

            $sourcePath = $image->getRealPath();
            $destPath = $destinationPath . '/' . $imageName;

            $this->resizeImageKeepRatio($sourcePath, $destPath, 800, 800);

            $validatedData['anhsp'] = "frontend/upload/" . $imageName;
        } else {
            // Giữ nguyên ảnh cũ khi không upload ảnh mới
            $validatedData['anhsp'] = $request->anhsp1;
        }

        // Tính giá khuyến mãi
        $giagoc = $validatedData['giasp'];
        $giamgia = $validatedData['giamgia'] ?? 0;

        $tinh = ($giagoc * $giamgia) / 100;
        $validatedData['giakhuyenmai'] = $giagoc - $tinh;

        $this->productRepository->updateProduct($validatedData, $id);

        return redirect()->route('product.index')->with('success', 'Cập nhập sản phẩm thành công');
    }

    public function destroy($id){
        $this->productRepository->deleteProduct($id);

        return redirect()->route('product.index')->with('success', 'Xóa sản phẩm thành công');
    }

    
}
