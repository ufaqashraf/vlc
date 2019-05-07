<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Flagreports extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('Flagreports_Model');
        $this->load->library('form_validation');
    }

    public function index($user_id , $listing_slug)
    {
        if (volgo_front_is_logged_in()) {
            $data = [
                'user_id' => $user_id,
                'listing_slug' => $listing_slug,

            ];

            $this->load->view('frontend/flag_reports/flag_reports', $data);
        }else{
            redirect('login?redirected_to=' . base_url('flagreports/index/') . $user_id. '/' . $listing_slug);
        }

    }

    public function insert_flagreport($user_id, $listing_slug)
    {


        $data = array(
            'flag_validation_errors' => '',
            'flag_success_msg' => ''
        );

        $input_data = filter_input_array(INPUT_POST);

        if (!empty($input_data)) {

            $this->form_validation->set_rules('spam', 'Spam', 'required');
            $this->form_validation->set_rules('fraud', 'Fraud', 'required');
            $this->form_validation->set_rules('miscategorized', 'Miscategorized', 'required');
            $this->form_validation->set_rules('repetitive', 'Repetitive', 'required');

            if ($this->form_validation->run() !== false) {

                $spam = $this->input->post('spam');
                $fraud = $this->input->post('fraud');
                $miscategorized = $this->input->post('miscategorized');
                $repetitive = $this->input->post('repetitive');
                $descirption = "[Spam] ";
                $descirption .= $spam;
                $descirption .= "</br>";
                $descirption .= "[Fraud] ";
                $descirption .= $fraud;
                $descirption .= "</br>";
                $descirption .= "[Miscategorized] ";
                $descirption .= $miscategorized;
                $descirption .= "</br>";
                $descirption .= "[Repetitive] ";
                $descirption .= $repetitive;

                $listing_title = $this->Flagreports_Model->get_title_of_listing($listing_slug);
                $user_name = $this->Flagreports_Model->get_username($user_id);

                $is_created = $this->Flagreports_Model->create_flag_report(
                    $user_name,
                    $listing_title,
                    $descirption
                );

                if ($is_created) {
                    $data = array(
                        'flag_validation_errors' => validation_errors(),
                        'spam' => $spam,
                        'fraud' => $fraud,
                        'miscategorized' => $miscategorized,
                        'repetitive ' => $repetitive
                    );


                    $this->session->set_flashdata('flag_success_msg', '<strong>Thank You!</strong><br />' . 'Flag Report submitted successfully.');

                    //$this->load->view('frontend/flag_reports/flag_reports', $data);

                    redirect(base_url() . volgo_make_slug($listing_title[0]->title));

                } else {
                    $this->session->set_flashdata('flag_validation_errors', 'flag report submission error');
                    $this->load->view('frontend/flag_reports/flag_reports', $data);
                    redirect(base_url() . 'flagreports');
                }
            } else {
                $this->session->set_flashdata('flag_validation_errors', 'Already submitted flag report query');
                $this->load->view('frontend/flag_reports/flag_reports', $data);
                redirect(base_url() . 'flagreports');
            }

        } else {
            $this->session->set_flashdata('flag_validation_errors', '');
            $this->load->view('frontend/flag_reports/flag_reports', $data);
            redirect(base_url() . 'flagreports');
        }
    }


}
