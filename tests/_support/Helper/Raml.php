<?php
namespace Helper;

// here you can define custom actions
// all public methods declared in helper class will be available in $I

use Raml\ApiDefinition;

class Raml extends \Codeception\Module
{
    /**
     * @var ApiDefinition
     */
    private $apiDef;

    public function _beforeSuite($config = [])
    {
        $parser = new \Raml\Parser();
        $this->apiDef = $parser->parse(codecept_root_dir($config['raml_file']), true);
    }

    public function seeResponseMatchesType($type)
    {
        $types = $this->apiDef->getTypes();
        codecept_debug("TYPES: " . json_encode($types->toArray()));
        $type = $types->getTypeByName($type);
        $data = json_decode($this->getModule('REST')->grabResponse());
        if (is_array($data)) { // if we have multiple items - check the first one
            $data = $data[0];  // TODO: check all items!
        }
        $type->validate($data);
        if (!$type->isValid()) {
            $this->fail(implode(', ', $type->getErrors()));
        }
    }
}
