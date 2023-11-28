<?php
require_once 'php/db/Db.php';
require_once 'Staff.php';

class Course {
    private ?string $id = null;
    private int $fase;
    private string $name;
    private Staff $teacher;

    /**
     * @param string $name course name
     * @param int $fase fase in which the course is given
     * @param Staff $teacher staff member responsible for the course
     */
    public function __construct(string $name, int $fase, Staff $teacher) {
        $this->name = $name;
        $this->fase = $fase;
        $this->teacher = $teacher;
    }

    /**
     * @return string|null unique id from the database
     */
    public function getId(): ?string {
        return $this->id;
    }

    /**
     * @param string|null $id unique id from the database
     * @return Course current course object
     */
    protected function setId(?string $id): Course {
        $this->id = $id;
        return $this;
    }

    /**
     * @return int fase in which the course is given
     */
    public function getFase(): int {
        return $this->fase;
    }

    /**
     * @param int $fase fase in which the course is given
     * @return Course current course object
     */
    public function setFase(int $fase): Course {
        $this->fase = $fase;
        return $this;
    }

    /**
     * @return string course name
     */
    public function getName(): string {
        return $this->name;
    }

    /**
     * @param string $name course name
     * @return Course current course object
     */
    public function setName(string $name): Course {
        $this->name = $name;
        return $this;
    }

    /**
     * @return Staff staff member responsible for the course
     */
    public function getTeacher(): Staff {
        return $this->teacher;
    }

    /**
     * @param Staff $teacher staff member responsible for the course
     * @return Course current course object
     */
    public function setTeacher(Staff $teacher): Course {
        $this->teacher = $teacher;
        return $this;
    }

    /**
     * @param string $id the course id
     * @return Course|null the course object for the given id
     */
    static function getCourseById(string $id) : ?Course {
        $db = Db::getConnection();
        $stm = $db->prepare('SELECT id, fase, name, staff FROM course WHERE id = :id;');
        $stm->execute([':id' => $id]);

        $course = null;
        while ($item = $stm->fetch()) {
            $staff = Staff::getStaffById($item['staff']);
            $fase = $item['fase'];
            $course = new Course($item['name'], $fase, $staff);
            $course->setId($item['id']);
        };
        return $course;
    }

    /**
     * @return Course[] all courses from the database
     */
    static function getAllCourses() : array {
        $db = Db::getConnection();
        $stm = $db->prepare('SELECT id, fase, name, staff FROM course;');
        $stm->execute();

        $allCourses = array();
        while ($item = $stm->fetch()) {
            $staff = Staff::getStaffById($item['staff']);
            $course = new Course($item['name'], $item['fase'], $staff);
            $course->setId($item['id']);
            $allCourses[] = $course;
        };
        return $allCourses;
    }

    /**
     * @param int $fase selection criteria
     * @return Course[] all courses for a fase in a program from the database
     */
    static function getCoursesByFase(int $fase) : array {
        $db = Db::getConnection();
        $stm = $db->prepare('SELECT id, fase, name, staff FROM course WHERE fase = :fase;');
        $stm->execute([
            ':fase' => $fase
        ]);

        $courses = array();
        while ($item = $stm->fetch()) {
            $staff = Staff::getStaffById($item['staff']);
            $course = new Course($item['name'], $item['fase'], $staff);
            $course->setId($item['id']);
            $courses[] = $course;
        };
        return $courses;
    }

    /**
     * @return $this the persisted Course object with the id filled out.
     */
    public function save() : Course {
        $db = Db::getConnection();
        $stm = $db->prepare('INSERT INTO course (fase, name, staff) VALUES (:fase, :name, :staff);');
        $stm->execute([
            ':fase' => $this->fase,
            ':name' => $this->name,
            ':staff' => $this->teacher->getId()
        ]);
        $this->id = $db->lastInsertId();
        return $this;
    }

}