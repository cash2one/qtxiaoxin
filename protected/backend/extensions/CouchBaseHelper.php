<?php

 Yii::import("backend.config.DatabaseConfig");
class CouchBaseHelper
{

	public static function set($key,$value)
	{
		$info = DatabaseConfig::couchbaseInfo();
		$cb = new Couchbase($info['url'], "", "", $info['bucket']);
		$cb->set($key, $value);
    }

    public static function get($key)
	{
		$info = DatabaseConfig::couchbaseInfo();
		$cb = new Couchbase($info['url'], "", "", $info['bucket']);
		$value = $cb->get($key);
		return $value;
    }
	
	public static function delete($key)
	{
		$info = DatabaseConfig::couchbaseInfo();
		$cb = new Couchbase($info['url'], "", "", $info['bucket']);
		$value = $cb->delete($key);
    }
}