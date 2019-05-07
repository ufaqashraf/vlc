<?php
/**
 * Created by PhpStorm.
 * User: Ali Shan
 * Date: 2/28/2019
 * Time: 4:30 PM
 */

defined('BASEPATH') OR exit('No direct script access allowed');


class Tradeshow_Model extends CI_Model{

	private $tablename = 'posts';

	public function get_all($limit = 20)
	{
		$this->db->cache_on();
		$this->db->select('p.id ,p.title, p.content, p.featured_image, p.slug, p.date_time');
		$this->db->select('pm.meta_value ,pm.meta_key');
		$this->db->from($this->tablename . ' as p');
		$this->db->join('posts_meta as pm', 'pm.post_id = p.id', 'left');
		$this->db->where('type', 'tradeshow');


		$result = $this->db->get();
		$this->db->cache_off();


		$tradeshows = $this->combine_array($result->result());

		return $tradeshows;
	}

	public function get_by_slug($slug)
	{
		$this->db->cache_on();
		$this->db->select('p.id ,p.title, p.content, p.featured_image, p.slug, p.date_time');
		$this->db->select('pm.meta_value ,pm.meta_key');
		$this->db->from($this->tablename . ' as p');
		$this->db->join('posts_meta as pm', 'pm.post_id = p.id', 'left');
		$this->db->where('type', 'tradeshow');
		$this->db->where('slug', $slug);

		$result = $this->db->get();
		$this->db->cache_off();

		$tradeshows = $this->combine_array($result->result());

		return $tradeshows;
	}

    public function get_trade_related_posts($related_post_current_id)
    {

		$this->db->cache_on();

		$this->db->select('p.id , p.title, p.slug, p.featured_image');
		$this->db->from('posts p');
		$this->db->where('p.type', 'tradeshow');

		$array = array('p.id !=' => $related_post_current_id);
		$this->db->where($array);

		$this->db->order_by('p.id', 'desc');
		$this->db->limit(3);

		$meta_result = [];
		$result = $this->db->get();
		$this->db->cache_off();

        $trad_info = $result->result();

        if ($trad_info) {
            $meta_result['info'] = $trad_info;
            foreach ($trad_info as $single) {

				$this->db->cache_on();
				$this->db->select('*');
				$this->db->from('posts_meta');
				$this->db->where('post_id', $single->id);

				$result = $this->db->get();
				$this->db->cache_off();


                $listing_meta = $result->result();

                $meta_result['metas'][] = $listing_meta;

            }

            return $meta_result;

        }
    }

    public function get_trade_next_previous_posts($next_previous)
    {
		$this->db->cache_on();
		$this->db->select('p.id , p.title, p.slug, p.featured_image');
		$this->db->from('posts p');
		$this->db->where('p.type', 'tradeshow');
		$array = array('p.id !=' => $next_previous);
		$this->db->where($array);

		$this->db->order_by('p.id', 'desc');
		$this->db->limit(2);

		$result = $this->db->get();
		$this->db->cache_off();

        return $result->result();

    }

	private function combine_array(array $tradeshows)
	{
		if (empty($tradeshows))
			return $tradeshows;

		$id = '';
		$newarr = [];
		foreach ($tradeshows as $tradeshow){
			if (empty($id) || intval($id) !== intval($tradeshow->id)){
				$id = $tradeshow->id;
				$newarr[$id]['post_info'] = [
					'post_id'	=> $tradeshow->id,
					'title'	=> $tradeshow->title,
					'content'	=> $tradeshow->content,
					'featured_image'	=> $tradeshow->featured_image,
					'slug'	=> $tradeshow->slug,
					'create_date'	=> $tradeshow->date_time
				];
			}

			$newarr[$id]['meta_info'][] = [
				'meta_key'	=> $tradeshow->meta_key,
				'meta_value'	=> $tradeshow->meta_value
			];

		}

		return array_values($newarr);
	}
}
