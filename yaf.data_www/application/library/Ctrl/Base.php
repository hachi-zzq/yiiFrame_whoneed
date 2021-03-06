<?php
/**
 * 控制器 基础类
 *
 * @author      黑冰(001.black.ice@gmail.com)
 * @copyright   (c) 2014
 * @version     $Id$
 * @package     ctrl
 * @since       v0.1
 */
abstract class Ctrl_Base extends Yaf_Controller_Abstract 
{
    /**
     * 提示信息
     * @param string $pMsg
     * @param bool $pUrl
     */
    function showMsg($pMsg, $pUrl = false) 
    {
        header('Content-Type:text/html; charset=utf-8');
        is_array($pMsg) && $pMsg = join('\n', $pMsg);
        echo '<script type="text/javascript">';
        if($pMsg) echo "alert('$pMsg');";
        if($pUrl) echo "self.location='{$pUrl}'";
        elseif(empty($_SERVER['HTTP_REFERER'])) echo 'window.history.back(-1);';
        else echo "self.location='{$_SERVER['HTTP_REFERER']}';";
        exit('</script>');
    }

    /**
   * AJAX返回
   * @param string $pMsg 提示信息
   * @param int $pStatus 返回状态
   * @param mixed $pData 要返回的数据
   * @param string $pStatus ajax返回类型
   */
    protected function ajax($pMsg='', $pStatus=0, $pData='', $pType='json')
    {
        # 编码
        header("Content-Type:text/html; charset=utf-8");
        # 信息
        $tResult = array('status'=>$pStatus, 'msg'=>$pMsg, 'data'=>$pData);
        # 格式
        'json' == $pType && exit(json_encode($tResult));
        'xml' == $pType && exit(xml_encode($tResult));
        'eval' == $pType && exit($pData);
    }
}
?>
