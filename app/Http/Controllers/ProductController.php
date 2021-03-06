<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\Product;
use App\Model\Brand;
use App\Model\Vendor;
use App\Model\Category;
use App\Model\ProductImage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct()
    {
        $this->authorizeResource(Product::class, 'san_pham');
    }

    protected function resourceAbilityMap()
    {
        return array_merge(parent::resourceAbilityMap(), ['index' => 'view']);
    }

    public function index(Request $request)
    {
        //

        $products = Product::latest()->paginate(10);

        if ($request->has('search')) {

            $products = Product::where('name', 'like', "%{$request->get('search')}%")->paginate(10);
        }
        $rank = $products->firstItem();
        return view('admin.product.index', ['products' => $products, 'rank' => $rank]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $categories = Category::where([
            'parent_id' => 0,
            'type' => 0
        ])->get();
        $vendors = Vendor::all();
        $brands = Brand::all();
        return view('admin.product.create', compact('categories', 'vendors', 'brands'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //

        $validated = $request->validate(
            [
                'name' => 'required|max:255|unique:categories,name',
                'image' => 'required|file|mimes:jpg,png,jpeg,gif,svg|max:10000',
                'category_id' => 'required',
                'url' => 'max:255',
                'sku' => 'max:255',
                'meta_title' => 'max:255',
                'product_images.*' => 'file|mimes:jpg,png,jpeg,gif,svg|max:20000',
            ],
            [
                'name.required' => 'T??n s???n ph???m kh??ng ???????c ????? tr???ng !!!',
                'name.required' => 'T??n s???n ph???m ???? t???n t???i !!!',
                'name.max' => 'T??n s???n ph???m kh??ng ???????c qu?? 255 k?? t??? !!!',
                'name.required' => 'Danh m???c kh??ng ???????c ????? tr???ng !!!',
                'url.max' => 'Url kh??ng ???????c qu?? 255 k?? t??? !!!',
                'sku.max' => 'M?? h??ng (SKU) kh??ng ???????c qu?? 255 k?? t??? !!!',
                'meta_title.max' => 'Meta title kh??ng ???????c qu?? 255 k?? t??? !!!',
                'product_images.*.mimes' => "File ???nh kh??ng h???p l???",
                'product_images.*.file' => "File ???nh kh??ng h???p l???",
            ]
        );

        $image = '';
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $fileName = $file->getClientOriginalName();
            while (file_exists('./uploads/product/' . $fileName)) {
                $fileName = str_random(10) . $fileName;
            }
            $file->move('./uploads/product', $fileName);
            $image = './uploads/product/' . $fileName;
        }

        try {
            DB::beginTransaction();
            $product = Product::create([
                'name' => $request->name,
                'slug' => str_slug($request->name),
                'image' => $image,
                'stock' => $request->stock,
                'price' => $request->price,
                'sale' => $request->sale,
                'position' => $request->position,
                'is_active' => ($request->is_active) ? 1 : 0,
                'is_hot' => ($request->is_hot) ? 1 : 0,
                'category_id' => $request->category_id,
                'url' => $request->url,
                'sku' => $request->sku,
                'color' => $request->color,
                'memory' => $request->memory,
                'brand_id' => $request->brand_id,
                'vendor_id' => $request->vendor_id,
                'summary' => $request->summary,
                'description' => $request->description,
                'meta_title' => $request->meta_title,
                'meta_description' => $request->meta_description,
                'user_id' => Auth::user()->id,
            ]);

            if ($request->hasFile('product_images.*')) {
                $file = $request->product_images;
                for ($i = 0; $i < count($file); $i++) {
                    // code...
                    $fileName = $file[$i]->getClientOriginalName();
                    while (file_exists('./uploads/product/' . $fileName)) {
                        $fileName = str_random(10) . $fileName;
                    }
                    $file[$i]->move('./uploads/product', $fileName);
                    ProductImage::create(
                        [
                            'product_id' => $product->id,
                            'image' => './uploads/product/' . $fileName,
                            'url' => '',
                            'is_active' => $request->input("is_active_images.$i"),
                            'position' => $request->input("images_position.$i") != null ? $request->input("images_position.$i") : 0
                        ]
                    );
                }
            }
            DB::commit();
        } catch (\Exception $ex) {
            if (file_exists($image)) {
                unlink($image);
            }

            DB::rollback();
        }

        return redirect()->route('san-pham.index')->with('success', 'Th??m th??nh c??ng !!!');
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $san_pham)
    {
        $categories = Category::where([
            'parent_id' => 0,
            'type' => 0
        ])->get();
        $vendors = Vendor::all();
        $brands = Brand::all();
        $product = $san_pham;
        return view('admin.product.edit', compact('product', 'categories', 'vendors', 'brands'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */


    public function update(Request $request, Product $san_pham)
    {


        $validated = $request->validate(
            [
                'name' => 'required|max:255|unique:categories,name,' . $san_pham->id,
                'image' => 'file|mimes:jpg,png,jpeg,gif,svg|max:20000',
                'category_id' => 'required',
                'url' => 'max:255',
                'sku' => 'max:255',
                'meta_title' => 'max:255',
                'product_images.*' => 'file|mimes:jpg,png,jpeg,gif,svg|max:20000',
            ],
            [
                'name.required' => 'T??n s???n ph???m kh??ng ???????c ????? tr???ng !!!',
                'name.required' => 'T??n s???n ph???m ???? t???n t???i !!!',
                'name.max' => 'T??n s???n ph???m kh??ng ???????c qu?? 255 k?? t??? !!!',
                'name.required' => 'Danh m???c kh??ng ???????c ????? tr???ng !!!',
                'url.max' => 'Url kh??ng ???????c qu?? 255 k?? t??? !!!',
                'sku.max' => 'M?? h??ng (SKU) kh??ng ???????c qu?? 255 k?? t??? !!!',
                'meta_title.max' => 'Meta title kh??ng ???????c qu?? 255 k?? t??? !!!',
                'product_images.*.mimes' => "File ???nh kh??ng h???p l???",
                'product_images.*.file' => "File ???nh kh??ng h???p l???",
            ]
        );

        $old_image = $san_pham->image;
        $image = '';
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $fileName = $file->getClientOriginalName();
            while (file_exists('./uploads/product/' . $fileName)) {
                $fileName = str_random(10) . $fileName;
            }
            $file->move('./uploads/product', $fileName);
            $image = './uploads/product/' . $fileName;
        }

        try {
            DB::beginTransaction();

            DB::table('products')->where('id', $san_pham->id)->update([
                'name' => $request->name,
                'slug' => str_slug($request->name),
                'image' => ($image != '') ? $image : $old_image,
                'stock' => $request->stock,
                'price' => $request->price,
                'sale' => $request->sale,
                'position' => $request->position,
                'is_active' => ($request->is_active) ? 1 : 0,
                'is_hot' => ($request->is_hot) ? 1 : 0,
                'category_id' => $request->category_id,
                'url' => $request->url,
                'sku' => $request->sku,
                'color' => $request->color,
                'memory' => $request->memory,
                'brand_id' => $request->brand_id,
                'vendor_id' => $request->vendor_id,
                'summary' => $request->summary,
                'description' => $request->description,
                'meta_title' => $request->meta_title,
                'meta_description' => $request->meta_description,
                'user_id' => Auth::user()->id,
            ]);

            /// start update product_images :
            if ($request->input('id_product_images')) { // n???u t???n t???i product_images

                ProductImage::where('product_id', $san_pham->id)->get()->each(function ($item) use ($request) {
                    if (!in_array($item->id, $request->input('id_product_images'))) {
                        @unlink($item->image);
                        $item->delete();
                    }
                }); /// X??a nh???ng item ???nh khi ng?????i d??ng x??a

                $arrProductImages = ProductImage::where('product_id', $san_pham->id)->get(); // l???y ra t???t c??? ???nh chi ti???t s???n ph???m :
                for ($i = 0; $i < count($request->input('id_product_images')); $i++) {
                    if ($arrProductImages->contains('id', $request->input("id_product_images.$i"))) {
                        /// ch???y v??ng l???p request  n???u $request->input('id_product_images') t???n t???i trong arrProductImages[c???t id] th?? update l???i v??? tr?? v?? hi???n th??? !!! [khi c?? nhu c???u s???a v??? tr?? v?? hi???n th???]
                        $product_image = ProductImage::find($request->input("id_product_images.$i"));
                        $product_image->position = $request->input("images_position.$i") != null ? $request->input("images_position.$i") : 0;
                        $product_image->is_active = $request->input("is_active_images.$i") != null ? $request->input("is_active_images.$i") : 0;
                        $product_image->save();
                    } else {
                        //  kh??ng t???n t???i th?? t???o m???i :: ( m???c ?????nh $request->input('id_product_images') == 0 ) [ th??m m???i ]
                        $product_image = new ProductImage();
                        $product_image->product_id = $san_pham->id;
                        $product_image->is_active = $request->input("is_active_images.$i");
                        $product_image->position = $request->input("images_position.$i") != null ? $request->input("images_position.$i") : 0;
                        if ($request->hasFile("product_images.$i")) {
                            $file = $request->file("product_images.$i");
                            $fileName = $file->getClientOriginalName();
                            while (file_exists('./uploads/product/' . $fileName)) {
                                $fileName = str_random(10) . $fileName;
                            }
                            $file->move('./uploads/product', $fileName);
                            $product_image->image = './uploads/product/' . $fileName;
                        }
                        $product_image->save();
                    }
                }
            } else { // nhu c???u x??a h???t ???nh k??m theo
                ProductImage::where('product_id', $san_pham->id)->delete();
            }
            // end update product_images

            if ($image != '') {
                @unlink(old_image); // n???u thay ?????i h??nh ???nh ch??nh trong s???n ph???m => x??a h??nh c??
            }
            DB::commit();

        } catch (\Exception $ex) {
            if (file_exists($image)) {
                @unlink($image);
            }
            DB::rollback();
        }

        return redirect()->route('san-pham.index')->with('success', 'S???a th??nh c??ng !!!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $san_pham)
    {
        $status = $text = $iconColor = ''; /// Khai b??o tr???ng th??i v?? icon tr??? v??? client
        $arrImages = $san_pham->product_images()->get();
        $old_image = $san_pham->image;
        if ($san_pham->delete()) { // n???u x??a th??nh c??ng status == true v?? ng?????c l???i ;
            $arrImages->each(function ($item) {
                @unlink($item->image);
                $item->delete();
            });
            @unlink($old_image); //x??a h???t t???t c??? h??nh ???nh

            $status = 'success';
            $text = 'X??a th??nh c??ng';
            $iconColor = 'green';
        } else {
            $status = 'error';
            $text = 'X??a kh??ng th??nh c??ng';
            $iconColor = 'red';
        }
        return response()->json([
            'icon' => $status,
            'text' => $text,
            'iconColor' => $iconColor
        ], 200);
        //tr??? v??? client chu???i json;
    }
}
//./uploads/product/UFRXtMyKFxtrinh-lang-sieu-xe-mui-tran-mclaren-720s-spider-5-2018-12-09-18-02-00.jpg
