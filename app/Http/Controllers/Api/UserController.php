<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use App\Dtos\ResponseDto;
use App\Constants\Status;
use App\Constants\Constants;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller {

    public function index(Request $request) {
        $conditions = array('customer' => $request->user()->customer);
        $filter = Controller::arrayToObject($request->filter);

        if (isset($filter->entity->name)) {
            array_push($conditions, ['name', 'like', '%' . $filter->entity->name . '%']);
        }
        if (isset($filter->entity->user)) {
            array_push($conditions, ['user', 'like', '%' . $filter->entity->user . '%']);
        }
        if (isset($filter->entity->status)) {
            array_push($conditions, ['status', $filter->entity->status]);
        } else {
            array_push($conditions, ['status', Status::ACTIVE]);
        }

        $users = User::where($conditions)->paginate($filter->rows);

        $response = new ResponseDto;
        $response->status = 0;
        $response->code = 200;
        $response->message = '';
        $response->fields = array('response_data' => $users);

        return response()->json($response, 200, [], JSON_NUMERIC_CHECK);
    }

    public function exists($user) {
        $count = User::where('user', $user)->count();

        $response = new ResponseDto;
        $response->status = 0;
        $response->code = 200;
        $response->fields = array(Constants::EXISITS => $count >= 1);

        return response()->json($response, 200, [], JSON_NUMERIC_CHECK);
    }

    /**
     * Save a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function save(Request $request) {
        $entity = Controller::arrayToObject($request->entity);
        $password = '';
        if ($entity->id !== 0) {
            $conditions = array('customer' => $request->user()->customer);
            array_push($conditions, ['id', $this->decode($entity->id)]);
            $user = User::where($conditions)->first();
        } else {
            $password = UserController::randomPassword();
            $user = new User();
            $user->password = Hash::make($password);
        }

        if ($user == null && $entity->id !== 0) {
            $response = new ResponseDto;
            $response->status = 1;
            $response->code = 400;
            $response->message = 'La petición no es correcta';

            return response()->json($response, 400, [], JSON_NUMERIC_CHECK);
        }

        $user->customer = $request->user()->customer;
        $user->name = $entity->name;
        $user->user = $entity->user;
        $user->email = $entity->email;
        $user->modules = $request->entity['modules'];
        $user->status = Status::ACTIVE;

        $user->save();

        $response = new ResponseDto;
        $response->status = 0;
        $response->code = 200;
        $response->message = 'El usuario se ha guardado correctamente';
        $response->fields = array(Constants::USER => $user, Constants::PASSWORD => $password);

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
        $conditions = array('customer' => $request->user()->customer, 'id' => $this->decode($entity->id));

        $user = User::where($conditions)->first();

        $response = new ResponseDto;
        $response->status = 0;


        if ($user != null) {
            $response->code = 200;
            $user->status = Status::DELETE;
            $user->save();
            $response->message = 'El usuario se ha eliminado con exito';
            $response->fields = array(Constants::USER => $user);
        } else {
            $response->code = 402;
            $response->message = 'El usuario no fue encontrado';
        }

        return response()->json($response, 200, [], JSON_NUMERIC_CHECK);
    }

    private static function randomPassword($length = 8) {
        $alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
        $pass = array(); //remember to declare $pass as an array
        $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
        for ($i = 0; $i < $length; $i++) {
            $n = rand(0, $alphaLength);
            $pass[] = $alphabet[$n];
        }
        return implode($pass); //turn the array into a string
    }

}
