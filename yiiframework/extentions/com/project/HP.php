<?php
/**
 * homepage 相关接口
 *
 * @author		黑冰 (001.black.ice@gmail.com)
 * @copyright	Copyright 2014
 * @package		homepage
 */
class HP
{
    // test
    public static function funTest()
    {
        echo "This is HP funTest! <br/>";
    }

    // get the article list
    public static function get_hp_article_list($type = '')
    {
        $arrR = array();
        if($type)
            $arrR = Page::getContentByList('pdw_homepage_article', 'where type in ('.$type.') order by id desc', '*', 20, true, Yii::app()->db_data_www);

        return $arrR;
    }

    // get the article content
    public static function get_hp_article_content_obj($id = 0)
    {
        $id = intval($id);
        $objR = array();

        if($id){
            $objR = Page::funGetIntroOneObj('pdw_homepage_article', "id = {$id}"); 
        }

        return $objR;
    }

    // get the type
    public static function get_hp_type($type = '', $limit = 20)
    {
        $arrR = array();
        $arrT = array();

        if($type)
        {
            $arrT = Page::getContentByList('pdw_homepage_type', 'where id in ('.$type.') order by id desc', 'id,type_name', $limit, false, Yii::app()->db_data_www);

            if($arrT['data']){
                foreach($arrT['data'] as $data){
                    $arrR[$data['id']] = $data['type_name'];
                }
            }
        }

        return $arrR; 
    }


    // get the qrcode
    public static function get_qrcode_by_id($id = 0)
    {
        $objDB  = '';
        $id     = intval($id); 

        if($id){
            $objDB = Pdw_homepage_qrcode::model()->find("id = {$id}");
        }

        return $objDB;
    }

    // get cdn image url
    public static function get_cdn_img_url($img_url = '')
    {
        $img_url = Yii::app()->params['img_domain'].$img_url; 
        return $img_url; 
    }

    //获取seo信息
    static public function funGetSeoInfo($table,$id){
        $reArr = array();
        if( class_exists( ucfirst($table) ) ){
            $cdb = new CDbCriteria();
            $cdb->select    = 'meta_title,meta_keywords,meta_description';
            $cdb->condition = 'id = :id';
            $cdb->params     =array(':id'=>$id);
            $model = new $table;
            $objDB = $model->find($cdb);
            if($objDB){
                $reArr['meta_title']      = $objDB->meta_title;
                $reArr['meta_keywords']   = $objDB->meta_keywords;
                $reArr['meta_description']= $objDB->meta_description;
            }
        }
        return $reArr;
    }

    //获取首页seo
    static public function funGetIndexSeoInfo($id){
        return self::funGetSeoInfo('pdw_game_homepage',$id);
    }

    //获取单页Seo
    static public function funGetArchivesSeoInfo($id){
        return self::funGetSeoInfo('pdw_homepage_archives',$id);

    }
    //获取文章内容页seo
    static public function funGetArticleSeoInfo($id){
        return self::funGetSeoInfo('pdw_homepage_article',$id);
    }
    
    //获取列表页seo
    static public function funGetListSeoInfo($id){
        return self::funGetSeoInfo('pdw_homepage_type',$id);
    }
}