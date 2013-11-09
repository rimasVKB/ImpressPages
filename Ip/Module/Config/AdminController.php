<?php
/**
 * @package ImpressPages
 *
 *
 */
namespace Ip\Module\Config;




class AdminController extends \Ip\Controller{

    public function index()
    {

        \Ip\ServiceLocator::getSite()->addJavascript(\Ip\Config::coreModuleUrl('Config/public/config.js'));

        $form = Forms::getForm();
        $data = array (
            'form' => $form
        );
        return \Ip\View::create('view/configWindow.php', $data)->render();

    }


    public function saveValue()
    {
        $request = \Ip\ServiceLocator::getRequest();

        $request->mustBePost();

        $post = $request->getPost();
        if (empty($post['fieldName'])) {
            throw new \Exception('Missing required parameter');
        }
        $fieldName = $post['fieldName'];
        if (!isset($post['value'])) {
            throw new \Exception('Missing required parameter');
        }
        $value = $post['value'];

        if (!in_array($fieldName, array('automaticCron'))) {
            throw new \Exception('Unknown config value');
        }

        \Ip\Storage::set('Config', $fieldName, $value);


        $this->returnJson(array(1));

    }
}