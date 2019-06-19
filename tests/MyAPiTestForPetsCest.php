<?php

class MyAPiTestForPetsCest
{
    public function _before(ApiTester $I, \Codeception\Scenario $scenario)
    {
        if ($scenario->current('env') === 'staging') {
            $scenario->skip("Not for staging");
        }
        $I->haveHttpHeader('Content-Type', 'application/json');
        $I->sendPOST('/auth/login', [
            'username' => $scenario->current('username'),
            'password' => $scenario->current('password'),
        ]);
    }

    /**
     * @group pet
     * @group admin
     *
     * @param ApiTester $I
     * @param \Data\Help $helpData
     * @throws Exception
     */
    public function insertPet(ApiTester $I, \Data\Help $helpData)
    {
        $helpData->createHelp(['name' => 'dragon']);
        $helpData->createHelp(['name' => 'cat']);
        $helpData->createHelp(['name' => 'dog']);

        $I->canSeeResponseCodeIs(200);
        $I->canSeeResponseIsJson();
        $I->canSeeResponseContainsJson([
            'name' => 'drjhaghjgjagon123',
            'status' => 'available',
        ]);
        $I->canSeeResponseMatchesJsonType([
            'name' => 'string',
            'status' => 'string',
            'id' => 'integer',
            'category' => 'array'
        ]);
        list($id) = $I->grabDataFromResponseByJsonPath('$..id');
        $I->sendGET('/pet/' . $id);
        $I->seeResponseCodeIs(200);
        $I->seeResponseContainsJson([
            'name' => 'dragon123'
        ]);
        $this->id = $id;
    }

    protected $id;

    /**
     * @group pet
     *
     * @depends insertPet
     * @param ApiTester $I
     */
    public function updatePet(ApiTester $I)
    {
        $this->id;
        $I->sendPUT('/pet', [
            'id' => $this->id,
            'name' => 'notadragon'
        ]);
        // TODO: check that name of a pet was updated $I->sendGET();
    }

    /**
     * @depends insertPet
     * @param ApiTester $I
     */
    public function deletePet(ApiTester $I)
    {
        // implement it
        // TODO: check that pet was deleted

    }
}