<?php

class AdminController extends DController {
    public function __construct() {
        parent::__construct();
    }

    public function loadAdmin() {
        $this->load->view('admin');
    }
}