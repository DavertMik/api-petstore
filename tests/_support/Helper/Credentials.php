<?php
namespace Helper;

// here you can define custom actions
// all public methods declared in helper class will be available in $I

use Codeception\Step\Argument\PasswordArgument;
use Codeception\TestInterface;

class Credentials extends \Codeception\Module
{
    protected $config = ['password' => '123456'];

    protected $requiredFields = ['username', 'password'];

    public function _before(TestInterface $test)
    {
        $config = $this->_getConfig();
        $test->getMetadata()->setCurrent([
            'username' => $config['username'],
            'password' => $config['password']
        ]);
    }

    public function getCredentials()
    {
        return $this->getCredentials();
    }

}
