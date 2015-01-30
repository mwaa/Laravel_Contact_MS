<?php

use lcms\ContactsTransformer;

class ContactsController extends \BaseController{

    function __construct()
    {
        $this->protect(['store','update','destroy','archive','restore']);
    }
	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		//
        $max = Input::get('max') ? : 5;
        $contacts = contact::paginate($max);
        return $this->response->paginator($contacts, new ContactsTransformer);
	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		//
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{

        $rules = array(
            'first_name'     => 'required',
            'last_name'      => 'required',
            'email'          => 'required|email|unique:contacts',     // required and must be unique in the contacts table
            'address'        => 'required'
        );

        $input = Input::all();

        $validator = Validator::make($input, $rules);

        if($validator->fails())
        {
            //return $this->response->errorBadRequest('Failed Validation. All Requirements were not met.');
            throw new Dingo\Api\Exception\StoreResourceFailedException('Could not create new contact.', $validator->errors());
        }

        contact::create(Input::all());

        return $this->response->created();
	}


	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//
        $contact = contact::find($id);

        if(!$contact)
        {
            return $this->response->errorNotFound('Contact does not exist.Please Check your Request.');
        }

        return $this->response->item($contact, new ContactsTransformer);
	}


	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//
	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		//
        $contact = contact::find($id);

        if(!$contact)
        {
            return $this->response->errorNotFound('Contact does not exist.Please Check your Request and Try again.');
        }

        $rules = array(
            'first_name'     => 'required',
            'last_name'      => 'required',
            'email'          => 'required|email|unique:contacts',     // required and must be unique in the contacts table
            'address'        => 'required',
            'twitter'        => 'required'
        );

        $input = Input::all();

        $validator = Validator::make($input, $rules);

        if(!$validator->fails())
        {
            return $this->response->errorNotFound('Contact does not exist.Please Check your Request and Try again.');
        }

        $contact->first_name = Input::get('first_name');
        $contact->last_name = Input::get('last_name');
        $contact->email = Input::get('email');
        $contact->address = Input::get('address');
        $contact->twitter = Input::get('twitter');
        $contact->save();

	}


	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
        $contact = contact::find($id);

        if(!$contact)
        {
            return $this->response->errorNotFound('Contact does not exist.Please Check your Request and Try again.');
        }

        $contact->forceDelete();

        return $this->response->noContent(); //create custom response to notify on delete
	}

    /**
     * @param $id
     * @return \Dingo\Api\Http\ResponseBuilder|\Illuminate\Http\Response
     */
    public function archive($id)
    {

        //
        $contact = contact::find($id);

        if(!$contact)
        {
            return $this->response->errorNotFound('Contact does not exist.Please Check your Request and Try again.');
        }

        contact::destroy($id);

        return $this->response->noContent(); //create custom response to notify on delete

    }

    /**
     * @param $id
     * @return \Dingo\Api\Http\ResponseBuilder|\Illuminate\Http\Response
     */
    public function restore($id)
    {

        //
        $contact = contact::find($id);

        if(!$contact)
        {
            return $this->response->errorNotFound('Contact does not exist.Please Check your Request and Try again.');
        }

        $contact->restore($id);

        return $this->response->noContent(); //create custom response to notify on delete


    }



}
