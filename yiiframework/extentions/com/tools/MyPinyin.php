<?php
class MyPinyin
{
	public static $_instance;
	public static $_pinyin_obj;

	public static function getInstance()
	{
		if(!self::$_instance)
		{
			self::$_instance = new self();
		}
		return self::$_instance;
	}

	public function __construct()
	{
		include 'pinyin/pinyin.php';

		self::$_pinyin_obj = pinyin::getInstance();
	}

	//�õ�ƴ��
	public  static function get_pinyin($str)
	{
		self::getInstance();
		return self::$_pinyin_obj->get_pinyin($str);
	}


	//�õ�ƴ������ĸ
	public  static function get_pinyin_initial($str)
	{
		self::getInstance();
		return self::$_pinyin_obj->get_initial($str);
	}
}