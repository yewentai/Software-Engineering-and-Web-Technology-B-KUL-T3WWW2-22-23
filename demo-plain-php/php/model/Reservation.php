<?php
require_once 'php/db/Db.php';
require_once 'Student.php';

class Reservation {
    private ?int $id;
    private Student $student;
    private DateTime $created;
    private array $books;

    /**
     * @param Student $student student object for the new reservation
     * @param array $books array of books in the reservation
     */
    public function __construct(Student $student, array $books = array()) {
        $this->student = $student;
        $this->books = $books;
        $this->created = new DateTime();
    }

    /**
     * @return int|null unique id from the database
     */
    public function getId(): ?int {
        return $this->id;
    }

    /**
     * @param int|null $id unique id from the database
     * @return Reservation current reservation object
     */
    protected function setId(?int $id): Reservation {
        $this->id = $id;
        return $this;
    }

    /**
     * @return Student student object for current reservation
     */
    public function getStudent(): Student {
        return $this->student;
    }

    /**
     * @param Student $student student object for current reservation
     * @return Reservation current reservation object
     */
    public function setStudent(Student $student): Reservation {
        $this->student = $student;
        return $this;
    }

    /**
     * @return DateTime the time when the reservation was created
     */
    public function getCreated(): DateTime {
        return $this->created;
    }

    /**
     * @param DateTime $created the creation time of the reservation
     */
    protected function setCreated(DateTime $created): void {
        $this->created = $created;
    }

    /**
     * @return array all books in current reservation
     */
    public function getBooks(): array {
        return $this->books;
    }

    /**
     * @param Book $book book to add to order
     * @return Reservation current reservation object
     */
    public function addBook(Book $book): Reservation {
        $this->books[] = $book;
        return $this;
    }

    /**
     * @return $this the persisted Order object with the id filled out.
     */
    public function save() : Reservation {
        $db = Db::getConnection();
        $stm = $db->prepare('INSERT INTO reservation (student, created) VALUES (:student, :created);');
        $stm->execute([
            ':student' => $this->student->getId(),
            ':created' => $this->created->format("Y-m-d H:i:s")
        ]);
        $this->id = $db->lastInsertId();
        $stm = $db->prepare('INSERT INTO reservation_book (reservation, book) VALUES (:reservation, :book);');
        foreach ($this->books as $book) {
            $stm->execute([
                ':reservation' => $this->id,
                ':book' => $book->getId()
            ]);
        }
        return $this;
    }

}