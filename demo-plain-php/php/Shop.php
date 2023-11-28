<?php
// starting the session should be the first step in your PHP file
session_start();

require_once 'php/model/Course.php';
require_once 'php/model/Book.php';
require_once 'php/model/Student.php';
require_once 'php/model/Reservation.php';

/**
 * This class will implement the order wizard
 * @author Jeroen
 */
class Shop {

    private int $step;

    public function __construct() {
        // ref: https://www.php.net/manual/en/language.operators.comparison.php
        $this->step = $_SESSION['order_step'] ?? 1;
    }

    /**
     * @param array $data POST data from form
     * @return void
     */
    public function processStep(array $data) : void {
        $session_data = $_SESSION['order_data'] ?? array();
        //$session_data = array_merge($session_data, $data);
        foreach ($data as $key => $value) {
            $session_data[$key] = $value;
        }
        $_SESSION['order_data'] = $session_data;

        if ($this->step == 3) {
            $this->storeOrder($session_data);
            $this->step = 1;
        } else {
            $this->step++;
        }
        $_SESSION['order_step'] = $this->step;
    }

    private function storeOrder(array $data) : void {
        $student = Student::getStudentByEmail($data['email']);
        if (is_null($student)) {
            $student = new Student($data['email']);
            $student = $student->save();
        }
        $books = $this->getBooksSelected();
        $order = new Reservation($student,$books);
        $order->save();
    }

    /**
     * @return int the current step taken from the session
     */
    public function getStep(): int {
        return $this->step;
    }

    /**
     * Returns all possible books for a fase.
     * A fase needs to be present in the session so this method can only be called after step 1.
     * @return Book[] all books for the chosen program or phase
     */
    public function getBooksPossible() : array {
        $result = array();
        if ($this->step > 1 && isset($_SESSION['order_data']['fase'])) {
            $courses = Course::getCoursesByFase($_SESSION['order_data']['fase']);
            foreach ($courses as $course) {
                $books = Book::getBooksByCourseId($course->getId());
                $result = array_merge($result, $books);
            }
        }
        return $result;
    }

    /**
     * Returns an array with all selected books that need to be ordered.
     * A selection of books need to be present in the session so this method can only be called after step 2
     * @return Book[] all book details of the selected books
     */
    public function getBooksSelected() : array {
        $result = array();
        if ($this->step > 2) {
            $bookIds = $_SESSION['order_data']['books'];
            foreach ($bookIds as $bookId) {
                $book = Book::getBookById($bookId);
                $result[] = $book;
            }
        }
        return $result;
    }
}