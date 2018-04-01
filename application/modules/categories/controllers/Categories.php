<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Categories extends MY_Controller {

    function __construct() {
        parent::__construct();


        if (!$this->ion_auth->is_admin())
            show_404();

        $this->load->library('form_validation');
        $this->load->library('session');
        $this->load->helper('form');
        $this->load->model('categories_model', 'category');
    }

    public function index() {

        $this->form_validation->set_rules('name', 'Naam', 'trim|required');
        $this->form_validation->set_rules('sort', 'Positie', 'trim|required|is_natural_no_zero');
        $this->form_validation->set_rules('url', 'Url-link', 'trim|required|alpha_dash');

        if ($this->form_validation->run() == FALSE) {


            $data = array(
                'categories' => $this->category->get_list(),
                'errors' => (validation_errors() ? '<div class="alert alert-danger" role="alert">' . validation_errors() . '</div>' : '')
            );

            $data['name'] = array(
                'name' => 'name',
                'class' => 'form-control',
                'type' => 'text',
                'value' => $this->form_validation->set_value('name'),
            );
            $data['sort'] = array(
                'name' => 'sort',
                'class' => 'form-control',
                'type' => 'text',
                'value' => $this->form_validation->set_value('sort'),
            );
            $data['url'] = array(
                'name' => 'url',
                'class' => 'form-control',
                'type' => 'text',
                'value' => $this->form_validation->set_value('url'),
            );
            $this->template('categories', $data);
        } else {

            $data = array(
                'name' => $this->input->post('name'),
                'sort' => $this->input->post('sort'),
                'url' => $this->input->post('url')
            );

            $this->category->add($data);
            $this->session->set_flashdata('info', 'Categorie sccessvol toegevoegd !');
            redirect('categories', 'refresh');
        }
    }

    public function delete($id) {

        $id = (int) $id;

        if (!$this->category->get_cat($id))
            show_404();

        $this->category->delete($id);

        $this->session->set_flashdata('info', 'Categorie successvol verwijderd!');

        redirect('categories', 'refresh');
    }

    public function edit($id) {

        $id = (int) $id;

        if (!$this->category->get_cat($id))
            show_404();

        $this->form_validation->set_rules('name', 'Naam', 'trim|required');
        $this->form_validation->set_rules('sort', 'Positie', 'trim|required|is_natural_no_zero');
        $this->form_validation->set_rules('url', 'Url-link', 'trim|required|alpha_dash');

        if ($this->form_validation->run() == FALSE) {

            $cat = $this->category->get_cat_details($id);



            $data = array(
                'cat' => $cat,
                'errors' => (validation_errors() ? '<div class="alert alert-danger" role="alert">' . validation_errors() . '</div>' : '')
            );

            $data['name'] = array(
                'name' => 'name',
                'class' => 'form-control',
                'type' => 'text',
                'value' => $this->form_validation->set_value('name', $cat->name),
            );
            $data['sort'] = array(
                'name' => 'sort',
                'class' => 'form-control',
                'type' => 'text',
                'value' => $this->form_validation->set_value('sort', $cat->sort),
            );
            $data['url'] = array(
                'name' => 'url',
                'class' => 'form-control',
                'type' => 'text',
                'value' => $this->form_validation->set_value('url', $cat->url),
            );

            //$this->template->title = $cat->name;
            $this->template('edit_category', $data);
           // $this->template->publish();
        } else {

            $data = array(
                'name' => $this->input->post('name'),
                'sort' => $this->input->post('sort'),
                'url' => $this->input->post('url')
            );
            $this->category->edit($id, $data);

            $this->session->set_flashdata('info', 'Categorie successvol aangepast !');

            redirect('categories', 'refresh');
        }
    }

}