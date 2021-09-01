<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

use  App\Models\product;
use App\Models\Company;

class ProductsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    private   $rules = [
        'name'                 => ['required', 'string'],
        'img'                  => ['required'],
        'product_price'        => ['required'],
        'Brand_Name'           => ['required'],
        'offers'               => ['required'],
    ];
    public function index($id)
    {
        //
        $product = product::all();
        $Company  = Company::find($id);
        return view('admin.Product.index', ['Product' => $product, 'Company' => $Company]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {


        $Company  = Company::find($id);
        return view('admin.Product.create', ['Company' => $Company]);
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store($id, Request $request)
    {

        if (!$this->validtion($request->all(), $this->rules))
            return back();
        $img =  $this->UploadFile(!empty($request->file('img')) ? $request->file('img') : null);
        $product  = product::create([
            'name'                 => $request->input('name'),
            'img'                  => $img,
            'product_price'        => (float) $request->input('product_price'),
            'Brand_Name'           => $request->input('Brand_Name'),
            'offers'               => (float) $request->input('offers'),
            'companie_id' => $id,
        ]);


        return redirect('prodact/' . $id);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
