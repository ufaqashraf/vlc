<?php
/**
 * Created by PhpStorm.
 * User: volgopoint.com
 * Date: 2/25/2019
 * Time: 1:05 PM
 */

defined('BASEPATH') OR exit('No direct script access allowed');

class Contactus_Model extends CI_Model{

    private $table_name = 'contact';

    public function user_contact($name='', $subject ='', $email = '', $comments = '')
    {

        $data = array(
            'name' => $name,
            'subject' => $subject,
            'email' => $email,
            'comments ' => $comments
        );

        $this->db->set($data);
        return $this->db->insert($this->table_name);
    }


}

