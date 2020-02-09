<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Customer;
use Illuminate\Http\Request;
use App\Dtos\ResponseDto;
use App\Constants\Status;
use App\Constants\Constants;

class CustomerController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request) {

        $conditions = array('system_customer' => $request->user()->customer);

        $filter = Controller::arrayToObject($request->filter);

        if (isset($filter->entity->business_name)) {
            array_push($conditions, ['business_name', 'like', '%' . $filter->entity->business_name . '%']);
        }
        if (isset($filter->entity->tax_id)) {
            array_push($conditions, ['tax_id', 'like', '%' . $filter->entity->tax_id . '%']);
        }
        if (isset($filter->entity->contact)) {
            array_push($conditions, ['contact', 'like', '%' . $filter->entity->contact . '%']);
        }
        if (isset($filter->entity->status)) {
            array_push($conditions, ['status', $filter->entity->status]);
        } else {
            array_push($conditions, ['status', Status::ACTIVE]);
        }

        $customers = Customer::where($conditions)->paginate($filter->rows);

        $response = new ResponseDto;
        $response->status = 0;
        $response->code = 200;
        $response->message = '';
        $response->fields = array('response_data' => $customers);

        return response()->json($response, 200, [], JSON_NUMERIC_CHECK);
    }

    /**
     * Save a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function save(Request $request) {
        $entity = Controller::arrayToObject($request->entity);

        $conditions = array('system_customer' => $request->user()->customer);
        array_push($conditions, ['id', $this->decode($entity->id)]);

        $customer = $entity->id != 0 ? Customer::where($conditions)->first() : new Customer();

        if ($customer == null && $entity->id != 0) {
            $response = new ResponseDto;
            $response->status = 1;
            $response->code = 400;
            $response->message = 'La petición no es correcta';

            return response()->json($response, 400, [], JSON_NUMERIC_CHECK);
        }

        $customer->system_customer = $request->user()->customer;
        $customer->business_name = $entity->business_name;
        $customer->tax_id = $entity->tax_id;
        $customer->contact = $entity->contact;
        $customer->telephone = $entity->telephone;
        $customer->email = $entity->email;
        $customer->street = $entity->street;
        $customer->internal_number = $entity->internal_number;
        $customer->external_number = $entity->external_number;
        $customer->settlement = $entity->settlement;
        $customer->city = $entity->city;
        $customer->county = $entity->county;
        $customer->state = $entity->state;
        $customer->postal_code = $entity->postal_code;
        $customer->country = $entity->country;
        $customer->status = Status::ACTIVE;

        $customer->save();

        $response = new ResponseDto;
        $response->status = 0;
        $response->code = 200;
        $response->message = 'El cliente se ha registrado correctamente';
        $response->fields = array(Constants::CUSTOMER => $customer);

        return response()->json($response, 200, [], JSON_NUMERIC_CHECK);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\TransactionableCustomer  $request
     * @return \Illuminate\Http\Response
     */
    public function delete(Request $request) {
        $entity = Controller::arrayToObject($request->entity);
        $conditions = array('system_customer' => $request->user()->customer, 'id' => $this->decode($entity->id));

        $customer = Customer::where($conditions)->first();

        $response = new ResponseDto;
        $response->status = 0;


        if ($customer != null) {
            $response->code = 200;
            $customer->status = Status::DELETE;
            $customer->save();
            $response->message = 'El cliente se ha eliminado con exito';
            $response->fields = array('customer' => $customer);
        } else {
            $response->code = 402;
            $response->message = 'El cliente no fue encontrado';
        }

        return response()->json($response, 200, [], JSON_NUMERIC_CHECK);
    }

}
