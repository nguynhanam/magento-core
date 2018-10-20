<?php
require __DIR__ . '/app/bootstrap.php';
$bootstrap = \Magento\Framework\App\Bootstrap::create(BP, $_SERVER);
/** @var \Magento\Framework\App\Http $app */

class updateDbVersion
    extends \Magento\Framework\App\Http
    implements \Magento\Framework\AppInterface {

    public function launch()
    {
        //dirty code goes here.
        //the example below just prints a class name
        $this->_state->setAreaCode('frontend');
        echo '<pre>';
        $dbVersionInfo = $this->_objectManager->create('Magento\Framework\Module\DbVersionInfo');
        $moduleResource = $this->_objectManager->create('Magento\Framework\Module\ModuleResource');
        $errors = $dbVersionInfo->getDbVersionErrors();
        foreach ($errors as $error){
            if($error['type'] == 'schema'){
                $moduleResource->setDbVersion($error['module'], $error['required']);
            }
            if($error['type'] == 'data'){
                $moduleResource->setDataVersion($error['module'], $error['required']);
            }
        }
        return $this->_response;
    }

    public function catchException(\Magento\Framework\App\Bootstrap $bootstrap, \Exception $exception)
    {
        return false;
    }

}
$app = $bootstrap->createApplication('updateDbVersion');
$bootstrap->run($app);