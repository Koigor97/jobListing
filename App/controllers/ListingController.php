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

        $requiredFields = ['title', 'description', 'email', 'city', 'state', 'salary'];

        $errors = [];

        foreach ($requiredFields as $field) {
            if (empty($newListingData[$field]) || !Validation::string($newListingData[$field])) {
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
                $fields[] = $field;
            }
            $fields = implode(', ', $fields); 

            $values = [];

            foreach ($newListingData as $field => $value) {
                // convert empty strings to null
                if (empty($value)) {
                    $newListingData[$field] = null;
                }
                $values[] = ':' . $field;
            }
            $values = implode(', ', $values);

            // create query
            $query = "INSERT INTO listings ({$fields}) VALUES ({$values})";

            // execute query
            $this->db->query($query, $newListingData);
            
            // redirect to home page
            redirect('/listings');
        }
    }

    /**
     * This will delete a listing
     * 
     * @param array $params
     * @return void
     */
    public function destroy($params) {
        $id = $params['id'];

        $params = [
            'id' => $id
        ];

        $listing = $this->db->query("SELECT * FROM listings WHERE id = :id", $params)->fetch();

        if(!$listing) {
            ErrorController::notFound('Lising not found');
            return;
        }

        $this->db->query("DELETE FROM listings WHERE id = :id", $params);

        // Set flash message
        $_SESSION['success_message'] = 'Listing deleted successfully';

        redirect('/listings');
    }

    /**
     * This method show the edit listing page
     * 
     * @return void
     */
    public function edit($params) {
        $id = $params['id'] ?? '';

        $params = [
            'id' => $id
        ];

        $listing = $this->db->query("SELECT * FROM listings WHERE id = :id", $params)->fetch();

        if(!$listing) {
            ErrorController::notFound('Lising not found');
            return;
        }

        loadView('listings/edit', [
            'listing' => $listing
        ]);
    }

    /**
     * Update a listing
     * 
     * @param array s$param
     * return void
     */
    public function update($params) {
        $id = $params['id'] ?? '';

        $params = [
            'id' => $id
        ];

        $listing = $this->db->query("SELECT * FROM listings WHERE id = :id", $params)->fetch();

        if(!$listing) {
            ErrorController::notFound('Lising not found');
            return;
        }

        $allowedFields = ["title", "description", "salary", "requirements", "benefits", "company", "address", "city", "state", "phone", "email"];

        $updateValues = array_intersect_key($_POST, array_flip($allowedFields));
       
        $updateValues = array_map('sanitize', $updateValues);

        $requiredFields = ['title', 'description', 'salary', 'email', 'city', 'state'];

        $errors = [];

        foreach ($requiredFields as $field) {
            if(empty($updateValues[$field]) || !Validation::string($updateValues[$field])) {
                $errors[$field] = ucfirst($field) . ' is required';
            }
        }

        if(!empty($errors)) {
            loadView('listing/edit', ['listing' => $listing, 'errors' => $errors]);
            exit;
        } else {
            // submit to data
            $updateFields = [];

            foreach(array_keys($updateValues) as $field) {
                $updateFields[] = "{$field} = :{$field}";
            }

            $updateFields = implode(', ', $updateFields);

            $updateQuery = "UPDATE listings SET $updateFields WHERE id = :id";
            
            $updateValues['id'] = $id;

            $this->db->query($updateQuery, $updateValues);

            $_SESSION['success_message'] = 'Listing Updated';

            redirect('/listings/' . $id);
        }
    }
}