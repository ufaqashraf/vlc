<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Advertisewithus extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->model('Advertise_Model');
    }

    public function index()
    {
        $this->load->view('frontend/advertise_with_us/advertise_with_us');

    }

    public function create()
    {
        $input_data = filter_input_array(INPUT_POST);

            $this->form_validation->set_rules('fullname', 'Fullname', 'required');
            $this->form_validation->set_rules('email', 'Email', 'required|min_length[1]|max_length[255]');
            $this->form_validation->set_rules('phone', 'Phone', 'required');
            $this->form_validation->set_rules('message', 'Message', 'required');

            if ($this->form_validation->run() !== false) {

                    $data = array(
                        'validation_errors' => validation_errors(),
                        'success_msg' => '<strong>Congratulation!</strong><br /> Message successfull.',
                        'fullname' => '',
                        'email' => '',
                        'phone' => '',
                        'message' => ''
                    );

                    // @todo: advertise with us message to admin

                    $mail = new \PHPMailer\PHPMailer\PHPMailer();
                    // Passing `true` enables exceptions
                    try {
                        $mail->isSMTP();
                        $mail->Host = PHPMAILER_SENDER_HOST;
                        $mail->SMTPAuth = PHPMAILER_SENDER_SMTPAUTH;
                        $mail->Username = PHPMAILER_SENDER_USERNAME;
                        $mail->Password = PHPMAILER_SENDER_PASSWORD;
                        $mail->SMTPSecure = PHPMAILER_SENDER_SMTP_SECURE;
                        $mail->Port = PHPMAILER_SENDER_PORT;

                        $mail->setFrom(NEWSLETTER_FROM_EMAIL);
                        // Email subject
                        $mail->Subject = 'New user want to advertise with us |' . SITE_NAME;
                        // Set email format to HTML
                        $mail->isHTML(true);
                        $mail->addAddress(NEWSLETTER_FROM_EMAIL);
                        $html = 'Email: ' . $input_data['email'] .'<br />' .'Name: ' . $input_data['fullname'] .'<br />' .'Phone No: ' . $input_data['phone'] . '<br />' . 'Message: ' . $input_data['message'];
                        $mail->Body = $html;
                        $mail->send();
                    } catch (Exception $e) {
                        log_message('error', $mail->ErrorInfo);
                    }

                    $this->session->set_flashdata('success_msg', '<strong>Thank You!</strong><br />' . 'for advertise with us.');
                    $this->load->view('frontend/advertise_with_us/advertise_with_us', $data);
                    redirect(base_url() . 'advertisewithus');
            } else {
                $this->session->set_flashdata('validation_errors', 'sending error');
                $this->load->view('frontend/advertise_with_us/advertise_with_us');
                redirect(base_url(). 'advertisewithus');
            }

    }

}
