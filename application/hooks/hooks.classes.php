<?php

/**
 * Created by PhpStorm.
 * User: User
 * Date: 3/5/2019
 * Time: 3:42 PM
 */


defined('BASEPATH') OR exit('No direct script access allowed');


class ProfilerHandler
{
	function EnableProfiler()
	{
		$CI = &get_instance();
		$CI->output->enable_profiler( config_item('enable_hooks') );
	}
}
