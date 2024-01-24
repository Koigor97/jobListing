<?php

namespace App\Controllers;

use Framework\Database;

class ListingController {
    protected $db;

    /**
     * Constructor for ListingController
     * 
     * @return void
     */
    public function __construct()
    {
        $config = require base_path('config/db.php');
        $this->db = new Database($config);
    }

    /**
     * This method show the home page
     * 
     * @return void
     */
    public function index() {
        $listings = $this->db->query('SELECT * FROM listings')->fetchAll();

        loadView('listings/index', [
            'listings' => $listings]);
    }

    /**
     * This method show the create listing page
     * 
     * @return void
     */
    public function create() {
        loadView('listings/create');
    }

    /**
     * This method show the listing page
     * 
     * @return void
     */
    public function show($params) {
        $id = $params['id'] ?? '';

        $params = [
            'id' => $id
        ];

        $listing = $this->db->query("SELECT * FROM listings WHERE id = :id", $params)->fetch();

        if(!$listing) {
            ErrorController::notFound('Lising not found');
            return;

        }

        loadView('listings/show', [
            'listing' => $listing
        ]);
    }
}