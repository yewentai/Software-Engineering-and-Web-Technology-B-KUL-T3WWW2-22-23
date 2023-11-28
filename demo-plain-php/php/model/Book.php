<?php
require_once 'php/db/Db.php';
require_once 'Course.php';

class Book {
    private ?int $id = null;
    private string $title;
    private ?string $isbn;
    private bool $obliged;
    private Course $course;

    /**
     * @param string $title book title
     * @param string|null $isbn book ISBN number
     * @param Course $course course in which the book is used
     * @param bool $obliged indication if book is obliged or not, defaults to not obliged if not given
     */
    public function __construct(string $title, ?string $isbn, Course $course, bool $obliged = false) {
        $this->title = $title;
        $this->isbn = $isbn;
        $this->obliged = $obliged;
        $this->course = $course;
    }

    /**
     * @return int|null unique id from the database
     */
    public function getId(): ?int {
        return $this->id;
    }

    /**
     * @param int|null $id unique id from the database
     * @return Book current book object
     */
    protected function setId(?int $id): Book {
        $this->id = $id;
        return $this;
    }

    /**
     * @return string book title
     */
    public function getTitle(): string {
        return $this->title;
    }

    /**
     * @param string $title book title
     * @return Book current book object
     */
    public function setTitle(string $title): Book {
        $this->title = $title;
        return $this;
    }

    /**
     * @return string|null book isbn
     */
    public function getIsbn(): ?string {
        return $this->isbn;
    }

    /**
     * @param string|null $isbn book isbn
     * @return Book current book object
     */
    public function setIsbn(?string $isbn): Book {
        $this->isbn = $isbn;
        return $this;
    }

    /**
     * @return bool obliged or not
     */
    public function getObliged(): bool {
        return $this->obliged;
    }

    /**
     * @param bool $obliged true if obliged
     * @return Book current book object
     */
    public function setObliged(bool $obliged): Book {
        $this->obliged = $obliged;
        return $this;
    }

    /**
     * @return Course course in which the book is used
     */
    public function getCourse(): Course {
        return $this->course;
    }

    /**
     * @param Course $course course in which the book is used
     * @return Book current book object
     */
    public function setCourse(Course $course): Book {
        $this->course = $course;
        return $this;
    }

    /**
     * @param int $id the book id
     * @return Book|null the book object for the given id
     */
    static function getBookById(int $id) : ?Book {
        $db = Db::getConnection();
        $stm = $db->prepare('SELECT id, title, isbn, obliged, course FROM book WHERE id = :id;');
        $stm->execute([':id' => $id]);

        $book = null;
        while ($item = $stm->fetch()) {
            $course = Course::getCourseById($item['course']);
            $book = new Book($item['title'], $item['isbn'], $course, $item['obliged']);
            $book->setId($id);
        }
        return $book;
    }

    /**
     * @param string $id the course id
     * @return Book[] get all books for a course
     */
    static function getBooksByCourseId(string $id) : array {
        $db = Db::getConnection();
        $stm = $db->prepare('SELECT id, title, isbn, obliged, course FROM book WHERE course = :id;');
        $stm->execute([':id' => $id]);

        $books = array();
        while ($item = $stm->fetch()) {
            $course = Course::getCourseById($item['course']);
            $book = new Book($item['title'], $item['isbn'], $course, $item['obliged'] );
            $book->setId($item['id']);
            $books[] = $book;
        };
        return $books;
    }

    /**
     * @return $this the persisted Book object with the id filled out.
     */
    public function save() : Book {
        $db = Db::getConnection();
        $stm = $db->prepare('INSERT INTO book (title, isbn, obliged, course) VALUES (:title, :isbn, :obliged, :course);');
        $stm->execute([
            ':title' => $this->title,
            ':isbn' => $this->isbn,
            ':obliged' => $this->obliged,
            ':course' => $this->course->getId()
        ]);
        $this->id = $db->lastInsertId();
        return $this;
    }

}