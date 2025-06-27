<?php

namespace OnNow\Distributors\Http\Controllers;

use OnNow\Distributors\Repositories\DistributorRepository;

class DistributorController extends Controller
{
    protected $_config;
    protected $repository;

    public function __construct(DistributorRepository $repository)
    {
        $this->repository = $repository;
        $this->_config = request('_config');
        $this->middleware('admin');
    }

    public function index()
    {
        return view($this->_config['view']);
    }

    public function create()
    {
        return view($this->_config['view']);
    }

    public function store()
    {
        $this->validate(request(), [
            'name' => 'string|required',
            'commission' => 'float|required'
        ]);

        $data = request()->all();

        $supplier = $this->repository->create($data);

        session()->flash('success', 'Dados salvos com sucesso');

        return redirect()->route($this->_config['redirect']);
    }

    public function edit($id)
    {
        $supplier = $this->repository->findOrFail($id);

        return view($this->_config['view'], compact('supplier'));
    }

    public function update($id)
    {
        $this->validate(request(), [
            'name' => 'string|required',
            'commission' => 'float|required'
        ]);

        $data = request()->all();

        $supplier = $this->repository->update($data, $id);

        session()->flash('success', 'Dados salvos com sucesso');

        return redirect()->route($this->_config['redirect']);
    }

    public function destroy($id)
    {
        $this->repository->delete($id);

        session()->flash('success', 'Dados removidos com sucesso');

        return redirect()->route($this->_config['redirect']);
    }

    public function massDestroy()
    {
        $ids = explode(',', request('ids'));

        foreach ($ids as $id) {
            $this->repository->delete($id);
        }

        session()->flash('success', 'Dados removidos com sucesso');

        return redirect()->route($this->_config['redirect']);
    }

    public function getAll()
    {
        $distributors = $this->repository->all();
        return response()->json($distributors);
    }
}