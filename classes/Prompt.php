<?php class Prompt {
  private $text;
  private $author;
  private $model;
  private $price;

  public function __construct($text, $author, $model, $price) {
    $this->text = $text;
    $this->author = $author;
    $this->model = $model;
    $this->price = $price;
  }

  // getters and setters for properties
    public function getText() {
        return $this->text;
    }

    public function setText($text) {
        $this->text = $text;
        return $this;
    }

    public function getAuthor() {
        return $this->author;
    }

    public function setAuthor($author) {
        $this->author = $author;
        return $this;
    }

    public function getModel() {
        return $this->model;
    }

    public function setModel($model) {
        $this->model = $model;
        return $this;
    }

    public function getPrice() {
        return $this->price;
    }

    public function setPrice($price) {
        $this->price = $price;
        return $this;
    }
}