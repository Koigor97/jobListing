<?php

namespace App\Controllers;

use Framework\Database;
use Framework\Validation;

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

    /**
     * Store data in Database
     * 
     * @return void 
     */
    public function store() {
        $allowedFields = ["title", "description", "salary", "requirements", "benefits", "company", "address", "city", "state", "phone", "email"];

        $newListingData = array_intersect_key($_POST, array_flip($allowedFields));

        $newListingData['user_id'] = 1;

        $newListingData = array_map('sanitize', $newListingData);

        $requiredFields = ['title', 'description', 'email', 'city', 'state'];

        $errors = [];

        foreach ($requiredFields as $field) {
            if (empty($newListingData[$field]) || !Validation::string($newListingData['$field'])) {
                $errors[$field] = ucfirst($field) . ' is required';
            }
        }

        if (!empty($errors)) {
            // Reload view with errors
            loadView('listings/create', ['errors' => $errors, 'listing' => $newListingData]);
        } else {
            // Submit data
            $fields = [];

            foreach ($newListingData as $field => $value) {
                $field[] = $field;
            }

            $fields = implode('. ', $fields); 
        }
    }
}