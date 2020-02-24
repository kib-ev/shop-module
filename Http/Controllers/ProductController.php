<?php

namespace Modules\Shop\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Shop\Repositories\ProductRepository;

class ProductController extends Controller {

    /** @var ProductRepository */
    protected $productRepository;

    public function __construct() {
        $this->productRepository = app(ProductRepository::class);
    }

    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index() {
        return view('shop::products.index');
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create() {
        return view('shop::products.create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Response
     */
    public function store(Request $request) {
        $data = $request->all();
        $product = $this->productRepository->getModel();
        $product->fill($data)->save();

        return redirect()->back();
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Response
     */
    public function show($id) {
        return view('shop::products.show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Response
     */
    public function edit($id) {
        return view('shop::products.edit');
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(Request $request, $id) {
        $data = $request->all();

        $product = $this->productRepository->getWhereId($id);
        $product->update($data);

        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Response
     */
    public function destroy($id) {
        $product = $this->productRepository->getWhereId($id);
        $product->delete();

        $redirect = request()->get('redirect');
        if ($redirect) {
            return redirect()->to($redirect);
        }

        return view('shop::products.destroy');
    }

    /**
     * Save product id in session to create last viewed products list
     * @param int $id
     */
    public function saveViewedProductIdInSession(int $id) { // todo mb move to SessionController
        $viewedFiltersIds = session()->get('shop.products.viewed.ids') ?: [];
        if ($this->productRepository->getWhereId($id)) {
            array_push($viewedFiltersIds, $id);
            session()->put('shop.products.viewed.ids', array_unique($viewedFiltersIds));
        }
    }
}
