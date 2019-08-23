<?php

namespace Japazera\LaravelAdmin\Commands;

/**
* Commands Common Utils Functions
*/
class Utils
{
	public static function appendRoute($command, $route, $file_dst = '/routes/web.php')
	{
		$routes_content = file_get_contents(base_path($file_dst));

		// check if route already exist
		if(strpos($routes_content, $route) === false) {
			file_put_contents(base_path($file_dst), $route . PHP_EOL , FILE_APPEND | LOCK_EX);

			$command->info("route [$route] appended");
		} else {
			$command->comment("route [$route] already exists");
		}
	}

	public static function appendNav($command, $display, $model_lower, $fa_icon = 'fa-table', $file_dst = '/resources/views/admin/nav.blade.php')
	{
		$routes_content = file_get_contents(base_path($file_dst));

		// check if route already exist
		if(strpos($routes_content, $model_lower) === false) {
			$template = "";
			$template .= "<li class=\"nav-item {{ (Request::routeIs('$model_lower.index')) ? 'active' : '' }}\">";
			$template .= "	<a class=\"nav-link\" href=\"{{route('$model_lower.index')}}\">";
			$template .= "		<i class=\"fas fa-fw $fa_icon\"></i>";
			$template .= "		<span>$display</span>";
			$template .= "	</a>";
			$template .= "</li>";

			file_put_contents(base_path($file_dst), $template . PHP_EOL , FILE_APPEND | LOCK_EX);

			$command->info("nav [$model_lower] appended");
		} else {
			$command->comment("nav [$model_lower] already exists");
		}

	}

	public static function exportFolder($command, $folder, $templates_path)
	{
		$source = $templates_path . $folder;
		$dest = base_path($folder);

		self::createPathIfNotExist($command, $dest);

		foreach($iterator = new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator($source, \RecursiveDirectoryIterator::SKIP_DOTS),
		\RecursiveIteratorIterator::SELF_FIRST) as $item)  {

			if($item->isDir()) {
				self::createPathIfNotExist($command, $dest . DIRECTORY_SEPARATOR . $iterator->getSubPathName());
				$command->info($iterator->getSubPathName() . " exported.");
			} else {
				copy($item, $dest . DIRECTORY_SEPARATOR . $iterator->getSubPathName());
			}
		}
	}

	public static function createPathIfNotExist($command, $path)
	{
		if(!file_exists($path)) {
			mkdir($path, 777, true);
		}
	}

	public static function exportEnv($command, $content)
	{
		$env_content = file_get_contents(base_path('.env'));

		// check if content already exist
		if(strpos($env_content, $content) === false) {
			file_put_contents(base_path('.env'), $content . PHP_EOL , FILE_APPEND | LOCK_EX);

			$command->info("route [$content] appended");
		} else {
			$command->comment("route [$content] already exists");
		}
	}
}
