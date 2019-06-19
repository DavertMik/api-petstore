<?php
namespace Data;

class Help
{
    private $i;

    public function __construct(\ApiTester $I)
    {
        $this->i = $I;
    }

    public function createHelp(array $params = [])
    {
        $helpData = $this->generateHelp($params);
        $this->i->sendPOST('/pet', $helpData);
    }

    private function getDefaultData() : array {

        $faker = \Faker\Factory::create();
        return [
            'name' => $faker->name,
            'category' => [
                'id' => 0,
                "name" => "string",
            ],
            'status' => $faker->randomElement(['available', 'pending']),
            'photoUrls' => [
                'https://pixabay.com/en/dragon-illusions-silhouette-fantasy-2794030/'
            ]
        ];
    }

    public function generateHelp(array $params = []) : array
    {
        return array_merge($this->getDefaultData(), $params);
    }
}
