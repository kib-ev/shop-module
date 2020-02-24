<?php

namespace Modules\Shop\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Shop\Repositories\BrandRepository;

class BrandController extends Controller {

    /** @var BrandRepository */
    protected $brandRepository;

    public function __construct() {
        $this->brandRepository = app(BrandRepository::class);
    }

    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index() {
        $brands = $this->brandRepository->getModel()
            ->with('products:id,brand_id', 'children:id,parent_id,name', 'children.products:id,brand_id')
            ->withTrashed()
            ->orderBy('name', 'asc')
            ->get();
        return view('shop::brands.index', compact('brands'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create() {
        $brand = $this->brandRepository->getModel()
            ->make();
        return view('shop::brands.edit', compact('brand'));
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Response
     */
    public function store(Request $request) {
        $data = $request->all();
        $brand = $this->brandRepository->getModel();
        $brand->fill($data)->save();

        if ($brand->id) {
            return redirect()->to(route('brands.show', $brand->id))->with(['success' => 'Успешно сохранено.']);
        } else {
            return redirect()->back()->withErrors('Ошибка сохранения');
        }
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Response
     */
    public function show($id) {
        $brand = $this->brandRepository
            ->getWhereId($id);
        return view('shop::brands.show', compact('brand'));
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Response
     */
    public function edit($id) {
        $brand = $this->brandRepository
            ->getWhereId($id);
        return view('shop::brands.edit', compact('brand'));
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(Request $request, $id) {
        $data = $request->all();
        $brand = $this->brandRepository->getWhereId($id);
        $brand->fill($data)->save();

        if ($brand->id) {
            return redirect()->to(route('brands.show', $brand->id))->with(['success' => 'Успешно сохранено.']);
        } else {
            return redirect()->back()->withErrors('Ошибка сохранения');
        }
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Response
     */
    public function destroy($id) {
        $brand = $this->brandRepository->getWhereId($id);
        $brand->delete();

        $redirect = request()->get('redirect');
        if ($redirect) {
            return redirect()->to($redirect);
        }

        return view('shop::brands.destroy');
    }

}
