<?php
/**
 * 文章相关接口
 *
 * @author		黑冰 (001.black.ice@gmail.com)
 * @copyright	Copyright 2013
 * @package		article_api
 */
class Article_api{
	
	/**
	 * 用途:获取文章模型列表
	 *
	 * <b>使用示例：</b>Article_api::get_article_list(44);
	 *
	 * <b>参数id：</b>
	 * <br/>44	:	热门活动
	 * <br/>45	:	秀场公告
	 * 
	 * <b>返回值数组</b>
	 * <br/>id			: id
	 * <br/>title		: 标题
	 * <br/>submit_date	: 更新时间
	 * <br/>
	 *
	 * @author	黑冰(001.black.ice@gmail.com)
	 * @param	int		$type	参数id 
	 * @param	int		$limit	查询的记录条数		默认为20
	 * @param	boolean	$page	是否需要计算分页	默认为true
	 *
	 * @return	array
	 * array
	 */
	public static function get_article_list($type, $limit = 20, $page = false){
		// init
		$type = intval($type);
		if(!$type) return;

		$arrR = array();
		$arrR = Page::getContentByList('whoneed_article', "where type={$type} order by submit_date desc", '*', $limit, $page);
	
		return $arrR['data'];
	}

	/**
	 * 获取文章模型详细页
	 *
	 * <b>使用示例：</b> Ads_api::get_article_content(1);
	 *
	 * <b>返回值：数组</b>
	 * <br/>id			: 文章id
	 * <br/>title		: 文章标题
	 * <br/>submit_date	: 更新时间
	 * <br/>intro		: 文章内容
	 *
	 * @author	黑冰 (001.black.ice@gmail.com)
	 * @param	int		$id		文章id;
	 * @time	2013-01-24
	 * @return	array
	 */
	public static function get_article_content($id){
		// init
		$id = intval($id);
		if(!$id) return;
		
		// 获取主表
		$arrMain = array();
		$arrMain = Page::getContentByOne('whoneed_article', "where id = {$id}");
		// 获取从表
		$arrFollow = array();
		$arrFollow = Page::getContentByOne('whoneed_article_content', "where id = {$id}");
		
		$arrR = array();
		if($arrMain&&$arrFollow) {
			$arrR = array_merge($arrMain, $arrFollow);
		}

		return $arrR;
	}

	/**
	 * 获取单页内容
	 *
	 * <b>使用示例：</b> Article_api::get_archives(1);
	 *
	 * <b>参数id：</b>
	 * <br/>47	:	关于我们
	 * <br/>48	:	人才招聘
	 * <br/>49	:	用户声明
	 * <br/>50	:	法律声明
	 * <br/>51	:	商务合作
	 * <br/>52	:	联系我们
	 * 
	 * <b>返回值：数组</b>
	 * <br/>title	: 标题
	 * <br/>intro	: 内容
	 *
	 * @author	黑冰 (001.black.ice@gmail.com)
	 * @param	int		$id	参数id
	 * @time	2013-01-24
	 * @return	array
	 */
	public static function get_archives($id){
		// init
		$id = intval($id);
		if(!$id) return;

		// get content by id
		$arrR = array();
		$arrR = Page::getContentByOne('whoneed_archives', "where id = {$id}");
		
		return $arrR;
	}

	//================ 帮助中心
	/**
	 * 获取帮助中心分类
	 *
	 * <b>使用示例：</b> Article_api::get_help_type();
	 * 
	 * <b>返回值：数组</b>
	 * <br/>id			: 分类编号
	 * <br/>type_name	: 分类名称
	 *
	 * @author	黑冰 (001.black.ice@gmail.com)
	 * @time	2013-03-04
	 * @return	array
	 */
	public static function get_help_type(){
		$arrR = array();
		$arrR = Page::getContentByList('whoneed_rbac_column', "where fid=54 order by id asc", 'id, column_name as type_name', 20, false);

		return $arrR['data'];
	}

	/**
	 * 获取帮助内容列表
	 *
	 * <b>使用示例：</b> Article_api::get_help_list(1);
	 * 
	 * <b>返回值：二维数组</b>
	 * <br/>id		: 内容编号
	 * <br/>type	: 分类id
	 * <br/>title	: 帮助标题
	 * <br/>intro	: 帮助内容
	 *
	 * @author	黑冰 (001.black.ice@gmail.com)
	 * @param	int	$type	帮助分类id
	 * @time	2013-03-04
	 * @return	array
	 */
	public static function get_help_list($type = 0){
		$arrR = array();
		$type = intval($type);
		if(!$type) return $arrR;

		$sql = "select wa.id, wa.type, wa.title, wac.intro from whoneed_article wa, whoneed_article_content wac where wa.type = {$type} and wa.id = wac.id order by wa.id asc";
		$arrR = Page::funGetIntroBySql($sql);

		return $arrR;
	}
}
?>