<?php
require_once 'php/db/Db.php';

class Feedback {
    private ?int $id = null;
    private string $text;
    private string $author;
    private DateTime $created;

    /**
     * @param string $text content of the feedback
     * @param string $author feedback author
     */
    public function __construct(string $text, string $author) {
        $this->text = $text;
        $this->author = $author;
    }

    /**
     * @return int|null unique id from the database
     */
    public function getId(): ?int {
        return $this->id;
    }

    /**
     * @param int $id unique id from the database
     * @return Feedback current feedback object
     */
    protected function setId(int $id): Feedback {
        $this->id = $id;
        return $this;
    }

    /**
     * @return string content of the feedback
     */
    public function getText(): string {
        return $this->text;
    }

    /**
     * @param string $text content of the feedback
     * @return Feedback current feedback object
     */
    public function setText(string $text): Feedback {
        $this->text = $text;
        return $this;
    }

    /**
     * @return string feedback author
     */
    public function getAuthor(): string {
        return $this->author;
    }

    /**
     * @param string $author feedback author
     * @return Feedback current feedback object
     */
    public function setAuthor(string $author): Feedback {
        $this->author = $author;
        return $this;
    }

    /**
     * @return DateTime creation time of the feedback
     */
    public function getCreated(): DateTime {
        return $this->created;
    }

    /**
     * @param DateTime $created creation time
     * @return Feedback current feedback object
     */
    protected function setCreated(DateTime $created): Feedback {
        $this->created = $created;
        return $this;
    }

    /**
     * @return Feedback[] all feedback from the database
     */
    static function getAllFeedback() : array {
        $db = Db::getConnection();
        $stm = $db->prepare('SELECT id, text, author, created FROM feedback ORDER BY created DESC;');
        $stm->execute();

        $allFeedback = array();
        while ($item = $stm->fetch()) {
            $feedback = new Feedback($item['text'], $item['author']);
            $feedback->setId($item['id']);
            //$feedback->setCreated(DateTime::createFromFormat("Y-m-d H:i:s",$item['created']));
            $feedback->setCreated(new DateTime($item['created']));
            $allFeedback[] = $feedback;
        };
        return $allFeedback;
    }

    /**
     * @return $this the persisted Feedback object with the id filled out.
     */
    public function save() : Feedback {
        $db = Db::getConnection();
        $stm = $db->prepare('INSERT INTO feedback (text, author) VALUES (:text, :author);');
        $stm->execute([
            ':text' => $this->text,
            ':author' => $this->author
        ]);
        $this->id = $db->lastInsertId();
        return $this;
    }

}