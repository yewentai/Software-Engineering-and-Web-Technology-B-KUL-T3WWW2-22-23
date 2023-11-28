<?php
require_once 'php/db/Db.php';

class Student {
    private ?int $id = null;
    private string $email;

    /**
     * @param string $email students email
     */
    public function __construct(string $email) {
        $this->email = $email;
    }

    /**
     * @return int|null unique id from the database
     */
    public function getId(): ?int {
        return $this->id;
    }

    /**
     * @param int|null $id unique id from the database
     * @return Student current student object
     */
    protected function setId(?int $id): Student {
        $this->id = $id;
        return $this;
    }

    /**
     * @return string students email
     */
    public function getEmail(): string {
        return $this->email;
    }

    /**
     * @param string $email students email
     * @return Student current student object
     */
    public function setEmail(string $email): Student {
        $this->email = $email;
        return $this;
    }

    /**
     * @param string $email the email address for a given student
     * @return Student|null the student object for the given email
     */
    static function getStudentByEmail(string $email) : ?Student {
        $db = Db::getConnection();
        $stm = $db->prepare('SELECT id, email FROM student WHERE email LIKE :email;');
        $stm->execute([':email' => $email]);

        $student = null;
        while ($item = $stm->fetch()) {
            $student = new Student($item['email']);
            $student->setId($item['id']);
        };
        return $student;
    }

    /**
     * @return $this the persisted Student object with the id filled out.
     */
    public function save() : Student {
        $db = Db::getConnection();
        $stm = $db->prepare('INSERT INTO student (email) VALUES (:email);');
        $stm->execute([
            ':email' => $this->email
        ]);
        $this->id = $db->lastInsertId();
        return $this;
    }

}