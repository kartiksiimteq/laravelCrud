<?php

namespace App\Http\Controllers;

use App\Models\employee;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class EmployeeApiController extends Controller {

    const CREATED = "CREATED";
    const UPDATED = "UPDATED";
    const DELETED = "DELETED";
    const FOUND = "FOUND";

    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index() {
        $employee = employee::query()->limit( 5 )->get();

        return ( self::sendResponce( $employee, self::FOUND ) );
    }

    public function sendResponce( $data, $opration ) {
        if ( $data ) {
            $response = [ 'status' => 200, 'success' => true, 'message' => "USER " . $opration, 'data' => $data ];
        } else {
            $response = [ 'status' => 422, 'success' => true, 'message' => "USER NOT " . $opration ];
        }

        return response()->json( $response, 200 );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     *
     * @return JsonResponse
     */
    public function store( Request $request ) {
        $request->validate( [
            'name'   => 'required',
            'mobile' => 'required',
        ] );
        $data = employee::create( $request->all() );

        return self::sendResponce( $data, self::CREATED );
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     *
     * @return JsonResponse
     */
    public function show( $id ) {
        $employee = employee::query()->find( $id );

        return ( self::sendResponce( $employee, self::FOUND ) );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  int  $id
     *
     * @return JsonResponse
     */
    public function update( Request $request, $id ) {
        $data    = employee::query()->find( $id );
        $request = $request->all();

        if ( ! $data ) {
            return self::sendResponce( $data, self::FOUND );
        }
        $data->fill( $request );
        $data->save();

        return self::sendResponce( $data, self::UPDATED );

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     *
     * @return JsonResponse
     */
    public function destroy( $id ) {
        $data = employee::query()->find( $id );
        if ( $data ) {
            $data->delete();
        }

        return self::sendResponce( $data, $data ? self::DELETED : 'USER ALREDY ' . self::DELETED );
    }
}
