<?php
/**
 * Created by PhpStorm.
 * User: Ali Shan
 * Date: 2/28/2019
 * Time: 6:03 PM
 */

defined('BASEPATH') OR exit('No direct script access allowed');

class Page_Model extends CI_Model{

	private $tablename = 'posts';

	public function get_by_slug($slug)
	{
		$this->db->cache_on();
		$this->db->select('p.id ,p.title, p.content, p.featured_image, p.slug');
		$this->db->select('pm.meta_value ,pm.meta_key');
		$this->db->from($this->tablename . ' as p');
		$this->db->join('posts_meta as pm', 'pm.post_id = p.id', 'left');
		$this->db->where('type', 'page');
		$this->db->where('slug', $slug);

		$result = $this->db->get();
		$this->db->cache_off();

		$page = $this->combine_array($result->result());
		return $page;
	}

	private function combine_array(array $pages)
	{
		if (empty($pages))
			return $pages;

		$id = '';
		$newarr = [];
		foreach ($pages as $page){
			if (empty($id) || intval($id) !== intval($page->id)){
				$id = $page->id;
				$newarr[$id]['post_info'] = [
					'post_id'	=> $page->id,
					'title'	=> $page->title,
					'content'	=> $page->content,
					'featured_image'	=> $page->featured_image,
					'slug'	=> $page->slug
				];
			}

			$newarr[$id]['meta_info'][] = [
				'meta_key'	=> $page->meta_key,
				'meta_value'	=> $page->meta_value
			];

		}

		return array_values($newarr);
	}
}
