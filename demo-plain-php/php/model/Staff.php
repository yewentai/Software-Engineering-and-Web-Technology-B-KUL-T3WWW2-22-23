<?php
require_once 'php/db/Db.php';

class Staff {
    private ?int $id = null;
    private string $name;
    private string $email;

    /**
     * @param string $name staff full name
     * @param string $email staff email
     */
    public function __construct(string $name, string $email) {
        $this->name = $name;
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
     * @return Staff current staff object
     */
    protected function setId(?int $id): Staff {
        $this->id = $id;
        return $this;
    }

    /**
     * @return string staff full name
     */
    public function getName(): string {
        return $this->name;
    }

    /**
     * @param string $name staff full name
     * @return Staff current staff object
     */
    public function setName(string $name): Staff {
        $this->name = $name;
        return $this;
    }

    /**
     * @return string staff email
     */
    public function getEmail(): string {
        return $this->email;
    }

    /**
     * @param string $email staff email
     * @return Staff current staff object
     */
    public function setEmail(string $email): Staff {
        $this->email = $email;
        return $this;
    }

    /**
     * @param int $id the staff id
     * @return Staff|null the staff object for the given id
     */
    static function getStaffById(int $id) : ?Staff {
        $db = Db::getConnection();
        $stm = $db->prepare('SELECT id, name, email FROM staff WHERE id = :id;');
        $stm->execute([':id' => $id]);

        $staff = null;
        while ($item = $stm->fetch()) {
            $staff = new Staff($item['name'], $item['email']);
            $staff->setId($item['id']);
        };
        return $staff;
    }

    /**
     * @return $this the persisted Staff object with the id filled out.
     */
    public function save() : Staff {
        $db = Db::getConnection();
        $stm = $db->prepare('INSERT INTO staff (name, email) VALUES (:name, :email);');
        $stm->execute([
            ':name' => $this->name,
            ':email' => $this->email
        ]);
        $this->id = $db->lastInsertId();
        return $this;
    }

}