<?php

use Faker\Factory as Faker;

class ContactsTest extends ApiTester {

    use Factory;

    /** @test */
    public function it_fetches_contacts()
    {
        /*
         * Scenario Fetch All Contacts
         * Given that I want to get all contacts
         * And that they are contact objects
         * When I request Json('api/v1/contacts')
         * Then the response is JSON
         * Then response code should be 200
         */

        $this->times(5)->make('contact');
        $data = $this->getJson('api/v1/contacts');
        $this->assertJsonData($data);
        $this->assertResponseOk(); //Assert that contacts are gotten and exist

    }

    /** @test */
    public function it_fetches_a_single_contact()
    {
        /*
         * Scenario Fetch A Contact
         * Given that I want to get a single contact
         * When I request Json('api/v1/contacts/1')
         * Then the response is JSON
         * And response code should be 200
         * And Object should have Contact model attributes
         * And Key attributes Object are not empty
         */
        $this->make('contact');

        $contact = $this->getJson('api/v1/contacts/1')->data;
        $this->assertJsonData($contact);
        $this->assertResponseOk();
        $this->assertObjectHasAttributes($contact,'first_name','last_name','email','address','twitter','created_at',
            'last_updated_at','archived_at');
        $this->assertKeyAttributesNotEmpty($contact,'first_name','last_name','email','address','twitter','created_at');

    }

    /** @test */
    public function it_404s_if_a_contact_not_found()
    {
        /*
         * Scenario 404 Error for Non-existing Contact
         * Given that I want 404 Error
         * When I request Json('api/v1/contacts/x')
         * Then the response is JSON
         * And response message is equal to Intended message
         * Then response code should be 404
         */
        $data = $this->getJson('api/v1/contacts/x');
        $this->assertJsonData($data);
        $this->assertEquals('Contact does not exist.Please Check your Request.', $data->message);
        $this->assertResponseStatus(404);
    }

    /** @test */
    public function it_creates_a_new_contact_with_valid_login()
    {
        $this->it_creates_a_new_contact_given_valid_parameters();
        $this->assertResponseStatus(201);
    }

    /** @test */
    public function it_fails_to_create_a_new_contact_with_invalid_login()
    {
        Auth::logout();
        $data = $this->it_creates_a_new_contact_given_valid_parameters();
        $this->assertEquals('Invalid authentication credentials.', $data->message);
        $this->assertResponseStatus(401);
    }

    /** @test */
    public function it_creates_a_new_contact_given_valid_parameters()
    {
        return $this->getJson('api/v1/contacts','POST', $this->getStub());
    }

    /** @test */
    public function it_throws_a_422_if_a_new_contact_request_fails_validation()
    {
        $this->getJson('api/v1/contacts','POST');

        $this->assertResponseStatus(422);

    }

    /** @test */
    public function it_deletes_a_contact()
    {
        /*
         * Scenario: Deleting a User
         * Given that I want to delete a "Contact"
         * And that its "id" is "1"
         * When I request deletegetJson('api/v1/contacts/1')
         * Then the "status" property equals "true"
         */


        $data = $this->getJson('api/v1/contacts/1');
        $this->assertJsonData($data);


    }
    protected function getStub()
    {
        $faker = Faker::create();
        $ownerids = User::lists('id');
        return [
            'owner_id' => $faker->randomElement($ownerids),
            'first_name' => $faker->firstName(),
            'last_name' => $faker->lastName(),
            'email' => $faker->email(),
            'address' => $faker->address(),
            'twitter' => $faker-> word().$faker->randomNumber()
        ];
    }
}
