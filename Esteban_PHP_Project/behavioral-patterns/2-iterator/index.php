<?php

class Student {
    public function __construct(private string $id, private string $name) {
    }

    public function getId(): string {
        return $this->id;
    }

    public function getName(): string {
        return $this->name;
    }
} // Close Student class HERE


class StudentCollection implements IteratorAggregate {
    private array $students = [];

    public function add(Student $student): void {
        $this->students[] = $student;
    }

    public function getIterator(): Traversable {
        return new ArrayIterator($this->students);
    }
} // Close StudentCollection class HERE


$students = new StudentCollection();

$students->add(new Student('2026-0001', 'Juan'));
$students->add(new Student('2026-0002', 'Maria'));
$students->add(new Student('2026-0003', 'Ken'));

echo "Student List:\n";

foreach ($students as $student) {
    echo $student->getId() . " - " . $student->getName() . "\n";
}

?>