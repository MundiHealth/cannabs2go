<?php


namespace PureEncapsulations\Doctor\Http\Controllers;

use PureEncapsulations\Doctor\Http\Controllers\Controller;
use Illuminate\Http\Request;
use PureEncapsulations\Doctor\Repositories\DoctorRepository;

class DoctorController extends Controller
{
    protected $_config;
    protected $doctorRepository;

    public function __construct(DoctorRepository $doctorRepository)
    {
        $this->_config = request('_config');

        $this->middleware('admin');

        $this->doctorRepository = $doctorRepository;
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
            'doctor_reg' => 'string|required',
            'name' => 'string|required',
            'patient' => 'string|required',
            'prescription_date' => 'date',
            'purchase' => 'string|required',
            'purchase_date' => 'nullable|date',
            'order_number' => 'nullable|string',
        ]);

        $data = request()->all();

        $data['purchase_date'] = $data['purchase'] == 0 ? null : $data['purchase_date'] ;
        $data['order_number'] = $data['purchase'] == 0 ? null : $data['order_number'] ;
        $data['deleted_at'] = null;
        $doctor = $this->doctorRepository->create($data);

        session()->flash('success', 'Dados salvos com sucesso');

        return redirect()->route($this->_config['redirect']);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        $doctor = $this->doctorRepository->findOrFail($id);

        return view($this->_config['view'], compact('doctor'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update($id)
    {
        $this->validate(request(), [
            'doctor_reg' => 'string|required',
            'name' => 'string|required',
            'patient' => 'string|required',
            'prescription_date' => 'date',
            'purchase' => 'string|required',
            'purchase_date' => 'nullable|date',
            'order_number' => 'nullable|string',
        ]);

        $data = request()->all();

        $data['purchase_date'] = $data['purchase'] == 0 ? null : $data['purchase_date'] ;
        $data['order_number'] = $data['purchase'] == 0 ? null : $data['order_number'] ;

        $this->doctorRepository->update($data, $id);

        session()->flash('success', 'Dados atualizados com sucesso');

        return redirect()->route($this->_config['redirect']);
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $doctor = $this->doctorRepository->findorFail($id);
        
        try {
            $this->doctorRepository->delete($id);

            session()->flash('success', 'Registro apagado com sucesso');

            return response()->json(['message' => true], 200);
        } catch(\Exception $e) {
            session()->flash('error', 'Ocorreu um erro ao tentar apager o registro');
        }

        return response()->json(['message' => false], 400);
    }

    /**
     * To mass delete the customer
     *
     * @return redirect
     */
    public function massDestroy()
    {
        $doctorIds = explode(',', request()->input('indexes'));

        foreach ($doctorIds as $doctorId) {
            $this->doctorRepository->deleteWhere([
                'id' => $doctorId
            ]);
        }

        session()->flash('success', 'Registros removidos com sucesso');

        return redirect()->back();
    }
}