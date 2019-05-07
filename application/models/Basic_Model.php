<?php
class Basic_Model extends CI_Model{

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    function fullSelect($tablename,$order_by='', $order="ASC" )
    {
        $this->db->select('*');
        $this->db->from($tablename);
        if($order_by!=''){
            $this->db->order_by($order_by, $order);
        }
        $query = $this->db->get();
        return $query;
    }
    function basicSelect($tablename,$col_name,$value, $order_by='', $order="DESC" )
    {
        $this->db->select('*');
        $this->db->from($tablename);
        $this->db->where($col_name,$value);
        if($order_by!=''){
            $this->db->order_by($order_by, $order);
        }
        $query = $this->db->get();
        return $query ;
    }

    function basicSelectL($tablename,$col_name,$value, $order_by='', $order="DESC" )
    {
        $this->db->select('*');
        $this->db->from($tablename);
        $this->db->where($col_name,$value);
        if($order_by!=''){
            $this->db->order_by($order_by, $order);
        }
        $this->db->limit(8);
        $query = $this->db->get();
        return $query ;
    }

    function basicSelectTwo($tablename,$col_name,$value,$col_name2,$value2,$order_by='',$order="ASC")
    {
        $this->db->select('*');
        $this->db->from($tablename);
        $this->db->where($col_name,$value);
        $this->db->where($col_name2,$value2);
        if($order_by!=''){
            $this->db->order_by($order_by, $order);
        }
        $query = $this->db->get();
        return $query;
    }

    function basicSelectThree($tablename,$col_name,$value,$col_name2,$value2,$col_name3,$value3,$order_by,$order)
    {
        $this->db->select('*');
        $this->db->from($tablename);
        $this->db->where($col_name,$value);
        $this->db->where($col_name2,$value2);
        $this->db->where($col_name3,$value3);
        if($order_by!=''){
            $this->db->order_by($order_by, $order);
        }
        $query = $this->db->get();
        return $query;
    }

    function basicGetTable($tablename)
    {
        $this->db->select('*');
        $this->db->from($tablename);
        $query = $this->db->get();
        return $query;
    }

    function basicSave($table,$data)
    {
        $this->db->insert($table,$data);
        return $this->db->insert_id();

    }

    function basicUpdate($table,$data,$col,$val)
    {
        $this->db->where($col,$val);
        $this->db->update($table,$data);
    }

    function basicUpdateTwo($table,$data,$col,$val,$col2,$val2)
    {
        $this->db->where($col,$val);
        $this->db->where($col2,$val2);
        $this->db->update($table,$data);
    }

    function basicDelete($table,$col,$val)
    {
        $this->db->where($col,$val);
        $this->db->delete($table);

    }

    function basicDeleteTwo($table,$col,$val,$col2,$val2)
    {
        $this->db->where($col,$val);
        $this->db->where($col2,$val2);
        $this->db->delete($table);

    }

    function basicRecordExist($table,$field_name,$field_value)
    {

        if(trim($field_value) != '')
        {
            $this->db->select($field_name);
            $this->db->from($table);
            $this->db->where($field_name,$field_value);
            $query = $this->db->get();

            if ($query->num_rows() > 0)
            {

                return '0';
            }
            else
            {
                return '1';
            }
        }
        else
        {
            return '0';
        }

    }

    function basicRecordExistTwo($table,$field_name,$field_value,$field_name2,$field_value2)
    {

        if(trim($field_value) != '')
        {
            $this->db->select($field_name);
            $this->db->from($table);
            $this->db->where($field_name,$field_value);
            $this->db->where($field_name2,$field_value2);
            $query = $this->db->get();
            if ($query->num_rows() > 0)
            {

                return '0';
            }
            else
            {
                return '1';
            }
        }
        else
        {
            return false;
        }

    }

    function basicGetSingleValue($table,$where,$fieldname)
    {
        $q="select $fieldname from $table where $where";

        $query = $this->db->query($q);
        if ($query->num_rows() > 0)
        {
            foreach ($query->result() as $row)
                return $row->$fieldname;
        }
        else
            return '';

    }

    function basicGetColumValue($col , $table , $condition_str)
    {
        $res ='';
        $this->db->select($col);
        $this->db->from($table);
        $this->db->where($condition_str);
        $result = $this->db->get();
        if($result->num_rows()>0)
        {
            foreach($result->result_array() as $row)
            {
                return $res = $row[$col];
            }
        }
        return $res;
    }

    function basicQuery($query)
    {
        return $result=$this->db->query($query);
    }

