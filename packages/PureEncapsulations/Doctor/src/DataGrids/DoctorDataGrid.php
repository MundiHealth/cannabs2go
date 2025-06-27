<?php

namespace PureEncapsulations\Doctor\DataGrids;

use Illuminate\Support\Facades\DB;
use Webkul\Ui\DataGrid\DataGrid;

class DoctorDataGrid extends DataGrid
{
    protected $index = 'id';

    protected $sortOrder = 'desc';

    protected $itemsPerPage = 10;

    public function prepareQueryBuilder()
    {
        // TODO: Implement prepareQueryBuilder() method.
        $queryBuilder = DB::table('doctors')
            ->addSelect('id','doctor_reg','name', 'patient', 'prescription_date','purchase','purchase_date','order_number')
            ->whereNull('deleted_at');

        $this->setQueryBuilder($queryBuilder);
    }

    public function addColumns()
    {
        // TODO: Implement addColumns() method.
        $this->addColumn([
            'index' => 'id',
            'label' => '#',
            'type' => 'number',
            'searchable' => false,
            'sortable' => true,
            'filterable' => true
        ]);

        $this->addColumn([
            'index' => 'doctor_reg',
            'label' => 'Doctor ID',
            'type' => 'string',
            'searchable' => true,
            'sortable' => true,
            'filterable' => true
        ]);

        $this->addColumn([
            'index' => 'name',
            'label' => 'Nome',
            'type' => 'string',
            'searchable' => true,
            'sortable' => true,
            'filterable' => true
        ]);

        $this->addColumn([
            'index' => 'patient',
            'label' => 'Paciente',
            'type' => 'string',
            'searchable' => true,
            'sortable' => true,
            'filterable' => true
        ]);

        $this->addColumn([
            'index' => 'prescription_date',
            'label' => 'Data de Prescrição',
            'type' => 'date',
            'searchable' => false,
            'sortable' => false,
            'filterable' => true
        ]);

        $this->addColumn([
            'index' => 'purchase',
            'label' => 'Comprado',
            'type' => 'string',
            'searchable' => false,
            'sortable' => true,
            'filterable' => true,
            'closure' => true,
            'wrapper' => function ($row) {
                if ($row->purchase == 1) {
                    return '<span class="badge badge-md badge-success">Sim</span>';
                } else {
                    return '<span class="badge badge-md badge-danger">Não</span>';
                }
            }
        ]);

        $this->addColumn([
            'index' => 'purchase_date',
            'label' => 'Data Compra',
            'type' => 'date',
            'searchable' => false,
            'sortable' => false,
            'filterable' => true
        ]);

        $this->addColumn([
            'index' => 'order_number',
            'label' => 'No. Ordem',
            'type' => 'string',
            'searchable' => true,
            'sortable' => true,
            'filterable' => true
        ]);
    }

    public function prepareActions() {
        $this->addAction([
            'method' => 'GET', // use GET request only for redirect purposes
            'route' => 'doctor.edit',
            'icon' => 'icon pencil-lg-icon',
            'title' => 'Alterar'
        ]);

//        $this->addAction([
//            'type' => 'Edit',
//            'method' => 'GET', //use post only for redirects only
//            'route' => 'admin.customer.addresses.index',
//            'icon' => 'icon list-icon'
//        ]);

        $this->addAction([
            'method' => 'POST', // use GET request only for redirect purposes
            'route' => 'doctor.delete',
            'icon' => 'icon trash-icon',
            'title' => 'Deletar'
        ]);

//        $this->addAction([
//            'method' => 'GET',
//            'route' => 'doctor.note.create',
//            'icon' => 'icon note-icon',
//            'title' => 'Adicionar anotação'
//        ]);
    }

    /**
     * Customer Mass Action To Delete And Change Their
     */
    public function prepareMassActions()
    {
        $this->addMassAction([
            'type' => 'delete',
            'label' => 'Delete',
            'action' => route('doctor.mass-delete'),
            'method' => 'PUT',
        ]);

//        $this->addMassAction([
//            'type' => 'update',
//            'label' => 'Update Status',
//            'action' => route('doctor.mass-update'),
//            'method' => 'PUT',
//            'options' => [
//                'Active' => 1,
//                'Inactive' => 0
//            ]
//        ]);

        $this->enableMassAction = true;
    }
}