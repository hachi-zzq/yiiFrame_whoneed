<?php
/**
 * 控制器 Page类
 *
 * @author      黑冰(001.black.ice@gmail.com)
 * @copyright   (c) 2014
 * @version     $Id$
 * @package     ctrl
 * @since       v0.1
 */
abstract class Ctrl_Page extends Ctrl_Base
{
    public $_layout     = '';
    public $_layoutDir  = '';

    public function display($action_file = '', $data = array())
    {
        // have layout file
        if($this->_layout){
            $response = $this->getResponse();
            $body = parent::render($action_file, $data);;

            /*clear existing response*/
            $response->clearBody();

            /* wrap it in the layout */
            if(!$this->_layoutDir){
                $this->_layoutDir = Yaf_Registry::get("config")->application->directory.'views';
            }
            $layout = new Yaf_View_Simple($this->_layoutDir);
            $layout->content = $body;

            /* set the response to use the wrapped version of the content */
            $response->setBody($layout->render($this->_layout, $data));
        }else{
            parent::display($action_file, $data);
        }
    }
}
?>
