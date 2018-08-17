<?php
namespace CliqsStudio\service;
use \CliqsStudio\config\CQS_Config;


class CQS_Cache extends CQS_Config{

		public function __construct(){

			$parent = new parent;
 			$systemPath  = $parent->CQSPath;
			require {$systemPath}.'lib/Cache_Lite-1.8.0/Cache/Lite.php';

		}

		public static function isCacheExists($id){

			$parent = new parent;
			
			$cache_status 	= 	$parent->cache;
			$cacheDir 		= 	$parent->cachePath[0];
			$cachePeriod 	=	$parent->cacheDuration;

			$options = array(
			    'cacheDir' => $cacheDir,
			    'lifeTime' => $cachePeriod
			);

			// Create a Cache_Lite object
			$Cache_Lite = new \Cache_Lite($options);
			if ($Cache_Lite->get($id)) 
				
				return true;
			
			else

				return false;
		
		}

		public static function getCache($id){

			$parent = new parent;
			
			$cache_status 	= 	$parent->cache;
			$cacheDir 		= 	$parent->cachePath[0];
			$cachePeriod 	=	$parent->cacheDuration;

			$options = array(
			    'cacheDir' => $cacheDir,
			    'lifeTime' => $cachePeriod
			);

			// Create a Cache_Lite object
			$Cache_Lite = new \Cache_Lite($options);
			$data = $Cache_Lite->get($id);

		}

		public static function buildCache($id,$data){

			$parent = new parent;
			
			$cache_status 	= 	$parent->cache;
			$cacheDir 		= 	$parent->cachePath[0];
			$cachePeriod 	=	$parent->cacheDuration;

			$options = array(
			    'cacheDir' => $cacheDir,
			    'lifeTime' => $cachePeriod
			);

			// Create a Cache_Lite object
			$Cache_Lite = new \Cache_Lite($options);

			if($Cache_Lite->save($data))

				return true;
			
			else

				return false;

		}
}
	
?>