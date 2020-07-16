<?php

class Post {

    // DB Connection
    private $oConn;
    private $sTable = 'posts';

    // Post Props
    public $iID;
    public $iCategoryID;
    public $sCategoryName;
    public $sTitle;
    public $sBody;
    public $sAuthor;
    public $dtCreatedAt;

    // Constructor for DB
    public function __construct($oDB) {
        $this->oConn = $oDB;
    }

    // Get Posts
    public function read() {
        // Create query
        $sQuery = '
        SELECT 
            c.name AS category_name,
            p.id,
            p.category_id,
            p.title,
            p.body,
            p.author,
            p.created_at
        FROM '.$this->sTable.' p
        LEFT JOIN categories c ON p.category_id = c.id
        ORDER BY p.created_at DESC;';

        // Prepare Statement
        $sStmt = $this->oConn->prepare($sQuery);
        
        // Execute Query
        $sStmt->execute();

        return $sStmt;
    }

    // Get single post
    public function readSingle() {
        // Create query
        $sQuery = '
        SELECT 
            c.name AS category_name,
            p.id,
            p.category_id,
            p.title,
            p.body,
            p.author,
            p.created_at
        FROM '.$this->sTable.' p
        LEFT JOIN categories c ON p.category_id = c.id
        WHERE p.id = ?
        LIMIT 1;';

        // Prepare Statement
        $sStmt = $this->oConn->prepare($sQuery);
        
        // Execute Query
        $sStmt->bindParam(1, $this->iID);
        
        // Execute Query
        $sStmt->execute();

        // Fetch record
        $aRecord = $sStmt->fetch(PDO::FETCH_ASSOC);

        $this->sTitle = $aRecord['title'];
        $this->iCategoryID = $aRecord['category_id'];
        $this->sCategoryName = $aRecord['category_name'];
        $this->sBody = $aRecord['body'];
        $this->sAuthor = $aRecord['author'];
    }

    // Create post
    public function create() {
        // Create query
        $sQuery = '
		INSERT INTO '.$this->sTable.' (
			category_id,
			title,
			body,
			author
		)
			VALUES (
				:category_id,
				:title,
				:body,
				:author);';

        // Prepare Statement
		$sStmt = $this->oConn->prepare($sQuery);
		
		// Clean/Sanitise data
		$this->iCategoryID = htmlspecialchars(strip_tags($this->iCategoryID));
		$this->sTitle = htmlspecialchars(strip_tags($this->sTitle));
		$this->sBody = htmlspecialchars(strip_tags($this->sBody));
		$this->sAuthor = htmlspecialchars(strip_tags($this->sAuthor));
		
		// Bind/Mapping to query
        $sStmt->bindParam(':category_id', $this->iCategoryID);
        $sStmt->bindParam(':title', $this->sTitle);
        $sStmt->bindParam(':body', $this->sBody);
        $sStmt->bindParam(':author', $this->sAuthor);
		
  		// Execute Query
        if ($sStmt->execute()) {
			return true;
		}

		// Print any errors if something goes wrong
		printf('Error: %s. \n', $sStmt->error);

		return false;
	}

	// Update post
    public function update() {
        // Create query
        $sQuery = '
		UPDATE '.$this->sTable.' 
		SET 
			category_id = :category_id,
			title = :title,
			body = :body,
			author = :author
		WHERE id = :id;';

        // Prepare Statement
		$sStmt = $this->oConn->prepare($sQuery);
		
		// Clean/Sanitise data
		$this->iID = htmlspecialchars(strip_tags($this->iID));
		$this->iCategoryID = htmlspecialchars(strip_tags($this->iCategoryID));
		$this->sTitle = htmlspecialchars(strip_tags($this->sTitle));
		$this->sBody = htmlspecialchars(strip_tags($this->sBody));
		$this->sAuthor = htmlspecialchars(strip_tags($this->sAuthor));
		
		// Bind/Mapping to query
        $sStmt->bindParam(':id', $this->iID);
        $sStmt->bindParam(':category_id', $this->iCategoryID);
        $sStmt->bindParam(':title', $this->sTitle);
        $sStmt->bindParam(':body', $this->sBody);
        $sStmt->bindParam(':author', $this->sAuthor);
		
  		// Execute Query
        if ($sStmt->execute()) {
			return true;
		}

		// Print any errors if something goes wrong
		printf('Error: %s. \n', $sStmt->error);

		return false;
	}

	// Delete post
    public function delete() {
        // Delete query
        $sQuery = 'DELETE FROM '.$this->sTable.' WHERE id = :id;';

        // Prepare Statement
		$sStmt = $this->oConn->prepare($sQuery);

		// Clean/Sanitise data
		$this->iID = htmlspecialchars(strip_tags($this->iID));

		// Bind/Mapping to query
        $sStmt->bindParam(':id', $this->iID);

  		// Execute Query
        if ($sStmt->execute()) {
			return true;
		}

		// Print any errors if something goes wrong
		printf('Error: %s. \n', $sStmt->error);

		return false;
	}
}