    public function basicCreateConfigForPagination($url,$table,$total_records='',$per_page='',$uri_segment=''){
        $config['base_url'] = base_url().$url;

        if($total_records=="")
            $config['total_rows'] = $this->db->count_all($table);
        else
            $config['total_rows']=$total_records;

        $config['per_page'] = $per_page;
//        $config["uri_segment"] = $uri_segment;
        $choice = $config["total_rows"] / $config["per_page"];

        $config["num_links"] = 4;

        //config for bootstrap pagination class integration
        $config['full_tag_open'] = '<ul class="pagination">';
        $config['full_tag_close'] = '</ul>';
        $config['first_link'] = false;
        $config['last_link'] = false;
        $config['first_tag_open'] = '<li>';
        $config['first_tag_close'] = '</li>';
        $config['prev_link'] = '&laquo';
        $config['prev_tag_open'] = '<li class="prev">';
        $config['prev_tag_close'] = '</li>';
        $config['next_link'] = '&raquo';
        $config['next_tag_open'] = '<li>';
        $config['next_tag_close'] = '</li>';
        $config['last_tag_open'] = '<li>';
        $config['last_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<li class="active"><a href="#">';
        $config['cur_tag_close'] = '</a></li>';
        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';
        $config['anchor_class'] = "parma";

        return $config;
    }

    public function basicGetRecordsByLimit($table,$query="",$limit, $start) {
        if($query==""){
            $this->db->limit($limit, $start);
            $query = $this->db->get($table);
        }
        else{
            $query= $this->db->query($query);//"selct * from users"
        }
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return false;
    }
    public function basicGetRecordsByLimit2($table,$value,$limit, $start) {

        $this->db->select('*');
        $this->db->from($table);
        $this->db->where('uni_id',$value);
        $this->db->limit($limit, $start);
        $query = $this->db->get();
        return $query;


    }


    public function uploadImage($folder_name,$image_name,$height){


        $upload_path = './'.$folder_name.'/';
        $config['upload_path'] = $upload_path;
        //allowed file types. * means all types
        $config['allowed_types'] = 'jpg|png|gif';
        //allowed max file size. 0 means unlimited file size
        $config['max_size'] = '0';
        //max file name size
        $config['max_filename'] = '255';
        //whether file name should be encrypted or not
//        $config['encrypt_name'] = TRUE;
        $new_name = rand().$_FILES[$image_name]['name'];
        $config['file_name'] = $new_name;
        //store image info once uploaded
        $image_data = array();

        $this->load->library('upload', $config);
        $this->upload->initialize($config);

        if ($this->upload->do_upload($image_name)) { //store the file info
            $image_data = $this->upload->data();
            $config['image_library'] = 'gd2';
            $config['source_image'] = $image_data['full_path']; //get original image
            $config['maintain_ratio'] = TRUE;
//            $config['width'] = $width;
            $config['height'] = $height;
            $this->load->library('image_lib', $config);
            $this->image_lib->resize();
            $this->image_lib->clear();
            return $config['file_name'];
        }else{
            return false;
        }

    }

    public function uploadImageGallery($folder_name,$image_name,$width){


        $upload_path = './'.$folder_name.'/';
        $config['upload_path'] = $upload_path;
        //allowed file types. * means all types
        $config['allowed_types'] = 'jpg|png|gif|jpeg';
        //allowed max file size. 0 means unlimited file size
//        $config['max_size'] = '0';
        //max file name size
        $config['max_filename'] = '255';
        //whether file name should be encrypted or not
//        $config['encrypt_name'] = TRUE;
        $new_name = rand().$_FILES[$image_name]['name'];
        $config['file_name'] = $new_name;
        //store image info once uploaded
        $image_data = array();

        $this->load->library('upload', $config);
        $this->upload->initialize($config);

        if ($this->upload->do_upload($image_name)) { //store the file info
            $image_data = $this->upload->data();
            $config['image_library'] = 'gd2';
            $config['source_image'] = $image_data['full_path']; //get original image
            $config['maintain_ratio'] = False;
            $config['create_thumb'] = TRUE;
            $config['width'] = $width;
//            $config['height'] = $height;
            $config['quality'] = '100%';
            $this->load->library('image_lib', $config);
            $this->image_lib->resize();
            $this->image_lib->clear();

        }

        return $new_name;
    }

    public function upload_image($img_name,$source,$width,$height){
        $target_dir = $source."/";
        $target_file = $target_dir . basename($_FILES[$img_name]["name"]);

        move_uploaded_file($_FILES[$img_name]["tmp_name"], $target_file);

        return basename( $_FILES[$img_name]["name"]);

    }
    public function basicResizeImage($source,$width=700,$height=1000){
        $this->load->library('image_lib');
        $config['image_library'] 	= 'gd2';
        $config['source_image']	= $source;
        $config['new_image']		= $source;
        $config['create_thumb'] 	= TRUE;
        $config['thumb_marker'] 	= "";
        $config['maintain_ratio'] 	= TRUE;
        $config['width']           = $width;
        $config['height']          = $height;
        $this->image_lib->initialize($config);
        $this->image_lib->resize();
        $this->image_lib->clear();
        unset($config2);

        return $source;

    }
    function SelectTwoTablesJoin($col_name,$value)
    {
        $this->db->select('*');
        $this->db->from('university');
        $this->db->join('program', 'university.uni_id=program.uni_id', 'inner');
        $this->db->where('university.uni_id',$value);

        return $query = $this->db->get();

    }

    function SelectTwoTablesJoin2($ptable,$ctable,$col_name,$ctable_id)
    {
        $this->db->select('*');
        $this->db->from("$ptable as p");
        $this->db->join("$ctable as c1", 'p.uni_id=c1.uni_id', 'inner');
        $this->db->where('p.'.$col_name,$ctable_id);
//        echo $this->db->last_query();
//        exit;
        return $query = $this->db->get();

    }

}
?>